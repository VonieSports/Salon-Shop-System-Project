<?php

use App\Models\ItemVariant;
use App\Models\Post;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

new #[Layout('layouts.salon_owner')] class extends Component
{
    use WithPagination;

    public ?int $tenantId = null;

    #[Url(as: 'q')]
    public string $search = '';

    public string $typeFilter = 'all'; // all | product | service

    public array $selectedIds = [];
    public bool $selectAll = false;

    public function mount(): void
    {
        $tenant = Auth::user()->tenant;

        abort_unless($tenant?->business_setup_completed, 403, 'Please complete your business setup first.');

        $this->tenantId = $tenant->id;
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
        $this->clearSelection();
    }

    public function updatingTypeFilter(): void
    {
        $this->resetPage();
        $this->clearSelection();
    }

    #[Computed]
    public function items()
    {
        return Post::query()
            ->with(['productCategory:id,name', 'serviceCategory:id,name'])
            ->where('tenant_id', $this->tenantId)
            ->where('created_by', Auth::id())
            ->whereNotNull('archived_at')
            ->when($this->typeFilter !== 'all', fn ($q) => $q->where('type', $this->typeFilter))
            ->when($this->search !== '', fn ($q) => $q->where('name', 'like', '%' . $this->search . '%'))
            ->orderByDesc('archived_at')
            ->paginate(12);
    }

    public function toggleSelectAll(): void
    {
        $this->selectedIds = $this->selectAll
            ? $this->items->getCollection()->pluck('id')->map(fn ($id) => (string) $id)->toArray()
            : [];
    }

    public function updatedSelectedIds(): void
    {
        $pageIds = $this->items->getCollection()->pluck('id')->map(fn ($id) => (string) $id)->toArray();
        $this->selectAll = count($pageIds) > 0 && empty(array_diff($pageIds, $this->selectedIds));
    }

    public function clearSelection(): void
    {
        $this->selectedIds = [];
        $this->selectAll = false;
    }

    public function restoreItem(int $postId): void
    {
        $post = Post::where('tenant_id', $this->tenantId)
            ->where('created_by', Auth::id())
            ->whereNotNull('archived_at')
            ->find($postId);

        if (!$post) {
            session()->flash('error', 'Item not found in archive.');
            return;
        }

        $post->update(['archived_at' => null]);

        $this->selectedIds = array_values(array_diff($this->selectedIds, [(string) $postId]));

        unset($this->items);
        session()->flash('message', ucfirst($post->type) . ' restored successfully.');
    }

    public function bulkRestore(): void
    {
        if (empty($this->selectedIds)) {
            session()->flash('error', 'No items selected.');
            return;
        }

        $count = Post::where('tenant_id', $this->tenantId)
            ->where('created_by', Auth::id())
            ->whereNotNull('archived_at')
            ->whereIn('id', $this->selectedIds)
            ->update(['archived_at' => null]);

        if ($count > 0) {
            $this->clearSelection();
            unset($this->items);
            session()->flash('message', "{$count} item(s) restored successfully.");
        } else {
            session()->flash('error', 'Failed to restore selected items.');
        }
    }

    public function deleteForever(int $postId): void
    {
        $post = Post::with('inventory')
            ->where('tenant_id', $this->tenantId)
            ->where('created_by', Auth::id())
            ->whereNotNull('archived_at')
            ->find($postId);

        if (!$post) {
            session()->flash('error', 'Item not found in archive.');
            return;
        }

        try {
            DB::transaction(function () use ($post) {
                if ($post->type === 'product') {
                    $post->inventory?->variants()->delete();
                    $post->inventory?->delete();
                } elseif ($post->type === 'service') {
                    ItemVariant::where('service_id', $post->inventory_id)->delete();
                    Service::where('id', $post->inventory_id)->delete();
                }
                $post->delete();
            });

            $this->selectedIds = array_values(array_diff($this->selectedIds, [(string) $postId]));

            unset($this->items);
            session()->flash('message', 'Item permanently deleted.');
        } catch (\Exception $e) {
            Log::error('Error permanently deleting item', ['error' => $e->getMessage(), 'post_id' => $postId]);
            session()->flash('error', 'Failed to permanently delete item. Please try again.');
        }
    }

    public function bulkDeleteForever(): void
    {
        if (empty($this->selectedIds)) {
            session()->flash('error', 'No items selected.');
            return;
        }

        $posts = Post::with('inventory')
            ->where('tenant_id', $this->tenantId)
            ->where('created_by', Auth::id())
            ->whereNotNull('archived_at')
            ->whereIn('id', $this->selectedIds)
            ->get();

        try {
            DB::transaction(function () use ($posts) {
                foreach ($posts as $post) {
                    if ($post->type === 'product') {
                        $post->inventory?->variants()->delete();
                        $post->inventory?->delete();
                    } elseif ($post->type === 'service') {
                        ItemVariant::where('service_id', $post->inventory_id)->delete();
                        Service::where('id', $post->inventory_id)->delete();
                    }
                    $post->delete();
                }
            });

            $count = $posts->count();
            $this->clearSelection();
            unset($this->items);
            session()->flash('message', "{$count} item(s) permanently deleted.");
        } catch (\Exception $e) {
            Log::error('Error bulk permanently deleting items', ['error' => $e->getMessage()]);
            session()->flash('error', 'Failed to permanently delete selected items. Please try again.');
        }
    }
};
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

    public ?int $selectedPostId = null;

    public function mount(): void
    {
        $tenant = Auth::user()->tenant;

        abort_unless($tenant?->business_setup_completed, 403, 'Please complete your business setup first.');

        $this->tenantId = $tenant->id;
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    #[Computed]
    public function items()
    {
        return Post::query()
            ->with('serviceCategory:id,name')
            ->where('tenant_id', $this->tenantId)
            ->where('created_by', Auth::id())
            ->where('type', 'service')
            ->when($this->search !== '', fn ($q) => $q->where('name', 'like', '%' . $this->search . '%'))
            ->latest()
            ->paginate(12);
    }

    #[Computed]
    public function selectedPost()
    {
        if (!$this->selectedPostId) {
            return null;
        }

        return Post::with('serviceCategory:id,name')
            ->where('tenant_id', $this->tenantId)
            ->where('id', $this->selectedPostId)
            ->where('type', 'service')
            ->first();
    }

    #[Computed]
    public function selectedService()
    {
        $post = $this->selectedPost;

        return $post ? Service::find($post->inventory_id) : null;
    }

    #[Computed]
    public function selectedVariants()
    {
        $service = $this->selectedService;

        return $service ? ItemVariant::where('service_id', $service->id)->get() : collect();
    }

    #[Computed]
    public function selectedGallery()
    {
        $post = $this->selectedPost;

        if (!$post) {
            return collect();
        }

        return collect([$post->image])
            ->merge($this->selectedVariants->pluck('image'))
            ->filter()
            ->unique()
            ->values();
    }

    public function viewItem(int $postId): void
    {
        $this->selectedPostId = $postId;
    }

    public function closeItem(): void
    {
        $this->selectedPostId = null;
    }

    public function navigateItem(string $direction): void
    {
        $ids = $this->items->getCollection()->pluck('id')->toArray();
        $currentIndex = array_search($this->selectedPostId, $ids, true);

        if ($currentIndex === false) {
            return;
        }

        $newIndex = $direction === 'next' ? $currentIndex + 1 : $currentIndex - 1;

        if (isset($ids[$newIndex])) {
            $this->selectedPostId = $ids[$newIndex];
        }
    }

    public function toggleStatus(int $postId): void
    {
        $post = Post::where('tenant_id', $this->tenantId)
            ->where('created_by', Auth::id())
            ->where('type', 'service')
            ->find($postId);

        if (!$post) {
            return;
        }

        $newStatus = $post->status === 'published' ? 'draft' : 'published';
        $post->update(['status' => $newStatus]);

        // Mirrors your create-service.php save() logic, which sets
        // is_active based on status at creation time.
        Service::where('id', $post->inventory_id)->update(['is_active' => $newStatus === 'published']);

        unset($this->items);
        unset($this->selectedPost);
    }

    public function deleteItem(int $postId): void
    {
        $post = Post::where('id', $postId)
            ->where('tenant_id', $this->tenantId)
            ->where('created_by', Auth::id())
            ->where('type', 'service')
            ->first();

        if (!$post) {
            session()->flash('error', 'Service not found.');
            return;
        }

        try {
            DB::transaction(function () use ($post) {
                ItemVariant::where('service_id', $post->inventory_id)->delete();
                Service::where('id', $post->inventory_id)->delete();
                $post->delete();
            });

            if ($this->selectedPostId === $postId) {
                $this->selectedPostId = null;
            }

            unset($this->items);
            session()->flash('message', 'Service deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting service', ['error' => $e->getMessage(), 'post_id' => $postId]);
            session()->flash('error', 'Failed to delete service. Please try again.');
        }
    }
};
<?php

use App\Models\ItemVariant;
use App\Models\Post;
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
            ->with('productCategory:id,name')
            ->where('tenant_id', $this->tenantId)
            ->where('created_by', Auth::id())
            ->where('type', 'product')
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

        return Post::with('productCategory:id,name')
            ->where('tenant_id', $this->tenantId)
            ->where('id', $this->selectedPostId)
            ->where('type', 'product')
            ->first();
    }

    #[Computed]
    public function selectedProduct()
    {
        return $this->selectedPost?->inventory;
    }

    #[Computed]
    public function selectedVariants()
    {
        return $this->selectedProduct?->variants ?? collect();
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

    /**
     * Steps within the currently loaded page of results (12 per page).
     * Crossing a page boundary requires paginating first.
     */
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
            ->where('type', 'product')
            ->find($postId);

        if (!$post) {
            return;
        }

        $post->update(['status' => $post->status === 'published' ? 'draft' : 'published']);

        unset($this->items);
        unset($this->selectedPost);
    }

    public function deleteItem(int $postId): void
    {
        $post = Post::with('inventory')
            ->where('tenant_id', $this->tenantId)
            ->where('created_by', Auth::id())
            ->where('type', 'product')
            ->find($postId);

        if (!$post) {
            session()->flash('error', 'Product not found.');
            return;
        }

        try {
            DB::transaction(function () use ($post) {
                $post->inventory?->variants()->delete();
                $post->inventory?->delete();
                $post->delete();
            });

            if ($this->selectedPostId === $postId) {
                $this->selectedPostId = null;
            }

            unset($this->items);
            session()->flash('message', 'Product deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting product', ['error' => $e->getMessage(), 'post_id' => $postId]);
            session()->flash('error', 'Failed to delete product. Please try again.');
        }
    }
};
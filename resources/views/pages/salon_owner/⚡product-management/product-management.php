<?php

use App\Models\Post;
use App\Models\Product;  // ← ADD THIS LINE
use App\Models\ItemVariant;
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

    public string $dateFilter = 'all';
    public ?string $customDateFrom = null;
    public ?string $customDateTo = null;

    public array $selectedIds = [];
    public bool $selectAll = false;

    public ?int $selectedPostId = null;

    // Public properties for modal (no Computed)
    public $selectedPost = null;
    public $selectedProduct = null;
    public $selectedVariants = [];
    public $selectedGallery = [];

    public function mount(): void
    {
        $tenant = Auth::user()->tenant;
        abort_unless($tenant?->business_setup_completed, 403, 'Please complete your business setup first.');
        $this->tenantId = $tenant->id;
    }
    public $showVariantGallery = false;

    public function openVariantGallery()
    {
        $this->showVariantGallery = true;
    }

    public function closeVariantGallery()
    {
        $this->showVariantGallery = false;
    }
    public function getItemsProperty()
    {
        return Post::query()
            ->with('productCategory:id,name')
            ->where('tenant_id', $this->tenantId)
            ->where('created_by', Auth::id())
            ->where('type', 'product')
            ->when($this->search !== '', fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
            ->when($this->dateFilter === 'today', fn($q) => $q->whereDate('created_at', today()))
            ->when($this->dateFilter === 'week', fn($q) => $q->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]))
            ->when($this->dateFilter === 'month', fn($q) => $q->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year))
            ->when($this->dateFilter === 'custom' && $this->customDateFrom, fn($q) => $q->whereDate('created_at', '>=', $this->customDateFrom))
            ->when($this->dateFilter === 'custom' && $this->customDateTo, fn($q) => $q->whereDate('created_at', '<=', $this->customDateTo))
            ->latest()
            ->paginate(12);
    }

    public function viewItem(int $postId): void
    {
        $this->selectedPostId = $postId;

        // Load the post with category
        $this->selectedPost = Post::with(['productCategory:id,name'])
            ->where('tenant_id', $this->tenantId)
            ->where('id', $postId)
            ->where('type', 'product')
            ->first();

        // Load the actual Product using inventory_id from the post
        if ($this->selectedPost && $this->selectedPost->inventory_id) {
            $this->selectedProduct = Product::find($this->selectedPost->inventory_id);
            $this->selectedVariants = $this->selectedProduct?->variants ?? collect();
        } else {
            $this->selectedProduct = null;
            $this->selectedVariants = collect();
        }

        // Build gallery from post image
        $gallery = collect();
        if ($this->selectedPost && $this->selectedPost->image) {
            $gallery = collect([$this->selectedPost->image])->filter()->values();
        }
        $this->selectedGallery = $gallery;
    }

    public function closeItem(): void
    {
        $this->selectedPostId = null;
        $this->selectedPost = null;
        $this->selectedProduct = null;
        $this->selectedVariants = [];
        $this->selectedGallery = [];
    }

    public function navigateItem(string $direction): void
{

    $items = $this->items; 
    $ids = $items->getCollection()->pluck('id')->toArray();
    $currentIndex = array_search($this->selectedPostId, $ids, true);

    if ($currentIndex === false) {
        return;
    }

    $newIndex = $direction === 'next' ? $currentIndex + 1 : $currentIndex - 1;

    if (isset($ids[$newIndex])) {
        $this->viewItem($ids[$newIndex]);
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

        if ($this->selectedPostId === $postId) {
            $this->viewItem($postId);
        }

        unset($this->items);
    }

    public function toggleSelectAll(): void
    {
        $this->selectedIds = $this->selectAll
            ? $this->items->getCollection()->pluck('id')->map(fn($id) => (string) $id)->toArray()
            : [];
    }

    public function updatedSelectedIds(): void
    {
        $pageIds = $this->items->getCollection()->pluck('id')->map(fn($id) => (string) $id)->toArray();
        $this->selectAll = count($pageIds) > 0 && empty(array_diff($pageIds, $this->selectedIds));
    }

    public function clearSelection(): void
    {
        $this->selectedIds = [];
        $this->selectAll = false;
    }

    // ===== SIMPLE DELETION METHODS =====

    /**
     * Delete a single product - SIMPLE
     */
    public function deleteItem(int $postId): void
    {
        $deleted = Post::where('tenant_id', $this->tenantId)
            ->where('created_by', Auth::id())
            ->where('type', 'product')
            ->where('id', $postId)
            ->delete();

        if ($deleted) {
            if ($this->selectedPostId === $postId) {
                $this->selectedPostId = null;
            }

            $this->selectedIds = array_values(array_diff($this->selectedIds, [(string) $postId]));

            unset($this->items);
            session()->flash('message', 'Product deleted successfully.');
        } else {
            session()->flash('error', 'Product not found.');
        }
    }

    /**
     * Delete multiple selected products - SIMPLE
     */
    public function bulkDelete(): void
    {
        if (empty($this->selectedIds)) {
            session()->flash('error', 'No products selected.');
            return;
        }

        $count = Post::where('tenant_id', $this->tenantId)
            ->where('created_by', Auth::id())
            ->where('type', 'product')
            ->whereIn('id', $this->selectedIds)
            ->delete();

        if ($count > 0) {
            $this->clearSelection();
            unset($this->items);
            session()->flash('message', "{$count} product(s) deleted successfully.");
        } else {
            session()->flash('error', 'Failed to delete selected products.');
        }
    }
};

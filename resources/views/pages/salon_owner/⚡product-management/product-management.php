<?php
// Product Management
use App\Models\Post;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use App\Models\Tenant;
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
    public $selectedPost = null;
    public $selectedProduct = null;
    public $selectedVariants = null;
    public $selectedGallery = null;

    public function mount()
    {
        $user = Auth::user();
    
        $this->tenant = $user->tenant;
        
        if (!$this->tenant) {
            $this->tenant = Tenant::where('user_id', $user->id)->first();
        }
    
        if (!$this->tenant) {
            return redirect()->route('owner.business_setup')->with('error', 'Please complete your business setup first.');
        }

        $this->tenantId = $this->tenant->id;
        $this->showSetupModal = !$this->tenant->business_setup_completed;
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
            ->where('type', 'product')
            ->whereNull('archived_at')
            ->when($this->search !== '', fn ($q) => $q->where('name', 'like', '%' . $this->search . '%'))
            ->when($this->dateFilter === 'today', fn ($q) => $q->whereDate('created_at', today()))
            ->when($this->dateFilter === 'week', fn ($q) => $q->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]))
            ->when($this->dateFilter === 'month', fn ($q) => $q->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year))
            ->when($this->dateFilter === 'custom' && $this->customDateFrom, fn ($q) => $q->whereDate('created_at', '>=', $this->customDateFrom))
            ->when($this->dateFilter === 'custom' && $this->customDateTo, fn ($q) => $q->whereDate('created_at', '<=', $this->customDateTo))
            ->latest()
            ->paginate(12);
    }

    public function viewItem(?int $postId = null): void
    {
        if (!$postId) {
            return;
        }

        $this->selectedPostId = $postId;

        $this->selectedPost = Post::with('productCategory:id,name')
            ->where('tenant_id', $this->tenantId)
            ->where('id', $postId)
            ->where('type', 'product')
            ->first();

        if (!$this->selectedPost) {
            $this->selectedProduct = null;
            $this->selectedVariants = collect();
            $this->selectedGallery = collect();
            return;
        }

        $this->selectedProduct = Product::with('variants')
            ->where('tenant_id', $this->tenantId)
            ->find($this->selectedPost->inventory_id);

        $this->selectedVariants = $this->selectedProduct?->variants ?? collect();

        $this->selectedGallery = collect([$this->selectedProduct?->image, $this->selectedPost->image])
            ->merge($this->selectedVariants->pluck('image'))
            ->filter()
            ->unique()
            ->values();
    }

    public function closeItem(): void
    {
        $this->selectedPostId = null;
        $this->selectedPost = null;
        $this->selectedProduct = null;
        $this->selectedVariants = null;
        $this->selectedGallery = null;
    }

    public function navigateItem(string $direction = 'next'): void
    {
        $ids = $this->items->getCollection()->pluck('id')->toArray();
        $currentIndex = array_search($this->selectedPostId, $ids, true);

        if ($currentIndex === false) {
            return;
        }

        $newIndex = $direction === 'next' ? $currentIndex + 1 : $currentIndex - 1;

        if (isset($ids[$newIndex])) {
            $this->viewItem($ids[$newIndex]);
        }
    }

    public function toggleStatus(?int $postId = null): void
    {
        if (!$postId) {
            return;
        }
        
        $post = Post::where('tenant_id', $this->tenantId)
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


    public function deleteItem(?int $postId = null): void
    {
     
        $post = Post::where('tenant_id', $this->tenantId)
            ->where('type', 'product')
            ->where('id', $postId)
            ->first();

        if (!$post) {
            session()->flash('error', 'Product not found.');
            return;
        }

        $post->update(['archived_at' => now()]);

        if ($this->selectedPostId === $postId) {
            $this->closeItem();
        }

        $this->selectedIds = array_values(array_diff($this->selectedIds, [(string) $postId]));

        unset($this->items);
        session()->flash('message', 'Product archived successfully. You can restore it from the Archive page.');
    }

    public function bulkDelete(): void
    {

        if (empty($this->selectedIds)) {
            session()->flash('error', 'No products selected.');
            return;
        }

        $count = Post::where('tenant_id', $this->tenantId)
            ->where('type', 'product')
            ->whereIn('id', $this->selectedIds)
            ->update(['archived_at' => now()]);

        if ($count > 0) {
            $this->clearSelection();
            unset($this->items);
            session()->flash('message', "{$count} product(s) archived successfully.");
        } else {
            session()->flash('error', 'Failed to archive selected products.');
        }
    }
};
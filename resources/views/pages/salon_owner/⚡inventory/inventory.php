<?php

use App\Models\InventoryLog;
use App\Models\ItemVariant;
use App\Models\Post;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Tenant;
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

    #[Url(as: 'tab')]
    public string $activeTab = 'stock';

    #[Url(as: 'q')]
    public string $search = '';

    public string $stockFilter = 'all';
    public string $logTypeFilter = 'all';

    public ?int $adjustProductId = null;
    public ?int $adjustVariantId = null;
    public string $adjustType = 'restock';
    public ?int $adjustQuantity = null;
    public ?string $adjustReference = null;
    public bool $showAdjustModal = false;

    public ?int $stockManagerProductId = null;
    public bool $showStockManagerModal = false;

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
        $this->resetPage('stockPage');
    }

    public function updatingStockFilter(): void
    {
        $this->resetPage('stockPage');
    }

    public function updatingLogTypeFilter(): void
    {
        $this->resetPage('historyPage');
    }

    #[Computed]
    public function stats(): array
    {
        $base = Product::where('tenant_id', $this->tenantId)->whereNull('archived_at');

        return [
            'total' => (clone $base)->count(),
            'total_stock' => (clone $base)->sum('stock'),
            'available_categories' => ProductCategory::where('tenant_id', $this->tenantId)
                ->where('status', 'active')
                ->count(),
            'draft' => Post::query()
                ->product()
                ->draft()
                ->where('tenant_id', $this->tenantId)
                ->whereNull('archived_at')
                ->count(),
        ];
    }

    #[Computed]
    public function products()
    {
        $products = Product::query()
            ->with('productCategory:id,name')
            ->withCount('variants')
            ->where('tenant_id', $this->tenantId)
            ->whereNull('archived_at')
            ->when($this->search !== '', fn ($q) => $q->where(function ($q2) {
                $q2->where('name', 'like', '%' . $this->search . '%')
                   ->orWhere('sku', 'like', '%' . $this->search . '%');
            }))
            ->when($this->stockFilter === 'low', fn ($q) => $q->whereColumn('stock', '<=', 'low_stock_alert')->where('stock', '>', 0))
            ->when($this->stockFilter === 'out', fn ($q) => $q->where('stock', '<=', 0))
            ->orderBy('name')
            ->paginate(10, pageName: 'stockPage');

        // Get post_ids for ALL products (including archived posts) to show the archive button
        $postIdsByProduct = Post::where('tenant_id', $this->tenantId)
            ->where('type', 'product')
            ->whereIn('inventory_id', $products->pluck('id'))
            ->pluck('id', 'inventory_id');

        $products->getCollection()->transform(function ($product) use ($postIdsByProduct) {
            $product->post_id = $postIdsByProduct->get($product->id);
            return $product;
        });

        return $products;
    }

    #[Computed]
    public function logs()
    {
        return InventoryLog::query()
            ->with('product:id,name,sku')
            ->where('tenant_id', $this->tenantId)
            ->when($this->logTypeFilter !== 'all', fn ($q) => $q->where('type', $this->logTypeFilter))
            ->latest()
            ->paginate(15, pageName: 'historyPage');
    }

    #[Computed]
    public function adjustProduct()
    {
        if (!$this->adjustProductId) {
            return null;
        }

        return Product::where('tenant_id', $this->tenantId)->find($this->adjustProductId);
    }

    #[Computed]
    public function adjustVariant()
    {
        if (!$this->adjustVariantId) {
            return null;
        }

        return ItemVariant::where('tenant_id', $this->tenantId)->find($this->adjustVariantId);
    }

    #[Computed]
    public function stockManagerProduct()
    {
        if (!$this->stockManagerProductId) {
            return null;
        }

        return Product::with('variants')
            ->where('tenant_id', $this->tenantId)
            ->find($this->stockManagerProductId);
    }

    public function openStockManager(?int $productId = null): void
    {
        if (!$productId) {
            return;
        }

        $product = Product::where('tenant_id', $this->tenantId)
            ->withCount('variants')
            ->find($productId);

        if (!$product) {
            return;
        }

        if ($product->variants_count > 0) {
            $this->stockManagerProductId = $productId;
            $this->showStockManagerModal = true;
        } else {
            $this->openAdjustModal($productId);
        }
    }

    public function closeStockManager(): void
    {
        $this->showStockManagerModal = false;
        $this->stockManagerProductId = null;
    }

    public function openAdjustModal(?int $productId = null, ?int $variantId = null): void
    {
        if (!$productId) {
            return;
        }

        $this->adjustProductId = $productId;
        $this->adjustVariantId = $variantId;
        $this->adjustType = 'restock';
        $this->adjustQuantity = null;
        $this->adjustReference = null;
        $this->showAdjustModal = true;
        $this->showStockManagerModal = false;
    }

    public function closeAdjustModal(): void
    {
        $this->showAdjustModal = false;
        $this->adjustProductId = null;
        $this->adjustVariantId = null;
    }

    public function adjustStock(): void
    {
        $this->validate([
            'adjustType' => 'required|in:restock,sale,adjustment,return,damage',
            'adjustQuantity' => 'required|integer|min:1',
            'adjustReference' => 'nullable|string|max:255',
        ]);

        try {
            DB::transaction(function () {
                $isDeduction = in_array($this->adjustType, ['sale', 'damage'], true);

                if ($this->adjustVariantId) {
                    $variant = ItemVariant::where('tenant_id', $this->tenantId)
                        ->lockForUpdate()
                        ->findOrFail($this->adjustVariantId);

                    $stockBefore = $variant->stock ?? 0;
                    $stockAfter = $isDeduction
                        ? max(0, $stockBefore - $this->adjustQuantity)
                        : $stockBefore + $this->adjustQuantity;

                    $variant->update(['stock' => $stockAfter]);

                    $product = Product::where('tenant_id', $this->tenantId)
                        ->lockForUpdate()
                        ->findOrFail($variant->product_id);

                    $product->update([
                        'stock' => ItemVariant::where('product_id', $product->id)->sum('stock'),
                    ]);

                    $variantLabel = collect($variant->attributes ?? [])
                        ->map(fn ($value, $key) => "{$key}: {$value}")
                        ->implode(' / ');

                    $reference = trim(($variantLabel ? "Variant: {$variantLabel}. " : '') . ($this->adjustReference ?? ''));

                    InventoryLog::create([
                        'tenant_id' => $this->tenantId,
                        'product_id' => $product->id,
                        'type' => $this->adjustType,
                        'quantity' => $this->adjustQuantity,
                        'stock_before' => $stockBefore,
                        'stock_after' => $stockAfter,
                        'reference' => $reference ?: null,
                    ]);
                } else {
                    $product = Product::where('tenant_id', $this->tenantId)
                        ->lockForUpdate()
                        ->findOrFail($this->adjustProductId);

                    $stockBefore = $product->stock;
                    $stockAfter = $isDeduction
                        ? max(0, $stockBefore - $this->adjustQuantity)
                        : $stockBefore + $this->adjustQuantity;

                    $product->update(['stock' => $stockAfter]);

                    InventoryLog::create([
                        'tenant_id' => $this->tenantId,
                        'product_id' => $product->id,
                        'type' => $this->adjustType,
                        'quantity' => $this->adjustQuantity,
                        'stock_before' => $stockBefore,
                        'stock_after' => $stockAfter,
                        'reference' => $this->adjustReference,
                    ]);
                }
            });

            $this->closeAdjustModal();
            unset($this->products);
            unset($this->logs);
            unset($this->stats);
            unset($this->stockManagerProduct);

            session()->flash('message', 'Stock updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error adjusting stock', [
                'error' => $e->getMessage(),
                'product_id' => $this->adjustProductId,
                'variant_id' => $this->adjustVariantId,
            ]);
            session()->flash('error', 'Failed to update stock. Please try again.');
        }
    }

    public function viewProduct(?int $postId = null): void
    {
        if (!$postId) {
            return;
        }

        $this->selectedPostId = $postId;

        $this->selectedPost = Post::with('productCategory')
            ->where('tenant_id', $this->tenantId)
            ->where('type', 'product')
            ->find($postId);

        if ($this->selectedPost) {
            $this->selectedProduct = Product::with('variants')
                ->where('tenant_id', $this->tenantId)
                ->find($this->selectedPost->inventory_id);

            $this->selectedVariants = $this->selectedProduct?->variants ?? collect();

            $gallery = [];
            if ($this->selectedProduct?->image) {
                $gallery[] = $this->selectedProduct->image;
            }
            foreach ($this->selectedVariants ?? [] as $variant) {
                if ($variant->image) {
                    $gallery[] = $variant->image;
                }
            }
            $this->selectedGallery = array_values(array_unique($gallery));
        } else {
            $this->selectedProduct = null;
            $this->selectedVariants = collect();
            $this->selectedGallery = [];
        }
    }

    public function viewProductById(?int $productId = null): void
    {
        if (!$productId) {
            return;
        }

        $postId = Post::where('tenant_id', $this->tenantId)
            ->where('type', 'product')
            ->where('inventory_id', $productId)
            ->value('id');

        if ($postId) {
            $this->viewProduct($postId);
        }
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
        if (!$this->selectedProduct) {
            return;
        }

        $ids = $this->products->getCollection()->pluck('id')->toArray();
        $currentIndex = array_search($this->selectedProduct->id, $ids, true);

        if ($currentIndex === false) {
            return;
        }

        $newIndex = $direction === 'next' ? $currentIndex + 1 : $currentIndex - 1;

        if (isset($ids[$newIndex])) {
            $this->viewProductById($ids[$newIndex]);
        }
    }

    public function toggleStatus(?int $postId = null): void
    {
        if (!$postId) {
            return;
        }

        $post = Post::where('tenant_id', $this->tenantId)->find($postId);

        if (!$post) {
            return;
        }

        $post->update(['status' => $post->status === 'published' ? 'draft' : 'published']);

        if ($this->selectedPostId === $postId) {
            $this->viewProduct($postId);
        }

        unset($this->stats);
        session()->flash('message', 'Product status updated!');
    }

    public function deleteItem(?int $postId = null): void
    {
        if (!$postId) {
            return;
        }

        $post = Post::where('tenant_id', $this->tenantId)
            ->where('type', 'product')
            ->whereNull('archived_at')
            ->find($postId);

        if (!$post) {
            session()->flash('error', 'Product not found or already archived.');
            return;
        }

        DB::transaction(function () use ($post) {
            $post->update(['archived_at' => now()]);
            if ($post->inventory_id) {
                Product::where('tenant_id', $this->tenantId)
                    ->where('id', $post->inventory_id)
                    ->update(['archived_at' => now()]);
            }
        });

        if ($this->selectedPostId === $postId) {
            $this->closeItem();
        }

        unset($this->products);
        unset($this->stats);
        session()->flash('message', 'Product archived successfully.');
    }
};
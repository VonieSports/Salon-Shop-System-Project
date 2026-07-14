<?php

use App\Livewire\Concerns\BuildsVariants;
use App\Models\ItemVariant;
use App\Models\Post;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

new #[Layout('layouts.salon_owner')] class extends Component
{
    use WithFileUploads, BuildsVariants;

    private const LOW_STOCK_ALERT = 5;

    public string $name = '';
    public ?int $product_category_id = null;
    public float $cost_price = 0;
    public float $selling_price = 0;
    public ?string $description = null;
    public $image = null;
    public string $status = 'draft';
    public int $stock = 0;

    public ?string $newCategoryName = null;
    public ?int $tenantId = null;

    public function mount(): void
    {
        $tenant = Auth::user()->tenant;

        abort_unless($tenant?->business_setup_completed, 403, 'Please complete your business setup first.');

        $this->tenantId = $tenant->id;
        $this->resetVariantBuilder();
    }

    protected function defaultVariantFields(): array
    {
        return ['stock' => 0, 'price_adjustment' => 0];
    }

    protected function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'product_category_id' => 'required|exists:product_categories,id',
            'cost_price' => 'required|numeric|min:1',
            'selling_price' => 'required|numeric|min:1|gte:cost_price',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published',
        ];

        if ($this->hasVariants) {
            $rules['variants'] = 'required|array|min:1';
            $rules['variants.*.stock'] = 'required|integer|min:0';
            $rules['variants.*.price_adjustment'] = 'nullable|numeric';
            $rules['variantOptions.0.values.*.image'] = 'nullable|file|image|max:2048';
        } else {
            $rules['stock'] = 'required|integer|min:0';
        }

        return $rules;
    }

    protected function messages(): array
    {
        return [
            'variants.required' => 'Click "Generate Variants" to build your combinations first.',
            'selling_price.gte' => 'Selling price cannot be lower than cost price.',
        ];
    }

    #[Computed]
    public function categories()
    {
        return ProductCategory::where('tenant_id', $this->tenantId)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();
    }

    #[Computed]
    public function inventoryProducts()
    {
        return Post::with('productCategory:id,name')
            ->select('id', 'product_category_id', 'name', 'image', 'price', 'status')
            ->where('tenant_id', $this->tenantId)
            ->where('created_by', Auth::id())
            ->where('type', 'product')
            ->latest()
            ->limit(20)
            ->get();
    }

    public function createCategory(): void
    {
        $this->validate([
            'newCategoryName' => [
                'required', 'string', 'max:255',
                Rule::unique('product_categories', 'name')->where('tenant_id', $this->tenantId),
            ],
        ]);

        $category = ProductCategory::create([
            'tenant_id' => $this->tenantId,
            'name' => $this->newCategoryName,
            'status' => 'active',
        ]);

        $this->newCategoryName = '';
        $this->product_category_id = $category->id;
        unset($this->categories);
        $this->dispatch('category-created');

        session()->flash('message', 'Category created successfully!');
    }

    public function save(): void
    {
        $this->validate();

        try {
            DB::transaction(function () {
                $imagePath = $this->image?->store('products', 'public');
                $baseSku = 'PRD-' . strtoupper(Str::random(8));

                $product = Product::create([
                    'tenant_id' => $this->tenantId,
                    'product_category_id' => $this->product_category_id,
                    'name' => $this->name,
                    'image' => $imagePath,
                    'sku' => $baseSku,
                    'cost_price' => $this->cost_price,
                    'selling_price' => $this->selling_price,
                    'stock' => $this->hasVariants ? collect($this->variants)->sum('stock') : $this->stock,
                    'low_stock_alert' => self::LOW_STOCK_ALERT,
                    'notes' => $this->description,
                ]);

                if ($this->hasVariants) {
                    $valueImagePaths = $this->storeVariantValueImages('product-variants');

                    foreach ($this->variants as $i => $variant) {
                        ItemVariant::create([
                            'tenant_id' => $this->tenantId,
                            'product_id' => $product->id,
                            'attributes' => $variant['attributes'],
                            'sku' => $baseSku . '-' . ($i + 1) . strtoupper(Str::random(3)),
                            'stock' => $variant['stock'],
                            'price_adjustment' => $variant['price_adjustment'] ?? 0,
                            'image' => $this->variantImagePathFor($variant['attributes'], $valueImagePaths),
                            'is_optional' => false,
                        ]);
                    }
                }

                Post::create([
                    'tenant_id' => $this->tenantId,
                    'created_by' => Auth::id(),
                    'product_category_id' => $this->product_category_id,
                    'type' => 'product',
                    'inventory_type' => Product::class,
                    'inventory_id' => $product->id,
                    'name' => $this->name,
                    'image' => $imagePath,
                    'price' => $this->selling_price,
                    'description' => $this->description,
                    'status' => $this->status,
                ]);
            });

            $count = $this->hasVariants ? count($this->variants) : 0;
            session()->flash('message', 'Product created successfully' . ($count ? " with {$count} variant(s)!" : '!'));

            $this->reset(['name', 'product_category_id', 'cost_price', 'selling_price', 'description', 'image', 'status', 'stock', 'hasVariants']);
            $this->resetVariantBuilder();
            unset($this->inventoryProducts);
        } catch (\Exception $e) {
            Log::error('Error saving product', ['error' => $e->getMessage(), 'tenant_id' => $this->tenantId]);
            session()->flash('error', 'Failed to save product. Please try again.');
        }
    }

    public function editProduct(int $postId)
    {
        return redirect()->route('owner.update_product', $postId);
    }

    public function deleteProduct(int $postId): void
    {
        $post = Post::with('inventory')
            ->where('id', $postId)
            ->where('created_by', Auth::id())
            ->where('type', 'product')
            ->first();

        if (!$post) {
            session()->flash('error', 'Product not found.');
            return;
        }

        DB::transaction(function () use ($post) {
            $post->inventory?->variants()->delete();
            $post->inventory?->delete();
            $post->delete();
        });

        unset($this->inventoryProducts);
        session()->flash('message', 'Product deleted successfully.');
    }
};
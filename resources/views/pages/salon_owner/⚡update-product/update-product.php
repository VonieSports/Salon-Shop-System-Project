<?php

use App\Models\ItemVariant;
use App\Models\Post;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

new #[Layout('layouts.salon_owner')] class extends Component
{
   use WithFileUploads;

    public $postId;
    public $name;
    public $description;
    public $status;
    public $image;
    public $existingImage;

    public $productId;
    public $category_id;
    public $cost_price;
    public $selling_price;
    public $stock;

    public $hasVariants = false;
    public $variants = [];
    public $existingVariants = [];
    public $variantImages = [];

    public $post;
    public $product;

    public function mount($id): void
    {
        $tenant = Auth::user()->tenant;
        abort_unless($tenant?->business_setup_completed, 403, 'Please complete your business setup first.');

        $this->postId = $id;
        
        $this->post = Post::where('tenant_id', $tenant->id)
            ->where('created_by', Auth::id())
            ->where('type', 'product')
            ->where('id', $id)
            ->firstOrFail();

        $this->product = Product::where('tenant_id', $tenant->id)
            ->where('id', $this->post->inventory_id)
            ->firstOrFail();

        $this->name = $this->post->name;
        $this->description = $this->post->description;
        $this->status = $this->post->status;
        $this->existingImage = $this->post->image;

        $this->productId = $this->product->id;
        $this->category_id = $this->product->product_category_id;
        $this->cost_price = $this->product->cost_price;
        $this->selling_price = $this->product->selling_price;
        $this->stock = $this->product->stock;

        $this->existingVariants = ItemVariant::where('product_id', $this->productId)
            ->where('tenant_id', $tenant->id)
            ->get()
            ->toArray();

        $this->hasVariants = count($this->existingVariants) > 0;
        $this->variants = $this->existingVariants;
    }

    protected function rules()
    {
        $rules = [
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|in:draft,published',
            'image' => 'nullable|image|max:2048',
            'category_id' => 'nullable|exists:product_categories,id',
            'cost_price' => 'nullable|numeric|min:1',
            'selling_price' => 'nullable|numeric|min:1|gte:cost_price',
            'stock' => 'nullable|integer|min:0',
            'variantImages.*' => 'nullable|image|max:2048',
        ];

        if ($this->hasVariants) {
            $rules['variants.*.stock'] = 'nullable|integer|min:0';
            $rules['variants.*.price_adjustment'] = 'nullable|numeric';
        }

        return $rules;
    }

    public function save()
    {
        $this->validate();

        DB::transaction(function () {
            // Handle main image
            $imagePath = $this->existingImage;
            if ($this->image) {
                if ($this->existingImage) {
                    Storage::disk('public')->delete($this->existingImage);
                }
                $imagePath = $this->image->store('products', 'public');
            }

            // Update post
            $this->post->update([
                'name' => $this->name,
                'description' => $this->description,
                'status' => $this->status,
                'image' => $imagePath,
                'price' => $this->selling_price,
            ]);

            // Update product
            $this->product->update([
                'product_category_id' => $this->category_id,
                'name' => $this->name,
                'image' => $imagePath,
                'cost_price' => $this->cost_price,
                'selling_price' => $this->selling_price,
                'stock' => $this->hasVariants ? collect($this->variants)->sum('stock') : $this->stock,
            ]);

            $this->syncVariants();
        });

        session()->flash('message', 'Product updated successfully!');
        return redirect()->route('owner.product_management');
    }

    private function syncVariants(): void
    {
        if (!$this->hasVariants) {
            ItemVariant::where('product_id', $this->productId)
                ->where('tenant_id', Auth::user()->tenant->id)
                ->delete();
            return;
        }

        $currentIds = collect($this->variants)
            ->filter(fn($v) => isset($v['id']))
            ->pluck('id')
            ->toArray();

        ItemVariant::where('product_id', $this->productId)
            ->where('tenant_id', Auth::user()->tenant->id)
            ->whereNotIn('id', $currentIds)
            ->delete();

        foreach ($this->variants as $index => $variant) {
            $variantImagePath = $variant['image'] ?? null;

            if (isset($this->variantImages[$index]) && $this->variantImages[$index]) {
                if ($variantImagePath && !str_contains($variantImagePath, 'temporary')) {
                    Storage::disk('public')->delete($variantImagePath);
                }
                $variantImagePath = $this->variantImages[$index]->store('product-variants', 'public');
            } elseif (isset($variant['existing_image']) && $variant['existing_image']) {
                $variantImagePath = $variant['existing_image'];
            }

            $data = [
                'tenant_id' => Auth::user()->tenant->id,
                'product_id' => $this->productId,
                'service_id' => null,
                'attributes' => $variant['attributes'],
                'stock' => $variant['stock'] ?? 0,
                'price_adjustment' => $variant['price_adjustment'] ?? 0,
                'duration_adjustment' => 0,
                'image' => $variantImagePath,
                'is_optional' => false,
            ];

            if (isset($variant['id']) && $variant['id']) {
                ItemVariant::where('id', $variant['id'])->update($data);
            } else {
                $data['sku'] = 'PRD-' . strtoupper(Str::random(8));
                ItemVariant::create($data);
            }
        }
    }

    public function removeImage()
{
    if ($this->existingImage) {
        Storage::disk('public')->delete($this->existingImage);
        $this->existingImage = null;
    }
    $this->image = null;
    session()->flash('message', 'Image removed successfully.');
}

    #[Computed]
    public function categories()
    {
        return ProductCategory::where('tenant_id', Auth::user()->tenant->id)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();
    }

public $showConfirmationModal = false;
public $confirmationTitle = 'Remove this Image?';
public $confirmationMessage = 'This action cannot be undone. The image will be permanently deleted.';
public $confirmationAction = null;
public $confirmationData = null;

public function confirmRemoveVariantImage($index)
{
    $this->confirmationTitle = 'Remove this Image?';
    $this->confirmationMessage = 'This action cannot be undone. The image will be permanently deleted.';
    $this->confirmationAction = 'removeVariantImage';
    $this->confirmationData = $index;
    $this->showConfirmationModal = true;
}

public function confirmAction()
{
    if ($this->confirmationAction === 'removeVariantImage' && $this->confirmationData !== null) {
        $this->removeVariantImage($this->confirmationData);
    }
    $this->showConfirmationModal = false;
    $this->confirmationData = null;
    $this->confirmationAction = null;
}

public function cancelConfirmation()
{
    $this->showConfirmationModal = false;
    $this->confirmationData = null;
    $this->confirmationAction = null;
}

public function removeVariantImage($index)
{
    if (isset($this->variants[$index]['image']) && $this->variants[$index]['image']) {
        Storage::disk('public')->delete($this->variants[$index]['image']);
    }
    $this->variants[$index]['image'] = null;
    $this->variants[$index]['existing_image'] = null;
    unset($this->variantImages[$index]);
    
    session()->flash('message', 'Image removed successfully.');
}

};
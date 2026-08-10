<?php

use App\Models\Post;
use App\Services\CartService;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.customer')] class extends Component
{
    public Post $post;
    public int $quantity = 1;
    public array $selectedAttributes = [];
    public ?string $currentImage = null;
    public ?int $selectedVariantId = null;

    /**
     * Bound automatically because the route segment is named {post},
     * matching this parameter name exactly (implicit route model binding).
     */
    public function mount(Post $post): void
    {
        abort_unless($post->status === 'published' && is_null($post->archived_at), 404);

        $post->load(['tenant:id,name', 'productCategory:id,name', 'serviceCategory:id,name']);
        $post->load($post->type === 'product' ? 'inventory.variants' : 'inventory');

        $this->post = $post;
        $this->currentImage = $this->post->image;

        if ($this->post->type === 'product' && $this->availableOptions) {
            $firstVariant = $this->post->inventory?->variants?->first();
            if ($firstVariant) {
                $this->selectedAttributes = is_array($firstVariant->attributes)
                    ? $firstVariant->attributes
                    : (json_decode($firstVariant->attributes, true) ?? []);
                $this->selectedVariantId = $firstVariant->id;
                if ($firstVariant->image) {
                    $this->currentImage = $firstVariant->image;
                }
            }
        }
    }

    #[Computed]
    public function availableOptions(): array
    {
        if ($this->post->type !== 'product') return [];

        $variants = $this->post->inventory?->variants ?? collect();
        $options = [];

        foreach ($variants as $variant) {
            $attributes = is_array($variant->attributes) ? $variant->attributes : (json_decode($variant->attributes, true) ?? []);
            foreach ($attributes as $key => $value) {
                $options[$key][] = $value;
            }
        }

        return array_map(fn ($values) => array_values(array_unique($values)), $options);
    }

    #[Computed]
    public function selectedVariant()
    {
        if (!$this->selectedVariantId) return null;

        return $this->post->inventory?->variants?->firstWhere('id', $this->selectedVariantId);
    }

    #[Computed]
    public function displayPrice(): float
    {
        $base = (float) ($this->post->price ?? 0);

        if ($this->selectedVariant && $this->selectedVariant->price_adjustment) {
            return $base + (float) $this->selectedVariant->price_adjustment;
        }

        return $base;
    }

    #[Computed]
    public function stock(): int
    {
        if ($this->post->type !== 'product') return 0;

        if ($this->selectedVariant) {
            return $this->selectedVariant->stock ?? 0;
        }

        return $this->post->inventory?->stock ?? 0;
    }

    #[Computed]
    public function stockStatus(): string
    {
        $stock = $this->stock;
        $threshold = $this->post->inventory?->low_stock_alert ?? 5;

        if ($stock <= 0) return 'out';
        if ($stock <= $threshold) return 'low';
        return 'in';
    }

    #[Computed]
    public function allImages(): array
    {
        return collect([$this->post->image])
            ->merge(($this->post->inventory?->variants ?? collect())->pluck('image'))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    #[Computed]
    public function reviewCount(): int
    {
        return class_exists(\App\Models\Review::class)
            ? \App\Models\Review::where('product_id', $this->post->inventory?->id)->count()
            : 0;
    }

    public function selectImage(int $index): void
    {
        $images = $this->allImages;
        if (isset($images[$index])) {
            $this->currentImage = $images[$index];
        }
    }

    public function previousImage(): void
    {
        $images = $this->allImages;
        if (count($images) <= 1) return;

        $i = array_search($this->currentImage, $images, true);
        $this->currentImage = $images[$i !== false && $i > 0 ? $i - 1 : count($images) - 1];
    }

    public function nextImage(): void
    {
        $images = $this->allImages;
        if (count($images) <= 1) return;

        $i = array_search($this->currentImage, $images, true);
        $this->currentImage = $images[$i !== false && $i < count($images) - 1 ? $i + 1 : 0];
    }

    public function selectAttributeValue(string $attribute, string $value): void
    {
        $this->selectedAttributes[$attribute] = $value;
        $this->resetErrorBag('variant');

        $matched = ($this->post->inventory?->variants ?? collect())->first(function ($variant) {
            $attributes = is_array($variant->attributes) ? $variant->attributes : (json_decode($variant->attributes, true) ?? []);
            foreach ($this->selectedAttributes as $key => $val) {
                if (($attributes[$key] ?? null) !== $val) return false;
            }
            return true;
        });

        $this->selectedVariantId = $matched?->id;

        if ($matched?->image) {
            $this->currentImage = $matched->image;
        }
    }

    public function incrementQuantity(): void
    {
        $this->quantity = min($this->quantity + 1, max(1, $this->stock ?: 99));
    }

    public function decrementQuantity(): void
    {
        $this->quantity = max(1, $this->quantity - 1);
    }

    protected function canAddToCart(): bool
    {
        $this->resetErrorBag(['variant', 'stock']);

        if ($this->post->type === 'product' && !empty($this->availableOptions) && !$this->selectedVariantId) {
            $this->addError('variant', 'Please select all variant options before continuing.');
            return false;
        }

        if ($this->stockStatus === 'out') {
            $this->addError('stock', 'This item is currently out of stock.');
            return false;
        }

        return true;
    }

    public function addToCart(): void
    {
        if (!$this->canAddToCart()) return;

        app(CartService::class)->add([
            'tenant_id' => $this->post->tenant_id,
            'product_id' => $this->post->inventory?->id,
            'variant_id' => $this->selectedVariantId,
            'name' => $this->post->name,
            'image' => $this->currentImage ?? $this->post->image,
            'unit_price' => $this->displayPrice,
            'quantity' => $this->quantity,
            'variant_attributes' => $this->selectedVariantId ? $this->selectedAttributes : [],
            'max_stock' => $this->stock ?: 999,
        ]);

        session()->flash('message', 'Added to cart successfully!');
    }

    public function buyNow()
    {
        if (!$this->canAddToCart()) return;

        app(CartService::class)->add([
            'tenant_id' => $this->post->tenant_id,
            'product_id' => $this->post->inventory?->id,
            'variant_id' => $this->selectedVariantId,
            'name' => $this->post->name,
            'image' => $this->currentImage ?? $this->post->image,
            'unit_price' => $this->displayPrice,
            'quantity' => $this->quantity,
            'variant_attributes' => $this->selectedVariantId ? $this->selectedAttributes : [],
            'max_stock' => $this->stock ?: 999,
        ]);

        return redirect()->route('customer.checkout');
    }
};
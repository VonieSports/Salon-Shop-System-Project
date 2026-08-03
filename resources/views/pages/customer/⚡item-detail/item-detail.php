<?php

use App\Models\ItemVariant;
use App\Models\Post;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.customer')] class extends Component
{
    public Post $post;
    public $inventory;
    public $variants = [];

    public array $selectedAttributes = [];
    public ?int $selectedVariantId = null;

    public int $quantity = 1;
    public ?string $currentImage = null;

    /**
     * Placeholder rating data — there is no reviews table in the schema
     * yet, so this is generated once in mount() rather than called
     * separately in multiple places in the view (which previously
     * produced two different, inconsistent numbers on the same page).
     * Replace with a real query once a `reviews` table exists.
     */
    public int $reviewCount = 0;

    public function mount($id): void
    {
        $this->post = Post::with(['tenant:id,name', 'inventory', 'productCategory:id,name', 'serviceCategory:id,name'])
            ->published()
            ->whereNull('archived_at')
            ->findOrFail($id);

        $this->inventory = $this->post->inventory;
        $this->currentImage = $this->post->image;
        $this->reviewCount = rand(100, 500);

        if ($this->post->type === 'product' && $this->inventory) {
            $this->variants = ItemVariant::where('product_id', $this->inventory->id)->get();

            if ($this->variants->isNotEmpty()) {
                $firstVariant = $this->variants->first();
                $this->selectedAttributes = $firstVariant->attributes ?? [];
                $this->selectedVariantId = $firstVariant->id;
            }
        }
    }

    #[Computed]
    public function selectedVariant()
    {
        if (!$this->selectedVariantId) {
            return null;
        }

        return $this->variants->firstWhere('id', $this->selectedVariantId);
    }

    /**
     * Built entirely from the $variants collection already loaded in
     * mount() — zero database queries, including on image navigation
     * clicks, which previously re-queried the database on every click.
     */
    #[Computed]
    public function allImages()
    {
        return collect([$this->post->image])
            ->merge($this->variants->pluck('image'))
            ->filter()
            ->unique()
            ->values();
    }

    #[Computed]
    public function availableOptions(): array
    {
        $options = [];

        foreach ($this->variants as $variant) {
            foreach ($variant->attributes ?? [] as $key => $value) {
                $options[$key][] = $value;
            }
        }

        return array_map(fn ($values) => array_values(array_unique($values)), $options);
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
    public function stock(): ?int
    {
        if ($this->post->type !== 'product') {
            return null;
        }

        if ($this->selectedVariant) {
            return $this->selectedVariant->stock ?? 0;
        }

        return $this->inventory->stock ?? 0;
    }

    /**
     * Single source of truth for the stock badge — replaces the
     * hardcoded "In Stock" text that never reflected real data.
     */
    #[Computed]
    public function stockStatus(): ?string
    {
        if ($this->post->type !== 'product') {
            return null;
        }

        $stock = $this->stock;
        $threshold = $this->inventory->low_stock_alert ?? 0;

        if ($stock <= 0) {
            return 'out';
        }

        if ($stock <= $threshold) {
            return 'low';
        }

        return 'in';
    }

    #[Computed]
    public function isFavorited(): bool
    {
        return in_array($this->post->id, session()->get('favorites', []));
    }

    /**
     * Same tenant, different listing. Only Post-level columns are used
     * in the view, so no eager load of `inventory` is needed here.
     */
    #[Computed]
    public function shopProducts()
    {
        if (!$this->post->tenant_id) {
            return collect();
        }

        return Post::where('tenant_id', $this->post->tenant_id)
            ->where('id', '!=', $this->post->id)
            ->published()
            ->whereNull('archived_at')
            ->product()
            ->inRandomOrder()
            ->limit(6)
            ->get();
    }

    /**
     * Dropped the previous ->with('inventory') eager load here — the
     * view never touches inventory fields for these cards, so it was
     * an extra query producing data that was thrown away.
     */
    #[Computed]
    public function recommendedProducts()
    {
        if (!$this->post->product_category_id) {
            return collect();
        }

        return Post::where('product_category_id', $this->post->product_category_id)
            ->where('id', '!=', $this->post->id)
            ->published()
            ->whereNull('archived_at')
            ->product()
            ->inRandomOrder()
            ->limit(4)
            ->get();
    }

    public function selectImage(int $index): void
    {
        $images = $this->allImages;

        if (isset($images[$index])) {
            $this->currentImage = $images[$index];
        }
    }

    public function nextImage(): void
    {
        $images = $this->allImages;
        $currentIndex = $images->search($this->currentImage);

        if ($currentIndex === false) {
            return;
        }

        $this->currentImage = $images[($currentIndex + 1) % $images->count()];
    }

    public function previousImage(): void
    {
        $images = $this->allImages;
        $currentIndex = $images->search($this->currentImage);

        if ($currentIndex === false) {
            return;
        }

        $this->currentImage = $images[($currentIndex - 1 + $images->count()) % $images->count()];
    }

    public function selectAttributeValue(string $attributeName, string $value): void
    {
        $this->selectedAttributes[$attributeName] = $value;

        $matchingVariant = $this->variants->first(function ($variant) {
            foreach ($this->selectedAttributes as $key => $val) {
                if (($variant->attributes[$key] ?? null) !== $val) {
                    return false;
                }
            }
            return true;
        });

        if ($matchingVariant) {
            $this->selectedVariantId = $matchingVariant->id;

            if ($matchingVariant->image) {
                $this->currentImage = $matchingVariant->image;
            }
        }
    }

    public function toggleFavorite(): void
    {
        $favorites = session()->get('favorites', []);

        if (in_array($this->post->id, $favorites)) {
            $favorites = array_diff($favorites, [$this->post->id]);
        } else {
            $favorites[] = $this->post->id;
        }

        session()->put('favorites', $favorites);
        unset($this->isFavorited);
    }

    /**
     * Replaces the broken inline "$set('quantity', max(1, $quantity - 1))"
     * expression, which mixed PHP syntax into a context Livewire
     * evaluates as JS — $quantity and max() are not valid there.
     */
    public function incrementQuantity(): void
    {
        $maxQuantity = $this->stock ?? 99;
        $this->quantity = min($this->quantity + 1, max(1, $maxQuantity));
    }

    public function decrementQuantity(): void
    {
        $this->quantity = max(1, $this->quantity - 1);
    }

    public function addToCart(): void
    {
        session()->flash('message', 'Added to cart successfully!');
    }

    public function buyNow()
    {
        return redirect()->route('customer.checkout');
    }
};
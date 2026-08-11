<?php

use App\Models\Post;
use App\Services\AvailabilityService;
use App\Services\CartService;
use App\Services\ProfileCompletenessService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
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
    public int $currentImageIndex = 0;

    public ?int $selectedEmployeeId = null;
    public string $selectedDate;

    public function mount(Post $post): void
    {
        abort_unless($post->status === 'published' && is_null($post->archived_at), 404);

        $post->load(['tenant:id,name,address,phone,business_hours', 'productCategory:id,name', 'serviceCategory:id,name']);
        $post->load($post->type === 'product' ? 'inventory.variants' : 'inventory.employees.user:id,name,avatar');

        $this->post = $post;
        $this->selectedDate = now()->toDateString();

        if ($post->type === 'product') {
            $this->currentImage = $post->image;
            
            $this->selectedAttributes = [];
            $this->selectedVariantId = null;
        } else {
            $this->currentImage = $post->image;
        }
        
        $images = $this->allImages;
        $this->currentImageIndex = array_search($this->currentImage, $images, true) ?: 0;
    }

    #[Computed]
    public function availableOptions(): array
    {
        if ($this->post->type !== 'product') return [];

        $variants = $this->post->inventory?->variants ?? collect();
        $options = [];
        foreach ($variants as $variant) {
            $attributes = is_array($variant->attributes) ? $variant->attributes : (json_decode($variant->attributes, true) ?? []);
            foreach ($attributes as $key => $value) $options[$key][] = $value;
        }

        return array_map(fn ($v) => array_values(array_unique($v)), $options);
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
        if ($this->post->type === 'product' && $this->selectedVariant?->price_adjustment) {
            return $base + (float) $this->selectedVariant->price_adjustment;
        }
        return $base;
    }

    #[Computed]
    public function stock(): int
    {
        if ($this->post->type !== 'product') return 0;
        if ($this->selectedVariant) return $this->selectedVariant->stock ?? 0;
        return 0;
    }

    #[Computed]
    public function stockStatus(): string
    {
        if ($this->post->type !== 'product') return 'in';
        
        if (!$this->selectedVariant) return 'select_required';

        $stock = $this->stock;
        $threshold = $this->post->inventory?->low_stock_alert ?? 5;
        if ($stock <= 0) return 'out';
        if ($stock <= $threshold) return 'low';
        return 'in';
    }

    #[Computed]
    public function allImages(): array
    {
        if ($this->post->type !== 'product') {
            return array_filter([$this->post->image]);
        }

        return collect([$this->post->image])
            ->merge(($this->post->inventory?->variants ?? collect())->pluck('image'))
            ->filter()->unique()->values()->all();
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
            $this->currentImageIndex = $index;
        }
    }

    public function previousImage(): void
    {
        $images = $this->allImages;
        if (count($images) <= 1) return;
        $i = array_search($this->currentImage, $images, true);
        $i = ($i !== false && $i > 0) ? $i - 1 : count($images) - 1;
        $this->currentImage = $images[$i];
        $this->currentImageIndex = $i;
    }

    public function nextImage(): void
    {
        $images = $this->allImages;
        if (count($images) <= 1) return;
        $i = array_search($this->currentImage, $images, true);
        $i = ($i !== false && $i < count($images) - 1) ? $i + 1 : 0;
        $this->currentImage = $images[$i];
        $this->currentImageIndex = $i;
    }

    public function selectAttributeValue(string $attribute, string $value): void
    {
       if (isset($this->selectedAttributes[$attribute]) && $this->selectedAttributes[$attribute] === $value) {
        unset($this->selectedAttributes[$attribute]);
    } else {
        $this->selectedAttributes[$attribute] = $value;
    }

    $this->resetErrorBag('variant');

    if (!empty($this->selectedAttributes)) {
        $matched = ($this->post->inventory?->variants ?? collect())->first(function ($variant) {
            $attributes = is_array($variant->attributes) ? $variant->attributes : (json_decode($variant->attributes, true) ?? []);
            foreach ($this->selectedAttributes as $k => $v) {
                if (($attributes[$k] ?? null) !== $v) return false;
            }
            return true;
        });

        $this->selectedVariantId = $matched?->id;
        if ($matched?->image) $this->currentImage = $matched->image;
    } else {
        $this->selectedVariantId = null;
     
        $this->currentImage = $this->post->image;
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

        if (!empty($this->availableOptions) && !$this->selectedVariantId) {
            $this->addError('variant', 'Please select an options before continuing.');
            return false;
        }
        if ($this->stockStatus === 'out') {
            $this->addError('stock', 'This item is currently out of stock.');
            return false;
        }
        return true;
    }

    protected function buildCartItem(): array
    {
        $variant = $this->selectedVariant;
        
        return [
            'tenant_id' => $this->post->tenant_id,
            'product_id' => $this->post->inventory?->id,
            'variant_id' => $this->selectedVariantId,
            'name' => $this->post->name,
            'image' => ($variant && $variant->image) ? $variant->image : ($this->currentImage ?? $this->post->image),
            'variant_image' => $variant ? $variant->image : null,
            'unit_price' => $this->displayPrice,
            'quantity' => $this->quantity,
            'variant_attributes' => $this->selectedVariantId ? $this->selectedAttributes : [],
            'max_stock' => $this->stock ?: 999,
        ];
    }

    public function addToCart(): void
    {
        if (!$this->canAddToCart()) return;
        app(CartService::class)->add($this->buildCartItem());
        session()->flash('message', 'Added to cart successfully!');
    }

    public function buyNow()
    {
        if (!$this->canAddToCart()) return;

        $cartService = app(CartService::class);
        $cartService->clearCart();
        $cartService->add($this->buildCartItem());
        
        session()->flash('message', 'Item added to cart. Proceed to checkout.');
        return redirect()->route('customer.cart');
    }

    #[Computed]
    public function eligibleEmployees()
    {
        if ($this->post->type !== 'service') return collect();
        return app(AvailabilityService::class)->eligibleEmployees($this->post);
    }

    #[Computed]
    public function hasAssignedStaff(): bool
    {
        return $this->post->type !== 'service' || $this->eligibleEmployees->isNotEmpty();
    }

    #[Computed]
    public function shopHoursForSelectedDate(): array
    {
        $hours = $this->post->tenant?->getBusinessHours() ?? [];
        $day = strtolower(Carbon::parse($this->selectedDate)->format('l'));

        if (empty($hours[$day]) || ($hours[$day]['closed'] ?? false)) {
            return ['open' => false, 'label' => 'Closed on this date'];
        }

        $open = $hours[$day]['open'] ?? null;
        $close = $hours[$day]['close'] ?? null;

        if (!$open || !$close) {
            return ['open' => true, 'label' => 'Hours not set'];
        }

        return [
            'open' => true,
            'label' => Carbon::createFromFormat('H:i', $open)->format('g:i A')
                . ' – '
                . Carbon::createFromFormat('H:i', $close)->format('g:i A'),
        ];
    }

    #[Computed]
    public function employeeAvailability()
    {
        if ($this->post->type !== 'service') return collect();

        return app(AvailabilityService::class)->employeeAvailability(
            $this->post,
            Carbon::parse($this->selectedDate),
            $this->eligibleEmployees
        );
    }

    public function selectEmployee(int $employeeId): void
    {
        $this->selectedEmployeeId = $employeeId;
    }

    public function bookService(ProfileCompletenessService $profileCheck)
    {
        if (!$this->selectedEmployeeId) {
            $this->addError('employee', 'Please choose a staff member first.');
            return;
        }

        $user = Auth::user();

        if (!$profileCheck->isComplete($user)) {
            session()->flash('warning', 'Please complete your profile (' . implode(', ', $profileCheck->missingFields($user)) . ') before booking a service.');
            return redirect()->route('customer.update_profile');
        }

        return redirect()->route('customer.service_checkout', [
            'post' => $this->post->id,
            'employee' => $this->selectedEmployeeId,
            'date' => $this->selectedDate,
        ]);
    }
};
<?php

use App\Models\Post;
use App\Models\ProductCategory;
use App\Models\ServiceCategory;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

new #[Layout('layouts.customer')] class extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filter = 'all'; // all, products, services
    public string $sort = 'newest'; // newest, price_low, price_high
    public ?int $selectedCategory = null;
    public array $favorites = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'filter' => ['except' => 'all'],
        'sort' => ['except' => 'newest'],
        'selectedCategory' => ['except' => null],
    ];

    public function mount()
    {
        $this->favorites = session()->get('favorites', []);
    }

    public function toggleFavorite($postId)
    {
        if (in_array($postId, $this->favorites)) {
            $this->favorites = array_diff($this->favorites, [$postId]);
        } else {
            $this->favorites[] = $postId;
        }
        session()->put('favorites', $this->favorites);
    }

    public function isFavorite($postId): bool
    {
        return in_array($postId, $this->favorites);
    }

    #[Computed]
    public function categories()
    {
        return ProductCategory::where('status', 'active')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();
    }

    #[Computed]
    public function items()
    {
        $query = Post::query()
            ->with(['tenant', 'productCategory', 'serviceCategory', 'inventory'])
            ->where('status', 'published')
            ->whereNull('archived_at');

        // Filter by type
        if ($this->filter === 'products') {
            $query->where('type', 'product');
        } elseif ($this->filter === 'services') {
            $query->where('type', 'service');
        }

        // Search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // Category filter
        if ($this->selectedCategory) {
            $query->where('product_category_id', $this->selectedCategory);
        }

        // Sorting
        switch ($this->sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            default: // newest
                $query->orderBy('created_at', 'desc');
                break;
        }

        return $query->paginate(12);
    }


};
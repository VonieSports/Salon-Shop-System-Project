<?php

use App\Models\Order;
use App\Models\Post;
use Livewire\Attributes\Layout;
use Livewire\Component; 

new #[Layout('layouts.customer')] class extends Component
{
    public $posts;
    public $orders;
    public $stats = [
        'total_posts' => 0,
        'total_products' => 0,
        'total_services' => 0,
        'total_orders' => 0,
        'pending_orders' => 0,
    ];

    public function mount()
    {
        $this->loadDashboardData();
    }

    public function loadDashboardData()
    {
        $tenantId = auth()->user()->tenant_id;
        $userId = auth()->id();

        // Eager load relationships to avoid N+1
        $this->posts = Post::with(['serviceCategory', 'productCategory'])
            ->where('tenant_id', $tenantId)
            ->where('created_by', $userId)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Get orders with eager loading
        $this->orders = Order::with(['items'])
            ->where('tenant_id', $tenantId)
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Calculate stats using optimized queries
        $this->stats = [
            'total_posts' => Post::where('tenant_id', $tenantId)
                ->where('created_by', $userId)
                ->count(),
            'total_products' => Post::where('tenant_id', $tenantId)
                ->where('created_by', $userId)
                ->where('type', 'product')
                ->count(),
            'total_services' => Post::where('tenant_id', $tenantId)
                ->where('created_by', $userId)
                ->where('type', 'service')
                ->count(),
            'total_orders' => Order::where('tenant_id', $tenantId)
                ->where('user_id', $userId)
                ->count(),
            'pending_orders' => Order::where('tenant_id', $tenantId)
                ->where('user_id', $userId)
                ->where('status', 'pending')
                ->count(),
        ];
    }

    public function deletePost($postId)
    {
        $post = Post::where('id', $postId)
            ->where('created_by', auth()->id())
            ->first();

        if ($post) {
            $post->delete();
            $this->loadDashboardData();
            session()->flash('message', 'Post deleted successfully.');
        }
    }
};
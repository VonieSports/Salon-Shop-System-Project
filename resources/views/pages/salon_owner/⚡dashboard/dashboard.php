<?php
//shop Owner Dashboard
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Models\Order;
use App\Models\Post;
use App\Models\Product;
use App\Models\Service;
use App\Models\ItemVariant;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Review;
use App\Models\Tenant;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

new #[Layout('layouts.salon_owner')] class extends Component
{
    public $tenant;
    public $showSetupModal = false;
    public ?int $tenantId = null;
    public string $dateRange = 'month';
    public array $dateRanges = [
        'day' => 'Today',
        'week' => 'This Week',
        'month' => 'This Month',
        'year' => 'This Year',
    ];
    
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

    public function updatedDateRange(): void
    {
        unset($this->analytics);
        unset($this->chartData);
        unset($this->topItems);
        unset($this->recentOrders);
        unset($this->shopRating);
    }

    private function getDateRange(): array
    {
        $now = Carbon::now();
        
        return match($this->dateRange) {
            'day' => [
                'start' => $now->copy()->startOfDay(),
                'end' => $now->copy()->endOfDay(),
                'label' => $now->format('F j, Y')
            ],
            'week' => [
                'start' => $now->copy()->startOfWeek(),
                'end' => $now->copy()->endOfWeek(),
                'label' => $now->copy()->startOfWeek()->format('M j') . ' - ' . $now->copy()->endOfWeek()->format('M j, Y')
            ],
            'month' => [
                'start' => $now->copy()->startOfMonth(),
                'end' => $now->copy()->endOfMonth(),
                'label' => $now->format('F Y')
            ],
            'year' => [
                'start' => $now->copy()->startOfYear(),
                'end' => $now->copy()->endOfYear(),
                'label' => $now->format('Y')
            ],
            default => [
                'start' => $now->copy()->startOfMonth(),
                'end' => $now->copy()->endOfMonth(),
                'label' => $now->format('F Y')
            ]
        };
    }

    #[Computed]
    public function analytics()
    {
        $tenantId = $this->tenantId;
        $dateRange = $this->getDateRange();

        // Get all orders in date range
        $orders = Order::with(['items'])
            ->where('tenant_id', $tenantId)
            ->whereBetween('created_at', [$dateRange['start'], $dateRange['end']])
            ->get();

        // Completed orders for revenue calculations
        $completedOrders = $orders->where('status', 'completed');
        
        // Revenue
        $revenue = $completedOrders->sum('total');

        // Cost calculation from completed orders
        $cost = 0;
        foreach ($completedOrders as $order) {
            foreach ($order->items as $item) {
                if ($item->product_id) {
                    $product = Product::where('id', $item->product_id)
                        ->where('tenant_id', $tenantId)
                        ->first();
                    if ($product) {
                        $cost += $product->cost_price * $item->quantity;
                    }
                }
            }
        }

        $netProfit = $revenue - $cost;

        // Cancelled Loss (revenue from canceled orders)
        $canceledOrders = $orders->where('status', 'canceled');
        $cancelledLoss = $canceledOrders->sum('total');

        // Items Sold (total units from completed orders)
        $itemsSold = $completedOrders->sum(function ($order) {
            return $order->items->sum('quantity');
        });

        // Total Visitors (unique customers)
        $totalVisitors = Order::where('tenant_id', $tenantId)
            ->whereBetween('created_at', [$dateRange['start'], $dateRange['end']])
            ->distinct('customer_id')
            ->count('customer_id');

        // Total Engagement (total orders + appointments)
        $totalOrders = $orders->count();
        $appointmentsCount = 0;
        if (class_exists(\App\Models\Appointment::class)) {
            $appointmentsCount = \App\Models\Appointment::where('tenant_id', $tenantId)
                ->whereBetween('created_at', [$dateRange['start'], $dateRange['end']])
                ->count();
        }
        $totalEngagement = $totalOrders + $appointmentsCount;

        return [
            'revenue' => $revenue,
            'net_profit' => $netProfit,
            'cancelled_loss' => $cancelledLoss,
            'items_sold' => $itemsSold,
            'total_visitors' => $totalVisitors,
            'total_engagement' => $totalEngagement,
            'date_label' => $dateRange['label'],
            'total_orders' => $totalOrders,
            'completed_orders' => $completedOrders->count(),
            'canceled_orders' => $canceledOrders->count(),
        ];
    }

    #[Computed]
    public function shopRating()
    {
        $tenantId = $this->tenantId;

        if (!class_exists(\App\Models\Review::class)) {
            return ['average' => 0, 'total' => 0, 'label' => 'No reviews yet'];
        }

        $reviews = Review::where('tenant_id', $tenantId)
            ->select(DB::raw('AVG(rating) as average, COUNT(*) as total'))
            ->first();

        $average = $reviews ? round($reviews->average, 1) : 0;
        $total = $reviews ? $reviews->total : 0;

        return [
            'average' => $average,
            'total' => $total,
            'label' => $total > 0 ? "Based on {$total} review(s)" : 'No reviews yet',
        ];
    }

    #[Computed]
    public function chartData()
    {
        $tenantId = $this->tenantId;
        $dateRange = $this->getDateRange();

        // Get daily revenue for the date range
        $dailyData = Order::where('tenant_id', $tenantId)
            ->where('status', 'completed')
            ->whereBetween('created_at', [$dateRange['start'], $dateRange['end']])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total) as revenue')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Get daily orders count
        $dailyOrders = Order::where('tenant_id', $tenantId)
            ->whereBetween('created_at', [$dateRange['start'], $dateRange['end']])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as orders')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Format for chart
        $dates = [];
        $revenueData = [];
        $ordersData = [];

        // Create a date range
        $current = $dateRange['start']->copy();
        while ($current <= $dateRange['end']) {
            $dateKey = $current->format('Y-m-d');
            $dates[] = $current->format('M d');
            
            $revenue = $dailyData->firstWhere('date', $dateKey);
            $revenueData[] = $revenue ? (float) $revenue->revenue : 0;
            
            $orders = $dailyOrders->firstWhere('date', $dateKey);
            $ordersData[] = $orders ? (int) $orders->orders : 0;
            
            $current->addDay();
        }

        return [
            'labels' => $dates,
            'revenue' => $revenueData,
            'orders' => $ordersData,
        ];
    }

    #[Computed]
    public function topItems()
    {
        $tenantId = $this->tenantId;
        $dateRange = $this->getDateRange();

        // Get top products from completed orders
        $topProducts = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.tenant_id', $tenantId)
            ->where('orders.status', 'completed')
            ->whereBetween('orders.created_at', [$dateRange['start'], $dateRange['end']])
            ->select(
                'products.id',
                'products.name',
                DB::raw('SUM(order_items.quantity) as total_quantity')
            )
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();

        // If no products, get top services
        if ($topProducts->isEmpty()) {
            $topProducts = DB::table('order_items')
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->join('services', 'order_items.service_id', '=', 'services.id')
                ->where('orders.tenant_id', $tenantId)
                ->where('orders.status', 'completed')
                ->whereBetween('orders.created_at', [$dateRange['start'], $dateRange['end']])
                ->select(
                    'services.id',
                    'services.name',
                    DB::raw('SUM(order_items.quantity) as total_quantity')
                )
                ->groupBy('services.id', 'services.name')
                ->orderByDesc('total_quantity')
                ->limit(5)
                ->get();
        }

        return $topProducts->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'quantity' => $item->total_quantity,
            ];
        });
    }

    #[Computed]
    public function recentOrders()
    {
        $tenantId = $this->tenantId;

        return Order::with(['customer'])
            ->where('tenant_id', $tenantId)
            ->orderByDesc('created_at')
            ->limit(10)
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->id,
                    'order_number' => $order->order_number ?? 'ORD-' . str_pad($order->id, 6, '0', STR_PAD_LEFT),
                    'customer_name' => $order->customer?->name ?? 'Guest',
                    'total' => $order->total,
                    'status' => $order->status,
                    'created_at' => $order->created_at->diffForHumans(),
                ];
            });
    }

    #[Computed]
    public function totalPosts()
    {
        return Post::where('tenant_id', $this->tenantId)
            ->where('created_by', Auth::id())
            ->count();
    }

};
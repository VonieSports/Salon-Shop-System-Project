<?php

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\Product;
use App\Models\Tenant;
use App\Support\PrivacyMasker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
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
        $this->tenant = $user->tenant ?? Tenant::where('user_id', $user->id)->first();

        if (!$this->tenant) {
            return redirect()->route('owner.business_setup')->with('error', 'Please complete your business setup first.');
        }

        $this->tenantId = $this->tenant->id;
        $this->showSetupModal = !$this->tenant->business_setup_completed;
    }

    public function updatedDateRange(): void
    {
        unset($this->analytics, $this->chartData, $this->topItems, $this->recentOrders, $this->shopRating, $this->orderStatusBreakdown);
        $this->dispatch('dateRangeChanged');
    }

    private function getDateRange(): array
    {
        $now = Carbon::now();

        return match ($this->dateRange) {
            'day' => ['start' => $now->copy()->startOfDay(), 'end' => $now->copy()->endOfDay(), 'label' => $now->format('F j, Y')],
            'week' => ['start' => $now->copy()->startOfWeek(), 'end' => $now->copy()->endOfWeek(), 'label' => $now->copy()->startOfWeek()->format('M j') . ' - ' . $now->copy()->endOfWeek()->format('M j, Y')],
            'year' => ['start' => $now->copy()->startOfYear(), 'end' => $now->copy()->endOfYear(), 'label' => $now->format('Y')],
            default => ['start' => $now->copy()->startOfMonth(), 'end' => $now->copy()->endOfMonth(), 'label' => $now->format('F Y')],
        };
    }

    #[Computed]
    public function analytics()
    {
        $tenantId = $this->tenantId;
        $dateRange = $this->getDateRange();

        $orders = Order::query()->forTenant($tenantId)->betweenDates($dateRange['start'], $dateRange['end'])->withItems()->get();
        $paidOrders = Order::query()->forTenant($tenantId)->betweenDates($dateRange['start'], $dateRange['end'])->paid()->get();

        $revenue = $paidOrders->sum('total');

        $awaitingPayment = Order::query()->forTenant($tenantId)
            ->betweenDates($dateRange['start'], $dateRange['end'])
            ->unpaid()->notCanceled()
            ->sum('total');

        $productIds = $paidOrders->flatMap(fn ($o) => $o->items->pluck('product_id'))->filter()->unique();
        $costByProduct = Product::whereIn('id', $productIds)->pluck('cost_price', 'id');

        $cost = $paidOrders->flatMap->items->sum(
            fn ($item) => $item->product_id ? ($costByProduct[$item->product_id] ?? 0) * $item->quantity : 0
        );

        $cancelledLoss = Order::query()->forTenant($tenantId)->betweenDates($dateRange['start'], $dateRange['end'])->canceled()->sum('total');
        $itemsSold = $paidOrders->flatMap->items->sum('quantity');
        $totalVisitors = $orders->pluck('customer_id')->filter()->unique()->count();

        $appointmentsCount = class_exists(\App\Models\Appointment::class)
            ? \App\Models\Appointment::where('tenant_id', $tenantId)->whereBetween('created_at', [$dateRange['start'], $dateRange['end']])->count()
            : 0;

        return [
            'revenue' => $revenue,
            'net_profit' => $revenue - $cost,
            'awaiting_payment' => $awaitingPayment,
            'cancelled_loss' => $cancelledLoss,
            'items_sold' => $itemsSold,
            'total_visitors' => $totalVisitors,
            'total_engagement' => $orders->count() + $appointmentsCount,
            'date_label' => $dateRange['label'],
        ];
    }

    #[Computed]
    public function shopRating()
    {
        if (!class_exists(\App\Models\Review::class)) {
            return ['average' => 0, 'total' => 0, 'label' => 'No reviews yet'];
        }

        $stats = \App\Models\Review::where('tenant_id', $this->tenantId)
            ->selectRaw('AVG(rating) as average, COUNT(*) as total')->first();

        $average = $stats ? round((float) $stats->average, 1) : 0;
        $total = $stats ? (int) $stats->total : 0;

        return ['average' => $average, 'total' => $total, 'label' => $total > 0 ? "Based on {$total} review(s)" : 'No reviews yet'];
    }

    #[Computed]
    public function chartData()
    {
        $tenantId = $this->tenantId;
        $dateRange = $this->getDateRange();

        $dailyRevenue = Order::query()->forTenant($tenantId)->paid()
            ->betweenDates($dateRange['start'], $dateRange['end'])
            ->selectRaw('DATE(created_at) as date, SUM(total) as revenue')->groupBy('date')->pluck('revenue', 'date');

        $dailyOrders = Order::query()->forTenant($tenantId)
            ->betweenDates($dateRange['start'], $dateRange['end'])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as orders')->groupBy('date')->pluck('orders', 'date');

        $dates = []; $revenueData = []; $ordersData = [];
        $current = $dateRange['start']->copy();
        while ($current <= $dateRange['end']) {
            $key = $current->format('Y-m-d');
            $dates[] = $current->format('M d');
            $revenueData[] = (float) ($dailyRevenue[$key] ?? 0);
            $ordersData[] = (int) ($dailyOrders[$key] ?? 0);
            $current->addDay();
        }

        return ['labels' => $dates, 'revenue' => $revenueData, 'orders' => $ordersData];
    }

    #[Computed]
    public function orderStatusBreakdown(): array
    {
        $dateRange = $this->getDateRange();

        $counts = Order::query()->forTenant($this->tenantId)
            ->betweenDates($dateRange['start'], $dateRange['end'])
            ->selectRaw('status, COUNT(*) as total')->groupBy('status')->pluck('total', 'status')->toArray();

        $labels = []; $data = []; $colors = [];
        foreach (OrderStatus::cases() as $status) {
            $labels[] = $status->label();
            $data[] = (int) ($counts[$status->value] ?? 0);
            $colors[] = $status->chartColor();
        }

        return compact('labels', 'data', 'colors');
    }

    #[Computed]
    public function topItems()
    {
        $tenantId = $this->tenantId;
        $dateRange = $this->getDateRange();

        $topProducts = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.tenant_id', $tenantId)
            ->where('orders.payment_status', PaymentStatus::PAID->value)
            ->whereBetween('orders.created_at', [$dateRange['start'], $dateRange['end']])
            ->select('products.id', 'products.name', 'products.image', DB::raw('SUM(order_items.quantity) as total_quantity'))
            ->groupBy('products.id', 'products.name', 'products.image')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();

        $max = $topProducts->max('total_quantity') ?: 1;

        return $topProducts->map(fn ($item) => [
            'id' => $item->id,
            'name' => $item->name,
            'image' => $item->image,
            'quantity' => $item->total_quantity,
            'percentage' => (int) round(($item->total_quantity / $max) * 100),
        ]);
    }

    #[Computed]
    public function recentOrders()
    {
        return Order::query()
            ->forTenant($this->tenantId)
            ->with(['customer.user:id,name,avatar', 'items:id,order_id,name,product_id'])
            ->latestOrder()
            ->limit(10)
            ->get()
            ->map(function ($order) {
                $firstItem = $order->items->first();
                $itemsLabel = $firstItem?->name ?? 'No items';
                if ($order->items->count() > 1) {
                    $itemsLabel .= ' +' . ($order->items->count() - 1) . ' more';
                }

                return [
                    'order_number' => $order->order_number,
                    'customer_name' => PrivacyMasker::name($order->customer?->name),
                    'avatar' => $order->customer?->user?->avatar,
                    'items_label' => $itemsLabel,
                    'total' => $order->total,
                    'status_label' => $order->status->label(),
                    'status_class' => $order->status->badgeClass(),
                ];
            });
    }
};
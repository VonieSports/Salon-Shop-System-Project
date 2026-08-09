<!-- shop Owner Dashboard -->
<div class="mx-5 py-5">
@if (session()->has('warning'))
    <div class="mb-4 bg-yellow-50 border border-yellow-300 text-yellow-800 px-4 py-3 rounded-xl text-sm font-medium">
        {{ session('warning') }}
    </div>
@endif

@if ($showSetupModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center px-4" x-data x-cloak>
        <div class="fixed inset-0 bg-black/50"></div>
        <div class="relative bg-white rounded-2xl shadow-xl lg:w-1/4 w-full md:w-1/2 p-6 text-center">
            <div class="w-16 h-16 rounded-full bg-[#1E7A4A]/10 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-[#1E7A4A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Set Up Your Business</h3>
            <p class="text-sm text-gray-500 mb-6">
                You need to complete your business setup before you can manage products, services, and orders.
            </p>
            <a href="{{ route('owner.business_setup') }}"
               class="inline-flex items-center justify-center w-full px-5 py-2.5 bg-[#1E7A4A] text-white rounded-xl hover:bg-[#16653D] transition text-sm font-semibold">
                Complete Setup Now
            </a>
        </div>
    </div>
@endif
<div class="min-h-screen bg-gray-50">
    <div class="">
        <!-- Header -->
        <div class="flex items-start justify-between mb-8 flex-wrap gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
                <p class="text-gray-500 text-sm mt-1">{{ $this->analytics['date_label'] ?? Carbon\Carbon::now()->format('l, F j Y') }}</p>
            </div>
            <div class="flex items-center gap-2">
                <select wire:model.live="dateRange" 
                    class="px-4 py-2 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#1E7A4A] focus:border-transparent text-sm">
                    @foreach($dateRanges as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Analytics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
            <!-- Revenue -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Revenue</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">₱ {{ number_format($this->analytics['revenue'], 2) }}</p>
                        <p class="text-xs text-gray-400 mt-1">Global revenue</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Net Profit -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Net Profit</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">₱ {{ number_format($this->analytics['net_profit'], 2) }}</p>
                        <p class="text-xs text-gray-400 mt-1">Revenue - Operating</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Cancelled Loss -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Cancelled Loss</p>
                        <p class="text-2xl font-bold text-red-600 mt-1">₱ {{ number_format($this->analytics['cancelled_loss'], 2) }}</p>
                        <p class="text-xs text-gray-400 mt-1">Lost revenue</p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Row -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-5">
            <!-- Items Sold -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4">
                <p class="text-sm text-gray-500">Items Sold</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($this->analytics['items_sold']) }}</p>
                <p class="text-xs text-gray-400 mt-1">Units sold</p>
            </div>

            <!-- Shop Rating -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4">
                <p class="text-sm text-gray-500">Shop Rating</p>
                <div class="flex items-center gap-2 mt-1">
                    <span class="text-2xl font-bold text-gray-900">{{ $this->shopRating['average'] }}</span>
                    <span class="text-yellow-400 text-xl">★</span>
                </div>
                <p class="text-xs text-gray-400 mt-1">{{ $this->shopRating['label'] }}</p>
            </div>

            <!-- Total Visitors & Engagement -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-500">Total Visitors</p>
                        <p class="text-xl font-bold text-gray-900 mt-1">{{ number_format($this->analytics['total_visitors']) }}</p>
                        <p class="text-xs text-gray-400 mt-1">Units & actions this year</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Total Engagement</p>
                        <p class="text-xl font-bold text-gray-900 mt-1">{{ number_format($this->analytics['total_engagement']) }}</p>
                        <p class="text-xs text-gray-400 mt-1">Orders & appointments</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-sm font-semibold text-gray-900">Revenue & Orders Overview</h3>
            </div>
            <div class="p-6">
                <div class="h-64">
                    <canvas id="dashboardChart" class="w-full h-full"></canvas>
                </div>
            </div>
        </div>

        <!-- Top Items & Recent Orders -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Top Items -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-sm font-semibold text-gray-900">Most Requested Items</h3>
                </div>
                <div class="p-6">
                    @if($this->topItems->isEmpty())
                        <p class="text-center text-gray-400 text-sm py-4">No items requested yet</p>
                    @else
                        <div class="space-y-4">
                            @foreach($this->topItems as $item)
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-700 truncate flex-1">{{ $item['name'] }}</span>
                                    <span class="text-sm text-gray-500 ml-4">{{ $item['quantity'] }} units</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
                    <h3 class="text-sm font-semibold text-gray-900">Recent Orders</h3>
                    <a href="" class="text-sm text-[#1E7A4A] hover:underline">View all →</a>
                </div>
                <div class="overflow-y-auto max-h-64">
                    @if($this->recentOrders->isEmpty())
                        <div class="p-8 text-center text-gray-400 text-sm">No orders yet</div>
                    @else
                        <div class="divide-y divide-gray-200">
                            @foreach($this->recentOrders as $order)
                                <div class="px-6 py-3 hover:bg-gray-50 transition flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">#{{ $order['order_number'] }}</p>
                                        <p class="text-xs text-gray-500">{{ $order['customer_name'] }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-medium text-gray-900">₱ {{ number_format($order['total'], 2) }}</p>
                                        <span class="text-xs px-2 py-0.5 rounded-full 
                                            {{ $order['status'] === 'completed' ? 'bg-green-100 text-green-800' : 
                                               ($order['status'] === 'confirmed' ? 'bg-blue-100 text-blue-800' : 
                                               ($order['status'] === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                               'bg-red-100 text-red-800')) }}">
                                            {{ ucfirst($order['status']) }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('livewire:initialized', function () {
        initChart();
    });

    document.addEventListener('livewire:updated', function () {
        initChart();
    });

    function initChart() {
        const ctx = document.getElementById('dashboardChart');
        if (!ctx) return;

        // Destroy existing chart if it exists
        if (window.dashboardChart instanceof Chart) {
            window.dashboardChart.destroy();
        }

        const chartData = @json($this->chartData);

        window.dashboardChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartData.labels,
                datasets: [
                    {
                        label: 'Revenue (₱)',
                        data: chartData.revenue,
                        backgroundColor: 'rgba(30, 122, 74, 0.7)',
                        borderColor: 'rgba(30, 122, 74, 1)',
                        borderWidth: 2,
                        borderRadius: 4,
                        order: 1,
                    },
                    {
                        label: 'Orders',
                        data: chartData.orders,
                        backgroundColor: 'rgba(59, 130, 246, 0.7)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 2,
                        borderRadius: 4,
                        order: 2,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: {
                                size: 12,
                                weight: '500'
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                if (this.chart.data.datasets[0].label === 'Revenue (₱)') {
                                    return '₱' + value.toLocaleString();
                                }
                                return value;
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }
</script>
@endpush
</div>
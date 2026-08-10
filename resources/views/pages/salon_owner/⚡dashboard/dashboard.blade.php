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
                <p class="text-sm text-gray-500 mb-6">You need to complete your business setup before you can manage products, services, and orders.</p>
                <a href="{{ route('owner.business_setup') }}" class="inline-flex items-center justify-center w-full px-5 py-2.5 bg-[#1E7A4A] text-white rounded-xl hover:bg-[#16653D] transition text-sm font-semibold">
                    Complete Setup Now
                </a>
            </div>
        </div>
    @endif

    <div class="min-h-screen bg-gray-50">
        <div>
            <div class="flex items-start justify-between mb-8 flex-wrap gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
                    <p class="text-gray-500 text-sm mt-1">{{ $this->analytics['date_label'] }}</p>
                </div>
                <select wire:model.live="dateRange" class="px-4 py-2 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#1E7A4A] focus:border-transparent text-sm">
                    @foreach($dateRanges as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Analytics Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <p class="text-sm text-gray-500">Revenue</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">₱ {{ number_format($this->analytics['revenue'], 2) }}</p>
                    <p class="text-xs text-gray-400 mt-1">From paid orders</p>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <p class="text-sm text-gray-500">Net Profit</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">₱ {{ number_format($this->analytics['net_profit'], 2) }}</p>
                    <p class="text-xs text-gray-400 mt-1">Revenue − Cost</p>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <p class="text-sm text-gray-500">Awaiting Payment</p>
                    <p class="text-2xl font-bold text-amber-600 mt-1">₱ {{ number_format($this->analytics['awaiting_payment'], 2) }}</p>
                    <p class="text-xs text-gray-400 mt-1">Placed but not marked paid</p>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <p class="text-sm text-gray-500">Cancelled Loss</p>
                    <p class="text-2xl font-bold text-red-600 mt-1">₱ {{ number_format($this->analytics['cancelled_loss'], 2) }}</p>
                    <p class="text-xs text-gray-400 mt-1">Lost revenue</p>
                </div>
            </div>

            <!-- Stats Row -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-5">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4">
                    <p class="text-sm text-gray-500">Items Sold</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($this->analytics['items_sold']) }}</p>
                    <p class="text-xs text-gray-400 mt-1">From paid orders</p>
                </div>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4">
                    <p class="text-sm text-gray-500">Shop Rating</p>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="text-2xl font-bold text-gray-900">{{ $this->shopRating['average'] }}</span>
                        <span class="text-yellow-400 text-xl">★</span>
                    </div>
                    <p class="text-xs text-gray-400 mt-1">{{ $this->shopRating['label'] }}</p>
                </div>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm text-gray-500">Visitors</p>
                            <p class="text-xl font-bold text-gray-900 mt-1">{{ number_format($this->analytics['total_visitors']) }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500">Engagement</p>
                            <p class="text-xl font-bold text-gray-900 mt-1">{{ number_format($this->analytics['total_engagement']) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts: revenue trend + status breakdown -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-sm font-semibold text-gray-900">Revenue & Orders Overview</h3>
                    </div>
                    <div class="p-6"><div class="h-64"><canvas id="dashboardChart"></canvas></div></div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-sm font-semibold text-gray-900">Order Status</h3>
                    </div>
                    <div class="p-6"><div class="h-64"><canvas id="orderStatusChart"></canvas></div></div>
                </div>
            </div>

            <!-- Top Items & Recent Orders -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
              <!-- Most Requested Items — now with image + progress bar -->
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
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-gray-100 overflow-hidden shrink-0 border border-gray-100">
                            @if ($item['image'])
                                <img src="{{ Storage::url($item['image']) }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-sm font-medium text-gray-700 truncate">{{ $item['name'] }}</span>
                                <span class="text-xs text-gray-500 ml-2 shrink-0">{{ $item['quantity'] }} units</span>
                            </div>
                            <div class="w-full h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full bg-[#1E7A4A] rounded-full" style="width: {{ $item['percentage'] }}%"></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<!-- Recent Orders — now with avatar + item name -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
        <h3 class="text-sm font-semibold text-gray-900">Recent Orders</h3>
        <a href="{{ route('owner.customer_orders') }}" class="text-sm text-[#1E7A4A] hover:underline">View all →</a>
    </div>
    <div class="overflow-y-auto max-h-64">
        @if($this->recentOrders->isEmpty())
            <div class="p-8 text-center text-gray-400 text-sm">No orders yet</div>
        @else
            <div class="divide-y divide-gray-200">
                @foreach($this->recentOrders as $order)
                    <div class="px-6 py-3 hover:bg-gray-50 transition flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center shrink-0 overflow-hidden">
                            @if ($order['avatar'])
                                <img src="{{ Storage::url($order['avatar']) }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-xs font-bold text-emerald-700">{{ \App\Support\PrivacyMasker::avatarInitial($order['customer_name']) }}</span>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $order['items_label'] }}</p>
                            <p class="text-xs text-gray-500">{{ $order['customer_name'] }} · #{{ $order['order_number'] }}</p>
                        </div>
                        <div class="text-right shrink-0">
                            <p class="text-sm font-medium text-gray-900">₱ {{ number_format($order['total'], 2) }}</p>
                            <span class="text-xs px-2 py-0.5 rounded-full {{ $order['status_class'] }}">{{ $order['status_label'] }}</span>
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
</div>

<!-- Chart.js Script with Livewire integration -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('livewire:initialized', function() {
        initDashboardCharts();
    });

    // Listen for date range changes
    document.addEventListener('livewire:updated', function() {
        // Wait for DOM to update then re-render charts
        setTimeout(() => {
            initDashboardCharts();
        }, 100);
    });

    // Listen for custom event from component
    document.addEventListener('dateRangeChanged', function() {
        setTimeout(() => {
            initDashboardCharts();
        }, 200);
    });

    function initDashboardCharts() {
        renderRevenueChart();
        renderStatusChart();
    }

    function renderRevenueChart() {
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
                        backgroundColor: 'rgba(30,122,74,0.7)',
                        borderColor: 'rgba(30,122,74,1)',
                        borderWidth: 2,
                        borderRadius: 4,
                        order: 2
                    },
                    {
                        label: 'Orders',
                        data: chartData.orders,
                        backgroundColor: 'rgba(59,130,246,0.7)',
                        borderColor: 'rgba(59,130,246,1)',
                        borderWidth: 2,
                        borderRadius: 4,
                        order: 1
                    },
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: { size: 11 }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0,0,0,0.05)' }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    }

    function renderStatusChart() {
        const ctx = document.getElementById('orderStatusChart');
        if (!ctx) return;
        
        // Destroy existing chart if it exists
        if (window.orderStatusChart instanceof Chart) {
            window.orderStatusChart.destroy();
        }

        const data = @json($this->orderStatusBreakdown);

        // Filter out statuses with 0 count
        const filteredData = {
            labels: [],
            data: [],
            colors: []
        };

        data.labels.forEach((label, index) => {
            if (data.data[index] > 0) {
                filteredData.labels.push(label);
                filteredData.data.push(data.data[index]);
                filteredData.colors.push(data.colors[index]);
            }
        });

        // If all data is 0, show placeholder
        if (filteredData.data.length === 0) {
            filteredData.labels = ['No Data'];
            filteredData.data = [1];
            filteredData.colors = ['#e5e7eb'];
        }

        window.orderStatusChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: filteredData.labels,
                datasets: [{
                    data: filteredData.data,
                    backgroundColor: filteredData.colors,
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            boxWidth: 8,
                            padding: 12,
                            font: { size: 11 }
                        }
                    }
                },
                cutout: '70%'
            }
        });
    }

    // Re-run when Livewire updates
    document.addEventListener('livewire:navigated', function() {
        setTimeout(() => {
            initDashboardCharts();
        }, 150);
    });
</script>
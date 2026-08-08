
<div>
    <div class="space-y-6">
    <h1 class="text-xl font-bold text-gray-900">Admin Overview</h1>

    <div class="grid grid-cols-2 sm:grid-cols-5 gap-4">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs text-gray-400 uppercase tracking-wide">Total Shops</p>
            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $this->stats['total_tenants'] }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs text-amber-600 uppercase tracking-wide">Pending</p>
            <p class="text-2xl font-bold text-amber-700 mt-1">{{ $this->stats['pending'] }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs text-green-600 uppercase tracking-wide">Approved</p>
            <p class="text-2xl font-bold text-green-700 mt-1">{{ $this->stats['approved'] }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs text-red-600 uppercase tracking-wide">Rejected</p>
            <p class="text-2xl font-bold text-red-700 mt-1">{{ $this->stats['rejected'] }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs text-gray-400 uppercase tracking-wide">Customers</p>
            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $this->stats['total_customers'] }}</p>
        </div>
    </div>

    <a href="{{ route('admin.business_approvals') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#1E7A4A] text-white rounded-xl hover:bg-[#16633c] transition text-sm font-medium">
        Review Pending Approvals
    </a>
</div>
    {{-- Breathing in, I calm body and mind. Breathing out, I smile. - Thich Nhat Hanh --}}
</div>
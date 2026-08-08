<div>
  {{-- Unauthorized modal --}}
  @if ($showUnauthorizedModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center px-4">
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm"></div>

        <div class="relative bg-white rounded-2xl shadow-xl max-w-md w-full overflow-hidden">
            <div class="p-6 text-center">
                <div class="mx-auto flex items-center justify-center w-14 h-14 rounded-full bg-red-100 mb-4">
                    <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                    </svg>
                </div>

                <h3 class="text-lg font-bold text-gray-900 mb-1.5">Access Restricted</h3>
                <p class="text-sm text-gray-500 leading-relaxed">
                    Only the <span class="font-semibold text-gray-700">Main Headquarters</span> account can view the branch list.
                </p>
            </div>

            <div class="px-6 pb-6">
                <button type="button" wire:click="goToDashboard"
                        class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-[#1E7A4A] text-white rounded-xl hover:bg-[#16633c] transition text-sm font-medium">
                    Back to Dashboard
                </button>
            </div>
        </div>
    </div>
  @endif

  <div class="min-h-screen bg-gray-50 {{ $showUnauthorizedModal ? 'pointer-events-none select-none blur-sm' : '' }}">
    <div class="mx-auto space-y-6 py-6 px-4">

        @if (session()->has('success'))
            <div class="bg-green-50 text-green-700 px-5 py-3.5 rounded-xl text-sm font-medium">{{ session('success') }}</div>
        @endif
        @if (session()->has('error'))
            <div class="bg-red-50 text-red-700 px-5 py-3.5 rounded-xl text-sm font-medium">{{ session('error') }}</div>
        @endif

        <!-- Header -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 bg-[#1E7A4A] flex items-center justify-between flex-wrap gap-4">
                <div class="flex items-center gap-3">
                    <a href="{{ route('owner.dashboard') }}" class="p-2 hover:bg-green-600/30 rounded-lg transition-colors">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-2xl font-bold text-white">Branches</h1>
                        <p class="text-sm text-white/80 mt-0.5">Track every branch and its assigned manager</p>
                    </div>
                </div>
                <a href="{{ route('owner.create_branch') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-white text-[#1E7A4A] rounded-xl hover:bg-gray-100 transition text-sm font-semibold whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    New Branch
                </a>
            </div>

            <div class="p-4 flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1">
                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" wire:model.live.debounce.300ms="search"
                           placeholder="Search by branch name, email, or manager..."
                           class="w-full pl-10 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A] transition bg-white">
                </div>

                <select wire:model.live="statusFilter"
                        class="px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A] transition bg-white w-full sm:w-auto min-w-44">
                    <option value="all">All Statuses</option>
                    <option value="pending">Pending Approval</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            @if ($this->branches->isEmpty())
                <div class="text-center py-16">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V7l8-4v18M13 21V11l6 2v8M9 9v.01M9 12v.01M9 15v.01M9 18v.01"/>
                    </svg>
                    <p class="text-gray-500 text-sm font-medium">No branches yet</p>
                    <p class="text-gray-400 text-sm mt-1">Click "New Branch" to create your first one.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm min-w-180">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                <th class="px-6 py-3">Branch</th>
                                <th class="px-6 py-3">Manager</th>
                                <th class="px-6 py-3">Contact</th>
                                <th class="px-6 py-3">Team</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3">Created</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($this->branches as $branch)
                                @php
                                    $manager = $branch->owner;
                                    $managerStatus = $manager ? $manager->status : null;
                                @endphp
                                <tr class="hover:bg-gray-50 transition">
                                    <!-- Branch -->
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            @if ($branch->logo)
                                                <img src="{{ Storage::url($branch->logo) }}"
                                                     class="w-10 h-10 rounded-lg object-cover border border-gray-200 shrink-0">
                                            @else
                                                <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center border border-gray-200 shrink-0">
                                                    <span class="text-sm font-bold text-emerald-700">
                                                        {{ strtoupper(substr($branch->name, 0, 1)) }}
                                                    </span>
                                                </div>
                                            @endif
                                            <div class="min-w-0">
                                                <p class="font-semibold text-gray-900 truncate max-w-50">{{ $branch->name }}</p>
                                                <p class="text-xs text-gray-400 truncate max-w-50">{{ $branch->business_type ?: 'No type set' }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Manager -->
                                    <td class="px-6 py-4">
                                        @if ($manager)
                                            <div class="flex items-center gap-2.5">
                                                <div class="relative shrink-0">
                                                    @if ($manager->avatar)
                                                        <img src="{{ Storage::url($manager->avatar) }}"
                                                             class="w-8 h-8 rounded-full object-cover border border-gray-200">
                                                    @else
                                                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center border border-gray-200">
                                                            <span class="text-xs font-bold text-blue-700">
                                                                {{ strtoupper(substr($manager->name, 0, 1)) }}
                                                            </span>
                                                        </div>
                                                    @endif
                                                    @if ($managerStatus['is_online'] ?? false)
                                                        <span class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-green-500 border-2 border-white rounded-full"></span>
                                                    @endif
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="text-sm font-medium text-gray-800 truncate max-w-36">{{ $manager->name }}</p>
                                                    <p class="text-xs {{ ($managerStatus['is_online'] ?? false) ? 'text-green-600' : 'text-gray-400' }}">
                                                        {{ $managerStatus['label'] ?? 'Unknown' }}
                                                    </p>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-xs text-gray-400 italic">No manager assigned</span>
                                        @endif
                                    </td>

                                    <!-- Contact -->
                                    <td class="px-6 py-4">
                                        <p class="text-gray-700 truncate max-w-40">{{ $branch->email }}</p>
                                        <p class="text-xs text-gray-400">{{ $branch->phone }}</p>
                                    </td>

                                    <!-- Team -->
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-gray-100 text-gray-600 text-xs font-medium">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            {{ $branch->employees_count }}
                                        </span>
                                    </td>

                                    <!-- Status -->
                                    <td class="px-6 py-4">
                                        @php
                                            $verificationMap = [
                                                'pending' => 'bg-amber-50 text-amber-700',
                                                'approved' => 'bg-green-50 text-green-700',
                                                'rejected' => 'bg-red-50 text-red-700',
                                            ];
                                        @endphp
                                        <div class="flex flex-col gap-1">
                                            <span class="px-2.5 py-1 rounded-full text-xs font-medium w-fit {{ $verificationMap[$branch->verification_status] ?? 'bg-gray-100 text-gray-600' }}">
                                                {{ ucfirst($branch->verification_status) }}
                                            </span>
                                            @if (!$branch->is_active)
                                                <span class="px-2.5 py-1 rounded-full text-xs font-medium w-fit bg-gray-100 text-gray-500">
                                                    Inactive
                                                </span>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Created -->
                                    <td class="px-6 py-4 text-gray-500 text-xs whitespace-nowrap">
                                        {{ $branch->created_at->format('M d, Y') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $this->branches->links() }}
                </div>
            @endif
        </div>
    </div>
  </div>
</div>
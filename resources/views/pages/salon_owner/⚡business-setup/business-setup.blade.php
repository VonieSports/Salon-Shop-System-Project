<div class="min-h-screen bg-[#F5F5F5]">
    @php
        $timeOptions = collect(range(0, 95))->map(function ($i) {
            $totalMinutes = $i * 15;
            $h = intdiv($totalMinutes, 60);
            $m = $totalMinutes % 60;
            return [
                'value' => sprintf('%02d:%02d', $h, $m),
                'label' => \Carbon\Carbon::createFromTime($h, $m)->format('g:i A'),
            ];
        });
        $daysWithHours = collect($days)->filter(fn ($d) => isset($business_hours[$d]))->values();
    @endphp

    <div class="max-w-7xl mx-auto px-3 sm:px-4 py-4 sm:py-6">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
            <div>
                <h1 class="text-xl sm:text-2xl font-semibold text-[#222]">
                    {{ $is_setup_complete ? 'Edit Business' : 'Setup Business' }}
                </h1>
                <p class="text-sm text-[#666] mt-0.5 flex items-center gap-2">
                    <span class="inline-block w-1.5 h-1.5 rounded-full bg-[#D6657A]"></span>
                    {{ $is_setup_complete ? 'Update your business details' : 'Complete your business setup' }}
                </p>
            </div>
            @if ($is_setup_complete)
                <a href="{{ route('owner.business_info') }}"
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm text-[#666] hover:text-[#222] transition font-medium bg-white hover:bg-[#F5F5F5] rounded-lg border border-[#EFEFEF]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back
                </a>
            @endif
        </div>

        <!-- Progress Steps -->
        <div class="hidden sm:flex items-center gap-2 mb-5">
            <div class="flex-1 flex items-center gap-2">
                <div class="flex items-center gap-1.5">
                    <div class="w-6 h-6 rounded-full bg-[#D6657A] text-white flex items-center justify-center text-[10px] font-bold">1</div>
                    <span class="text-xs font-medium text-[#D6657A]">Logo</span>
                </div>
                <div class="flex-1 h-0.5 bg-[#D6657A]"></div>
                <div class="flex items-center gap-1.5">
                    <div class="w-6 h-6 rounded-full bg-[#EFEFEF] text-[#999] flex items-center justify-center text-[10px] font-bold">2</div>
                    <span class="text-xs font-medium text-[#999]">Info</span>
                </div>
                <div class="flex-1 h-0.5 bg-[#EFEFEF]"></div>
                <div class="flex items-center gap-1.5">
                    <div class="w-6 h-6 rounded-full bg-[#EFEFEF] text-[#999] flex items-center justify-center text-[10px] font-bold">3</div>
                    <span class="text-xs font-medium text-[#999]">Hours</span>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if (session()->has('success'))
            <div class="bg-[#FCE9ED] border border-[#D6657A]/30 text-[#7A3B4A] px-4 py-2.5 rounded-lg text-sm font-medium flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-[#D6657A] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Main Card -->
        <div class="bg-white rounded-lg shadow-sm border border-[#EFEFEF] overflow-hidden">
            <form wire:submit="saveBusinessInfo" enctype="multipart/form-data">
                <!-- Mobile Tabs -->
                <div class="flex sm:hidden gap-1 p-1 bg-[#F5F5F5] border-b border-[#EFEFEF]">
                    <button type="button" wire:click="$set('activeTab', 'logo')"
                            class="flex-1 py-1.5 text-xs font-medium rounded transition {{ ($activeTab ?? 'logo') === 'logo' ? 'bg-white text-[#D6657A] shadow-sm' : 'text-[#999]' }}">
                        Logo
                    </button>
                    <button type="button" wire:click="$set('activeTab', 'info')"
                            class="flex-1 py-1.5 text-xs font-medium rounded transition {{ ($activeTab ?? 'logo') === 'info' ? 'bg-white text-[#D6657A] shadow-sm' : 'text-[#999]' }}">
                        Info
                    </button>
                    <button type="button" wire:click="$set('activeTab', 'hours')"
                            class="flex-1 py-1.5 text-xs font-medium rounded transition {{ ($activeTab ?? 'logo') === 'hours' ? 'bg-white text-[#D6657A] shadow-sm' : 'text-[#999]' }}">
                        Hours
                    </button>
                </div>

                <div class="p-4 sm:p-6">
                    
                    <!-- Logo Section - TOP -->
                    <div class="{{ ($activeTab ?? 'logo') === 'logo' ? 'block' : 'hidden sm:block' }}">
                        <div class="pb-2 border-b border-[#EFEFEF] mb-4">
                            <h2 class="text-base font-semibold text-[#222]">Business Logo</h2>
                            <p class="text-xs text-[#999]">Upload your business branding - this appears on your profile</p>
                        </div>

                        <div class="flex flex-col sm:flex-row items-center gap-6 bg-[#F5F5F5] rounded-lg p-4 sm:p-5">
                            <!-- Logo Preview -->
                            <div class="flex-shrink-0">
                                @if ($business_logo)
                                    <div class="relative">
                                        <img src="{{ $business_logo->temporaryUrl() }}"
                                             class="w-24 h-24 object-cover rounded-lg border-2 border-[#D6657A] shadow-sm">
                                        <span class="absolute -top-1 -right-1 px-1.5 py-0.5 bg-[#D6657A] text-white text-[8px] rounded-full font-medium">New</span>
                                    </div>
                                @elseif ($existing_logo)
                                    <img src="{{ Storage::url($existing_logo) }}"
                                         class="w-24 h-24 object-cover rounded-lg border-2 border-[#EFEFEF] shadow-sm">
                                @else
                                    <div class="w-24 h-24 rounded-lg bg-white border-2 border-dashed border-[#EFEFEF] flex items-center justify-center">
                                        <div class="text-center">
                                            <svg class="w-10 h-10 text-[#D6657A]/30 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            <p class="text-[10px] text-[#999] mt-1">No logo</p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Upload Controls -->
                            <div class="flex-1 text-center sm:text-left">
                                <div class="flex flex-col sm:flex-row items-center gap-3">
                                    <label class="cursor-pointer inline-flex items-center gap-2 px-4 py-2.5 bg-[#D6657A] text-white rounded-lg hover:bg-[#C25467] transition text-sm font-medium">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                        </svg>
                                        Choose Logo
                                        <input type="file" wire:model="business_logo" accept="image/*" class="hidden">
                                    </label>
                                    @if($existing_logo && !$business_logo)
                                        <button type="button" wire:click="removeLogo"
                                                class="text-sm text-red-500 hover:text-red-700 transition font-medium">
                                            Remove
                                        </button>
                                    @endif
                                </div>
                                <p class="text-[10px] text-[#999] mt-2">400×400px min. JPG or PNG (Max 2MB)</p>
                                @error('business_logo') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                @if ($business_logo)
                                    <p class="text-[10px] text-green-600 mt-1 font-medium">✓ {{ $business_logo->getClientOriginalName() }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Basic Information -->
                    <div class="{{ ($activeTab ?? 'info') === 'info' ? 'block' : 'hidden sm:block' }} mt-6 pt-4 border-t border-[#EFEFEF]">
                        <div class="pb-2 border-b border-[#EFEFEF] mb-4">
                            <h2 class="text-base font-semibold text-[#222]">Basic Information</h2>
                            <p class="text-xs text-[#999]">Essential details about your business</p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-[#666] mb-1">
                                    Business Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" wire:model="business_name" placeholder="e.g., BeautyNova Salon"
                                       class="w-full px-3 py-2 bg-[#F5F5F5] border-0 rounded-lg focus:ring-2 focus:ring-[#D6657A]/30 text-sm placeholder:text-[#999] transition">
                                @error('business_name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-[#666] mb-1">Business Type</label>
                                <input type="text" wire:model="business_type" placeholder="e.g., Hair Salon, Nail Spa"
                                       class="w-full px-3 py-2 bg-[#F5F5F5] border-0 rounded-lg focus:ring-2 focus:ring-[#D6657A]/30 text-sm placeholder:text-[#999] transition">
                                @error('business_type') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                            <div>
                                <label class="block text-xs font-medium text-[#666] mb-1">Business Email</label>
                                <input type="email" wire:model="business_email" placeholder="info@yourbusiness.com"
                                       class="w-full px-3 py-2 bg-[#F5F5F5] border-0 rounded-lg focus:ring-2 focus:ring-[#D6657A]/30 text-sm placeholder:text-[#999] transition">
                                @error('business_email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-[#666] mb-1">Business Phone</label>
                                <input type="text" wire:model="business_phone" placeholder="+1 (555) 000-0000"
                                       class="w-full px-3 py-2 bg-[#F5F5F5] border-0 rounded-lg focus:ring-2 focus:ring-[#D6657A]/30 text-sm placeholder:text-[#999] transition">
                                @error('business_phone') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="block text-xs font-medium text-[#666] mb-1">Business Address</label>
                            <input type="text" wire:model="business_address" placeholder="123 Main Street, City, State"
                                   class="w-full px-3 py-2 bg-[#F5F5F5] border-0 rounded-lg focus:ring-2 focus:ring-[#D6657A]/30 text-sm placeholder:text-[#999] transition">
                            @error('business_address') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="mt-4">
                            <label class="block text-xs font-medium text-[#666] mb-1">Description</label>
                            <textarea wire:model="description" rows="3" placeholder="Tell customers about your business..."
                                      class="w-full px-3 py-2 bg-[#F5F5F5] border-0 rounded-lg focus:ring-2 focus:ring-[#D6657A]/30 text-sm placeholder:text-[#999] transition resize-none"></textarea>
                            <div class="flex justify-end mt-1">
                                <span class="text-xs text-[#999]">{{ strlen($description ?? '') }}/1000</span>
                            </div>
                            @error('description') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Business Hours - Reduced Pink -->
                    <div class="{{ ($activeTab ?? 'info') === 'hours' ? 'block' : 'hidden sm:block' }} mt-6 pt-4 border-t border-[#EFEFEF]">
                        <div class="flex items-center justify-between pb-2 border-b border-[#EFEFEF] mb-4">
                            <div>
                                <h2 class="text-base font-semibold text-[#222]">Business Hours</h2>
                                <p class="text-xs text-[#999]">Set your operating hours</p>
                            </div>
                            <button type="button" wire:click="$set('business_hours', [])"
                                    class="text-xs text-red-400 hover:text-red-600 transition font-medium">
                                Clear All
                            </button>
                        </div>

                        <!-- Copy Hours Toolbar - Subtle -->
                        @if($daysWithHours->count() > 0)
                            <div class="mb-3 p-2.5 bg-[#F5F5F5] rounded-lg border border-[#EFEFEF]">
                                <p class="text-[10px] font-medium text-[#666] mb-1.5 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-[#999]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                    Copy hours to other days
                                </p>
                                <div class="flex flex-wrap items-center gap-2">
                                    <select wire:model.live="copyFromDay"
                                            class="flex-1 min-w-[100px] px-2.5 py-1.5 text-xs bg-white border border-[#EFEFEF] rounded focus:ring-2 focus:ring-[#D6657A]/30">
                                        <option value="">Copy from...</option>
                                        @foreach($daysWithHours as $d)
                                            <option value="{{ $d }}">{{ ucfirst($d) }}</option>
                                        @endforeach
                                    </select>

                                    @if($copyFromDay)
                                        <div class="flex flex-wrap gap-1 flex-1">
                                            @foreach($days as $d)
                                                @continue($d === $copyFromDay)
                                                <label wire:key="copy-target-{{ $d }}"
                                                       class="inline-flex items-center gap-0.5 text-[10px] border rounded-full px-2.5 py-0.5 cursor-pointer transition {{ in_array($d, $copyToDays) ? 'bg-[#D6657A] border-[#D6657A] text-white' : 'bg-white border-[#EFEFEF] text-[#666]' }}">
                                                    <input type="checkbox" wire:model.live="copyToDays" value="{{ $d }}" class="hidden">
                                                    {{ ucfirst(substr($d, 0, 3)) }}
                                                </label>
                                            @endforeach
                                        </div>
                                        <button type="button" wire:click="applyCopiedHours"
                                                class="px-3 py-1.5 bg-[#D6657A] text-white text-[10px] rounded font-semibold hover:bg-[#C25467] transition whitespace-nowrap">
                                            Apply
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Day Rows -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2">
                            @foreach($days as $day)
                                @php
                                    $hasDay = isset($business_hours[$day]);
                                    $dayData = $business_hours[$day] ?? null;
                                    $dayIsClosed = $dayData['closed'] ?? false;
                                @endphp
                                <div wire:key="day-row-{{ $day }}"
                                     class="flex items-center gap-2 p-2 rounded-lg border border-[#EFEFEF] hover:border-[#D6657A]/30 transition bg-white">

                                    <span class="text-xs font-medium text-[#666] w-14 flex-shrink-0">{{ ucfirst($day) }}</span>

                                    @if($hasDay)
                                        <label class="relative inline-flex items-center cursor-pointer flex-shrink-0" title="Closed">
                                            <input type="checkbox" wire:change="toggleDayClosed('{{ $day }}')"
                                                   {{ $dayIsClosed ? 'checked' : '' }} class="sr-only peer">
                                            <div class="w-7 h-4 bg-[#EFEFEF] peer-focus:ring-2 peer-focus:ring-[#D6657A]/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-[#EFEFEF] after:border after:rounded-full after:h-3 after:w-3 after:transition-all peer-checked:bg-red-400"></div>
                                        </label>

                                        <div class="flex items-center gap-1 flex-1 min-w-0">
                                            <select wire:model="business_hours.{{ $day }}.open" {{ $dayIsClosed ? 'disabled' : '' }}
                                                    class="flex-1 min-w-0 rounded border border-[#EFEFEF] focus:ring-2 focus:ring-[#D6657A]/30 px-1.5 py-1 text-[10px] bg-white {{ $dayIsClosed ? 'bg-[#F5F5F5] text-[#999] cursor-not-allowed' : '' }}">
                                                <option value="">Open</option>
                                                @foreach($timeOptions as $opt)
                                                    <option value="{{ $opt['value'] }}">{{ $opt['label'] }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-[10px] text-[#999] flex-shrink-0">–</span>
                                            <select wire:model="business_hours.{{ $day }}.close" {{ $dayIsClosed ? 'disabled' : '' }}
                                                    class="flex-1 min-w-0 rounded border border-[#EFEFEF] focus:ring-2 focus:ring-[#D6657A]/30 px-1.5 py-1 text-[10px] bg-white {{ $dayIsClosed ? 'bg-[#F5F5F5] text-[#999] cursor-not-allowed' : '' }}">
                                                <option value="">Close</option>
                                                @foreach($timeOptions as $opt)
                                                    <option value="{{ $opt['value'] }}">{{ $opt['label'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <button type="button" wire:click="removeDay('{{ $day }}')"
                                                class="text-red-400 hover:text-red-600 transition p-0.5 flex-shrink-0">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    @else
                                        <button type="button" wire:click="addDay('{{ $day }}')"
                                                class="text-xs text-[#D6657A] hover:text-[#C25467] font-medium transition">
                                            + Add Hours
                                        </button>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        @error('business_hours') <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="px-4 sm:px-6 py-3 bg-[#FAFAFA] border-t border-[#EFEFEF] flex flex-col-reverse sm:flex-row justify-between items-center gap-3">
                    <a href="{{ route('owner.dashboard') }}" 
                       class="text-sm text-[#666] hover:text-[#222] transition font-medium flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Cancel
                    </a>
                    <button type="submit"
                            class="w-full sm:w-auto px-6 py-2 bg-[#D6657A] hover:bg-[#C25467] text-white rounded-lg transition text-sm font-medium flex items-center justify-center gap-2"
                            wire:loading.attr="disabled">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span wire:loading.remove>{{ $is_setup_complete ? 'Update Business' : 'Save Business' }}</span>
                        <span wire:loading>
                            <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Saving...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
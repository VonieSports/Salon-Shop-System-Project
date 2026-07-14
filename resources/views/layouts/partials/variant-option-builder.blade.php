<div>
    <div class="space-y-4">
        @foreach ($variantOptions as $optionIndex => $option)
            <div wire:key="option-{{ $optionIndex }}" class="border border-gray-200 rounded-xl p-4">
                <div class="flex items-center gap-3 mb-3">
                    <input type="text" wire:model.blur="variantOptions.{{ $optionIndex }}.name"
                           placeholder="Option name (e.g. Color, Size, Material)"
                           class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium focus:ring-2 focus:ring-[#1E7A4A] focus:border-transparent">
                    @if (count($variantOptions) > 1)
                        <button type="button" wire:click="removeVariantOption({{ $optionIndex }})"
                                @if (count($option['values']) > 0) onclick="return confirm('Remove this option and all its values?')" @endif
                                class="text-red-500 hover:text-red-700 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    @endif
                </div>
                @if ($optionIndex === 0)
                    <p class="text-xs text-gray-500 mb-2">Tap the image box to upload a photo for each value</p>
                @endif
                <div class="flex gap-3 overflow-x-auto pb-3 no-scrollbar">
                    @foreach ($option['values'] as $valueIndex => $valueData)
                        <div wire:key="option-{{ $optionIndex }}-value-{{ $valueIndex }}" class="flex-shrink-0">
                            @if ($optionIndex === 0)
<div class="flex flex-col items-center gap-1.5 bg-white border border-gray-200 rounded-xl p-3 min-w-[100px]">
    <label class="relative cursor-pointer group" title="Upload photo for {{ $valueData['value'] }}">
        @if (!empty($valueData['preview']))
            <div class="relative w-20 h-20 rounded-lg overflow-hidden border-2 border-gray-200 group-hover:border-[#1E7A4A] transition-colors">
                <img src="{{ $valueData['preview'] }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-colors flex items-center justify-center">
                    <svg class="w-6 h-6 text-white opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
            </div>
        @else
            <div class="w-20 h-20 rounded-lg bg-gray-100 border-2 border-dashed border-gray-300 flex flex-col items-center justify-center group-hover:border-[#1E7A4A] group-hover:bg-gray-50 transition-all">
                <svg class="w-8 h-8 text-gray-400 group-hover:text-[#1E7A4A] transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span class="text-[10px] text-gray-400 mt-1">Upload</span>
            </div>
        @endif
        <input type="file" wire:model="variantOptions.{{ $optionIndex }}.values.{{ $valueIndex }}.image" accept="image/*" class="hidden">
    </label>
    
    <div class="flex items-center gap-1 w-full justify-center">
        <span class="text-xs font-medium text-gray-700 truncate max-w-[70px]">{{ $valueData['value'] }}</span>
        <button type="button" wire:click="removeOptionValue({{ $optionIndex }}, {{ $valueIndex }})" class="text-gray-400 hover:text-red-600 shrink-0">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
</div>
                                @error("variantOptions.{$optionIndex}.values.{$valueIndex}.image")
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            @else
                                <span class="inline-flex items-center gap-1.5 bg-[#1E7A4A]/10 text-[#1E7A4A] text-xs font-medium px-3 py-2 rounded-full whitespace-nowrap">
                                    {{ $valueData['value'] }}
                                    <button type="button" wire:click="removeOptionValue({{ $optionIndex }}, {{ $valueIndex }})" class="hover:text-red-600">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="flex items-center gap-2 mt-2">
                    <input type="text" wire:model="newOptionValue.{{ $optionIndex }}"
                           wire:keydown.enter.prevent="addOptionValue({{ $optionIndex }})"
                           placeholder="Type a value and press Enter"
                           class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#1E7A4A] focus:border-transparent">
                    <button type="button" wire:click="addOptionValue({{ $optionIndex }})"
                            class="px-3 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm font-medium shrink-0">
                        Add
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    <div class="flex items-center gap-3 flex-wrap mt-4 pt-3 border-t border-gray-100">
        @if (count($variantOptions) < 3)
            <button type="button" wire:click="addVariantOption"
                    class="inline-flex items-center px-3 py-2 border border-dashed border-gray-300 text-gray-600 rounded-lg hover:border-[#1E7A4A] hover:text-[#1E7A4A] text-sm font-medium transition">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Add another option
            </button>
        @endif

        <button type="button" wire:click="generateVariants" wire:loading.attr="disabled" wire:target="generateVariants"
                class="inline-flex items-center px-4 py-2 bg-[#1E7A4A] text-white rounded-lg hover:bg-[#16633c] text-sm font-medium transition">
            <span wire:loading.remove wire:target="generateVariants">Generate Variants</span>
            <span wire:loading wire:target="generateVariants">Generating...</span>
        </button>
    </div>
    
    @error('variants') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror
</div>
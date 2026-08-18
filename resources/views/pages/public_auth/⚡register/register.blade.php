<div>
  <div>
    <div>
      <section class="relative overflow-hidden lg:h-[calc(100vh-88px)] flex items-center justify-center bg-[#FDF6F9] py-4">

        <!-- Pink Floral Background layer -->
        <div class="absolute inset-0 z-0"
             style="background-image: url('https://images.unsplash.com/photo-1618331835717-801e976710b2?q=80&w=2500&auto=format&fit=crop'); background-size: cover; background-position: center; background-repeat: no-repeat; opacity: 0.4;">
        </div>

        <!-- Subtle light overlay -->
        <div class="absolute inset-0 z-[1] bg-gradient-to-br from-[#FDF6F9]/20 via-[#FDF6F9]/40 to-[#FDF6F9]/90"></div>

        <div class="relative z-10 w-full max-w-[1700px] mx-auto px-3 sm:px-6 lg:px-10 flex justify-center">
          
          {{-- Register Card - DEAD CENTER, COMPACT SPACING --}}
          <div class="w-full sm:w-[400px] lg:w-[400px] shrink-0">
            <div class="bg-white rounded-xl sm:rounded-lg shadow-xl shadow-[#D6657A]/10 border border-[#F4D9E2] p-6 sm:p-6">

              <!-- Logo + Title Header -->
              <div class="flex flex-col items-center justify-center gap-1 mb-5">
                <div class="w-9 h-9 lg:w-10 lg:h-10 border-2 border-[#D6657A]/20 rounded-lg flex items-center justify-center bg-[#D6657A]/10 shrink-0">
                  <svg class="w-4 h-4 lg:w-5 lg:h-5 text-[#D6657A]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c-1.5 2-4 3-4 6a4 4 0 008 0c0-3-2.5-4-4-6z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 13v8M9 18h6"/>
                  </svg>
                </div>
                <span class="font-serif text-lg font-bold text-[#D6657A] tracking-tight">Velvet & Co.</span>
                <p class="text-[9px] text-[#D6657A]/40 tracking-[0.2em] uppercase font-light leading-none">Luxury Salon</p>
              </div>

              <h2 class="font-serif text-xl font-bold text-center text-[#D6657A]">Create Account</h2>
              <p class="text-center text-xs text-[#D6657A]/60 mt-0.5">Register to start booking & purchasing</p>

              <form wire:submit.prevent="register" class="mt-4 space-y-2.5">

                {{-- Name --}}
                <div>
                  <input type="text"
                    wire:model="name"
                    placeholder="Full Name"
                    class="w-full border rounded px-3 py-2 text-sm placeholder:text-gray-400 bg-white focus:outline-none focus:ring-1 focus:ring-[#D6657A] focus:border-[#D6657A]
                           @error('name') border-[#D6657A] bg-[#FDF6F9] @else border-gray-200 @enderror">
                  @error('name')
                    <p class="mt-1 text-xs text-[#D6657A]">{{ $message }}</p>
                  @enderror
                </div>

                {{-- Email --}}
                <div>
                  <input type="email"
                    wire:model="email"
                    placeholder="Email"
                    class="w-full border rounded px-3 py-2 text-sm placeholder:text-gray-400 bg-white focus:outline-none focus:ring-1 focus:ring-[#D6657A] focus:border-[#D6657A]
                           @error('email') border-[#D6657A] bg-[#FDF6F9] @else border-gray-200 @enderror">
                  @error('email')
                    <p class="mt-1 text-xs text-[#D6657A]">{{ $message }}</p>
                  @enderror
                </div>

                {{-- Password --}}
                <div class="relative">
                  <input
                    wire:model="password"
                    type="{{ $showPassword ? 'text' : 'password' }}"
                    placeholder="Password"
                    class="w-full border rounded px-3 py-2 pr-10 text-sm placeholder:text-gray-400 bg-white focus:outline-none focus:ring-1 focus:ring-[#D6657A] focus:border-[#D6657A]
                           @error('password') border-[#D6657A] bg-[#FDF6F9] @else border-gray-200 @enderror">
                  <button type="button"
                    wire:click="$set('showPassword', {{ $showPassword ? 'false' : 'true' }})"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#D6657A]">
                    @if($showPassword)
                      <i data-lucide="eye" class="w-4 h-4"></i>
                    @else
                      <i data-lucide="eye-off" class="w-4 h-4"></i>
                    @endif
                  </button>
                </div>
                @error('password')
                  <p class="mt-1 text-xs text-[#D6657A]">{{ $message }}</p>
                @enderror

                {{-- Confirm Password --}}
                <div class="relative">
                  <input
                    wire:model="password_confirmation"
                    type="{{ $showConfirm ? 'text' : 'password' }}"
                    placeholder="Confirm Password"
                    class="w-full border rounded px-3 py-2 pr-10 text-sm placeholder:text-gray-400 bg-white focus:outline-none focus:ring-1 focus:ring-[#D6657A] focus:border-[#D6657A]
                           @error('password_confirmation') border-[#D6657A] bg-[#FDF6F9] @else border-gray-200 @enderror">
                  <button type="button"
                    wire:click="$set('showConfirm', {{ $showConfirm ? 'false' : 'true' }})"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#D6657A]">
                    @if($showConfirm)
                      <i data-lucide="eye" class="w-4 h-4"></i>
                    @else
                      <i data-lucide="eye-off" class="w-4 h-4"></i>
                    @endif
                  </button>
                </div>
                @error('password_confirmation')
                  <p class="mt-1 text-xs text-[#D6657A]">{{ $message }}</p>
                @enderror

                {{-- Terms --}}
                <div class="flex items-start gap-2 pt-1">
                  <input type="checkbox" 
                    id="terms" 
                    wire:model="termsAccepted"
                    class="mt-0.5 w-3.5 h-3.5 rounded border-gray-300 text-[#D6657A] focus:ring-[#D6657A]/50">
                  <label for="terms" class="text-xs text-[#D6657A]/70 leading-snug">
                    I Agree to
                    <a href="#" class="text-[#D6657A] hover:underline font-medium">Terms and Conditions</a>
                  </label>
                </div>
                @error('termsAccepted')
                  <p class="mt-1 text-xs text-[#D6657A]">{{ $message }}</p>
                @enderror

                {{-- Submit --}}
                <button type="submit"
                  class="w-full bg-[#D6657A] hover:bg-[#C25467] text-white font-semibold py-2.5 rounded transition flex items-center justify-center gap-2 text-sm shadow-sm hover:shadow-md mt-1">
                  <span wire:loading.remove wire:target="register">REGISTER</span>
                  <span wire:loading wire:target="register" class="flex items-center gap-2">
                    <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>
                    Creating account...
                  </span>
                </button>
              </form>
              
              <p class="text-center text-xs text-[#D6657A]/70 mt-4">
                Already have an account?
                <a href="{{ route('login') }}" class="text-[#D6657A] font-medium hover:underline">Sign in</a>
              </p>

            </div>
          </div>

        </div>
      </section>
    </div>
  </div>
</div>
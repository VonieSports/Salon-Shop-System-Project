
<div>
    <div>
<section class="relative overflow-hidden">

  <div class="absolute inset-0 z-0 bg-emerald-50/70"
       style="background-image: url('/images/herobg.png'); background-size: cover; background-position: center; opacity: 0.1;">
  </div>
  <div class="absolute inset-0 z-[1] bg-gradient-to-t from-white via-white/10 to-[#1E7A4A]/15"></div>

  <div class="relative z-10 max-w-[1700px] mx-auto px-6 lg:px-10 py-16 lg:py-24">
    <div class="flex flex-col lg:flex-row items-center justify-center gap-10 lg:gap-16">

      {{-- Left copy --}}
      <div class="w-full lg:w-auto lg:max-w-md shrink-0">
        <h1 class="font-serif-display text-5xl sm:text-6xl font-bold leading-[1.05] text-gray-900">
          Grow Your <span class="text-emerald-700">Salon</span>
          <br>
          <span class="text-emerald-700">Business.</span>
        </h1>
        <p class="mt-6 text-lg text-gray-700 leading-relaxed">
          Join Beauty Nova and manage your salon, staff, and customers all in one place.
        </p>
        <ul class="mt-7 space-y-4 text-lg text-gray-800">
          <li class="flex items-center gap-3">
            <i data-lucide="badge-check" class="w-5 h-5 text-emerald-600 shrink-0"></i>
            Manage services & products.
          </li>
          <li class="flex items-center gap-3">
            <i data-lucide="badge-check" class="w-5 h-5 text-emerald-600 shrink-0"></i>
            Track appointments & orders.
          </li>
          <li class="flex items-center gap-3">
            <i data-lucide="badge-check" class="w-5 h-5 text-emerald-600 shrink-0"></i>
            Grow with analytics & insights.
          </li>
        </ul>
      </div>

      {{-- Register card --}}
      <div class="w-full sm:w-auto shrink-0">
        <div class="bg-white w-full sm:w-[400px] rounded-2xl shadow-xl p-8 sm:p-10">

          <h2 class="font-serif-display text-2xl font-bold text-center text-gray-900">Create Account</h2>
          <p class="text-center text-sm text-gray-500 mt-1">Register your account to start selling, purchasing and booking</p>

          <form wire:submit.prevent="register" class="mt-7 space-y-4">

            {{-- Name --}}
            <div>
              <label class="block text-sm font-medium text-gray-800 mb-1.5">Name</label>
              <input type="text"
                wire:model.live="name"
                placeholder="e.g. yourname"
                class="w-full border rounded-md px-3.5 py-2.5 text-sm placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-emerald-700
                       @error('name') border-red-400 bg-red-50 @else border-gray-300 @enderror">
              @error('name')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
              @enderror
            </div>

            {{-- Email --}}
            <div>
              <label class="block text-sm font-medium text-gray-800 mb-1.5">Email</label>
              <input type="email"
                wire:model.live="email"
                placeholder="example@gmail.com"
                class="w-full border rounded-md px-3.5 py-2.5 text-sm placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-emerald-700
                       @error('email') border-red-400 bg-red-50 @else border-gray-300 @enderror">
              @error('email')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
              @enderror
            </div>

            {{-- Password --}}
            <div>
              <label class="block text-sm font-medium text-gray-800 mb-1.5">Password</label>
              <div class="relative">
                <input
                  wire:model.live="password"
                  type="{{ $showPassword ? 'text' : 'password' }}"
                  placeholder="••••••••"
                  class="w-full border rounded-md px-3.5 py-2.5 pr-10 text-sm placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-emerald-700
                         @error('password') border-red-400 bg-red-50 @else border-gray-300 @enderror">
                <button type="button"
                  wire:click="$set('showPassword', {{ $showPassword ? 'false' : 'true' }})"
                  class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                  @if($showPassword)
                    <i data-lucide="eye" class="w-4 h-4"></i>
                  @else
                    <i data-lucide="eye-off" class="w-4 h-4"></i>
                  @endif
                </button>
              </div>
              @error('password')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
              @enderror
            </div>

            {{-- Confirm Password --}}
            <div>
              <label class="block text-sm font-medium text-gray-800 mb-1.5">Confirm password</label>
              <div class="relative">
                <input
                  wire:model.live="password_confirmation"
                  type="{{ $showConfirm ? 'text' : 'password' }}"
                  placeholder="••••••••"
                  class="w-full border rounded-md px-3.5 py-2.5 pr-10 text-sm placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-emerald-700
                         @error('password_confirmation') border-red-400 bg-red-50 @else border-gray-300 @enderror">
                <button type="button"
                  wire:click="$set('showConfirm', {{ $showConfirm ? 'false' : 'true' }})"
                  class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                  @if($showConfirm)
                    <i data-lucide="eye" class="w-4 h-4"></i>
                  @else
                    <i data-lucide="eye-off" class="w-4 h-4"></i>
                  @endif
                </button>
              </div>
              @error('password_confirmation')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
              @enderror
            </div>

            {{-- Terms --}}
            <div class="flex items-start gap-2 pt-1">
              <input type="checkbox" id="terms" required
                class="mt-0.5 w-3.5 h-3.5 rounded border-gray-300 text-emerald-700 focus:ring-emerald-700">
              <label for="terms" class="text-xs text-gray-500 leading-snug">
                I Agree to
                <a href="#" class="text-[#1E7A4A] hover:underline font-medium">Terms and Conditions</a>
              </label>
            </div>

            {{-- Submit --}}
            <button type="submit"
              class="w-full bg-[#1E7A4A] hover:bg-emerald-900 text-white font-medium py-3 rounded-md transition flex items-center justify-center gap-2 mt-2">
              <span wire:loading.remove wire:target="register">Register</span>
              <span wire:loading wire:target="register" class="flex items-center gap-2">
                <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                </svg>
                Creating account...
              </span>
            </button>

          </form>

          <p class="text-center text-sm text-gray-600 mt-5">
            Already have an account?
            <a href="{{ route('owner.login.page') }}" class="text-[#1E7A4A] font-medium hover:underline">Sign in</a>
          </p>

        </div>
      </div>

    </div>
  </div>
</section>
</div>
    {{-- Be present above all else. - Naval Ravikant --}}
</div>
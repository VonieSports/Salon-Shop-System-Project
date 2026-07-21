<div>
<!-- Hero -->
<section class="relative overflow-hidden">

  <!-- Background image layer -->
  <div class="absolute inset-0 z-0 bg-emerald-50/70"
       style="background-image: url('images/herobg.png'); background-size: cover; background-position: center; opacity: 0.1;">
  </div>

  <!-- Gradient overlay -->
  <div class="absolute inset-0 z-[1] bg-gradient-to-t from-white via-white/10 to-[#1E7A4A]/15"></div>

  <div class="relative z-10 max-w-[1700px] mx-auto px-6 lg:px-10 py-16 lg:py-24">
    <div class="flex flex-col lg:flex-row items-center justify-center gap-10 lg:gap-16">

      <!-- Left copy -->
      <div class="w-full lg:w-auto lg:max-w-md shrink-0">
        <h1 class="font-serif-display text-5xl sm:text-6xl font-bold leading-[1.05] text-gray-900">
          Look Good. <span class="text-emerald-700">Feel</span>
          <br>
          <span class="text-emerald-700">Great.</span>
        </h1>
        <p class="mt-6 text-lg text-gray-700 leading-relaxed">
          Beaty Nova connects you with the best beauty and wellness experts in town.
        </p>
        <ul class="mt-7 space-y-4 text-lg text-gray-800">
          <li class="flex items-center gap-3">
            <i data-lucide="badge-check" class="w-5 h-5 text-emerald-600 shrink-0"></i>
            Shop verified products.
          </li>
          <li class="flex items-center gap-3">
            <i data-lucide="badge-check" class="w-5 h-5 text-emerald-600 shrink-0"></i>
            Book appointments 24/7.
          </li>
          <li class="flex items-center gap-3">
            <i data-lucide="badge-check" class="w-5 h-5 text-emerald-600 shrink-0"></i>
            Review your favorite experiences.
          </li>
        </ul>
      </div>

      <!-- Right: Login card -->
      <div class="w-full sm:w-auto shrink-0">
        <div class="bg-white w-full sm:w-[380px] rounded-2xl shadow-xl p-8 sm:p-10">
          <h2 class="font-serif-display text-2xl font-bold text-center text-gray-900">Welcome Back</h2>
          <p class="text-center text-sm text-gray-500 mt-1">Log in your credentials</p>

          {{-- Session error --}}
          @if(session('error'))
            <div class="mt-4 p-3 rounded-lg bg-red-50 border border-red-200 text-red-600 text-sm">
              {{ session('error') }}
            </div>
          @endif

          <form wire:submit.prevent="login" class="mt-7 space-y-5">

            {{-- Email --}}
            <div>
              <label class="block text-sm font-medium text-gray-800 mb-1.5">Email</label>
              <input type="email"
                wire:model="email"
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
                <input id="password"
                  type="password"
                  wire:model="password"
                  placeholder="••••••••"
                  class="w-full border rounded-md px-3.5 py-2.5 pr-10 text-sm focus:outline-none focus:ring-1 focus:ring-emerald-700
                         @error('password') border-red-400 bg-red-50 @else border-gray-300 @enderror">
                <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                  <i data-lucide="eye-off" id="eye-icon" class="w-4 h-4"></i>
                </button>
              </div>
              @error('password')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
              @enderror
            </div>

            {{-- Remember me --}}
            <div class="flex items-center justify-between">
              <label class="flex items-center gap-1.5 text-xs text-gray-600 cursor-pointer">
                <input type="checkbox"
                  wire:model="remember"
                  class="w-3.5 h-3.5 rounded border-gray-300 text-emerald-700 focus:ring-emerald-700">
                Remember me
              </label>
              <a href=""" class="text-xs text-emerald-700 hover:underline">
                Forgot Password?
              </a>
            </div>

            {{-- Submit --}}
            <button type="submit"
              class="w-full bg-[#1E7A4A] hover:bg-emerald-900 text-white font-medium py-3 rounded-md transition flex items-center justify-center gap-2">
              <span wire:loading.remove>Login</span>
              <span wire:loading class="flex items-center gap-2">
                Logging in...
              </span>
            </button>
          </form>

          <p class="text-center text-sm text-gray-600 mt-5">
            Don't have an account?
            <a href="{{ route('owner.register.page') }}" class="text-[#1E7A4A] font-medium hover:underline">Sign up</a>
          </p>
        </div>
      </div>

    </div>
  </div>
</section>
</div>

<script>
  function togglePassword() {
    const input   = document.getElementById('password');
    const iconEl  = document.getElementById('eye-icon');
    const isHidden = input.type === 'password';
    input.type = isHidden ? 'text' : 'password';
    iconEl.setAttribute('data-lucide', isHidden ? 'eye' : 'eye-off');
    lucide.createIcons();
  }
</script>
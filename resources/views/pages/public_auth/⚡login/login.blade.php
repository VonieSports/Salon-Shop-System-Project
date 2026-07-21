<div>
  <div>
    <!-- Hero -->
    <section class="relative overflow-hidden py-8 sm:py-12 lg:py-16">

      <!-- Background image layer -->
      <div class="absolute inset-0 z-0 bg-emerald-50/70"
           style="background-image: url('images/herobg.png'); background-size: cover; background-position: center; opacity: 0.1;">
      </div>

      <!-- Gradient overlay -->
      <div class="absolute lg:inset-0 z-[1] bg-gradient-to-t from-white via-white/10 to-[#1E7A4A]/15"></div>

      <div class="relative z-10 w-full max-w-[1700px] mx-auto ">
        <!-- MOBILE: Form ONLY (text hidden), DESKTOP: Content LEFT, Form RIGHT -->
        <div class="flex flex-col lg:flex-row items-center justify-center gap-6 sm:gap-8 lg:gap-12">

          <!-- Login Card - FULL SCREEN on mobile, RIGHT on desktop -->
          <div class="w-full sm:w-auto shrink-0 lg:order-2">
            <div class="bg-white w-full sm:w-[400px] lg:w-[460px] rounded-none sm:rounded-2xl shadow-none sm:shadow-xl p-5 sm:p-6 lg:p-8">
              
              <!-- Logo above form -->
              <div class="flex justify-center mb-4">
                <div class="flex items-center gap-2">
                  <svg class="w-8 h-8 lg:w-10 lg:h-10 text-emerald-800" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c-1.5 2-4 3-4 6a4 4 0 008 0c0-3-2.5-4-4-6z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 13v8M9 18h6"/>
                  </svg>
                  <span class="font-serif-display text-xl lg:text-2xl font-bold text-emerald-800 tracking-tight">Style Station</span>
                </div>
              </div>
              
              <h2 class="font-serif-display text-xl lg:text-2xl font-bold text-center text-gray-900">Welcome Back</h2>
              <p class="text-center text-xs text-gray-500 mt-0.5">Log in your credentials</p>

              {{-- Session error --}}
              @if(session('error'))
                <div class="mt-3 p-2.5 rounded-lg bg-red-50 border border-red-200 text-red-600 text-sm">
                  {{ session('error') }}
                </div>
              @endif

              <form wire:submit.prevent="login" class="mt-5 space-y-4">

                {{-- Email --}}
                <div>
                  <label class="block text-sm font-medium text-gray-800 mb-1">Email</label>
                  <input type="email"
                    wire:model="email"
                    placeholder="example@gmail.com"
                    class="w-full border rounded-md px-3.5 py-2.5 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-700
                           @error('email') border-red-400 bg-red-50 @else border-gray-300 @enderror">
                  @error('email')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                  @enderror
                </div>

                {{-- Password --}}
                <div>
                  <label class="block text-sm font-medium text-gray-800 mb-1">Password</label>
                  <div class="relative">
                    <input id="password"
                      type="password"
                      wire:model="password"
                      placeholder="••••••••"
                      class="w-full border rounded-md px-3.5 py-2.5 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-700
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
                      class="w-4 h-4 rounded border-gray-300 text-emerald-700 focus:ring-emerald-700">
                    Remember me
                  </label>
                  <a href="#" class="text-xs text-emerald-700 hover:underline">
                    Forgot Password?
                  </a>
                </div>

                {{-- Submit --}}
                <button type="submit"
                  class="w-full bg-[#1E7A4A] hover:bg-emerald-900 text-white font-medium py-3 rounded-md transition flex items-center justify-center gap-2 text-sm">
                  <span wire:loading.remove>Login</span>
                  <span wire:loading class="flex items-center gap-2">
                    <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>
                    Logging in...
                  </span>
                </button>
              </form>

              <p class="text-center text-sm text-gray-600 mt-4">
                Don't have an account?
                <a href="{{ route('register.page') }}" class="text-[#1E7A4A] font-medium hover:underline">Sign up</a>
              </p>

              <!-- Divider -->
              <div class="relative my-4">
                <div class="absolute inset-0 flex items-center">
                  <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                  <span class="px-3 bg-white text-gray-500">or</span>
                </div>
              </div>

              <!-- Social Login Buttons - ROW on desktop, COLUMN on mobile -->
              <div class="flex flex-col sm:grid sm:grid-cols-3 gap-2.5">
                <!-- Google Login -->
                <button type="button" class="w-full flex items-center justify-center gap-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium py-2.5 rounded-md transition text-xs">
                  <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 0 1-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                  </svg>
                  <span class="sm:hidden">Sign in with Google</span>
                  <span class="hidden sm:inline">Sign in</span>
                </button>

                <!-- Facebook Login -->
                <button type="button" class="w-full flex items-center justify-center gap-2 bg-[#1877F2] hover:bg-[#166FE5] text-white font-medium py-2.5 rounded-md transition text-xs">
                  <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                  </svg>
                  <span class="sm:hidden">Sign in with Facebook</span>
                  <span class="hidden sm:inline">Sign in</span>
                </button>

                <!-- Apple Login -->
                <button type="button" class="w-full flex items-center justify-center gap-2 bg-black hover:bg-gray-900 text-white font-medium py-2.5 rounded-md transition text-xs">
                  <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.8-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/>
                  </svg>
                  <span class="sm:hidden">Sign in with Apple</span>
                  <span class="hidden sm:inline">Sign in</span>
                </button>
              </div>
            </div>
          </div>

          <!-- Content - HIDDEN on mobile, VISIBLE on desktop -->
          <div class="hidden lg:block w-full lg:w-auto lg:max-w-md shrink-0 lg:order-1">
            <h1 class="font-serif-display text-5xl xl:text-6xl font-bold leading-[1.05] text-gray-900">
              Look Good. <span class="text-emerald-700">Feel</span>
              <br>
              <span class="text-emerald-700">Great.</span>
            </h1>
            <p class="mt-5 text-lg text-gray-700 leading-relaxed">
              Beauty Nova connects you with the best beauty and wellness experts in town.
            </p>
            <ul class="mt-6 space-y-3.5 text-lg text-gray-800">
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
</div>
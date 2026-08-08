<div>
  <div>
    <section class="relative overflow-hidden min-h-screen flex items-stretch">
      <div class="absolute top-6 left-6 z-20">
        <a href="{{ route('index.page') }}" class="flex items-center gap-2 text-white hover:text-gray-200 transition duration-200  px-4 py-2 rounded-lg ">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
          </svg>
          <span class="text-sm font-medium">Back</span>
        </a>
      </div>
      
      <div class="relative w-full mx-auto flex flex-col lg:flex-row min-h-screen">
        <div class="hidden lg:flex lg:w-1/2 items-center justify-center p-12 relative" 
             style="background: linear-gradient(135deg, #1E7A4A, #166534, #0F4A32); clip-path: polygon(0 0, 100% 0, 85% 100%, 0 100%);">

          <div class="text-white max-w-md w-full">
            <div class="flex items-center gap-3 mb-8">
              <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c-1.5 2-4 3-4 6a4 4 0 008 0c0-3-2.5-4-4-6z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 13v8M9 18h6"/>
              </svg>
              <span class="font-serif-display text-3xl font-bold tracking-tight">Style Station</span>
            </div>
            
            <h1 class="text-4xl font-bold mb-4 leading-tight">
              Welcome Back!
            </h1>
            <p class="text-emerald-100 text-lg mb-8">
              Login to access your admin dashboard
            </p>
            <div class="flex items-center gap-2 text-emerald-100">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
              </svg>
              <span>Secure admin access</span>
            </div>
          </div>
        </div>
        
        <div class="w-full lg:w-1/2 flex items-center justify-center bg-white p-4 sm:p-8">
          <div class="w-full sm:w-[400px] lg:w-[420px]">
            <div class="bg-white w-full">
              
              <div class="flex lg:hidden justify-center mb-6">
                <div class="flex items-center gap-2">
                  <svg class="w-8 h-8 text-[#1E7A4A]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c-1.5 2-4 3-4 6a4 4 0 008 0c0-3-2.5-4-4-6z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 13v8M9 18h6"/>
                  </svg>
                  <span class="font-serif-display text-xl font-bold text-[#1E7A4A] tracking-tight">Style Station</span>
                </div>
              </div>

              <div class="lg:hidden flex justify-start mb-4">
                <a href="#" class="flex items-center gap-2 text-[#1E7A4A] hover:text-[#166534] transition duration-200 text-sm font-medium">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                  </svg>
                  Back
                </a>
              </div>

              <h2 class="text-center text-2xl font-bold text-gray-800 mb-2">Admin Login</h2>
              @if(session('error'))
                <div class="mt-4 p-3 rounded-lg bg-red-50 border border-red-200 text-red-600 text-sm">
                  {{ session('error') }}
                </div>
              @endif

              <form wire:submit.prevent="login" class="mt-6 space-y-5">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1.5">Your email</label>
                  <input type="email"
                    wire:model="email"
                    placeholder="Enter your email"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3.5 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#1E7A4A] focus:border-transparent transition duration-200
                           @error('email') border-red-400 bg-red-50 @else border-gray-300 hover:border-[#1E7A4A] @enderror">
                  @error('email')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                  @enderror
                </div>

                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                  <div class="relative">
                    <input id="password"
                      type="password"
                      wire:model="password"
                      placeholder="Enter your password"
                      class="w-full border border-gray-300 rounded-lg px-4 py-3.5 pr-12 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#1E7A4A] focus:border-transparent transition duration-200
                             @error('password') border-red-400 bg-red-50 @else border-gray-300 hover:border-[#1E7A4A] @enderror">
                    <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition duration-200">
                      <i data-lucide="eye-off" id="eye-icon" class="w-5 h-5"></i>
                    </button>
                  </div>
                  @error('password')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                  @enderror
                </div>

                <div class="flex items-center justify-between">
                  <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                    <input type="checkbox"
                      wire:model="remember"
                      class="w-4 h-4 rounded border-gray-300 text-[#1E7A4A] focus:ring-[#1E7A4A] focus:ring-2">
                    Remember me
                  </label>
                  <a href="#" class="text-sm text-[#1E7A4A] hover:text-[#166534] font-medium hover:underline transition">
                    Recover password
                  </a>
                </div>

                <button type="submit"
                  class="w-full bg-[#1E7A4A] hover:bg-[#166534] text-white font-semibold py-3.5 rounded-lg transition duration-200 flex items-center justify-center gap-2 text-sm uppercase tracking-wider shadow-md hover:shadow-lg transform hover:scale-[1.02]">
                  <span wire:loading.remove>Sign In</span>
                  <span wire:loading class="flex items-center gap-2">
                    <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>
                    Logging in...
                  </span>
                </button>
              </form>
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
    document.addEventListener('DOMContentLoaded', function() {
      lucide.createIcons();
    });
  </script>
</div>
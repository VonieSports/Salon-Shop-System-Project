<div>
    <div>
        <!-- Hero - COMPACT SHOPEE STYLE WITH LOGO -->
        <section
            class="relative overflow-hidden lg:h-[calc(100vh-88px)] flex items-center justify-center bg-[#FDF6F9] py-4 sm:py-6">

            <!-- Background image layer -->
            <div class="absolute inset-0 z-0"
                style="background-image: url('images/loginbg.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat; opacity: 0.4;">
            </div>

            <!-- Subtle light overlay -->
            <div class="absolute inset-0 z-[1] bg-gradient-to-br from-[#FDF6F9]/20 via-[#FDF6F9]/40 to-[#FDF6F9]/90">
            </div>

            <div class="relative z-10 w-full max-w-[1700px] mx-auto px-3 sm:px-6 lg:px-10">
                <!-- Flex layout vertically centered -->
                <div class="flex flex-col lg:flex-row items-center justify-center gap-4 sm:gap-6 lg:gap-10">

                    <!-- Login Card - COMPACT SHOPEE STYLE -->
                    <div class="w-full sm:w-auto shrink-0 lg:order-2">
                        <div
                            class="bg-white w-full sm:w-[400px] lg:w-[400px] rounded-xl sm:rounded-lg shadow-xl shadow-[#D6657A]/10 border border-[#F4D9E2] p-5 sm:p-6">

                            <!-- Logo + Title Header -->
                            <!-- Logo + Title Header (PERFECTLY CENTERED & SPACED) -->
                            <div class="flex flex-col items-center justify-center gap-1 mb-6">
                                <div
                                    class="w-9 h-9 lg:w-10 lg:h-10 border-2 border-[#D6657A]/20 rounded-lg flex items-center justify-center bg-[#D6657A]/10 shrink-0">
                                    <svg class="w-4 h-4 lg:w-5 lg:h-5 text-[#D6657A]" fill="none"
                                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 3c-1.5 2-4 3-4 6a4 4 0 008 0c0-3-2.5-4-4-6z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 13v8M9 18h6" />
                                    </svg>
                                </div>
                                <span class="font-serif text-lg font-bold text-[#D6657A] tracking-tight">Velvet &
                                    Co.</span>
                                <p
                                    class="text-[9px] text-[#D6657A]/40 tracking-[0.2em] uppercase font-light leading-none">
                                    Luxury Salon</p>
                            </div>

                            {{-- Session error --}}
                            @if (session('error'))
                                <div
                                    class="mb-3 p-2 rounded-lg bg-[#F4D9E2] border border-[#D6657A]/30 text-[#D6657A] text-xs">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <form wire:submit.prevent="login" class="space-y-3">

                                {{-- Email --}}
                                <div>
                                    <input type="email" wire:model="email" placeholder="Email"
                                        class="w-full border rounded px-3 py-2.5 text-sm placeholder:text-gray-400 bg-white focus:outline-none focus:ring-1 focus:ring-[#D6657A] focus:border-[#D6657A]
                           @error('email') border-[#D6657A] bg-[#FDF6F9] @else border-gray-200 @enderror">
                                    @error('email')
                                        <p class="mt-1 text-xs text-[#D6657A]">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Password --}}
                                <div class="relative">
                                    <input id="password" type="password" wire:model="password" placeholder="Password"
                                        class="w-full border rounded px-3 py-2.5 pr-10 text-sm placeholder:text-gray-400 bg-white focus:outline-none focus:ring-1 focus:ring-[#D6657A] focus:border-[#D6657A]
                           @error('password') border-[#D6657A] bg-[#FDF6F9] @else border-gray-200 @enderror">
                                    <button type="button" onclick="togglePassword()"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#D6657A]">
                                        <i data-lucide="eye-off" id="eye-icon" class="w-4 h-4"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="mt-1 text-xs text-[#D6657A]">{{ $message }}</p>
                                @enderror

                                {{-- Remember me & Forgot Password --}}
                                <div class="flex items-center justify-between pt-1">
                                    <label class="flex items-center gap-1.5 text-xs text-[#D6657A]/70 cursor-pointer">
                                        <input type="checkbox" wire:model="remember"
                                            class="w-3.5 h-3.5 rounded border-gray-300 text-[#D6657A] focus:ring-[#D6657A]/50 bg-white">
                                        Stay Signed In
                                    </label>
                                    <a href="#" class="text-xs text-[#D6657A]/70 hover:text-[#D6657A]">
                                        Forgot?
                                    </a>
                                </div>

                                {{-- Submit --}}
                                <button type="submit"
                                    class="w-full bg-[#D6657A] hover:bg-[#C25467] text-white font-semibold py-2.5 rounded transition flex items-center justify-center gap-2 text-sm shadow-sm hover:shadow-md">
                                    <span wire:loading.remove>LOG IN</span>
                                    <span wire:loading class="flex items-center gap-2">
                                        <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z">
                                            </path>
                                        </svg>
                                        Logging in...
                                    </span>
                                </button>
                            </form>

                            <p class="text-center text-xs text-[#D6657A]/70 mt-4">
                                Don't have an Account?
                                <a href="{{ route('register.page') }}"
                                    class="text-[#D6657A] font-medium hover:underline">Sign Up</a>
                            </p>

                            <!-- Social Login Buttons - 2 Column Row -->
                            <div class="flex gap-2 mt-3">
                                <!-- Facebook Login -->
                                <button type="button"
                                    class="flex-1 flex items-center justify-center gap-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-medium py-2 rounded text-xs transition">
                                    <svg class="w-4 h-4 shrink-0 text-[#1877F2]" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                    </svg>
                                    Facebook
                                </button>

                                <!-- Google Login -->
                                <button type="button"
                                    class="flex-1 flex items-center justify-center gap-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-medium py-2 rounded text-xs transition">
                                    <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24">
                                        <path fill="#4285F4"
                                            d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 0 1-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z" />
                                        <path fill="#34A853"
                                            d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                                        <path fill="#FBBC05"
                                            d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                                        <path fill="#EA4335"
                                            d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                                    </svg>
                                    Google
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Content - HIDDEN on mobile, VISIBLE on desktop -->
                    <div class="hidden lg:block w-full lg:w-auto lg:max-w-md shrink-0 lg:order-1">
                        <h1 class="font-serif text-4xl xl:text-5xl font-bold leading-[1.05] text-[#D6657A]">
                            Look Good. <span class="text-[#EFA3B2]">Feel</span>
                            <br>
                            <span class="text-[#EFA3B2]">Amazing.</span>
                        </h1>
                        <p class="mt-4 text-base text-[#D6657A]/80 leading-relaxed">
                            Discover top-rated salons and premium beauty products. Book instantly and transform your
                            style.
                        </p>
                        <ul class="mt-4 space-y-2.5 text-base text-[#D6657A]/90">
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-[#D6657A] shrink-0" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Shop verified products
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-[#D6657A] shrink-0" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Book appointments 24/7
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-[#D6657A] shrink-0" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Review your favorite experiences
                            </li>
                        </ul>

                        <!-- Stats -->
                        <div class="mt-6 pt-5 border-t border-[#F4D9E2]/50 flex items-center gap-8">
                            <div>
                                <p class="font-serif text-2xl font-bold text-[#D6657A]">20k+</p>
                                <p class="text-xs text-[#D6657A]/50">Happy Clients</p>
                            </div>
                            <div>
                                <p class="font-serif text-2xl font-bold text-[#D6657A]">4k+</p>
                                <p class="text-xs text-[#D6657A]/50">Expert Salons</p>
                            </div>
                            <div>
                                <p class="font-serif text-2xl font-bold text-[#D6657A]">4.8 ★</p>
                                <p class="text-xs text-[#D6657A]/50">Average Rating</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const iconEl = document.getElementById('eye-icon');
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            iconEl.setAttribute('data-lucide', isHidden ? 'eye' : 'eye-off');
            lucide.createIcons();
        }
    </script>
</div>

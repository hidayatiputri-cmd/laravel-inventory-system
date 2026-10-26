<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - {{ config('app.name', 'GoShopping') }}</title>

    <!-- CDN Tailwind CSS & FontAwesome Instan -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <!-- Favicon SVG -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23f43f5e' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><path d='M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z'/><line x1='3' y1='6' x2='21' y2='6'/><path d='M16 10a4 4 0 0 1-8 0'/></svg>">
</head>
<body class="font-sans antialiased text-slate-800">
    @php
        $roleParam = request()->query('role');
        $defaultEmail = match($roleParam) {
            'admin' => 'admin@inventory.com',
            'staff' => 'staff@inventory.com',
            'customer' => 'customer@inventory.com',
            default => old('email', ''),
        };
        $defaultPassword = in_array($roleParam, ['admin', 'staff', 'customer']) ? 'password' : '';
    @endphp

    <!-- Layout Centered Layar Penuh Gelap Modern -->
    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-800 flex items-center justify-center p-4 relative overflow-hidden">
        <!-- Glow Orbs di Background -->
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-indigo-600/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-rose-600/20 rounded-full blur-3xl pointer-events-none"></div>

        <!-- Kartu Form Putih Melengkung -->
        <div class="bg-white rounded-3xl shadow-2xl p-8 w-full max-w-md relative z-10 border border-slate-100">
            <!-- Branding GoShopping Header -->
            <div class="text-center mb-6">
                <a href="/" class="inline-flex flex-col items-center group">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-600 text-white flex items-center justify-center shadow-lg shadow-indigo-500/30 group-hover:scale-105 transition-transform">
                        <!-- SVG Tas Belanja -->
                        <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <path d="M16 10a4 4 0 0 1-8 0"></path>
                        </svg>
                    </div>
                    <span class="text-2xl font-black text-slate-900 tracking-tight mt-3">
                        Go<span class="text-indigo-600">Shopping</span>
                    </span>
                </a>
                <p class="text-xs text-slate-500 mt-1 font-medium">Masuk ke akun Anda untuk melanjutkan</p>

                @if ($roleParam)
                    <div class="mt-3">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-black uppercase tracking-wider
                            {{ $roleParam === 'admin' ? 'bg-indigo-100 text-indigo-700' : ($roleParam === 'staff' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700') }}">
                            <i class="fa-solid fa-circle-check text-[10px]"></i>
                            <span>Portal {{ ucfirst($roleParam) }} Aktif</span>
                        </span>
                    </div>
                @endif
            </div>

            <!-- Session Status Alert -->
            @if (session('status'))
                <div class="mb-4 p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold flex items-center gap-2">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <!-- Form Login -->
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <!-- Input Email -->
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Alamat Email
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                            <i class="fa-solid fa-envelope text-sm"></i>
                        </span>
                        <input id="email" type="email" name="email" value="{{ $defaultEmail }}" required autofocus autocomplete="username" placeholder="nama@email.com"
                            class="w-full pl-10 pr-4 py-2.5 text-sm text-slate-900 bg-white border border-slate-300 rounded-xl focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 outline-none transition @error('email') border-rose-500 @enderror">
                    </div>
                    @error('email')
                        <p class="mt-1 text-xs text-rose-600 font-semibold flex items-center gap-1">
                            <i class="fa-solid fa-circle-exclamation text-[10px]"></i>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- Input Password -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-xs font-bold text-slate-700">
                            Kata Sandi
                        </label>
                        @if (Route::has('password.request'))
                            <a class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 hover:underline" href="{{ route('password.request') }}">
                                Lupa sandi?
                            </a>
                        @endif
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                            <i class="fa-solid fa-lock text-sm"></i>
                        </span>
                        <input id="password" type="password" name="password" value="{{ $defaultPassword }}" required autocomplete="current-password" placeholder="••••••••"
                            class="w-full pl-10 pr-4 py-2.5 text-sm text-slate-900 bg-white border border-slate-300 rounded-xl focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 outline-none transition @error('password') border-rose-500 @enderror">
                    </div>
                    @error('password')
                        <p class="mt-1 text-xs text-rose-600 font-semibold flex items-center gap-1">
                            <i class="fa-solid fa-circle-exclamation text-[10px]"></i>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between pt-1">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer select-none">
                        <input id="remember_me" type="checkbox" class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" name="remember" {{ $roleParam ? 'checked' : '' }}>
                        <span class="ms-2 text-xs font-medium text-slate-600">Ingat sesi saya</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" class="w-full py-2.5 px-4 rounded-xl text-white font-bold text-sm bg-indigo-600 hover:bg-indigo-700 active:scale-[0.98] shadow-md shadow-indigo-600/30 transition-all flex items-center justify-center gap-2">
                        <span>Masuk Sekarang</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </button>
                </div>
            </form>

            <!-- 3 Tombol Quick Role Portal -->
            <div class="mt-6 pt-5 border-t border-slate-100">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[11px] font-black uppercase tracking-wider text-slate-400">Pilih Akses Role Cepat</span>
                    <span class="text-[10px] text-slate-400 font-medium">Klik untuk isi otomatis</span>
                </div>

                <div class="grid grid-cols-3 gap-2">
                    <!-- 1. Admin -->
                    <button type="button" onclick="fillRole('admin@inventory.com', 'password', 'admin')"
                        class="p-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold text-xs text-center shadow-md shadow-blue-500/25 hover:shadow-lg hover:scale-[1.02] active:scale-95 transition-all flex flex-col items-center justify-center gap-1">
                        <i class="fa-solid fa-user-shield text-sm"></i>
                        <span>Admin</span>
                    </button>

                    <!-- 2. Staff -->
                    <button type="button" onclick="fillRole('staff@inventory.com', 'password', 'staff')"
                        class="p-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-bold text-xs text-center shadow-md shadow-emerald-500/25 hover:shadow-lg hover:scale-[1.02] active:scale-95 transition-all flex flex-col items-center justify-center gap-1">
                        <i class="fa-solid fa-boxes-packing text-sm"></i>
                        <span>Staff</span>
                    </button>

                    <!-- 3. Customer -->
                    <button type="button" onclick="fillRole('customer@inventory.com', 'password', 'customer')"
                        class="p-2.5 rounded-xl bg-gradient-to-r from-amber-500 to-rose-500 text-white font-bold text-xs text-center shadow-md shadow-rose-500/25 hover:shadow-lg hover:scale-[1.02] active:scale-95 transition-all flex flex-col items-center justify-center gap-1">
                        <i class="fa-solid fa-cart-shopping text-sm"></i>
                        <span>Customer</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script Pengisian Otomatis Quick Role -->
    <script>
        function fillRole(email, password, role) {
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const rememberInput = document.getElementById('remember_me');

            if (emailInput) {
                emailInput.value = email;
                emailInput.focus();
            }
            if (passwordInput) {
                passwordInput.value = password;
            }
            if (rememberInput) {
                rememberInput.checked = true;
            }

            // Update URL parameter tanpa reload jika diinginkan
            const newUrl = new URL(window.location);
            newUrl.searchParams.set('role', role);
            window.history.replaceState({}, '', newUrl);
        }
    </script>
</body>
</html>

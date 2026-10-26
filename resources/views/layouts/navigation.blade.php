<nav x-data="{ open: false }" class="bg-slate-900 text-white border-b border-slate-800 sticky top-0 z-30 shadow-md">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo GoShopping -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 group">
                        <!-- Modern Shopping Bag Icon -->
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-amber-500 via-rose-500 to-indigo-600 flex items-center justify-center text-white shadow-md shadow-rose-500/20 group-hover:scale-105 transition-transform">
                            <i class="fa-solid fa-bag-shopping text-lg"></i>
                        </div>
                        <div class="flex flex-col leading-none">
                            <span class="text-xl font-black tracking-tight text-white">
                                Go<span class="text-rose-400">Shopping</span>
                            </span>
                            <span class="text-[9px] font-bold tracking-widest uppercase text-slate-400">Smart Retail & POS</span>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links (Berjarak rapi & interaktif) -->
                <div class="hidden space-x-2 sm:-my-px sm:ms-10 sm:flex items-center">
                    <a href="{{ route('dashboard') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 {{ request()->routeIs('dashboard') ? 'bg-slate-800 text-rose-400 border border-slate-700 shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800/60' }}">
                        <i class="fa-solid fa-gauge-high text-xs"></i>
                        <span>Dashboard</span>
                    </a>

                    @if (in_array(Auth::user()->role, ['admin', 'staff']))
                        <a href="{{ route('products.index') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 {{ request()->routeIs('products.*') ? 'bg-slate-800 text-rose-400 border border-slate-700 shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800/60' }}">
                            <i class="fa-solid fa-boxes-stacked text-xs"></i>
                            <span>Produk</span>
                        </a>

                        <a href="{{ route('categories.index') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 {{ request()->routeIs('categories.*') ? 'bg-slate-800 text-rose-400 border border-slate-700 shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800/60' }}">
                            <i class="fa-solid fa-tags text-xs"></i>
                            <span>Kategori</span>
                        </a>

                        <a href="{{ route('suppliers.index') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 {{ request()->routeIs('suppliers.*') ? 'bg-slate-800 text-rose-400 border border-slate-700 shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800/60' }}">
                            <i class="fa-solid fa-truck-field text-xs"></i>
                            <span>Supplier</span>
                        </a>

                        <a href="{{ route('purchases.index') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 {{ request()->routeIs('purchases.*') ? 'bg-slate-800 text-rose-400 border border-slate-700 shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800/60' }}">
                            <i class="fa-solid fa-cart-flatbed text-xs"></i>
                            <span>Pembelian (In)</span>
                        </a>

                        <a href="{{ route('sales.index') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 {{ request()->routeIs('sales.*') ? 'bg-slate-800 text-rose-400 border border-slate-700 shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800/60' }}">
                            <i class="fa-solid fa-cash-register text-xs"></i>
                            <span>Penjualan (Out)</span>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Profile & Logout (Kanan) -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-3">
                <!-- User Profile Dropdown -->
                <div class="relative" x-data="{ openProfile: false }">
                    <button @click="openProfile = !openProfile" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl bg-slate-800/80 hover:bg-slate-800 border border-slate-700 text-slate-200 text-xs font-bold transition">
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-tr from-indigo-500 to-purple-600 text-white flex items-center justify-center font-black uppercase text-xs">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <span>{{ Auth::user()->name }}</span>
                        <span class="text-[9px] uppercase font-black px-2 py-0.5 rounded-full {{ Auth::user()->role === 'admin' ? 'bg-indigo-500/30 text-indigo-300 border border-indigo-500/40' : (Auth::user()->role === 'staff' ? 'bg-teal-500/30 text-teal-300 border border-teal-500/40' : 'bg-rose-500/30 text-rose-300 border border-rose-500/40') }}">
                            {{ Auth::user()->role }}
                        </span>
                        <i class="fa-solid fa-chevron-down text-[10px] text-slate-400"></i>
                    </button>

                    <!-- Profile Dropdown Content -->
                    <div x-show="openProfile" @click.away="openProfile = false" x-transition class="absolute right-0 mt-2 w-48 bg-slate-800 rounded-2xl shadow-xl border border-slate-700 py-1.5 z-50 text-xs text-slate-200">
                        <div class="px-4 py-2 border-b border-slate-700 text-[11px] text-slate-400">
                            Masuk sebagai:<br>
                            <span class="font-bold text-white">{{ Auth::user()->email }}</span>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 hover:bg-slate-700/60 transition">
                            <i class="fa-solid fa-user-gear text-slate-400"></i>
                            <span>Edit Profil</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left flex items-center gap-2 px-4 py-2 text-rose-400 hover:bg-slate-700/60 hover:text-rose-300 transition">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                <span>Keluar (Logout)</span>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Direct Quick Logout Button -->
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="p-2 rounded-xl bg-rose-500/20 hover:bg-rose-500 text-rose-300 hover:text-white border border-rose-500/30 transition text-xs flex items-center justify-center" title="Keluar dari sistem">
                        <i class="fa-solid fa-power-off"></i>
                    </button>
                </form>
            </div>

            <!-- Hamburger Button Mobile -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800 focus:outline-none transition">
                    <i :class="{'fa-xmark': open, 'fa-bars': !open}" class="fa-solid text-lg"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Mobile Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-slate-800 bg-slate-900/95 backdrop-blur-xl px-4 py-3 space-y-2">
        <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-xl text-xs font-bold {{ request()->routeIs('dashboard') ? 'bg-slate-800 text-rose-400' : 'text-slate-300 hover:text-white' }}">
            <i class="fa-solid fa-gauge-high me-2"></i> Dashboard
        </a>

        @if (in_array(Auth::user()->role, ['admin', 'staff']))
            <a href="{{ route('products.index') }}" class="block px-3 py-2 rounded-xl text-xs font-bold {{ request()->routeIs('products.*') ? 'bg-slate-800 text-rose-400' : 'text-slate-300 hover:text-white' }}">
                <i class="fa-solid fa-boxes-stacked me-2"></i> Produk
            </a>
            <a href="{{ route('categories.index') }}" class="block px-3 py-2 rounded-xl text-xs font-bold {{ request()->routeIs('categories.*') ? 'bg-slate-800 text-rose-400' : 'text-slate-300 hover:text-white' }}">
                <i class="fa-solid fa-tags me-2"></i> Kategori
            </a>
            <a href="{{ route('suppliers.index') }}" class="block px-3 py-2 rounded-xl text-xs font-bold {{ request()->routeIs('suppliers.*') ? 'bg-slate-800 text-rose-400' : 'text-slate-300 hover:text-white' }}">
                <i class="fa-solid fa-truck-field me-2"></i> Supplier
            </a>
            <a href="{{ route('purchases.index') }}" class="block px-3 py-2 rounded-xl text-xs font-bold {{ request()->routeIs('purchases.*') ? 'bg-slate-800 text-rose-400' : 'text-slate-300 hover:text-white' }}">
                <i class="fa-solid fa-cart-flatbed me-2"></i> Pembelian (In)
            </a>
            <a href="{{ route('sales.index') }}" class="block px-3 py-2 rounded-xl text-xs font-bold {{ request()->routeIs('sales.*') ? 'bg-slate-800 text-rose-400' : 'text-slate-300 hover:text-white' }}">
                <i class="fa-solid fa-cash-register me-2"></i> Penjualan (Out)
            </a>
        @endif

        <div class="pt-3 border-t border-slate-800 flex items-center justify-between text-xs">
            <div>
                <span class="block font-bold text-white">{{ Auth::user()->name }}</span>
                <span class="text-slate-400 text-[10px]">{{ Auth::user()->email }} ({{ Auth::user()->role }})</span>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="px-3 py-1.5 rounded-lg bg-rose-500/20 text-rose-300 font-bold hover:bg-rose-500 hover:text-white transition">
                    Logout
                </button>
            </form>
        </div>
    </div>
</nav>

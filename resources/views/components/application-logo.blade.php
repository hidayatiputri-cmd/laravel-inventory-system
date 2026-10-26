<div {{ $attributes->merge(['class' => 'inline-flex items-center gap-2.5 font-sans tracking-tight']) }}>
    <!-- Modern Gradient Shopping Bag Icon -->
    <div class="relative flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-tr from-amber-500 via-rose-500 to-indigo-600 shadow-md shadow-rose-500/20 text-white shrink-0">
        <svg class="w-6 h-6 transform -rotate-6 transition-transform group-hover:rotate-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
            <line x1="3" y1="6" x2="21" y2="6"/>
            <path d="M16 10a4 4 0 0 1-8 0"/>
        </svg>
        <span class="absolute -top-1 -right-1 flex h-3 w-3">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-3 w-3 bg-amber-400"></span>
        </span>
    </div>
    <!-- Brand Typography -->
    <div class="flex flex-col leading-none">
        <div class="flex items-center text-xl font-black">
            <span class="bg-gradient-to-r from-rose-600 via-pink-600 to-indigo-600 bg-clip-text text-transparent">Go</span>
            <span class="text-gray-900 font-extrabold">Shopping</span>
        </div>
        <span class="text-[9px] font-bold tracking-widest uppercase text-gray-400">Smart Retail & Inventory</span>
    </div>
</div>

<header class="bg-amber-800 text-white shadow-sm">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <a href="{{ route('home') }}" class="text-xl font-bold tracking-tight text-amber-50 hover:text-white">
            Kaon Ta! Davao Rocamora's Food Guide
        </a>

        <nav class="flex flex-wrap items-center gap-4 text-sm font-medium">
            <a href="{{ route('home') }}"
               class="{{ request()->routeIs('home') ? 'underline underline-offset-4 text-amber-200' : 'text-amber-50 hover:text-amber-200' }}">
                Home
            </a>
            <a href="{{ route('eateries.index') }}"
               class="{{ request()->routeIs('eateries.index') || request()->routeIs('eateries.show') ? 'underline underline-offset-4 text-amber-200' : 'text-amber-50 hover:text-amber-200' }}">
                Eateries
            </a>
            <a href="{{ route('districts.index') }}"
               class="{{ request()->routeIs('districts.*') ? 'underline underline-offset-4 text-amber-200' : 'text-amber-50 hover:text-amber-200' }}">
                Districts
            </a>
            <a href="{{ route('eateries.create') }}"
               class="px-3.5 py-1.5 rounded-lg bg-amber-500 hover:bg-amber-400 text-slate-950 font-semibold transition">
                Add Eatery
            </a>
        </nav>
    </div>
</header>
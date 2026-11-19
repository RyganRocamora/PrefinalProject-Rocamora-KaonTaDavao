<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kaon Ta! Davao Rocamora's Food Guide</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-amber-50/40 text-slate-800 min-h-screen flex flex-col">
    @include('partials.nav')

    <main class="max-w-6xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 flex-1">
        @include('partials.flash')
        @yield('content')
    </main>

    <footer class="border-t border-amber-200/70 bg-white mt-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-4 text-xs text-slate-500 flex flex-col sm:flex-row justify-between gap-2">
            <span>Kaon Ta! Davao Rocamora's Food Guide — Davao City Tourism Office</span>
            <span>Carinderia &amp; Eatery Directory</span>
        </div>
    </footer>
</body>
</html>
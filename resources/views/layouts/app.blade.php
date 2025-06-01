<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    

    <title>{{ config('app.name', 'GlitchGate') }}</title>
            <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/png" />


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 flex flex-col min-h-screen text-gray-900 dark:text-gray-100">
    @include('layouts.navigation')

    @if (isset($header))
        <header class="bg-white dark:bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endif

    <!-- Контент страницы -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Футер -->
    <footer
    class="mt-auto
           bg-white dark:bg-gray-950/70
           backdrop-blur-sm
           text-gray-800 dark:text-gray-200
           border-t border-gray-300 dark:border-gray-800
           shadow-[0_-2px_10px_rgba(0,0,0,0.1)] dark:shadow-[0_-2px_10px_rgba(0,0,0,0.3)]"
>
    <div class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-3 gap-10">
        <!-- Лого и слоган -->
        <div class="space-y-2">
            <h2 class="text-2xl font-extrabold tracking-tight text-gray-900 dark:text-white">GlitchGate</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Мы создаём цифровые продукты с душой и вниманием к деталям.
            </p>
        </div>

        <!-- Навигация -->
        <div class="space-y-4">
            <h3 class="text-lg font-semibold border-b pb-1 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">Навигация</h3>
            <ul class="space-y-2 text-sm text-gray-700 dark:text-gray-300">
                <li><a href="{{ route('main.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Главная</a></li>
                <li><a href="{{ route('admin.orders.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Заказы</a></li>
            </ul>
        </div>

        <!-- Контакты -->
        <div class="space-y-4">
            <h3 class="text-lg font-semibold border-b pb-1 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">Контакты</h3>
            <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                <li>📧 glitchgate@gmail.com</li>
                <li>📞 +78005553535</li>
            </ul>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 border-t border-gray-300 dark:border-gray-800 mt-6 pt-4 text-center text-xs text-gray-600 dark:text-gray-400">
        © {{ date('Y') }} GlitchGate — Все права защищены.
    </div>
</footer>

</body>
</html>

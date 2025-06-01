{{-- resources/views/layouts/navigation.blade.php --}}
<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('main.index') }}" class="flex items-center">
                        {{-- SVG Logo --}}
                        <svg width="56" height="56" viewBox="0 0 140 56" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14 14 H32 A10 10 0 0 1 32 42 H14" stroke="#5C4DFF" stroke-width="4" fill="none" />
                            <path d="M22 14 V28 H32" stroke="#5C4DFF" stroke-width="4" fill="none" />
                            <line x1="18" y1="30" x2="26" y2="30" stroke="#FF3D3D" stroke-width="3" stroke-dasharray="4 4" />
                            <g transform="translate(68,0) scale(-1,1) translate(-68,0)">
                                <path d="M14 14 H32 A10 10 0 0 1 32 42 H14" stroke="#5C4DFF" stroke-width="4" fill="none" />
                                <path d="M22 14 V28 H32" stroke="#5C4DFF" stroke-width="4" fill="none" />
                                <line x1="18" y1="30" x2="26" y2="30" stroke="#FF3D3D" stroke-width="3" stroke-dasharray="4 4" />
                            </g>
                            <rect x="2" y="2" width="136" height="52" rx="8" stroke="#5C4DFF" stroke-width="2" fill="none" />
                            <circle cx="12" cy="12" r="2" fill="#FF3D3D" />
                            <circle cx="128" cy="44" r="2" fill="#FF3D3D" />
                            <circle cx="32" cy="44" r="1.5" fill="#FF3D3D" />
                            <circle cx="108" cy="12" r="1.5" fill="#FF3D3D" />
                        </svg>
                        <span class="ml-3 font-bold text-xl text-indigo-600 dark:text-indigo-400 select-none">GlitchGate</span>
                    </a>
                </div>

                <!-- Links -->
                <div class="hidden sm:flex sm:items-center space-x-8 ms-10">
                    <x-nav-link :href="route('main.index')" :active="request()->routeIs('main.index')">
                        Каталог
                    </x-nav-link>
                    @auth
                        <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.index')">
                            Мои заказы
                        </x-nav-link>
                    @endauth
                </div>
            </div>

            <!-- Right Section -->
            <div class="hidden sm:flex sm:items-center space-x-4">
                <!-- Cart Icon -->
                <a href="{{ route('cart.index') }}"
                   class="text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition relative"
                   aria-label="Корзина">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3 3h2l.4 2M7 13h10l4-8H5.4" />
                        <circle cx="7" cy="21" r="2" />
                        <circle cx="17" cy="21" r="2" />
                    </svg>
                </a>

                <!-- Theme Toggle -->
                <button id="theme-toggle"
                        class="p-2 rounded-md bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 transition focus:outline-none focus:ring-2 focus:ring-yellow-500"
                        aria-label="Переключить тему">
                    <svg id="theme-toggle-light-icon" class="w-5 h-5 hidden" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 3a1 1 0 011 1v1a1 1 0 11-2 0V4a1 1 0 011-1z..."/>
                    </svg>
                    <svg id="theme-toggle-dark-icon" class="w-5 h-5 hidden" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                              d="M17.293 13.293a8 8 0 11-10.586-10.586 7 7 0 0010.586 10.586z"
                              clip-rule="evenodd" />
                    </svg>
                </button>

                @auth
                    <!-- Dropdown -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border text-sm font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 transition">
                                <div>{{ Auth::user()->name }}</div>
                                <svg class="ms-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                          clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                Профиль
                            </x-dropdown-link>

                            @if(auth()->user()->isAdmin())
                                <x-dropdown-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.index')">
                                    Панель Заказов
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.games.index')" :active="request()->routeIs('admin.games.*')">
                                    Админка игр
                                </x-dropdown-link>
                            @endif

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                                 onclick="event.preventDefault(); this.closest('form').submit();">
                                    Выход
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}"
                           class="text-sm text-gray-700 dark:text-gray-300 underline hover:text-indigo-600 dark:hover:text-indigo-400">Войти</a>
                        <a href="{{ route('register') }}"
                           class="text-sm text-gray-700 dark:text-gray-300 underline hover:text-indigo-600 dark:hover:text-indigo-400">Регистрация</a>
                    </div>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }"
                              class="inline-flex" stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': ! open, 'inline-flex': open }"
                              class="hidden" stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="sm:hidden hidden bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-600">
        <div class="pt-4 pb-3 px-4 space-y-1">
            <x-responsive-nav-link :href="route('main.index')" :active="request()->routeIs('main.index')">
                Каталог
            </x-responsive-nav-link>

            @auth
                <x-responsive-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.index')">
                    Мои заказы
                </x-responsive-nav-link>
            @endauth

            <a href="{{ route('cart.index') }}"
               class="flex items-center px-4 py-2 text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 me-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4" />
                    <circle cx="7" cy="21" r="2" />
                    <circle cx="17" cy="21" r="2" />
                </svg>
                Корзина
            </a>

            <!-- Theme Toggle Mobile -->
            <button id="theme-toggle-mobile"
                    class="flex items-center w-full px-4 py-2 mt-3 rounded-md bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 transition"
                    aria-label="Переключить тему">
                <svg id="theme-toggle-light-icon-mobile" class="w-5 h-5 me-2 hidden" fill="currentColor" viewBox="0 0 20 20">
                    <path d="..."/>
                </svg>
                <svg id="theme-toggle-dark-icon-mobile" class="w-5 h-5 me-2 hidden" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="..." clip-rule="evenodd"/>
                </svg>
                Сменить тему
            </button>

            @auth
                <div class="border-t border-gray-200 dark:border-gray-600 mt-4 pt-4">
                    <div class="px-4">
                        <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <x-responsive-nav-link :href="route('profile.edit')">Профиль</x-responsive-nav-link>

                        @if(auth()->user()->isAdmin())
                            <x-responsive-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.index')">Панель Заказов</x-responsive-nav-link>
                            <x-responsive-nav-link :href="route('admin.games.index')" :active="request()->routeIs('admin.games.*')">Админка игр</x-responsive-nav-link>
                        @endif

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">Выход</x-responsive-nav-link>
                        </form>
                    </div>
                </div>
            @else
                <div class="border-t border-gray-200 dark:border-gray-600 mt-4 pt-4 px-4 flex justify-between">
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-300 underline hover:text-indigo-600 dark:hover:text-indigo-400">Войти</a>
                    <a href="{{ route('register') }}" class="text-sm text-gray-700 dark:text-gray-300 underline hover:text-indigo-600 dark:hover:text-indigo-400">Регистрация</a>
                </div>
            @endauth
        </div>
    </div>
</nav>

<script>
    function toggleTheme() {
        const html = document.documentElement;
        const lightIcon = document.getElementById('theme-toggle-light-icon');
        const darkIcon = document.getElementById('theme-toggle-dark-icon');
        const lightIconMobile = document.getElementById('theme-toggle-light-icon-mobile');
        const darkIconMobile = document.getElementById('theme-toggle-dark-icon-mobile');

        if (html.classList.contains('dark')) {
            html.classList.remove('dark');
            localStorage.setItem('theme', 'light');
            lightIcon.classList.remove('hidden');
            darkIcon.classList.add('hidden');
            lightIconMobile.classList.remove('hidden');
            darkIconMobile.classList.add('hidden');
        } else {
            html.classList.add('dark');
            localStorage.setItem('theme', 'dark');
            lightIcon.classList.add('hidden');
            darkIcon.classList.remove('hidden');
            lightIconMobile.classList.add('hidden');
            darkIconMobile.classList.remove('hidden');
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const themeToggleBtn = document.getElementById('theme-toggle');
        const themeToggleBtnMobile = document.getElementById('theme-toggle-mobile');

        const savedTheme = localStorage.getItem('theme');
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

        const html = document.documentElement;
        const lightIcon = document.getElementById('theme-toggle-light-icon');
        const darkIcon = document.getElementById('theme-toggle-dark-icon');
        const lightIconMobile = document.getElementById('theme-toggle-light-icon-mobile');
        const darkIconMobile = document.getElementById('theme-toggle-dark-icon-mobile');

        if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
            html.classList.add('dark');
            lightIcon.classList.add('hidden');
            darkIcon.classList.remove('hidden');
            lightIconMobile.classList.add('hidden');
            darkIconMobile.classList.remove('hidden');
        } else {
            html.classList.remove('dark');
            lightIcon.classList.remove('hidden');
            darkIcon.classList.add('hidden');
            lightIconMobile.classList.remove('hidden');
            darkIconMobile.classList.add('hidden');
        }

        if (themeToggleBtn) themeToggleBtn.addEventListener('click', toggleTheme);
        if (themeToggleBtnMobile) themeToggleBtnMobile.addEventListener('click', toggleTheme);
    });
</script>

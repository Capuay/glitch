@extends('layouts.app')

@section('content')
<div x-data="gameFilter()" class="container mx-auto mt-8 flex min-h-screen flex-col md:flex-row md:space-x-8">
    <!-- Фильтры -->
    <aside
        class="w-full md:w-1/4 bg-white dark:bg-gray-900 text-gray-900 dark:text-white p-8 rounded-lg shadow-xl flex flex-col mb-8 md:mb-0
               border border-gray-300 dark:border-gray-700
               md:sticky md:top-20 md:self-start"
        style="border: 1px solid var(--tw-border-opacity) !important;"
    >
        <h2 class="text-3xl font-extrabold mb-6 tracking-wide drop-shadow-lg">Фильтры</h2>

        <!-- Поиск -->
        <div class="mb-6">
            <label for="search" class="block text-sm font-semibold mb-3 tracking-wide">Поиск по названию</label>
            <input
                type="text"
                id="search"
                x-model.debounce.500="search"
                placeholder="Введите название"
                class="w-full bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 text-yellow-600 dark:text-yellow-400 py-3 px-4 rounded-lg shadow-inner
                       placeholder-gray-400 dark:placeholder-gray-600 focus:outline-none focus:ring-4 focus:ring-yellow-500 focus:border-yellow-500 transition duration-300 ease-in-out"
            >
        </div>

        <!-- Остальные фильтры -->
        <form method="GET" action="{{ route('main.index') }}">
            <input type="hidden" name="search" :value="search">

            <div class="mt-6">
                <label for="category" class="block text-sm font-semibold mb-3 tracking-wide">Категория</label>
                <select name="category" id="category"
                    class="w-full bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 text-yellow-600 dark:text-yellow-400 py-3 px-4 rounded-lg shadow-inner
                           focus:outline-none focus:ring-4 focus:ring-yellow-500 focus:border-yellow-500 transition duration-300 ease-in-out"
                    x-model="category"
                >
                    <option value="" class="text-gray-600 dark:text-gray-400">Все категории</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" class="text-gray-900 dark:text-gray-100">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-6">
                <label for="min_price" class="block text-sm font-semibold mb-3 tracking-wide">Мин. цена</label>
                <input
                    type="number"
                    name="min_price"
                    id="min_price"
                    placeholder="0"
                    class="w-full bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 text-yellow-600 dark:text-yellow-400 py-3 px-4 rounded-lg shadow-inner
                           placeholder-gray-400 dark:placeholder-gray-600 focus:outline-none focus:ring-4 focus:ring-yellow-500 focus:border-yellow-500 transition duration-300 ease-in-out"
                    x-model="min_price"
                >
            </div>

            <div class="mt-6">
                <label for="max_price" class="block text-sm font-semibold mb-3 tracking-wide">Макс. цена</label>
                <input
                    type="number"
                    name="max_price"
                    id="max_price"
                    placeholder="10000"
                    class="w-full bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 text-yellow-600 dark:text-yellow-400 py-3 px-4 rounded-lg shadow-inner
                           placeholder-gray-400 dark:placeholder-gray-600 focus:outline-none focus:ring-4 focus:ring-yellow-500 focus:border-yellow-500 transition duration-300 ease-in-out"
                    x-model="max_price"
                >
            </div>

            <button type="submit"
                class="mt-8 bg-gradient-to-r from-yellow-500 via-yellow-600 to-yellow-700 hover:from-yellow-600 hover:via-yellow-700 hover:to-yellow-800 text-gray-900 dark:text-gray-100 font-extrabold py-3 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300 ease-in-out w-full">
                Применить фильтры
            </button>
        </form>

        <!-- Кнопка корзины -->
        <a href="{{ route('cart.index') }}"
            class="mt-6 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white py-3 rounded-lg font-bold text-center shadow-lg transform hover:scale-105 transition-transform duration-300 ease-in-out">
            Перейти в корзину
        </a>
    </aside>

    <!-- Основной контент -->
    <main class="w-full md:w-3/4">
        <h1 class="text-4xl font-extrabold text-center mb-10 text-yellow-500 dark:text-yellow-400 tracking-wide drop-shadow-lg">
            Каталог игр
        </h1>

        <template x-if="games.length === 0">
            <p class="text-gray-500 dark:text-gray-400 text-center text-xl mt-20">Ничего не найдено.</p>
        </template>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8" x-show="games.length > 0">
            <template x-for="game in games" :key="game.id">
                <article
                    class="bg-white dark:bg-gray-900 text-gray-900 dark:text-white rounded-xl shadow-2xl p-6 flex flex-col justify-between border border-gray-300 dark:border-gray-700
                           hover:border-yellow-500 hover:shadow-yellow-600/40 transition-all duration-400 ease-in-out
                           transform hover:-translate-y-1 hover:scale-[1.03]"
                >
                    <img :src="`/storage/images/${game.image}`" :alt="game.title"
                        class="rounded-lg w-full h-56 object-cover mb-6 shadow-lg">

                    <h2 class="text-xl font-extrabold mb-3 text-center tracking-wide text-yellow-600 dark:text-yellow-400 drop-shadow-md" x-text="game.title"></h2>

                    <div class="text-gray-600 dark:text-gray-400 text-sm mb-2" style="white-space: pre-line;" x-text="game.description.length > 120 ? game.description.substring(0, 117) + '...' : game.description"></div>

                    <p class="text-2xl font-extrabold text-center mb-4 text-yellow-600 dark:text-yellow-400 drop-shadow-lg">
                        $<span x-text="parseFloat(game.price).toFixed(2)"></span>
                    </p>

                    <a :href="`/games/${game.id}`"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md text-center transition-transform duration-200 ease-in-out hover:scale-105 block mb-4">
                        Подробнее
                    </a>
                </article>
            </template>
        </div>

        <div class="mt-8" x-show="!search">
            {{-- Показываем пагинацию только если не используется динамический поиск --}}
            {{ $games->withQueryString()->links('vendor.pagination.custom') }}
        </div>
    </main>
</div>

<script>
function gameFilter() {
    return {
        search: @json(request('search', '')),
        category: @json(request('category', '')),
        min_price: @json(request('min_price', '')),
        max_price: @json(request('max_price', '')),
        games: @json($games->items()),

        fetchGames() {
            if (this.search.trim().length === 0) {
                // При пустом поиске подгружаем игры из первоначального запроса
                this.games = @json($games->items());
                return;
            }
            fetch(`/search-games?title=${encodeURIComponent(this.search)}`)
                .then(res => res.json())
                .then(data => {
                    this.games = data;
                })
                .catch(() => {
                    this.games = [];
                });
        },

        // Автообновление при изменении search
        init() {
            this.$watch('search', value => {
                this.fetchGames();
            });

            // Подгрузим игры при инициализации
            this.fetchGames();
        }
    }
}
</script>
@endsection

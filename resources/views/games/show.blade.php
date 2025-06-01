@extends('layouts.app')

<style>
    /* Скрываем скроллбар в разных браузерах */
.scrollbar-hide {
  -ms-overflow-style: none;  /* IE и Edge */
  scrollbar-width: none;     /* Firefox */
}
.scrollbar-hide::-webkit-scrollbar {
  display: none;             /* Chrome, Safari, Opera */
}

/* Немного добавим тени и плавности */
.carousel-item {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.carousel-item:hover {
  transform: scale(1.05);
  box-shadow: 0 8px 20px rgba(255, 215, 0, 0.7); /* желтая тень */
}
</style>

@section('content')
<div class="container mx-auto my-10 px-6 max-w-5xl" 
     x-data="gamePage({{ $game->id }})">

    <!-- Основной блок -->
    <div class="bg-white dark:bg-gray-900 text-gray-900 dark:text-white rounded-xl shadow-2xl p-8 flex flex-col md:flex-row gap-8">
        <!-- Изображение -->
        <div class="w-full md:w-1/2">
            <img src="{{ asset('storage/images/' . $game->image) }}"
                 alt="{{ $game->title }}"
                 class="w-full h-[400px] object-cover rounded-lg shadow-lg">
        </div>

        <!-- Информация -->
        <div class="w-full md:w-1/2 flex flex-col justify-between">
            <div>
                <h1 class="text-4xl font-extrabold text-yellow-400 mb-4">{{ $game->title }}</h1>
                <p class="text-gray-700 dark:text-gray-300 mb-4 whitespace-pre-line">{{ $game->description }}</p>

                <div class="mb-4">
                    <span class="text-sm text-gray-500 dark:text-gray-400">Жанр:</span>
                    <span class="text-lg font-semibold text-yellow-500">{{ $game->category->name ?? 'Без категории' }}</span>
                </div>

                <p class="text-3xl font-bold text-yellow-600 mb-6">${{ number_format($game->price, 2) }}</p>
            </div>

            <!-- Кнопки -->
            <div>
                <button
                    @click="addToCart"
                    x-show="!added"
                    class="w-full bg-yellow-400 hover:bg-yellow-500 dark:bg-yellow-500 dark:hover:bg-yellow-600 text-gray-900 font-bold py-3 px-6 rounded-lg shadow-lg transition duration-300 transform hover:scale-105"
                >
                    Добавить в корзину
                </button>

                <template x-if="added">
                    <div class="text-center">
                        <p class="text-green-600 dark:text-green-400 font-semibold mt-4">Товар успешно добавлен!</p>
                        <a href="{{ route('cart.index') }}"
                           class="mt-3 inline-block bg-green-600 hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300 transform hover:scale-105"
                        >
                            Перейти в корзину
                        </a>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- Игры из той же категории -->
    @if ($relatedGames->count() > 0)
    <div x-data="carousel()" class="mt-16">
        <h2 class="text-2xl font-bold text-yellow-500 dark:text-yellow-400 mb-6">Из этой же категории</h2>

        <div class="relative">
            <!-- Кнопки навигации -->
            <button @click="scrollLeft"
                    class="absolute left-0 top-1/2 -translate-y-1/2 bg-yellow-400 hover:bg-yellow-500 dark:bg-yellow-500 dark:hover:bg-yellow-600 text-gray-900 dark:text-white rounded-full p-2 shadow-lg z-10"
                    aria-label="Назад">
                &#8592;
            </button>
            <button @click="scrollRight"
                    class="absolute right-0 top-1/2 -translate-y-1/2 bg-yellow-400 hover:bg-yellow-500 dark:bg-yellow-500 dark:hover:bg-yellow-600 text-gray-900 dark:text-white rounded-full p-2 shadow-lg z-10"
                    aria-label="Вперед">
                &#8594;
            </button>

            <!-- Карусель -->
            <div x-ref="carousel" class="flex overflow-x-auto scrollbar-hide space-x-6 scroll-smooth px-8 bg-gray-100 dark:bg-gray-800 rounded-lg p-4">
                @foreach ($relatedGames as $related)
                    <a href="{{ route('games.show', $related->id) }}"
                        class="min-w-[200px] flex-shrink-0 bg-white dark:bg-gray-700 rounded-lg p-4 shadow-md carousel-item text-gray-900 dark:text-white">

                        <img src="{{ asset('storage/images/' . $related->image) }}"
                             alt="{{ $related->title }}"
                             class="w-full h-40 object-cover rounded mb-4">
                        <h3 class="text-lg font-bold text-yellow-600 dark:text-yellow-400">{{ $related->title }}</h3>
                        <p class="text-sm text-gray-700 dark:text-gray-400 mt-1">${{ number_format($related->price, 2) }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif

</div>

<script>
function gamePage(gameId) {
    return {
        added: false,
        addToCart() {
            fetch("{{ route('cart.add') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ game_id: gameId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.added = true;
                } else {
                    alert("Ошибка при добавлении в корзину.");
                }
            })
            .catch(() => alert("Ошибка сервера."));
        }
    }
}
</script>

<script>
// Карусель Alpine.js
function carousel() {
    return {
        scrollAmount: 220,
        scrollLeft() {
            this.$refs.carousel.scrollBy({ left: -this.scrollAmount, behavior: 'smooth' });
        },
        scrollRight() {
            this.$refs.carousel.scrollBy({ left: this.scrollAmount, behavior: 'smooth' });
        }
    }
}
</script>

@endsection

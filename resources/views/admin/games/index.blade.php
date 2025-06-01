@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-tr from-gray-100 via-gray-200 to-gray-300 dark:from-purple-900 dark:via-indigo-900 dark:to-black flex items-center justify-center px-4 py-12">
    <div class="container max-w-7xl">
        <h1 class="text-4xl font-extrabold mb-6 text-center text-gray-900 dark:text-white drop-shadow-lg">
            Управление играми
        </h1>

        @if(session('success'))
            <div class="bg-green-400 dark:bg-green-600 text-gray-900 dark:text-white p-5 rounded-lg mb-6 max-w-2xl mx-auto text-center shadow-2xl backdrop-blur-lg bg-opacity-90">
                {{ session('success') }}
            </div>
        @endif

        <!-- Кнопка добавления новой игры -->
        <div class="flex justify-center mb-8">
            <a href="{{ route('admin.games.create') }}" 
               class="bg-green-400 dark:bg-green-600 hover:bg-green-500 dark:hover:bg-green-700 text-gray-900 dark:text-white px-8 py-3 rounded-2xl shadow-2xl backdrop-blur-lg bg-opacity-90 inline-flex items-center gap-3 select-none transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Добавить новую игру
            </a>
        </div>

        <!-- Фильтр и сортировка -->
        <form method="GET" action="{{ route('admin.games.index') }}" class="mb-8 flex flex-wrap justify-center gap-6">
            <select name="category" 
                    class="bg-gray-200 dark:bg-gray-800 text-yellow-600 dark:text-yellow-400 py-2 px-4 rounded-lg shadow-inner focus:outline-none focus:ring-4 focus:ring-yellow-700 dark:focus:ring-yellow-500 transition duration-300">
                <option value="" class="text-gray-900 dark:text-gray-100">Все жанры</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <select name="sort" 
                    class="bg-gray-200 dark:bg-gray-800 text-yellow-600 dark:text-yellow-400 py-2 px-4 rounded-lg shadow-inner focus:outline-none focus:ring-4 focus:ring-yellow-700 dark:focus:ring-yellow-500 transition duration-300">
                <option value="" class="text-gray-900 dark:text-gray-100">Сортировать по дате</option>
                <option value="date_asc" {{ request('sort') == 'date_asc' ? 'selected' : '' }}>Сначала старые</option>
                <option value="date_desc" {{ request('sort') == 'date_desc' ? 'selected' : '' }}>Сначала новые</option>
            </select>

            <button type="submit" 
                    class="bg-yellow-400 dark:bg-yellow-600 hover:bg-yellow-500 dark:hover:bg-yellow-700 text-gray-900 dark:text-white font-bold px-6 py-2 rounded-lg shadow-lg transition duration-300">
                Применить
            </button>
        </form>

        @if($games->isEmpty())
            <p class="text-gray-600 dark:text-gray-300 text-center text-xl italic">Игр пока нет.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @foreach($games as $game)
                    <div class="flex flex-col bg-white dark:bg-gray-900 bg-opacity-90 dark:bg-opacity-90 backdrop-blur-lg rounded-2xl shadow-2xl p-4 hover:bg-green-300 dark:hover:bg-green-900 hover:bg-opacity-70 dark:hover:bg-opacity-70 transition">
                        <img 
                            src="{{ asset('storage/images/' . $game->image) }}" 
                            alt="{{ $game->title }}" 
                            class="w-full h-40 object-cover rounded-lg mb-4 shadow-lg"
                        >
                        <div class="flex-grow flex flex-col">
                            <h2 class="text-2xl font-extrabold text-yellow-600 dark:text-yellow-400 mb-2">{{ $game->title }}</h2>
                            <p class="text-green-600 dark:text-green-400 mb-1">{{ $game->category->name ?? 'Без категории' }}</p>
                            <p class="text-green-600 dark:text-green-400 font-semibold text-xl mb-4">${{ number_format($game->price, 2) }}</p>

                            <div class="mt-auto flex justify-between gap-2">
                                <a href="{{ route('admin.games.edit', $game) }}" 
                                   class="bg-yellow-400 dark:bg-yellow-600 hover:bg-yellow-500 dark:hover:bg-yellow-700 text-gray-900 dark:text-white px-4 py-2 rounded-xl shadow-lg inline-flex items-center gap-2 transition duration-200 flex-1 justify-center">
                                    Редактировать
                                </a>
                                <form action="{{ route('admin.games.destroy', $game) }}" method="POST" 
                                      onsubmit="return confirm('Удалить эту игру?');" class="inline flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-red-400 dark:bg-red-600 hover:bg-red-500 dark:hover:bg-red-700 text-gray-900 dark:text-white px-4 py-2 rounded-xl shadow-lg inline-flex items-center gap-2 transition duration-200 w-full justify-center">
                                        Удалить
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $games->withQueryString()->links('vendor.pagination.custom') }}
            </div>
        @endif
    </div>
</div>

@endsection

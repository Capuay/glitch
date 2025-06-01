@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-tr from-gray-100 via-gray-200 to-gray-100 dark:from-purple-900 dark:via-indigo-900 dark:to-black flex items-center justify-center px-4 py-12">
    <div class="container max-w-5xl">
        <h1 class="text-4xl font-extrabold mb-10 text-center text-gray-900 dark:text-white drop-shadow-lg">
            Редактировать игру
        </h1>

        <form action="{{ route('admin.games.update', $game) }}" method="POST" enctype="multipart/form-data" 
              class="bg-white bg-opacity-90 backdrop-blur-lg p-10 rounded-2xl shadow-2xl grid grid-cols-1 md:grid-cols-3 gap-8 dark:bg-gray-900 dark:bg-opacity-90">
            @csrf
            @method('PUT')

            <div class="md:col-span-2 space-y-6">
                <div>
                    <label for="title" class="block mb-2 font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-600 dark:text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2" />
                        </svg>
                        Название
                    </label>
                    <input 
                        type="text" 
                        name="title" 
                        id="title" 
                        value="{{ old('title', $game->title) }}" 
                        required
                        class="w-full px-4 py-3 rounded-lg bg-white text-gray-900 border border-gray-300 
                               focus:border-yellow-600 focus:ring-2 focus:ring-yellow-600 focus:outline-none transition
                               dark:bg-gray-800 dark:text-white dark:border-gray-700 dark:focus:border-yellow-400 dark:focus:ring-yellow-400"
                    >
                    @error('title')
                        <p class="text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block mb-2 font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-600 dark:text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h8m-8 4h8m-8-8h8m-8-4h8" />
                        </svg>
                        Описание
                    </label>
                    <textarea 
                        name="description" 
                        id="description" 
                        rows="5"
                        class="w-full px-4 py-3 rounded-lg bg-white text-gray-900 border border-gray-300 
                               focus:border-yellow-600 focus:ring-2 focus:ring-yellow-600 focus:outline-none transition
                               dark:bg-gray-800 dark:text-white dark:border-gray-700 dark:focus:border-yellow-400 dark:focus:ring-yellow-400"
                    >{{ old('description', $game->description) }}</textarea>
                    @error('description')
                        <p class="text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="price" class="block mb-2 font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-600 dark:text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2-1.343-2-3-2z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 12v4m0 0v4m0-4h4m-4 0H8" />
                        </svg>
                        Цена
                    </label>
                    <input 
                        type="number" 
                        name="price" 
                        id="price" 
                        step="0.01" 
                        value="{{ old('price', $game->price) }}" 
                        required
                        class="w-full px-4 py-3 rounded-lg bg-white text-gray-900 border border-gray-300 
                               focus:border-yellow-600 focus:ring-2 focus:ring-yellow-600 focus:outline-none transition
                               dark:bg-gray-800 dark:text-white dark:border-gray-700 dark:focus:border-yellow-400 dark:focus:ring-yellow-400"
                    >
                    @error('price')
                        <p class="text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="category_id" class="block mb-2 font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-600 dark:text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7" />
                        </svg>
                        Категория
                    </label>
                    <select 
                        name="category_id" 
                        id="category_id" 
                        required
                        class="w-full px-4 py-3 rounded-lg bg-white text-gray-900 border border-gray-300 
                               focus:border-yellow-600 focus:ring-2 focus:ring-yellow-600 focus:outline-none transition
                               dark:bg-gray-800 dark:text-white dark:border-gray-700 dark:focus:border-yellow-400 dark:focus:ring-yellow-400"
                    >
                        <option value="">Выберите категорию</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $game->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex flex-col items-center md:items-start">
                <label class="block mb-3 font-semibold text-gray-900 dark:text-white">Текущее изображение</label>
                @if($game->image)
                    <img src="{{ asset('storage/' . $game->image) }}" alt="{{ $game->title }}" class="w-48 mb-6 rounded-lg shadow-lg">
                @else
                    <p class="text-gray-600 dark:text-gray-400 mb-6">Изображение не установлено</p>
                @endif

                <label for="image" class="block mb-3 font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600 dark:text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 15a4 4 0 008 0M7 15a4 4 0 008 0M3 9a4 4 0 008 0M7 9a4 4 0 008 0" />
                    </svg>
                    Заменить изображение (jpg, png)
                </label>
                <input 
                    type="file" 
                    name="image" 
                    id="image" 
                    accept="image/*" 
                    class="w-full text-gray-900 bg-white rounded-lg border border-gray-300
                           focus:border-yellow-600 focus:ring-2 focus:ring-yellow-600 focus:outline-none transition mb-6
                           dark:text-white dark:bg-gray-800 dark:border-gray-700 dark:focus:border-yellow-400 dark:focus:ring-yellow-400"
                >
                @error('image')
                    <p class="text-red-600 mt-1">{{ $message }}</p>
                @enderror

                <button 
                    type="submit" 
                    class="mt-auto w-full bg-yellow-400 hover:bg-yellow-500 text-gray-900 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:text-white py-3 rounded-lg shadow-lg
                           transition duration-300"
                >
                    Сохранить изменения
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

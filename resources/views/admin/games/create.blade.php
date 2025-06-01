@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-tr from-white via-gray-200 to-gray-100 dark:from-purple-900 dark:via-indigo-900 dark:to-black flex items-center justify-center px-4 py-12">
    <div class="container max-w-5xl">
        <h1 class="text-4xl font-extrabold mb-10 text-center text-gray-900 dark:text-white drop-shadow-lg">
            Добавить новую игру
        </h1>

        <form action="{{ route('admin.games.store') }}" method="POST" enctype="multipart/form-data" 
              class="bg-gray-100 dark:bg-gray-900 bg-opacity-90 dark:bg-opacity-90 backdrop-blur-lg p-10 rounded-2xl shadow-2xl grid grid-cols-1 md:grid-cols-3 gap-8">
            @csrf

            <div class="md:col-span-2 space-y-6">
                <div>
                    <label for="title" class="block mb-2 font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2" />
                        </svg>
                        Название
                    </label>
                    <input 
                        type="text" 
                        name="title" 
                        id="title" 
                        value="{{ old('title') }}" 
                        required
                        class="w-full px-4 py-3 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white border border-gray-300 dark:border-gray-700
                               focus:border-green-500 focus:ring-2 focus:ring-green-400 focus:outline-none transition"
                    >
                    @error('title')
                        <p class="text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block mb-2 font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h8m-8 4h8m-8-8h8m-8-4h8" />
                        </svg>
                        Описание
                    </label>
                    <textarea 
                        name="description" 
                        id="description" 
                        rows="5"
                        class="w-full px-4 py-3 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white border border-gray-300 dark:border-gray-700
                               focus:border-green-500 focus:ring-2 focus:ring-green-400 focus:outline-none transition"
                    >{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="price" class="block mb-2 font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
                        value="{{ old('price') }}" 
                        required
                        class="w-full px-4 py-3 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white border border-gray-300 dark:border-gray-700
                               focus:border-green-500 focus:ring-2 focus:ring-green-400 focus:outline-none transition"
                    >
                    @error('price')
                        <p class="text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="category_id" class="block mb-2 font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7" />
                        </svg>
                        Категория
                    </label>
                    <select 
                        name="category_id" 
                        id="category_id" 
                        required
                        class="w-full px-4 py-3 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white border border-gray-300 dark:border-gray-700
                               focus:border-green-500 focus:ring-2 focus:ring-green-400 focus:outline-none transition"
                    >
                        <option value="">Выберите категорию</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex flex-col items-center md:items-start">
                <label for="image" class="block mb-3 font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 15a4 4 0 008 0M7 15a4 4 0 008 0M3 9a4 4 0 008 0M7 9a4 4 0 008 0" />
                    </svg>
                    Изображение (jpg, png)
                </label>
                <input 
                    type="file" 
                    name="image" 
                    id="image" 
                    accept="image/*" 
                    class="w-full text-gray-900 dark:text-white bg-white dark:bg-gray-800 rounded-lg border border-gray-300 dark:border-gray-700
                           focus:border-green-500 focus:ring-2 focus:ring-green-400 focus:outline-none transition mb-6"
                >

                <img id="imagePreview" class="max-w-full rounded-lg shadow-lg hidden transition-transform duration-500 ease-in-out" alt="Preview">

                @error('image')
                    <p class="text-red-500 mt-1">{{ $message }}</p>
                @enderror

                <button 
                    type="submit" 
                    class="mt-auto w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg shadow-lg
                           transition duration-300"
                >
                    Добавить игру
                </button>

                <p class="mt-6 text-green-400 text-sm italic text-center select-none">
                    🎮 Добавляйте лучшие игры и радуйте пользователей!
                </p>
            </div>
        </form>
    </div>
</div>

<script>
    const input = document.getElementById('image');
    const preview = document.getElementById('imagePreview');

    input.addEventListener('change', () => {
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                preview.style.transform = 'scale(1)';
            };
            reader.readAsDataURL(file);
        } else {
            preview.src = '';
            preview.classList.add('hidden');
            preview.style.transform = 'scale(0.8)';
        }
    });
</script>
@endsection

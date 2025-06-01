@props(['game'])

<article
    class="bg-gray-900 text-white rounded-xl shadow-2xl p-6 flex flex-col justify-between border border-gray-700
           hover:border-yellow-500 hover:shadow-yellow-600/40 transition-all duration-400 ease-in-out transform hover:-translate-y-1 hover:scale-[1.03]">
    <img src="{{ asset('storage/images/' . $game->image) }}" alt="{{ $game->title }}"
         class="rounded-lg w-full h-56 object-cover mb-6 shadow-lg">
    <h2 class="text-xl font-extrabold mb-3 text-center tracking-wide text-yellow-400 drop-shadow-md">{{ $game->title }}</h2>
    <div class="text-gray-400 text-sm mb-2" style="white-space: pre-line;">
        {{ \Illuminate\Support\Str::limit($game->description, 120) }}
    </div>
    <p class="text-2xl font-extrabold text-center mb-4 text-yellow-400 drop-shadow-lg">${{ number_format($game->price, 2) }}</p>
    <a href="{{ route('games.show', $game->id) }}"
       class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md text-center transition-transform duration-200 ease-in-out hover:scale-105 block mb-4">
        Подробнее
    </a>
</article>

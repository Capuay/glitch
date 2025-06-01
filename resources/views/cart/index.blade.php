@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8 px-4">
    <h1 class="text-4xl font-extrabold text-center mb-10 text-yellow-500 dark:text-yellow-400 tracking-wide drop-shadow-lg">
        Корзина
    </h1>

    @if (session('success'))
        <div class="bg-green-600 text-white p-4 mb-6 rounded shadow-md text-center font-semibold">
            {{ session('success') }}
        </div>
    @endif

    @if (empty($cart))
        <p class="text-gray-600 dark:text-gray-400 text-center text-xl mt-12">Ваша корзина пуста.</p>
    @else
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Список товаров -->
            <div class="flex-1 space-y-6">
                @foreach ($cart as $id => $item)
                    <div class="bg-white dark:bg-gray-900 text-gray-900 dark:text-white rounded-xl shadow-lg p-4 flex flex-col sm:flex-row items-center sm:items-start gap-4 border border-gray-300 dark:border-gray-700 hover:border-yellow-500 transition-all duration-300">
                        @if (isset($item['image']))
                            <img src="{{ asset('storage/images/' . $item['image']) }}"
                                 alt="{{ $item['title'] }}"
                                 class="w-24 h-24 object-cover rounded-lg shadow-md">
                        @else
                            <div class="w-24 h-24 bg-gray-200 dark:bg-gray-700 flex items-center justify-center rounded-lg text-gray-500 dark:text-gray-400 text-sm">
                                Нет фото
                            </div>
                        @endif

                        <div class="flex-1 w-full">
                            <h2 class="text-lg font-bold text-yellow-600 dark:text-yellow-400">{{ $item['title'] }}</h2>
                            <p class="text-sm text-gray-700 dark:text-gray-400">Цена: ${{ number_format($item['price'], 2) }}</p>

                            <form method="POST" action="{{ route('cart.update') }}" class="flex items-center gap-3 mt-3">
                                @csrf
                                <input type="hidden" name="id" value="{{ $id }}">
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"
                                    class="w-16 text-center bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded px-2 py-1 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                                <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded transition-all">
                                    Обновить
                                </button>
                            </form>
                        </div>

                        <div class="text-right mt-4 sm:mt-0 sm:text-left">
                            <p class="text-xl font-extrabold text-yellow-600 dark:text-yellow-400">${{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                            <form method="POST" action="{{ route('cart.remove') }}" class="mt-2">
                                @csrf
                                <input type="hidden" name="id" value="{{ $id }}">
                                <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded transition-all">
                                    Удалить
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Блок итого -->
            <div class="lg:w-1/3 bg-white dark:bg-gray-900 text-gray-900 dark:text-white rounded-xl shadow-xl p-6 border border-gray-300 dark:border-gray-700 h-fit">
                <h2 class="text-2xl font-bold mb-4 text-yellow-600 dark:text-yellow-400">Итого</h2>
                <p class="text-xl mb-6">Сумма: <span class="font-bold text-yellow-500 dark:text-yellow-300">${{ number_format($total, 2) }}</span></p>

                <form method="POST" action="{{ route('orders.store') }}">
                    @csrf
                    <button type="submit"
                        onclick="return confirm('Вы действительно хотите оформить заказ?');"
                        class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-semibold text-lg shadow-lg transition-all duration-300 ease-in-out">
                        Оформить заказ
                    </button>
                </form>
            </div>
        </div>
    @endif
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container mx-auto my-8 px-4">

    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Мои заказы</h2>

    @php
        $statusNames = [
            'created' => 'Создан',
            'processing' => 'В обработке',
            'completed' => 'Завершён',
            'declined' => 'Отклонён',
        ];
    @endphp

    <form method="GET" action="{{ route('orders.index') }}" class="mb-8 flex flex-wrap gap-4 items-center bg-gray-100 dark:bg-gray-900 p-4 rounded-lg shadow-md">
        <div class="flex flex-col">
            <label for="status" class="text-gray-900 dark:text-white font-semibold mb-1">Фильтр по статусу:</label>
            <select name="status" id="status" class="rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="" {{ request('status') == '' ? 'selected' : '' }}>Все</option>
                <option value="created" {{ request('status') == 'created' ? 'selected' : '' }}>Создан</option>
                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>В обработке</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Завершён</option>
                <option value="declined" {{ request('status') == 'declined' ? 'selected' : '' }}>Отклонён</option>
            </select>
        </div>

        <div class="flex flex-col">
            <label for="date" class="text-gray-900 dark:text-white font-semibold mb-1">Фильтр по дате:</label>
            <input 
                type="date" 
                name="date" 
                id="date" 
                value="{{ request('date') }}" 
                class="rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
        </div>

        <div class="flex items-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded transition duration-300">
                Применить
            </button>
        </div>
    </form>

    @if ($orders->isEmpty())
        <div class="bg-blue-100 dark:bg-blue-900 border border-blue-300 dark:border-blue-700 text-blue-900 dark:text-blue-100 px-6 py-4 rounded-lg shadow-md">
            <p>У вас пока нет оформленных заказов.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach ($orders as $order)
                <div class="bg-gray-50 dark:bg-gray-800 shadow-lg rounded-lg p-6 transition-transform transform hover:scale-102 border border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-center mb-5">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Заказ #{{ $order->id }}</h3>
                        <span class="text-sm px-4 py-2 rounded-full
                            {{ $order->status === 'created' ? 'bg-yellow-300 text-yellow-900 dark:bg-yellow-600 dark:text-yellow-100' : '' }}
                            {{ $order->status === 'processing' ? 'bg-blue-300 text-blue-900 dark:bg-blue-600 dark:text-blue-100' : '' }}
                            {{ $order->status === 'completed' ? 'bg-green-300 text-green-900 dark:bg-green-600 dark:text-green-100' : '' }}
                            {{ $order->status === 'declined' ? 'bg-red-300 text-red-900 dark:bg-red-600 dark:text-red-100' : '' }}
                        ">
                            {{ $statusNames[$order->status] ?? ucfirst($order->status) }}
                        </span>
                    </div>
                    <div class="text-gray-700 dark:text-gray-300 mb-6">
                        <p><strong>Общая стоимость:</strong> {{ number_format($order->total, 2, '.', ' ') }} $</p>
                        <p><strong>Дата создания:</strong> {{ $order->created_at->format('d.m.Y H:i') }}</p>
                    </div>
                    <h4 class="text-md font-semibold text-gray-900 dark:text-white mb-3">Состав заказа:</h4>
                    <ul class="space-y-4">
                        @foreach ($order->items as $item)
                            <li class="flex justify-between items-center bg-gray-200 dark:bg-gray-700 p-4 rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                                <div>
                                    <p class="text-gray-900 dark:text-white font-semibold">{{ $item['title'] }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Цена: {{ number_format($item['price'], 2, '.', ' ') }} $</p>
                                </div>
                                <span class="bg-blue-600 text-white px-4 py-2 rounded-full text-sm">
                                    {{ $item['quantity'] }} шт.
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>

        <!-- Пагинация -->
        <div class="mt-8">
            {{ $orders->links('vendor.pagination.custom') }}
        </div>
    @endif
</div>
@endsection

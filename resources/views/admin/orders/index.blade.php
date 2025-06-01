@extends('layouts.app')

@section('content')
<div class="container mx-auto my-10 px-4 sm:px-6 lg:px-8 max-w-7xl">
    <h2 class="text-4xl font-bold text-center text-gray-900 dark:text-gray-100 mb-10 tracking-tight">
        Все заказы
    </h2>

    <!-- Фильтр -->
    <form method="GET" action="{{ route('admin.orders.index') }}"
          class="mb-10 flex flex-col sm:flex-row sm:items-center sm:gap-6 gap-4 justify-center text-sm sm:text-base">
        <div class="flex items-center gap-3">
            <label for="status" class="text-gray-700 dark:text-gray-300 font-medium">Статус:</label>
            <select name="status" id="status"
                class="rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200
                       px-4 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 transition w-40">
                <option value="">Все</option>
                <option value="created" {{ request('status') == 'created' ? 'selected' : '' }}>Создан</option>
                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>В обработке</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Завершён</option>
                <option value="declined" {{ request('status') == 'declined' ? 'selected' : '' }}>Отклонён</option>
            </select>
        </div>

        <div class="flex items-center gap-3">
            <label for="date" class="text-gray-700 dark:text-gray-300 font-medium">Дата:</label>
            <input type="date" name="date" id="date" value="{{ request('date') }}"
                   class="rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200
                          px-4 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 transition w-40">
        </div>

        <button type="submit"
                class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-bold px-6 py-2 rounded-lg shadow-md
                       transition duration-300 hover:scale-105">
            Применить
        </button>
    </form>

    <!-- Нет заказов -->
    @if ($orders->isEmpty())
        <div class="bg-yellow-50 dark:bg-yellow-900 border border-yellow-400 dark:border-yellow-700
                    text-yellow-800 dark:text-yellow-300 px-6 py-5 rounded-lg text-center shadow-md">
            Нет заказов.
        </div>
    @else
        <!-- Список заказов -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($orders as $order)
                <div
                    class="bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-xl shadow-lg
                           p-6 flex flex-col justify-between transition-all hover:shadow-yellow-400/40 hover:border-yellow-500
                           hover:scale-[1.015] transform duration-300 ease-in-out"
                >
                    <div class="mb-4">
                        <div class="flex justify-between items-start">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                Заказ #{{ $order->id }}
                            </h3>
                            <span class="text-xs px-3 py-1 rounded-full font-semibold
                                {{ $order->status === 'created' ? 'bg-yellow-200 text-yellow-800' : '' }}
                                {{ $order->status === 'processing' ? 'bg-blue-200 text-blue-800' : '' }}
                                {{ $order->status === 'completed' ? 'bg-green-200 text-green-800' : '' }}
                                {{ $order->status === 'declined' ? 'bg-red-200 text-red-800' : '' }}">
                                {{ $order->status_translated }}
                            </span>
                        </div>

                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 italic">
                            от {{ $order->user->name ?? 'Пользователь удалён' }}
                        </p>
                    </div>

                    <div class="text-sm text-gray-700 dark:text-gray-300 space-y-2 mb-5">
                        <p><strong>Общая стоимость:</strong> <span class="font-semibold">${{ number_format($order->total, 2) }}</span></p>
                        <p><strong>Создан:</strong> {{ $order->created_at->format('d.m.Y H:i') }}</p>
                    </div>

                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.orders.edit', $order->id) }}"
                           class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-bold px-5 py-2 rounded-lg shadow-md
                                  transition hover:scale-105 duration-300 ease-in-out">
                            Редактировать
                        </a>
                    @endif
                </div>
            @endforeach
                          <div class="mt-8">
            {{ $orders->links('vendor.pagination.custom') }}
                      </div>
        </div>
    @endif
</div>
@endsection

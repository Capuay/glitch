@extends('layouts.app')

@section('content')
<div class="container mx-auto my-8">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Редактировать заказ #{{ $order->id }}</h2>

    @if(session('success'))
        <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded relative mb-6" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Колонка с товарами (2/3) -->
        <div class="md:col-span-2 bg-gray-100 dark:bg-gray-800 p-6 rounded-lg shadow-lg">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Товары в заказе:</h3>

            @foreach ($items as $itemId => $item)
                <div id="item-{{ $itemId }}" class="bg-gray-200 dark:bg-gray-700 p-4 mb-4 rounded-lg flex items-center gap-4">
                    @if (!empty($item['image']))
                        <img src="{{ asset('storage/images/' . $item['image']) }}" alt="{{ $item['title'] }}" class="w-20 h-20 object-cover rounded-md">
                    @else
                        <div class="w-20 h-20 bg-gray-300 dark:bg-gray-600 flex items-center justify-center rounded-md text-gray-600 dark:text-gray-400 text-sm">Нет фото</div>
                    @endif

                    <div class="flex-1">
                        <p class="text-gray-900 dark:text-gray-200 font-semibold">{{ $item['title'] }}</p>
                        <p class="text-gray-700 dark:text-gray-400">Цена: {{ number_format($item['price'], 2, '.', ' ') }} $</p>

                        <form action="{{ route('admin.orders.removeItem', ['orderId' => $order->id, 'itemId' => $itemId]) }}" method="POST" class="delete-item-form mt-3">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded transition">
                                Удалить товар
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach

            <div class="text-gray-900 dark:text-white text-lg font-semibold mt-4">
                Общая стоимость: <span id="total-price">{{ number_format($order->total, 2, '.', ' ') }}</span> $
            </div>
        </div>

        <!-- Колонка со статусом и кнопками -->
        <div class="bg-gray-100 dark:bg-gray-800 p-6 rounded-lg shadow-lg">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Статус заказа:</h3>
            <form id="status-form" action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                @csrf
                @method('PUT')
                <select name="status" id="status" class="bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white p-2 rounded w-full">
                    <option value="created" @if($order->status == 'created') selected @endif>Создан</option>
                    <option value="processing" @if($order->status == 'processing') selected @endif>В обработке</option>
                    <option value="completed" @if($order->status == 'completed') selected @endif>Завершён</option>
                    <option value="declined" @if($order->status == 'declined') selected @endif>Отклонён</option>
                </select>

                <button type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded mt-4 w-full transition">
                    Обновить статус
                </button>
            </form>

            @if(auth()->user()->is_admin)
                <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST"
                      onsubmit="return confirm('Вы уверены, что хотите удалить этот заказ?');" class="mt-6">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white rounded-lg px-6 py-2 w-full transition ease-in-out duration-300 focus:ring-4 focus:ring-red-400">
                        Удалить заказ
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- Кнопка назад -->
    <div class="flex justify-center mt-8">
        <a href="{{ route('admin.orders.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded transition">Назад к заказам</a>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const deleteForms = document.querySelectorAll('.delete-item-form');

        deleteForms.forEach(form => {
            form.addEventListener('submit', async (e) => {
                e.preventDefault();

                const formElement = e.target;
                const itemContainer = formElement.closest('div[id^="item-"]');
                const totalPriceElement = document.getElementById('total-price');
                const formData = new FormData(formElement);

                try {
                    const response = await fetch(formElement.action, {
                        method: 'DELETE',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                    });

                    if (response.ok) {
                        const result = await response.json();

                        itemContainer.remove();

                        if (result.newTotal !== undefined) {
                            totalPriceElement.textContent = `${result.newTotal.toFixed(2).replace('.', ' ')} $`;
                        }
                    } else {
                        console.error('Ошибка при удалении товара');
                    }
                } catch (error) {
                    console.error('Ошибка:', error);
                }
            });
        });
    });
</script>
@endsection

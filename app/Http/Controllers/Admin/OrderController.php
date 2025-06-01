<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Метод для отображения всех заказов
public function index(Request $request)
{
    $query = Order::with('user');

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('date')) {
        $query->whereDate('created_at', $request->date);
    }

    $query->orderBy('created_at', 'desc');

    // Пагинация вместо get()
    $orders = $query->paginate(9)->withQueryString();

    return view('admin.orders.index', compact('orders'));
}






    // Метод для отображения формы редактирования заказа
    public function edit($id)
    {
        $order = Order::findOrFail($id);
        $items = is_string($order->items) ? json_decode($order->items, true) : $order->items;

        return view('admin.orders.edit', compact('order', 'items'));
    }

    // Метод для обновления статуса заказа
     
    public function update(Request $request, $id)
    {
        // Находим заказ по ID
        $order = Order::findOrFail($id);
    
        // Валидация для поля статуса
        $validated = $request->validate([
            'status' => 'required|in:created,processing,completed,declined', // Убедитесь, что статус валидный
        ]);
    
        // Обновляем статус заказа
        $order->status = $validated['status'];
        $order->save(); // Сохраняем изменения
    
        // Перенаправляем на список заказов с успешным сообщением
        return redirect()->route('admin.orders.index')->with('success', 'Статус заказа обновлен!');
    }
    
    
    


    // Метод для удаления товара из заказа
    public function removeItem(Request $request, $orderId, $itemId)
    {
        // Находим заказ по ID
        $order = Order::findOrFail($orderId);
    
        // Декодируем JSON в массив
        $items = is_string($order->items) ? json_decode($order->items, true) : $order->items;
    
        // Удаляем товар по его ID
        if (isset($items[$itemId])) {
            unset($items[$itemId]);
        }
    
        // Обновляем поле 'items' в заказе
        $order->items = json_encode($items);
    
        // Пересчитываем общую стоимость
        $order->total = collect($items)->sum(fn($item) => $item['price']);
        $order->save();
    
        // Возвращаем новую сумму в ответе
        return response()->json(['success' => true, 'newTotal' => $order->total]);
    }
         
    public function destroy($id)
   {
     $order = Order::findOrFail($id);
     $order->delete();

      return redirect()->route('admin.orders.index')->with('success', 'Заказ успешно удалён.');
    }

   

    
}


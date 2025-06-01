<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
  {
    $cart = session()->get('cart', []);

    if (empty($cart)) {
        return redirect()->back()->with('error', 'Корзина пуста.');
    }

    // Подсчёт общей стоимости заказа
    $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

    // Создание нового заказа
    $order = Order::create([
        'user_id' => auth()->id(),
        'items' => json_encode($cart), // Сериализация корзины в JSON
        'total' => $total, // Сохранение итоговой стоимости
        'status' => 'created',
    ]);

    // Очистка корзины
    session()->forget('cart');

    return redirect()->route('orders.index')->with('success', 'Заказ успешно оформлен.');
   }

public function index(Request $request)
{
    $query = Order::where('user_id', auth()->id());

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('date')) {
        $query->whereDate('created_at', $request->date);
    }

    // Сортировка: новые заказы вперед
    $query->orderBy('created_at', 'desc');

    // Пагинация по 12 заказов на страницу с сохранением параметров фильтра
    $orders = $query->paginate(6)->withQueryString();

    foreach ($orders as $order) {
        $order->items = $order->items ? json_decode($order->items, true) : [];
    }

    return view('orders.index', compact('orders'));
}



   
}

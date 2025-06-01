<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'product_name', 'quantity', 'price'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function index()
   {
    // Загружаем все заказы с их товарами
    $orders = Order::with('items')->get(); // Включаем товары (связь)

    return view('admin.orders.index', compact('orders')); // Передаем в представление
   }

}

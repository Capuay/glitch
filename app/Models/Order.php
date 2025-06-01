<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'items', 'total', 'status'];

    public function getItemsAttribute($value)
    {
        return json_decode($value, true); // Возвращаем массив из JSON
    }

    public function setItemsAttribute($value)
    {
        $this->attributes['items'] = json_encode($value); // Сохраняем массив как JSON
    }

    // Добавляем аксессор для перевода статуса
    public function getStatusTranslatedAttribute()
    {
        $translations = [
            'created' => 'Создан',
            'processing' => 'В обработке',
            'completed' => 'Завершён',
            'declined' => 'Отклонён',
            // Добавляй остальные статусы по мере необходимости
        ];

        return $translations[$this->status] ?? $this->status;
    }

    public function user()
{
    return $this->belongsTo(User::class);
}
}


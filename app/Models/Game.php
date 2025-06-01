<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    // Добавь 'category_id' в fillable
    protected $fillable = ['title', 'description', 'image', 'price', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

<?php

namespace App\Http\Controllers;
use App\Models\Game;
use Illuminate\Http\Request;
use App\Models\Category;

class MainController extends Controller
{
public function index(Request $request)
{
    $query = Game::query();

    // Фильтрация по категориям, цене и т.п.
    if ($request->filled('category')) {
        $query->where('category_id', $request->category);
    }
    if ($request->filled('min_price')) {
        $query->where('price', '>=', (float)$request->min_price);
    }
    if ($request->filled('max_price')) {
        $query->where('price', '<=', (float)$request->max_price);
    }

    // Сортировка: новые игры первыми
    $query->orderBy('created_at', 'desc');

    // Пагинация с сохранением параметров фильтрации
    $games = $query->paginate(12)->withQueryString();

    $categories = Category::all();

    return view('main.index', compact('games', 'categories'));
}





public function search(Request $request)
{
    $games = Game::where('title', 'like', '%' . $request->title . '%')->get();
    return response()->json($games);
}

}

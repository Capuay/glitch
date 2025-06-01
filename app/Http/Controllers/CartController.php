<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        return view('cart.index', compact('cart', 'total'));
    }

public function add(Request $request)
{
    $game = Game::find($request->game_id);

    if (!$game) {
        return response()->json(['success' => false, 'message' => 'Игра не найдена.']);
    }

    $cart = session()->get('cart', []);

    if (isset($cart[$game->id])) {
        $cart[$game->id]['quantity']++;
    } else {
        $cart[$game->id] = [
            'title' => $game->title,
            'price' => $game->price,
            'quantity' => 1,
            'image' => $game->image,
        ];
    }

    session()->put('cart', $cart);

    return response()->json(['success' => true, 'message' => 'Товар добавлен в корзину.']);
}


    public function update(Request $request)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$request->id])) {
            $cart[$request->id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Корзина обновлена.');
    }

    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$request->id])) {
            unset($cart[$request->id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Товар удалён из корзины.');
    }
}

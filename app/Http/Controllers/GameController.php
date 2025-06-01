<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

class GameController extends Controller
{
public function show(Game $game)
{
    $relatedGames = Game::where('category_id', $game->category_id)
                        ->where('id', '!=', $game->id)
                        ->take(4)
                        ->get();

    return view('games.show', compact('game', 'relatedGames'));
}



}

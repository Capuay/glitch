<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class GameController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        $query = Game::query();

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('sort')) {
            if ($request->sort === 'date_asc') {
                $query->orderBy('created_at', 'asc');
            } elseif ($request->sort === 'date_desc') {
                $query->orderBy('created_at', 'desc');
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $games = $query->paginate(12)->withQueryString();
        $categories = Category::all();

        return view('admin.games.index', compact('games', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.games.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $filename = Str::random(20) . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('public/images', $filename);
            $data['image'] = $filename;
        }

        Game::create($data);

        return redirect()->route('admin.games.index')->with('success', 'Игра успешно добавлена!');
    }

    public function edit(Game $game)
    {
        $categories = Category::all();
        return view('admin.games.edit', compact('game', 'categories'));
    }

    public function update(Request $request, Game $game)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $filename = Str::random(20) . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('public/images', $filename);
            $data['image'] = $filename;
        }

        $game->update($data);

        return redirect()->route('admin.games.index')->with('success', 'Игра успешно обновлена!');
    }

    public function destroy(Game $game)
    {
        // optionally delete image file
        // if ($game->image) {
        //     Storage::delete('public/images/' . $game->image);
        // }

        $game->delete();

        return redirect()->route('admin.games.index')->with('success', 'Игра успешно удалена!');
    }
}

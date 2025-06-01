<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController; 
use Illuminate\Support\Facades\Route;





Route::get('/', [MainController::class, 'index'])->name('main.index');
Route::get('/search-games', [MainController::class, 'search'])->name('games.search');
Route::get('/games/{game}', [GameController::class, 'show'])->name('games.show');


Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::post('/update', [CartController::class, 'update'])->name('update');
    Route::post('/remove', [CartController::class, 'remove'])->name('remove');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
  


});

Route::middleware('auth')->get('/home', function () {
    return view('home');
});

Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verify-email');

Route::middleware('auth')->group(function () {
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
});



// Группа маршрутов для админки
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}/edit', [AdminOrderController::class, 'edit'])->name('orders.edit');
    Route::put('/orders/{id}', [AdminOrderController::class, 'update'])->name('orders.update');
    Route::delete('/orders/{orderId}/items/{itemId}', [AdminOrderController::class, 'removeItem'])->name('orders.removeItem');
    Route::delete('admin/orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'destroy'])->name('orders.destroy');
    Route::resource('games', App\Http\Controllers\Admin\GameController::class);

});












require __DIR__.'/auth.php';
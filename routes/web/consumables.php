<?php

use App\Http\Controllers\Consumables;
use Illuminate\Support\Facades\Route;



Route::group(['prefix' => 'consumables', 'middleware' => ['auth']], function () {
    Route::get(
        '{consumablesID}/checkout',
        [Consumables\ConsumableCheckoutController::class, 'create']
    )->name('checkout/consumable');

    Route::post(
        '{consumablesID}/checkout',
        [Consumables\ConsumableCheckoutController::class, 'store']
    )->name('checkout/consumable');

    Route::get(
        '{consumablesID}/replenish',
        [Consumables\ConsumableReplenishController::class, 'create']
    )->name('replenish/consumable');

    Route::post(
        '{consumablesID}/replenish',
        [Consumables\ConsumableReplenishController::class, 'store']
    )->name('replenish/consumable');


});
    
Route::resource('consumables', Consumables\ConsumablesController::class, [
    'middleware' => ['auth'],
    'parameters' => ['consumable' => 'consumable_id'],
]);

<?php

use App\Http\Controllers\Consumables;
use Illuminate\Support\Facades\Route;



Route::group(['prefix' => 'consumables', 'middleware' => ['auth']], function () {
    Route::get(
        '{consumablesID}/checkout',
        [Consumables\ConsumableCheckoutController::class, 'create']
    )->name('consumables.checkout.show');

    Route::post(
        '{consumablesID}/checkout',
        [Consumables\ConsumableCheckoutController::class, 'store']
    )->name('consumables.checkout.store');

    Route::post(
        '{consumableId}/upload',
        [Consumables\ConsumablesFilesController::class, 'store']
    )->name('upload/consumable');

    Route::delete(
        '{consumableId}/deletefile/{fileId}',
        [Consumables\ConsumablesFilesController::class, 'destroy']
    )->name('delete/consumablefile');

    Route::get(
        '{consumableId}/showfile/{fileId}/{download?}',
        [Consumables\ConsumablesFilesController::class, 'show']
    )->name('show.consumablefile');

    Route::get('{consumable}/clone',
        [Consumables\ConsumablesController::class, 'clone']
    )->name('consumables.clone.create');
    
    Route::get(
        '{consumablesID}/replenish',
        [Consumables\ConsumableReplenishController::class, 'create']
    )->name('replenish/consumable');

    Route::post(
        '{consumablesID}/replenish',
        [Consumables\ConsumableReplenishController::class, 'store']
    )->name('replenish/consumable');

    Route::get(
        '{consumablesID}/showfile/{file}',
        [Consumables\ConsumableReplenishController::class, 'show']
    )->name('replenish/showdocument');
});
    
Route::resource('consumables', Consumables\ConsumablesController::class, [
    'middleware' => ['auth'],
    'parameters' => ['consumable' => 'consumable_id'],
]);

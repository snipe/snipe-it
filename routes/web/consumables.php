<?php

use App\Http\Controllers\Consumables;
use Illuminate\Support\Facades\Route;

    // Consumables
    Route::group(['prefix' => 'consumables', 'middleware' => ['auth']], function () {
        Route::get(
            '{consumableID}/checkout',
            ['as' => 'checkout/consumable', 'uses' => [Consumables\ConsumableCheckoutController::class, 'create']]
        );
        Route::post(
            '{consumableID}/checkout',
            ['as' => 'checkout/consumable', 'uses' => [Consumables\ConsumableCheckoutController::class, 'store']]
        );
    });

    Route::resource('consumables', Consumables\ConsumablesController::class, [
        'middleware' => ['auth'],
        'parameters' => ['consumable' => 'consumable_id'],
    ]);

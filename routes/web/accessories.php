<?php

use App\Http\Controllers\Accessories;
use Illuminate\Support\Facades\Route;

/*
* Accessories
 */
Route::group(['prefix' => 'accessories', 'middleware' => ['auth']], function () {
    Route::get(
        '{accessoryID}/checkout',
        ['as' => 'checkout/accessory', 'uses' => [Accessories\AccessoryCheckoutController::class, 'create']]
    );
    Route::post(
        '{accessoryID}/checkout',
        ['as' => 'checkout/accessory', 'uses' => [Accessories\AccessoryCheckoutController::class, 'store']]
    );

    Route::get(
        '{accessoryID}/checkin/{backto?}',
        ['as' => 'checkin/accessory', 'uses' => [Accessories\AccessoryCheckinController::class, 'create']]
    );
    Route::post(
        '{accessoryID}/checkin/{backto?}',
        ['as' => 'checkin/accessory', 'uses' => [Accessories\AccessoryCheckinController::class, 'store']]
    );
});

Route::resource('accessories', Accessories\AccessoriesController::class, [
    'middleware' => ['auth'],
    'parameters' => ['accessory' => 'accessory_id'],
]);

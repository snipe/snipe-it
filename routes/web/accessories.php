<?php

use App\Http\Controllers\Accessories;
use Illuminate\Support\Facades\Route;

/*
* Accessories
 */
Route::group(['prefix' => 'accessories', 'middleware' => ['auth']], function () {
    Route::get(
        '{accessoryID}/checkout',
        [Accessories\AccessoryCheckoutController::class, 'create']
    )->name('checkout/accessory');

    Route::post(
        '{accessoryID}/checkout',
        [Accessories\AccessoryCheckoutController::class, 'store']
    )->name('checkout/accessory');

    Route::get(
        '{accessoryID}/checkin/{backto?}',
        [Accessories\AccessoryCheckinController::class, 'create']
    )->name('checkin/accessory');

    Route::post(
        '{accessoryID}/checkin/{backto?}',
        [Accessories\AccessoryCheckinController::class, 'store']
    )->name('checkin/accessory');

});

Route::resource('accessories', Accessories\AccessoriesController::class, [
    'middleware' => ['auth'],
    'parameters' => ['accessory' => 'accessory_id'],
]);

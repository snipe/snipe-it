<?php

use App\Http\Controllers\Consumables;
use App\Models\Consumable;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

Route::group(['prefix' => 'consumables', 'middleware' => ['auth']], function () {
    Route::get(
        '{consumablesID}/checkout',
        [Consumables\ConsumableCheckoutController::class, 'create']
    )->where('consumablesID', '[0-9]+')
        ->name('consumables.checkout.show');

    Route::post(
        '{consumablesID}/checkout',
        [Consumables\ConsumableCheckoutController::class, 'store']
    )->where('consumablesID', '[0-9]+')
        ->name('consumables.checkout.store');

    Route::get('{consumable}/clone',
        [Consumables\ConsumablesController::class, 'clone']
    )->where('consumable', '[0-9]+')
        ->name('consumables.clone.create');

    Route::post('{consumable}/adjust-quantity',
        [Consumables\ConsumablesController::class, 'adjustQuantity']
    )->where('consumable', '[0-9]+')
        ->name('consumables.adjust-quantity');

    // Bulk-fulfill queue for this consumable. See sibling
    // accessories.fulfill-requests.* for the shared per-row shape
    // and controller semantics.
    Route::get('{consumable}/fulfill-requests',
        [Consumables\ConsumableCheckoutController::class, 'bulkFulfillCreate']
    )->where('consumable', '[0-9]+')
        ->name('consumables.fulfill-requests.create')
        ->breadcrumbs(fn (Trail $trail, Consumable $consumable) => $trail
            ->parent('requests.index')
            ->push($consumable->name, route('consumables.show', $consumable))
            ->push(trans('general.checkout'), route('consumables.fulfill-requests.create', $consumable))
        );

    Route::post('{consumable}/fulfill-requests',
        [Consumables\ConsumableCheckoutController::class, 'bulkFulfillStore']
    )->where('consumable', '[0-9]+')
        ->name('consumables.fulfill-requests.store');

});

Route::resource('consumables', Consumables\ConsumablesController::class, [
    'middleware' => ['auth'],
    'parameters' => ['consumable' => 'consumable_id'],
]);

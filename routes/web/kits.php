<?php

use App\Http\Controllers\Kits;
use Illuminate\Support\Facades\Route;

// Predefined Kit Management
Route::resource('kits', Kits\PredefinedKitsController::class, [
    'middleware' => ['auth'],
    'parameters' => ['kit' => 'kit_id'],
]);

Route::group(['prefix' => 'kits/{kit_id}', 'middleware' => ['auth']], function () {

    // Route::get('licenses',
    //     [
    //         'as' => 'kits.licenses.index',
    //         'uses' => [Kits\PredefinedKitsController::class, 'indexLicenses'],
    //     ]
    // );

    Route::post('licenses',
        [
            'as' => 'kits.licenses.store',
            'uses' => [Kits\PredefinedKitsController::class, 'storeLicense'],
        ]
    );

    Route::put('licenses/{license_id}',
        [
            'as' => 'kits.licenses.update',
            'uses' => [Kits\PredefinedKitsController::class, 'updateLicense'],
        ]
    );

    Route::get('licenses/{license_id}/edit',
        [
            'as' => 'kits.licenses.edit',
            'uses' => [Kits\PredefinedKitsController::class, 'editLicense'],

        ]
    );

    Route::delete('licenses/{license_id}',
        [
            'as' => 'kits.licenses.detach',
            'uses' => [Kits\PredefinedKitsController::class, 'detachLicense'],
        ]
    );

    // Models

    Route::put('models/{model_id}',
        [
            'as' => 'kits.models.update',
            'uses' => [Kits\PredefinedKitsController::class, 'updateModel'],
            'parameters' => [2 => 'kit_id', 1 => 'model_id'],
        ]
    );

    Route::get('models/{model_id}/edit',
        [
            'as' => 'kits.models.edit',
            'uses' => [Kits\PredefinedKitsController::class, 'editModel'],

        ]
    );

    Route::delete('models/{model_id}',
        [
            'as' => 'kits.models.detach',
            'uses' => [Kits\PredefinedKitsController::class, 'detachModel'],
        ]
    );

    // Consumables
    Route::put('consumables/{consumable_id}',
        [
            'as' => 'kits.consumables.update',
            'uses' => [Kits\PredefinedKitsController::class, 'updateConsumable'],
            'parameters' => [2 => 'kit_id', 1 => 'consumable_id'],
        ]
    );

    Route::get('consumables/{consumable_id}/edit',
        [
            'as' => 'kits.consumables.edit',
            'uses' => [Kits\PredefinedKitsController::class, 'editConsumable'],

        ]
    );

    Route::delete('consumables/{consumable_id}',
        [
            'as' => 'kits.consumables.detach',
            'uses' => [Kits\PredefinedKitsController::class, 'detachConsumable'],
        ]
    );

    // Accessories
    Route::put('accessories/{accessory_id}',
        [
            'as' => 'kits.accessories.update',
            'uses' => [Kits\PredefinedKitsController::class, 'updateAccessory'],
            'parameters' => [2 => 'kit_id', 1 => 'accessory_id'],
        ]
    );

    Route::get('accessories/{accessory_id}/edit',
        [
            'as' => 'kits.accessories.edit',
            'uses' => [Kits\PredefinedKitsController::class, 'editAccessory'],

        ]
    );

    Route::delete('accessories/{accessory_id}',
        [
            'as' => 'kits.accessories.detach',
            'uses' => [Kits\PredefinedKitsController::class, 'detachAccessory'],
        ]
    );
    Route::get('checkout',
        [
            'as' => 'kits.checkout.show',
            'uses' => [Kits\CheckoutKitController::class, 'showCheckout'],
        ]
    );

    Route::post('checkout',
        [
            'as' => 'kits.checkout.store',
            'uses' => [Kits\CheckoutKitController::class, 'store'],
        ]
    );
}); // kits

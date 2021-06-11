<?php

use App\Http\Controllers\Components;
use Illuminate\Support\Facades\Route;

// Components
Route::group(['prefix' => 'components', 'middleware' => ['auth']], function () {
    Route::get(
        '{componentID}/checkout',
        ['as' => 'checkout/component', 'uses' => [Components\ComponentCheckoutController::class, 'create']]
    );
    Route::post(
        '{componentID}/checkout',
        ['as' => 'checkout/component', 'uses' => [Components\ComponentCheckoutController::class, 'store']]
    );
    Route::get(
        '{componentID}/checkin',
        ['as' => 'checkin/component', 'uses' => [Components\ComponentCheckinController::class, 'create']]
    );
    Route::post(
        '{componentID}/checkin',
        ['as' => 'component.checkin.save', 'uses' => [Components\ComponentCheckinController::class, 'store']]
    );
});

Route::resource('components', Components\ComponentsController::class, [
    'middleware' => ['auth'],
    'parameters' => ['component' => 'component_id'],
]);

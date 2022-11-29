<?php

use App\Http\Controllers\PurchaseOrderController;
use Illuminate\Support\Facades\Route;

/*
* PurchaseOrder
 */

// Route::controller(PurchaseOrderController::class)
//     ->group(['prefix' => 'purchases', 'middleware' => ['auth']], function () {
//         Route::get('/', 'index')->name('purchases.index');       
//     });

Route::resource('purchases', PurchaseOrderController::class, [
    'middleware' => ['auth'],
    'parameters' => ['purchase' => 'purchase_id'],
]);

// Route::resource('accessories', Accessories\AccessoriesController::class, [
//     'middleware' => ['auth'],
//     'parameters' => ['accessory' => 'accessory_id'],
// ]);
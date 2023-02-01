<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductFlowController;

Route::group(['prefix' => 'productflow', 'middleware' => ['auth']], function () {
    Route::get('receiving', [ProductFlowController::class, 'index'])->name('productflow.receiving');
    Route::get('show', [ProductFlowController::class, 'show'])->name('productflow.receiving.show');
    Route::post('store', [ProductFlowController::class, 'store'])->name('productflow.receiving.store');
    Route::post('update', [ProductFlowController::class, 'update'])->name('productflow.receiving.update');
});

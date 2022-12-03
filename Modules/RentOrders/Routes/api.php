<?php

use Illuminate\Support\Facades\Route;
use Modules\RentOrders\Http\Controllers\ApiRentOrdersController;

Route::group(['prefix' => 'v1', 'middleware' => ['api', 'throttle:api']], function () {

    Route::prefix("rentorders")->group(function (){
        Route::get("/", [ApiRentOrdersController::class, "index"])->name("api.rentorders.index");
        Route::post("/", [ApiRentOrdersController::class, "store"])->name("api.rentorders.store");
        Route::put("/", [ApiRentOrdersController::class, "update"])->name("api.rentorders.update");
        Route::delete("/", [ApiRentOrdersController::class, "destroy"])->name("api.rentorders.destroy");
    });

}); // end API routes

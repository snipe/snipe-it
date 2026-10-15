<?php

use App\Http\Controllers\BulkLocationsController;
use App\Http\Controllers\LocationsController;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

Route::group(['prefix' => 'locations', 'middleware' => ['auth']], function () {

    Route::post(
        'bulkdelete',
        [BulkLocationsController::class, 'edit']
    )->name('locations.bulkdelete.show')
        ->breadcrumbs(function (Trail $trail) {
            $label = match (request()->input('bulk_actions')) {
                'edit' => trans('general.bulk_edit'),
                'delete' => trans('general.delete'),
                default => trans('general.bulk_actions'),
            };

            return $trail->parent('locations.index')->push($label, route('locations.index'));
        });

    Route::post(
        'bulkedit',
        [BulkLocationsController::class, 'destroy']
    )->name('locations.bulkdelete.store');

    Route::post(
        'bulkeditsave',
        [BulkLocationsController::class, 'update']
    )->name('locations.bulkedit.store')
        ->breadcrumbs(fn(Trail $trail) => $trail->parent('locations.index')
            ->push(trans('general.bulk_edit'), route('locations.index')));

    Route::post(
        '{location}/restore',
        [LocationsController::class, 'postRestore']
    )->where('location', '[0-9]+')
        ->name('locations.restore')->withTrashed();

    Route::get('{locationId}/clone',
        [LocationsController::class, 'getClone']
    )->where('locationId', '[0-9]+')
        ->name('clone/location');

    Route::get(
        '{locationId}/printassigned',
        [LocationsController::class, 'print_assigned']
    )->where('locationId', '[0-9]+')
        ->name('locations.print_assigned');

    Route::get(
        '{locationId}/printallassigned',
        [LocationsController::class, 'print_all_assigned']
    )->where('locationId', '[0-9]+')
        ->name('locations.print_all_assigned');

});

Route::resource('locations', LocationsController::class, [
    'middleware' => ['auth'],
])->withTrashed();

<?php

use App\Http\Controllers\Users;
use App\Http\Controllers\Users\UserFilesController;
use Illuminate\Support\Facades\Route;

// User Management

Route::group(['prefix' => 'users', 'middleware' => ['auth']], function () {

    Route::get(
        'ldap',
        [
            Users\LDAPImportController::class, 
            'create'
        ]
    )->name('ldap/user');

    Route::post(
        'ldap',
        [
            Users\LDAPImportController::class, 
            'store'
        ]
    );

    Route::get(
        'export',
        [
            Users\UsersController::class, 
            'getExportUserCsv'
        ]
    )->name('users.export');

    Route::get(
        '{userId}/clone',
        [
            Users\UsersController::class, 
            'getClone'
        ]
    )->name('clone/user');

    Route::post(
        '{userId}/clone',
        [
            Users\UsersController::class, 
            'postCreate'
        ]
    )->name('clone/user');

    Route::post(
        '{userId}/restore',
        [
            Users\UsersController::class, 
            'getRestore'
        ]
    )->name('restore/user');

    Route::get(
        '{userId}/unsuspend',
        [
            Users\UsersController::class, 
            'getUnsuspend'
        ]
    )->name('unsuspend/user');

    Route::post(
        '{userId}/upload',
        [
            Users\UserFilesController::class, 
            'store'
        ]
    )->name('upload/user');

    Route::delete(
        '{userId}/deletefile/{fileId}',
        [
            Users\UserFilesController::class, 
            'destroy'
        ]
    )->name('userfile.destroy');

    Route::get(
        '{userId}/showfile/{fileId}',
        [
            Users\UserFilesController::class, 
            'show'
        ]
    )->name('show/userfile');

    Route::post(
        '{userId}/password',
        [
            Users\UsersController::class, 
            'sendPasswordReset'
        ]
    )->name('users.password');

    Route::get(
        '{userId}/print',
        [
            Users\UsersController::class, 
            'printInventory'
        ]
    )->name('users.print');

    Route::post(
        '{userId}/email',
        [
            Users\UsersController::class,
            'emailAssetList'
        ]
    )->name('users.email');

    Route::post(
        'bulkedit',
        [
            Users\BulkUsersController::class, 
            'edit'
        ]
    )->name('users/bulkedit');


    Route::post(
        'bulksave',
        [
            Users\BulkUsersController::class, 
            'destroy'
        ]
    )->name('users/bulksave');

    Route::post(
        'bulkeditsave',
        [
            Users\BulkUsersController::class, 
            'update'
        ]
    )->name('users/bulkeditsave');


});

Route::resource('users', Users\UsersController::class, [
    'middleware' => ['auth'],
    'parameters' => ['user' => 'user_id'],
]);
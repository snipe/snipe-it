<?php

use App\Http\Controllers\Users;
use Illuminate\Support\Facades\Route;

// User Management
Route::group(['prefix' => 'users', 'middleware' => ['auth']], function () {
    Route::get('ldap', ['as' => 'ldap/user', 'uses' => [Users\LDAPImportController::class, 'create']]);
    Route::post('ldap', [Users\LDAPImportController::class, 'store']);
    Route::get('export', ['as' => 'users.export', 'uses' => [Users\UsersController::class, 'getExportUserCsv']]);
    Route::get('{userId}/clone', ['as' => 'clone/user', 'uses' => [Users\UsersController::class, 'getClone']]);
    Route::post('{userId}/clone', ['uses' => [Users\UsersController::class, 'postCreate']]);
    Route::get('{userId}/restore', ['as' => 'restore/user', 'uses' => [Users\UsersController::class, 'getRestore']]);
    Route::get('{userId}/unsuspend', ['as' => 'unsuspend/user', 'uses' => [Users\UsersController::class, 'getUnsuspend']]);
    Route::post('{userId}/upload', ['as' => 'upload/user', 'uses' => [Users\UserFilesController::class, 'store']]);
    Route::delete(
        '{userId}/deletefile/{fileId}',
        ['as' => 'userfile.destroy', 'uses' => [Users\UserFilesController::class, 'destroy']]
    );

    Route::post(
        '{userId}/password',
        [
            'as'   => 'users.password',
            'uses' => [Users\UsersController::class, 'sendPasswordReset'],
        ]
    );

    Route::get(
        '{userId}/print',
        ['as' => 'users.print', 'uses' => [Users\UsersController::class, 'printInventory']]
    );

    Route::get(
        '{userId}/showfile/{fileId}',
        ['as' => 'show/userfile', 'uses' => [Users\UserFilesController::class, 'show']]
    );

    Route::post(
        'bulkedit',
        [
            'as'   => 'users/bulkedit',
            'uses' => [Users\BulkUsersController::class, 'edit'],
        ]
    );
    Route::post(
        'bulksave',
        [
            'as'   => 'users/bulksave',
            'uses' => [Users\BulkUsersController::class, 'destroy'],
        ]
    );
    Route::post(
        'bulkeditsave',
        [
            'as'   => 'users/bulkeditsave',
            'uses' => [Users\BulkUsersController::class, 'update'],
        ]
    );
});

Route::resource('users', Users\UsersController::class, [
    'middleware' => ['auth'],
    'parameters' => ['user' => 'user_id'],
]);

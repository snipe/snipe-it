<?php

# User Management
Route::group([ 'prefix' => 'users', 'middleware' => ['auth']], function () {

    Route::get('ldap', ['as' => 'ldap/user', 'uses' => 'Users\LDAPImportController@create' ]);
    Route::post('ldap', 'Users\LDAPImportController@store');
    Route::get('export', [ 'as' => 'users.export', 'uses' => 'Users\UsersController@getExportUserCsv' ]);
    Route::get('{userId}/clone', [ 'as' => 'clone/user', 'uses' => 'Users\UsersController@getClone' ]);
    Route::post('{userId}/clone', [ 'uses' => 'Users\UsersController@postCreate' ]);
    Route::get('{userId}/restore', [ 'as' => 'restore/user', 'uses' => 'Users\UsersController@getRestore' ]);
    Route::get('{userId}/unsuspend', [ 'as' => 'unsuspend/user', 'uses' => 'Users\UsersController@getUnsuspend' ]);
    Route::post('{userId}/upload', [ 'as' => 'upload/user', 'uses' => 'Users\UserFilesController@store' ]);
    Route::delete(
        '{userId}/deletefile/{fileId}',
        [ 'as' => 'userfile.destroy', 'uses' => 'Users\UserFilesController@destroy' ]
    );

    Route::get(
        '{userId}/print',
        [ 'as' => 'users.print', 'uses' => 'Users\UsersController@printInventory' ]
    );


    Route::get(
        '{userId}/showfile/{fileId}',
        [ 'as' => 'show/userfile', 'uses' => 'Users\UserFilesController@show' ]
    );

    Route::post(
        'bulkedit',
        [
            'as'   => 'users/bulkedit',
            'uses' => 'Users\BulkUsersController@edit',
        ]
    );
    Route::post(
        'bulksave',
        [
            'as'   => 'users/bulksave',
            'uses' => 'Users\BulkUsersController@destroy',
        ]
    );
    Route::post(
        'bulkeditsave',
        [
            'as'   => 'users/bulkeditsave',
            'uses' => 'Users\BulkUsersController@update',
        ]
    );


});

Route::resource('users', 'Users\UsersController', [
    'middleware' => ['auth'],
    'parameters' => ['user' => 'user_id']
]);

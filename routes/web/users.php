<?php

# User Management
Route::group([ 'prefix' => 'users', 'middleware' => ['auth']], function () {

    Route::get('ldap', ['as' => 'ldap/user', 'uses' => 'UsersController@getLDAP' ]);
    Route::post('ldap', 'UsersController@postLDAP');
    Route::get('export', [ 'as' => 'users.export', 'uses' => 'UsersController@getExportUserCsv' ]);
    Route::get('{userId}/clone', [ 'as' => 'clone/user', 'uses' => 'UsersController@getClone' ]);
    Route::post('{userId}/clone', [ 'uses' => 'UsersController@postCreate' ]);
    Route::get('{userId}/restore', [ 'as' => 'restore/user', 'uses' => 'UsersController@getRestore' ]);
    Route::get('{userId}/unsuspend', [ 'as' => 'unsuspend/user', 'uses' => 'UsersController@getUnsuspend' ]);
    Route::post('{userId}/upload', [ 'as' => 'upload/user', 'uses' => 'UsersController@postUpload' ]);
    Route::delete(
        '{userId}/deletefile/{fileId}',
        [ 'as' => 'userfile.destroy', 'uses' => 'UsersController@getDeleteFile' ]
    );

    Route::get(
        '{userId}/print',
        [ 'as' => 'users.print', 'uses' => 'UsersController@printInventory' ]
    );


    Route::get(
        '{userId}/showfile/{fileId}',
        [ 'as' => 'show/userfile', 'uses' => 'UsersController@displayFile' ]
    );

    Route::post(
        'bulkedit',
        [
            'as'   => 'users/bulkedit',
            'uses' => 'UsersController@postBulkEdit',
        ]
    );
    Route::post(
        'bulksave',
        [
            'as'   => 'users/bulksave',
            'uses' => 'UsersController@postBulkSave',
        ]
    );
    Route::post(
        'bulkeditsave',
        [
            'as'   => 'users/bulkeditsave',
            'uses' => 'UsersController@postBulkEditSave',
        ]
    );


});

Route::resource('users', 'UsersController', [
    'middleware' => ['auth'],
    'parameters' => ['user' => 'user_id']
]);

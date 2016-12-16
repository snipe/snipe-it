<?php

# User Management
Route::group([ 'prefix' => 'users', 'middleware' => ['web','auth','authorize:users.view']], function () {

    Route::get('ldap', ['as' => 'ldap/user', 'uses' => 'UsersController@getLDAP', 'middleware' => ['authorize:users.edit'] ]);
    Route::post('ldap', 'UsersController@postLDAP');
    Route::get('import', [ 'as' => 'import/user', 'uses' => 'UsersController@getImport', 'middleware' => ['authorize:users.edit']  ]);
    Route::post('import', [ 'uses' => 'UsersController@postImport', 'middleware' => ['authorize:users.edit']  ]);
    Route::get('export', [ 'uses' => 'UsersController@getExportUserCsv', 'middleware' => ['authorize:users.view']  ]);
    Route::get('{userId}/clone', [ 'as' => 'clone/user', 'uses' => 'UsersController@getClone', 'middleware' => ['authorize:users.edit']  ]);
    Route::post('{userId}/clone', [ 'uses' => 'UsersController@postCreate', 'middleware' => ['authorize:users.edit']  ]);
    Route::get('{userId}/restore', [ 'as' => 'restore/user', 'uses' => 'UsersController@getRestore', 'middleware' => ['authorize:users.edit']  ]);
    Route::get('{userId}/unsuspend', [ 'as' => 'unsuspend/user', 'uses' => 'UsersController@getUnsuspend', 'middleware' => ['authorize:users.edit'] ]);
    Route::get(
        '{userId}/deletefile/{fileId}',
        [ 'as' => 'delete/userfile', 'uses' => 'UsersController@getDeleteFile' ]
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
            'middleware' => ['authorize:users.edit'],
        ]
    );
    Route::post(
        'bulksave',
        [
            'as'   => 'users/bulksave',
            'uses' => 'UsersController@postBulkSave',
            'middleware' => ['authorize:users.edit'],
        ]
    );


});

Route::resource('users', 'UsersController', [
    'parameters' => ['user' => 'user_id']
]);

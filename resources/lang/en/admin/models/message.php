<?php

return [

    'does_not_exist' => 'Model does not exist.',
    'assoc_users'     => 'This model is currently associated with one or more assets and cannot be deleted. Please delete the assets, and then try deleting again. ',

    'create' => [
        'error'   => 'Model was not created, please try again.',
        'success' => 'Model created successfully.',
        'duplicate_set' => 'An asset model with that name, manufacturer and model number already exists.',
    ],

    'update' => [
        'error'   => 'Model was not updated, please try again',
        'success' => 'Model updated successfully.',
    ],

    'delete' => [
        'confirm'   => 'Are you sure you wish to delete this asset model?',
        'error'   => 'There was an issue deleting the model. Please try again.',
        'success' => 'The model was deleted successfully.',
    ],

    'restore' => [
        'error'        => 'Model was not restored, please try again',
        'success'        => 'Model restored successfully.',
    ],

    'bulkedit' => [
        'error'        => 'No fields were changed, so nothing was updated.',
        'success'        => 'Models updated.',
    ],

];

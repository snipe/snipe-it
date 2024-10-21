<?php

return array(

    'does_not_exist' => 'The asset [:id] does not exist.',
    'not_found' => 'That asset was not found.',
    'assoc_users'	 => 'This asset currently has :count items checked out to users. Please check in the accessories and and try again. ',

    'create' => array(
        'error'   => 'The asset was not created, please try again.',
        'success' => 'The asset was successfully created.'
    ),

    'update' => array(
        'error'   => 'The asset was not updated, please try again',
        'success' => 'The asset was updated successfully.'
    ),

    'delete' => array(
        'confirm'   => 'Are you sure you wish to delete this asset?',
        'error'   => 'There was an issue deleting the asset. Please try again.',
        'success' => 'The asset was deleted successfully.'
    ),

     'checkout' => array(
        'error'   		=> 'Asset was not checked out, please try again',
        'success' 		=> 'Asset checked out successfully.',
        'unavailable'   => 'Asset is not available for checkout. Check quantity available',
        'user_does_not_exist' => 'That user is invalid. Please try again.',
         'checkout_qty' => array(
            'lte'  => 'There is currently only one available asset of this type, and you are trying to check out :checkout_qty. Please adjust the checkout quantity or the total stock of this asset and try again.|There are :number_currently_remaining total available accessories, and you are trying to check out :checkout_qty. Please adjust the checkout quantity or the total stock of this asset and try again.',
            ),
           
    ),

    'checkin' => array(
        'error'   		=> 'Asset was not checked in, please try again',
        'success' 		=> 'Asset checked in successfully.',
        'user_does_not_exist' => 'That user is invalid. Please try again.'
    )


);

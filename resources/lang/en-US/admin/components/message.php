<?php

return array(

    'does_not_exist' => 'Part does not exist.',

    'create' => array(
        'error'   => 'Part was not created, please try again.',
        'success' => 'Part created successfully.'
    ),

    'update' => array(
        'error'   => 'Part was not updated, please try again',
        'success' => 'Part updated successfully.'
    ),

    'delete' => array(
        'confirm'   => 'Are you sure you wish to delete this part?',
        'error'   => 'There was an issue deleting the part. Please try again.',
        'success' => 'The part was deleted successfully.'
    ),

     'checkout' => array(
        'error'   		=> 'Part was not checked out, please try again',
        'success' 		=> 'Part checked out successfully.',
        'user_does_not_exist' => 'That user is invalid. Please try again.',
        'unavailable'      => 'Not enough parts remaining: :remaining remaining, :requested requested ',
    ),

    'checkin' => array(
        'error'   		=> 'Part was not checked in, please try again',
        'success' 		=> 'Part checked in successfully.',
        'user_does_not_exist' => 'That user is invalid. Please try again.'
    )


);

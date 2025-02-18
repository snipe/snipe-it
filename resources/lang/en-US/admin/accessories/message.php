<?php

return array(

    'does_not_exist' => 'The tool [:id] does not exist.',
    'not_found' => 'That tool was not found.',
    'assoc_users'	 => 'This tool currently has :count items checked out to users. Please check in the tools and and try again. ',

    'create' => array(
        'error'   => 'The tool was not created, please try again.',
        'success' => 'The tool was successfully created.'
    ),

    'update' => array(
        'error'   => 'The tool was not updated, please try again',
        'success' => 'The tool was updated successfully.'
    ),

    'delete' => array(
        'confirm'   => 'Are you sure you wish to delete this tool?',
        'error'   => 'There was an issue deleting the tool. Please try again.',
        'success' => 'The tool was deleted successfully.'
    ),

     'checkout' => array(
        'error'   		=> 'Tool was not checked out, please try again',
        'success' 		=> 'Tool checked out successfully.',
        'unavailable'   => 'Tool is not available for checkout. Check quantity available',
        'user_does_not_exist' => 'That user is invalid. Please try again.',
         'checkout_qty' => array(
            'lte'  => 'There is currently only one available tool of this type, and you are trying to check out :checkout_qty. Please adjust the checkout quantity or the total stock of this tool and try again.|There are :number_currently_remaining total available tools, and you are trying to check out :checkout_qty. Please adjust the checkout quantity or the total stock of this tool and try again.',
            ),
           
    ),

    'checkin' => array(
        'error'   		=> 'Tool was not checked in, please try again',
        'success' 		=> 'Tool checked in successfully.',
        'user_does_not_exist' => 'That user is invalid. Please try again.'
    )


);

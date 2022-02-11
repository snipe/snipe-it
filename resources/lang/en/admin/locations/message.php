<?php

return array(

    'does_not_exist' => 'Location does not exist.',
    'assoc_users'	 => 'This location is currently associated with at least one user and cannot be deleted. Please update your users to no longer reference this location and try again. ',
    'assoc_assets'	 => 'This location is currently associated with at least one asset and cannot be deleted. Please update your assets to no longer reference this location and try again. ',
    'assoc_child_loc'	 => 'This location is currently the parent of at least one child location and cannot be deleted. Please update your locations to no longer reference this location and try again. ',

    'create' => [
        'bulk_parent_warn'  => 'Your locations have been successfully updated, however your parent entry was not saved because the parent you selected was also in the location list to be edited, and locations may not be their own parent. Please select your locations again, excluding the parent.',
        'error'   => 'Location was not created, please try again.',
        'success' => 'Location created successfully.',
    ],

    'update' => [
        'error'   => 'Location was not updated, please try again',
        'success' => 'Location updated successfully.',
    ],

    'delete' => [
        'confirm'   	=> 'Are you sure you wish to delete this location?',
        'error'   => 'There was an issue deleting the location. Please try again.',
        'success' => 'The location was deleted successfully.',
    ],

);

<?php

return array(

    'does_not_exist' => 'Location does not exist.',
    'assoc_users'	 => 'This location is currently associated with at least one user and cannot be deleted. Please update your users to no longer reference this location and try again. ',


    'create' => array(
        'error'   => 'Location was not created, please try again.',
        'success' => 'Location created successfully.'
    ),

    'update' => array(
        'error'   => 'Location was not updated, please try again',
        'success' => 'Location updated successfully.'
    ),

    'delete' => array(
        'confirm'   => 'Are you sure you wish to delete this status label?',
        'error'   => 'There was an issue deleting the location. Please try again.',
        'success' => 'The location was deleted successfully.'
    ),
    
    'about'	=> 'Status labels are used to describe the various states and condition '
                . 'of assets. It could be waiting for installation, assigned, broken, '
                . 'out for diagnostics, out for repair, lost or stolen, etc. Status '
                . 'labels allow you to show the life-cycle progression.<BR><BR>You cannot '
                . 'delete the first three status as they are the default state of new, '
                . 'ready and assigned assets.<br><br>Each status can also have one of four '
                . 'inventory states (pending, available, assigned and unavailable) which '
                . 'control the behavior of assets in that status.',

);

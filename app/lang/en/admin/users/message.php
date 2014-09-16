<?php

return array(

    'user_exists'              => 'User already exists!',
    'user_not_found'           => 'User [:id] does not exist.',
    'user_login_required'      => 'The login field is required',
    'user_password_required'   => 'The password is required.',
    'insufficient_permissions' => 'Insufficient Permissions.',

    'success' => array(
        'create'    => 'User was successfully created.',
        'update'    => 'User was successfully updated.',
        'delete'    => 'User was successfully deleted.',
        'ban'       => 'User was successfully banned.',
        'unban'     => 'User was successfully unbanned.',
        'suspend'   => 'User was successfully suspended.',
        'unsuspend' => 'User was successfully unsuspended.',
        'restored'  => 'User was successfully restored.'
    ),

    'error' => array(
        'create' => 'There was an issue creating the user. Please try again.',
        'update' => 'There was an issue updating the user. Please try again.',
        'delete' => 'There was an issue deleting the user. Please try again.',
        'unsuspend' => 'There was an issue unsuspending the user. Please try again.'
    ),
    
    'groupnotes'    => 'Select a group to assign to the user, remember that a user '
                    . 'takes on the permissions of the group they are assigned.',
    
    'about'        => 'About users...',

);

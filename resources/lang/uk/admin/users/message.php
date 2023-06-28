<?php

return array(

    'accepted'                  => 'You have successfully accepted this asset.',
    'declined'                  => 'You have successfully declined this asset.',
    'bulk_manager_warn'	        => 'Your users have been successfully updated, however your manager entry was not saved because the manager you selected was also in the user list to be edited, and users may not be their own manager. Please select your users again, excluding the manager.',
    'user_exists'               => 'Користувач вже існує!',
    'user_not_found'            => 'User does not exist.',
    'user_login_required'       => 'The login field is required',
    'user_password_required'    => 'The password is required.',
    'insufficient_permissions'  => 'Недостатньо прав.',
    'user_deleted_warning'      => 'This user has been deleted. You will have to restore this user to edit them or assign them new assets.',
    'ldap_not_configured'        => 'LDAP integration has not been configured for this installation.',
    'password_resets_sent'      => 'The selected users who are activated and have a valid email addresses have been sent a password reset link.',
    'password_reset_sent'       => 'A password reset link has been sent to :email!',
    'user_has_no_email'         => 'This user does not have an email address in their profile.',
    'user_has_no_assets_assigned'   => 'This user does not have any assets assigned',


    'success' => array(
        'create'    => 'User was successfully created.',
        'update'    => 'User was successfully updated.',
        'update_bulk'    => 'Users were successfully updated!',
        'delete'    => 'User was successfully deleted.',
        'ban'       => 'User was successfully banned.',
        'unban'     => 'User was successfully unbanned.',
        'suspend'   => 'User was successfully suspended.',
        'unsuspend' => 'User was successfully unsuspended.',
        'restored'  => 'User was successfully restored.',
        'import'    => 'Users imported successfully.',
    ),

    'error' => array(
        'create' => 'There was an issue creating the user. Please try again.',
        'update' => 'There was an issue updating the user. Please try again.',
        'delete' => 'There was an issue deleting the user. Please try again.',
        'delete_has_assets' => 'This user has items assigned and could not be deleted.',
        'unsuspend' => 'There was an issue unsuspending the user. Please try again.',
        'import'    => 'There was an issue importing users. Please try again.',
        'asset_already_accepted' => 'This asset has already been accepted.',
        'accept_or_decline' => 'You must either accept or decline this asset.',
        'incorrect_user_accepted' => 'The asset you have attempted to accept was not checked out to you.',
        'ldap_could_not_connect' => 'Could not connect to the LDAP server. Please check your LDAP server configuration in the LDAP config file. <br>Error from LDAP Server:',
        'ldap_could_not_bind' => 'Could not bind to the LDAP server. Please check your LDAP server configuration in the LDAP config file. <br>Error from LDAP Server: ',
        'ldap_could_not_search' => 'Could not search the LDAP server. Please check your LDAP server configuration in the LDAP config file. <br>Error from LDAP Server:',
        'ldap_could_not_get_entries' => 'Could not get entries from the LDAP server. Please check your LDAP server configuration in the LDAP config file. <br>Error from LDAP Server:',
        'password_ldap' => 'The password for this account is managed by LDAP/Active Directory. Please contact your IT department to change your password. ',
    ),

    'deletefile' => array(
        'error'   => 'File not deleted. Please try again.',
        'success' => 'Файл успішно видалено.',
    ),

    'upload' => array(
        'error'   => 'File(s) not uploaded. Please try again.',
        'success' => 'File(s) successfully uploaded.',
        'nofiles' => 'You did not select any files for upload',
        'invalidfiles' => 'One or more of your files is too large or is a filetype that is not allowed. Allowed filetypes are png, gif, jpg, doc, docx, pdf, and txt.',
    ),

    'inventorynotification' => array(
        'error'   => 'This user has no email set.',
        'success' => 'The user has been notified about their current inventory.'
    )
);
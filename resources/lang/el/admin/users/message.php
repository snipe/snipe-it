<?php

return array(

    'accepted'                  => 'Έχετε αποδεχθεί με επιτυχία αυτό το πάγιο.',
    'declined'                  => 'You have successfully declined this asset.',
    'bulk_manager_warn'	        => 'Your users have been successfully updated, however your manager entry was not saved because the manager you selected was also in the user list to be edited, and users may not be their own manager. Please select your users again, excluding the manager.',
    'user_exists'               => 'Ο χρήστης υπάρχει ήδη!',
    'user_not_found'            => 'Ο χρήστης [:id] δεν υπάρχει.',
    'user_login_required'       => 'Το πεδίο εισόδου είναι υποχρεωτικό',
    'user_password_required'    => 'Ο κωδικός είναι απαραίτητος.',
    'insufficient_permissions'  => 'Δεν έχετε επαρκή δικαιώματα.',
    'user_deleted_warning'      => 'Αυτός ο χρήστης έχει διαγραφεί. Θα πρέπει να επαναφέρετε αυτό το χρήστη για να τον επεξεργαστείτε ή να του εκχωρήσετε νέα πάγια.',
    'ldap_not_configured'        => 'LDAP integration has not been configured for this installation.',


    'success' => array(
        'create'    => 'Ο χρήστης δημιουργήθηκε με επιτυχία.',
        'update'    => 'Ο χρήστης ενημερώθηκε με επιτυχία.',
        'update_bulk'    => 'Users were successfully updated!',
        'delete'    => 'Ο χρήστης διαφράφηκε με επιτυχία.',
        'ban'       => 'Ο χρήστης έχει αποκλειστεί επιτυχώς.',
        'unban'     => 'Ο Χρήστης επαναφέρθηκε με επιτυχία.',
        'suspend'   => 'User was successfully suspended.',
        'unsuspend' => 'User was successfully unsuspended.',
        'restored'  => 'Ο Χρήστης επαναφέρθηκε με επιτυχία.',
        'import'    => 'Users imported successfully.',
    ),

    'error' => array(
        'create' => 'There was an issue creating the user. Please try again.',
        'update' => 'There was an issue updating the user. Please try again.',
        'delete' => 'There was an issue deleting the user. Please try again.',
        'unsuspend' => 'There was an issue unsuspending the user. Please try again.',
        'import'    => 'There was an issue importing users. Please try again.',
        'asset_already_accepted' => 'This asset has already been accepted.',
        'accept_or_decline' => 'You must either accept or decline this asset.',
        'incorrect_user_accepted' => 'The asset you have attempted to accept was not checked out to you.',
        'ldap_could_not_connect' => 'Could not connect to the LDAP server. Please check your LDAP server configuration in the LDAP config file. <br>Error from LDAP Server:',
        'ldap_could_not_bind' => 'Could not bind to the LDAP server. Please check your LDAP server configuration in the LDAP config file. <br>Error from LDAP Server: ',
        'ldap_could_not_search' => 'Could not search the LDAP server. Please check your LDAP server configuration in the LDAP config file. <br>Error from LDAP Server:',
        'ldap_could_not_get_entries' => 'Could not get entries from the LDAP server. Please check your LDAP server configuration in the LDAP config file. <br>Error from LDAP Server:',
    ),

    'deletefile' => array(
        'error'   => 'Το αρχείο δεν έχει διαγραφεί. Παρακαλώ δοκιμάστε ξανά.',
        'success' => 'Το αρχείο διαγράφηκε με επιτυχία.',
    ),

    'upload' => array(
        'error'   => 'Τα αρχεία δεν μεταφορτώθηκαν. Παρακαλώ δοκιμάστε ξανά.',
        'success' => 'Τα αρχεία ενημερώθηκαν με επιτυχία.',
        'nofiles' => 'Δεν έχετε επιλέξει κανένα αρχείο για ενημέρωση',
        'invalidfiles' => 'One or more of your files is too large or is a filetype that is not allowed. Allowed filetypes are png, gif, jpg, doc, docx, pdf, and txt.',
    ),

);

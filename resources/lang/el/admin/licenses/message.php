<?php

return array(

    'does_not_exist' => 'Δεν υπάρχει άδεια χρήσης.',
    'user_does_not_exist' => 'Ο χρήστης δεν υπάρχει.',
    'asset_does_not_exist' 	=> 'Το πάγιο που προσπαθείτε να συσχετίσετε με αυτήν την άδεια δεν υπάρχει.',
    'owner_doesnt_match_asset' => 'The asset you are trying to associate with this license is owned by somene other than the person selected in the assigned to dropdown.',
    'assoc_users'	 => 'This license is currently checked out to a user and cannot be deleted. Please check the license in first, and then try deleting again. ',


    'create' => array(
        'error'   => 'Η άδεια δεν δημιουργήθηκε, παρακαλώ προσπαθήστε ξανά.',
        'success' => 'Η άδεια δημιουργήθηκε με επιτυχία.'
    ),

    'deletefile' => array(
        'error'   => 'Ο φάκελος έχει διαγραφεί. Παρακαλώ δοκιμάστε ξανά.',
        'success' => 'Το αρχείο διαγράφηκε με επιτυχία.',
    ),

    'upload' => array(
        'error'   => 'Τα αρχεία δεν μεταφορτώθηκαν. Παρακαλώ δοκιμάστε ξανά.',
        'success' => 'Τα αρχεία ενημερώθηκαν με επιτυχία.',
        'nofiles' => 'You did not select any files for upload, or the file you are trying to upload is too large',
        'invalidfiles' => 'One or more of your files is too large or is a filetype that is not allowed. Allowed filetypes are png, gif, jpg, jpeg, doc, docx, pdf, txt, zip, rar, rtf, xml, and lic.',
    ),

    'update' => array(
        'error'   => 'Η άδεια δεν δημιουργήθηκε, παρακαλώ προσπαθήστε ξανά',
        'success' => 'Η άδεια ενημερώθηκε με επιτυχία.'
    ),

    'delete' => array(
        'confirm'   => 'Είστε σίγουροι ότι θέλετε να διαγράψετε αυτή την άδεια;',
        'error'   => 'Υπήρξε ένα ζήτημα διαγράφοντας την άδεια. Παρακαλώ δοκιμάστε ξανά.',
        'success' => 'Η άδεια διαγράφηκε επιτυχώς.'
    ),

    'checkout' => array(
        'error'   => 'There was an issue checking out the license. Please try again.',
        'success' => 'The license was checked out successfully'
    ),

    'checkin' => array(
        'error'   => 'There was an issue checking in the license. Please try again.',
        'success' => 'The license was checked in successfully'
    ),

);

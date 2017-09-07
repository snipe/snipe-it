<?php

return array(

    'undeployable' 		=> '<strong>Warning: </strong> Το περιουσιακό αυτό στοιχείο έχει επισημανθεί ως επί του παρόντος undeployable.
                        Εάν αυτή η κατάσταση έχει αλλάξει, παρακαλούμε να ενημερώσετε την κατάσταση των περιουσιακών στοιχείων.',
    'does_not_exist' 	=> 'To πάγιο δεν υπάρχει.',
    'does_not_exist_or_not_requestable' => 'Nice try. That asset does not exist or is not requestable.',
    'assoc_users'	 	=> 'This asset is currently checked out to a user and cannot be deleted. Please check the asset in first, and then try deleting again. ',

    'create' => array(
        'error'   		=> 'Το περιουσιακού στοιχείο δεν δημιουργήθηκε, παρακαλώ προσπαθήστε ξανά. :(',
        'success' 		=> 'Το πάγιο δημιουργήθηκε επιτυχώς'
    ),

    'update' => array(
        'error'   			=> 'Το πάγιο δεν ενημερώθηκε, παρακαλώ προσπαθήστε ξανά',
        'success' 			=> 'Τα περιουσιακά στοιχεία ενημερώθηκαν επιτυχώς.',
        'nothing_updated'	=>  'No fields were selected, so nothing was updated.',
    ),

    'restore' => array(
        'error'   		=> 'Asset was not restored, please try again',
        'success' 		=> 'Τα πάγια επαναφέρθηκαν επιτυχώς.'
    ),

    'audit' => array(
        'error'   		=> 'Asset audit was unsuccessful. Please try again.',
        'success' 		=> 'Asset audit successfully logged.'
    ),


    'deletefile' => array(
        'error'   => 'Το αρχείο δεν έχει διαγραφεί. Παρακαλώ δοκιμάστε ξανά.',
        'success' => 'Το αρχείο διαγράφηκε με επιτυχία.',
    ),

    'upload' => array(
        'error'   => 'Τα αρχεία δεν μεταφορτώθηκαν. Παρακαλώ δοκιμάστε ξανά.',
        'success' => 'Τα αρχεία ενημερώθηκαν με επιτυχία.',
        'nofiles' => 'Δεν έχετε επιλέξει οποιαδήποτε αρχείο για μεταφόρτωση ή το αρχείο που προσπαθείτε να φορτώσετε είναι πάρα πολύ μεγάλο',
        'invalidfiles' => 'One or more of your files is too large or is a filetype that is not allowed. Allowed filetypes are png, gif, jpg, doc, docx, pdf, and txt.',
    ),

    'import' => array(
        'error'                 => 'Some items did not import correctly.',
        'errorDetail'           => 'The following Items were not imported because of errors.',
        'success'               => "Your file has been imported",
        'file_delete_success'   => "Your file has been been successfully deleted",
        'file_delete_error'      => "The file was unable to be deleted",
    ),


    'delete' => array(
        'confirm'   	=> 'Είστε σίγουροι ότι θέλετε να διαγράψετε αυτό το πάγιο;',
        'error'   		=> 'There was an issue deleting the asset. Please try again.',
        'nothing_updated'   => 'No assets were selected, so nothing was deleted.',
        'success' 		=> 'Το πάγιο διαγράφηκε με επιτυχία.'
    ),

    'checkout' => array(
        'error'   		=> 'Asset was not checked out, please try again',
        'success' 		=> 'Asset checked out successfully.',
        'user_does_not_exist' => 'That user is invalid. Please try again.',
        'not_available' => 'Αυτό το πάγιο δεν είναι διαθέσιμο για την ολοκλήρωση της παραγγελίας!'
    ),

    'checkin' => array(
        'error'   		=> 'Asset was not checked in, please try again',
        'success' 		=> 'Asset checked in successfully.',
        'user_does_not_exist' => 'Αυτός ο χρήστης δεν υπάρχει. Παρακαλώ δοκιμάστε ξανά.',
        'already_checked_in'  => 'That asset is already checked in.',

    ),

    'requests' => array(
        'error'   		=> 'Asset was not requested, please try again',
        'success' 		=> 'Τα πάγια ενημερώθηκαν επιτυχώς.',
        'canceled'      => 'Checkout request successfully canceled'
    )

);

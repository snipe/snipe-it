<?php

return [
    'about_assets_title'           => 'Σχετικά με τα πάγια',
    'about_assets_text'            => 'Τα στοιχεία ενεργητικού είναι στοιχεία που παρακολουθούνται με αύξοντα αριθμό ή ετικέτα στοιχείων. Έχουν την τάση να είναι στοιχεία υψηλότερης αξίας, όπου ο εντοπισμός ενός συγκεκριμένου στοιχείου έχει σημασία.',
    'archived'  				=> 'Αρχειοθετημένα',
    'asset'  					=> 'Πάγιο',
    'bulk_checkout'             => 'Checkout Assets',
    'bulk_checkin'              => 'Checkin Assets',
    'checkin'  					=> 'Checkin Asset',
    'checkout'  				=> 'Ταμείο ελέγχου',
    'clone'  					=> 'Κλώνος χρήστη',
    'deployable'  				=> 'Προς ανάπτυξη',
    'deleted'  					=> 'This asset has been deleted.',
    'edit'  					=> 'Επεξεργασία παγίων',
    'model_deleted'  			=> 'This Assets model has been deleted. You must restore the model before you can restore the Asset.',
    'model_invalid'             => 'The Model of this Asset is invalid.',
    'model_invalid_fix'         => 'The Asset should be edited to correct this before attempting to check it in or out.',
    'requestable'               => 'Επαναληπτικό',
    'requested'				    => 'Ζητήθηκαν',
    'not_requestable'           => 'Not Requestable',
    'requestable_status_warning' => 'Do not change  requestable status',
    'restore'  					=> 'Επαναφορά παγίου',
    'pending'  					=> 'Εκκρεμεί',
    'undeployable'  			=> 'Μη διανέμεται',
    'undeployable_tooltip'  	=> 'This asset has a status label that is undeployable and cannot be checked out at this time.',
    'view'  					=> 'Προβολή παγίου',
    'csv_error' => 'You have an error in your CSV file:',
    'import_text' => '
    <p>
    Upload a CSV that contains asset history. The assets and users MUST already exist in the system, or they will be skipped. Matching assets for history import happens against the asset tag. We will try to find a matching user based on the user\'s name you provide, and the criteria you select below. If you do not select any criteria below, it will simply try to match on the username format you configured in the Admin &gt; General Settings.
    </p>

    <p>Fields included in the CSV must match the headers: <strong>Asset Tag, Name, Checkout Date, Checkin Date</strong>. Any additional fields will be ignored. </p>

    <p>Checkin Date: blank or future checkin dates will checkout items to associated user.  Excluding the Checkin Date column will create a checkin date with todays date.</p>
    ',
    'csv_import_match_f-l' => 'Try to match users by firstname.lastname (jane.smith) format',
    'csv_import_match_initial_last' => 'Try to match users by first initial last name (jsmith) format',
    'csv_import_match_first' => 'Try to match users by first name (jane) format',
    'csv_import_match_email' => 'Try to match users by email as username',
    'csv_import_match_username' => 'Try to match users by username',
    'error_messages' => 'Error messages:',
    'success_messages' => 'Success messages:',
    'alert_details' => 'Please see below for details.',
    'custom_export' => 'Custom Export',
    'mfg_warranty_lookup' => ':manufacturer Warranty Status Lookup',
];

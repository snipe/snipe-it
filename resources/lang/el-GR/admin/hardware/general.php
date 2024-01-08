<?php

return [
    'about_assets_title'           => 'Σχετικά με τα πάγια',
    'about_assets_text'            => 'Τα στοιχεία ενεργητικού είναι στοιχεία που παρακολουθούνται με αύξοντα αριθμό ή ετικέτα στοιχείων. Έχουν την τάση να είναι στοιχεία υψηλότερης αξίας, όπου ο εντοπισμός ενός συγκεκριμένου στοιχείου έχει σημασία.',
    'archived'  				=> 'Αρχειοθετημένα',
    'asset'  					=> 'Πάγιο',
    'bulk_checkout'             => 'Στοιχεία Ολοκλήρωσης Παραγγελίας',
    'bulk_checkin'              => 'Checkin Assets',
    'checkin'  					=> 'Checkin Asset',
    'checkout'  				=> 'Ταμείο ελέγχου',
    'clone'  					=> 'Κλώνος χρήστη',
    'deployable'  				=> 'Προς ανάπτυξη',
    'deleted'  					=> 'Αυτό το στοιχείο έχει διαγραφεί.',
    'delete_confirm'            => 'Είστε βέβαιοι ότι θέλετε να διαγράψετε αυτό το στοιχείο?',
    'edit'  					=> 'Επεξεργασία παγίων',
    'model_deleted'  			=> 'Αυτό το μοντέλο περιουσιακών στοιχείων έχει διαγραφεί. Πρέπει να επαναφέρετε το μοντέλο για να μπορέσετε να επαναφέρετε το περιουσιακό στοιχείο.',
    'model_invalid'             => 'Το μοντέλο αυτού του περιουσιακού στοιχείου δεν είναι έγκυρο.',
    'model_invalid_fix'         => 'Το περιουσιακό στοιχείο θα πρέπει να επεξεργαστεί για να διορθώσει αυτό πριν επιχειρήσετε να το ελέγξετε μέσα ή έξω.',
    'requestable'               => 'Επαναληπτικό',
    'requested'				    => 'Ζητήθηκαν',
    'not_requestable'           => 'Δεν Απαιτούνται',
    'requestable_status_warning' => 'Να μην αλλαχθεί η κατάσταση αιτήματος',
    'restore'  					=> 'Επαναφορά παγίου',
    'pending'  					=> 'Εκκρεμεί',
    'undeployable'  			=> 'Μη διανέμεται',
    'undeployable_tooltip'  	=> 'Αυτό το στοιχείο έχει μια ετικέτα κατάστασης που δεν είναι δυνατή η εγκατάσταση και δεν μπορεί να ελεγχθεί αυτή τη στιγμή.',
    'view'  					=> 'Προβολή παγίου',
    'csv_error' => 'Έχετε ένα σφάλμα στο αρχείο CSV σας:',
    'import_text' => '
    <p>
    Upload a CSV that contains asset history. The assets and users MUST already exist in the system, or they will be skipped. Matching assets for history import happens against the asset tag. We will try to find a matching user based on the user\'s name you provide, and the criteria you select below. If you do not select any criteria below, it will simply try to match on the username format you configured in the Admin &gt; General Settings.
    </p>

    <p>Fields included in the CSV must match the headers: <strong>Asset Tag, Name, Checkout Date, Checkin Date</strong>. Any additional fields will be ignored. </p>

    <p>Checkin Date: blank or future checkin dates will checkout items to associated user.  Excluding the Checkin Date column will create a checkin date with todays date.</p>
    ',
    'csv_import_match_f-l' => 'Προσπαθήστε να ταιριάξετε τους χρήστες με τη μορφή firstname.lastname (jane.smith)',
    'csv_import_match_initial_last' => 'Προσπαθήστε να ταιριάζει με τους χρήστες με την πρώτη αρχική μορφή επώνυμου (jsmith)',
    'csv_import_match_first' => 'Προσπαθήστε να ταιριάζει με τους χρήστες με τη μορφή του ονόματος (jane)',
    'csv_import_match_email' => 'Προσπαθήστε να ταιριάζει με τους χρήστες μέσω email ως όνομα χρήστη',
    'csv_import_match_username' => 'Προσπαθήστε να ταιριάζει με τους χρήστες με το όνομα χρήστη',
    'error_messages' => 'Μηνύματα σφάλματος:',
    'success_messages' => 'Μηνύματα επιτυχίας:',
    'alert_details' => 'Παρακαλούμε δείτε παρακάτω για λεπτομέρειες.',
    'custom_export' => 'Προσαρμοσμένη Εξαγωγή',
    'mfg_warranty_lookup' => ':manufacturer Αναζήτηση Κατάστασης Εγγύησης',
    'user_department' => 'Τμήμα Χρηστών',
];

<?php

return [

    'update' => [
        'error'                 => 'Παρουσιάστηκε ένα σφάλμα κατά την ενημέρωση. ',
        'success'               => 'Οι ρυθμίσεις αναβαθμίστηκαν επιτυχώς.',
    ],
    'backup' => [
        'delete_confirm'        => 'Είστε βέβαιοι ότι θέλετε να διαγράψετε αυτό το αρχείο αντιγράφων ασφαλείας; Αυτή η ενέργεια δεν μπορεί να αναιρεθεί. ',
        'file_deleted'          => 'Το αντίγραφο ασφαλείας διαγράφηκε επιτυχώς. ',
        'generated'             => 'Δημιουργήθηκε με επιτυχία ένα νέο αρχείο δημιουργίας αντιγράφων ασφαλείας.',
        'file_not_found'        => 'Αυτό το αρχείο αντιγράφων ασφαλείας δεν βρέθηκε στο διακομιστή.',
        'restore_warning'       => 'Yes, restore it. I acknowledge that this will overwrite any existing data currently in the database. This will also log out all of your existing users (including you).',
        'restore_confirm'       => 'Are you sure you wish to restore your database from :filename?'
    ],
    'purge' => [
        'error'     => 'Παρουσιάστηκε ένα σφάλμα κατά την εκκαθάριση. ',
        'validation_failed'     => 'Η επιβεβαίωση καθαρισμού είναι εσφαλμένη. Παρακαλούμε πληκτρολογήστε τη λέξη «Διαγραφή» στο πλαίσιο επιβεβαίωσης.',
        'success'               => 'Οι διαγραμμένες εγγραφές καθαρίστηκαν με επιτυχία.',
    ],
    'mail' => [
        'sending' => 'Sending Test Email...',
        'success' => 'Mail sent!',
        'error' => 'Mail could not be sent.',
        'additional' => 'No additional error message provided. Check your mail settings and your app log.'
    ],
    'ldap' => [
        'testing' => 'Testing LDAP Connection, Binding & Query ...',
        '500' => '500 Server Error. Please check your server logs for more information.',
        'error' => 'Something went wrong :(',
        'sync_success' => 'A sample of 10 users returned from the LDAP server based on your settings:',
        'testing_authentication' => 'Testing LDAP Authentication...',
        'authentication_success' => 'User authenticated against LDAP successfully!'
    ],
    'webhook' => [
        'sending' => 'Sending :app test message...',
        'success_pt1' => 'Success! Check the ',
        'success_pt2' => ' channel for your test message, and be sure to click SAVE below to store your settings.',
        '500' => '500 Server Error.',
        'error' => 'Something went wrong. :app responded with: :error_message',
        'error_misc' => 'Something went wrong. :( ',
    ]
];

<?php

return array(

    'does_not_exist' => 'Προμηθευτής δεν υπάρχει.',


    'create' => array(
        'error'   => 'Ο προμηθευτής δεν δημιουργήθηκε, δοκιμάστε ξανά.',
        'success' => 'Ο προμηθευτής δημιουργήθηκε επιτυχώς.'
    ),

    'update' => array(
        'error'   => 'Ο προμηθευτής δεν επικαιροποιήθηκε, παρακαλώ δοκιμάστε ξανά',
        'success' => 'Οι προμηθευτές ανανεώθηκαν επιτυχώς.'
    ),

    'delete' => array(
        'confirm'   => 'Είστε βέβαιοι ότι θέλετε να διαγράψετε αυτό τον προμηθευτή;',
        'error'   => 'Υπήρξε ένα ζήτημα διαγράφοντας τον προμηθευτή. Παρακαλώ δοκιμάστε ξανά.',
        'success' => 'Ο προμηθευτής διαγράφηκε επιτυχώς.',
        'assoc_assets'	 => 'Αυτός ο προμηθευτής συσχετίζεται με τουλάχιστον ένα asset και δεν μπορεί να διαγραφεί. Παρακαλούμε να ενημερώσετε τα asset σας να μην αναφέρονται σε αυτόν τον προμηθευτή και δοκιμάστε ξανά. ',
        'assoc_licenses'	 => 'This supplier is currently associated with :licenses_count licences(s) and cannot be deleted. Please update your licenses to no longer reference this supplier and try again. ',
        'assoc_maintenances'	 => 'This supplier is currently associated with :asset_maintenances_count asset maintenances(s) and cannot be deleted. Please update your asset maintenances to no longer reference this supplier and try again. ',
    )

);

<?php

return [

    'does_not_exist' => 'Κατηγορία δεν υπάρχει.',
    'assoc_models' => 'Αυτή η κατηγορία συσχετίζεται επί του παρόντος με τουλάχιστον ένα μοντέλο και δεν μπορεί να διαγραφεί. Ενημερώστε τα μοντέλα σας ώστε να μην αναφέρονται πλέον στην κατηγορία αυτή και δοκιμάστε ξανά.',
    'assoc_items' => 'Αυτή η κατηγορία συσχετίζεται προς το παρόν με τουλάχιστον ένα: asset_type και δεν μπορεί να διαγραφεί. Ενημερώστε το στοιχείο: asset_type ώστε να μην αναφέρεται πλέον αυτή η κατηγορία και δοκιμάστε ξανά.',

    'create' => [
        'error' => 'Η κατηγορία δεν δημιουργήθηκε, παρακαλώ δοκιμάστε ξανά.',
        'success' => 'Η κατηγορία δημιουργήθηκε με επιτυχία.',
    ],

    'update' => [
        'error' => 'Η κατηγορία δεν ενημερώθηκε, παρακαλώ δοκιμάστε ξανά',
        'success' => 'Η κατηγορία ενημερώθηκε με επιτυχία.',
        'cannot_change_category_type' => 'Δεν μπορείτε να αλλάξετε τον τύπο κατηγορίας μόλις δημιουργηθεί',
    ],

    'delete' => [
        'confirm' => 'Είστε βέβαιοι ότι θέλετε να διαγράψετε αυτήν την κατηγορία;',
        'error' => 'Υπήρξε ένα ζήτημα διαγράφοντας αυτή την κατηγορία. Παρακαλώ δοκιμάστε ξανά.',
        'success' => 'Category was deleted successfully.',
        'bulk_success' => 'Category deleted successfully.|:count categories were deleted successfully.',
        'partial_success' => 'Category deleted successfully. See additional information below. | :count categories were deleted successfully. See additional information below.',
    ],

    'bulkedit' => [
        'warn' => 'You are about to edit the properties of the following category:|You are about to edit the properties of the following :count categories:',
        'no_selection' => 'You must select at least one category to edit.',
        'no_changes' => 'Δεν άλλαξαν πεδία, επομένως τίποτα δεν ενημερώθηκε.',
        'success' => 'Category successfully updated.|:count categories successfully updated.',
    ],

];

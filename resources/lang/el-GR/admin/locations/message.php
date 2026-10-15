<?php

return [

    'does_not_exist' => 'Η τοποθεσία δεν υπάρχει.',
    'assoc_users' => 'This location is not currently deletable because it is the location of record for at least one item or user, has assets assigned to it, or is the parent location of another location. Please update your records to no longer reference this location and try again ',
    'assoc_assets' => 'Αυτή η τοποθεσία συσχετίζεται προς το παρόν με τουλάχιστον ένα στοιχείο και δεν μπορεί να διαγραφεί. Ενημερώστε τα στοιχεία σας ώστε να μην αναφέρονται πλέον στην τοποθεσία αυτή και να προσπαθήσετε ξανά.',
    'assoc_child_loc' => 'Αυτή η τοποθεσία είναι αυτήν τη στιγμή γονέας τουλάχιστον μιας τοποθεσίας παιδιού και δεν μπορεί να διαγραφεί. Ενημερώστε τις τοποθεσίες σας ώστε να μην αναφέρονται πλέον σε αυτήν την τοποθεσία και δοκιμάστε ξανά.',
    'assigned_assets' => 'Αντιστοιχισμένα Στοιχεία Ενεργητικού',
    'current_location' => 'Τρέχουσα Τοποθεσία',
    'deleted_warning' => 'This location has been deleted. Please restore it before attempting to make any changes.',

    'create' => [
        'error' => 'Η τοποθεσία δεν έχει δημιουργηθεί, δοκιμάστε ξανά.',
        'success' => 'Η τοποθεσία δημιουργήθηκε με επιτυχία.',
    ],

    'update' => [
        'error' => 'Η τοποθεσία δεν έχει δημιουργηθεί, δοκιμάστε ξανά',
        'success' => 'Η τοποθεσία αναβαθμίστηκε επιτυχώς.',
    ],

    'restore' => [
        'error' => 'Location was not restored, please try again',
        'success' => 'Location restored successfully.',
    ],

    'delete' => [
        'confirm' => 'Είστε βέβαιοι ότι θέλετε να διαγράψετε αυτήν την τοποθεσία;',
        'error' => 'Παρουσιάστηκε πρόβλημα κατά τη διαγραφή της τοποθεσίας. ΠΑΡΑΚΑΛΩ προσπαθησε ξανα.',
        'success' => 'Η τοποθεσία διαγράφηκε με επιτυχία.',
    ],

    'bulkedit' => [
        'error' => 'Δεν άλλαξαν πεδία, επομένως τίποτα δεν ενημερώθηκε.',
        'success' => 'Location successfully updated.|:count locations successfully updated.',
        'warn' => 'Edit the fields below to update this location. Fields you leave blank will not change on the location.|Edit the fields below to update all :count selected locations. Fields you leave blank will not change on any of them.',
        'show_selected' => '1 selected location|:count selected locations',
        'company_scope_mismatch_partial' => 'The company was not changed on 1 location because items or users at that location belong to different companies. Update or move those first.|The company was not changed on :count locations because items or users at those locations belong to different companies. Update or move those first.',
        'company_scope_mismatch_all' => 'No locations were reassigned. The requested company does not match items or users at the selected location.|No locations were reassigned. The requested company does not match items or users at any of the :count selected locations.',
        'parent_company_mismatch_partial' => 'The parent or company was not changed on 1 location because it would leave the location in a different company than its parent.|The parent or company was not changed on :count locations because it would leave those locations in a different company than their parent.',
        'parent_company_mismatch_all' => 'No changes were saved. The requested parent or company would leave the location in a different company than its parent.|No changes were saved. The requested parent or company would leave every one of the :count selected locations in a different company than their parent.',
    ],

];

<?php

return [

    'deleted' => 'Μοντέλο διαγραμμένων στοιχείων ενεργητικού',
    'does_not_exist' => 'Το μοντέλο δεν υπάρχει.',
    'no_association' => 'ΠΡΟΣΟΧΗ! Το μοντέλο στοιχείων ενεργητικού για αυτό το στοιχείο δεν είναι έγκυρο ή λείπει!',
    'no_association_fix' => 'Αυτό θα σπάσει τα πράγματα με περίεργους και φρικτούς τρόπους. Επεξεργαστείτε αυτό το στοιχείο τώρα για να το αντιστοιχίσετε ένα μοντέλο.',
    'assoc_users' => 'Αυτό το μοντέλο συσχετίζεται επί του παρόντος με ένα ή περισσότερα στοιχεία και δεν μπορεί να διαγραφεί. Διαγράψτε τα στοιχεία και, στη συνέχεια, δοκιμάστε ξανά τη διαγραφή.',
    'invalid_category_type' => 'This category must be an asset category.',

    'create' => [
        'error' => 'Το μοντέλο δεν δημιουργήθηκε, παρακαλώ προσπαθήστε ξανά.',
        'success' => 'Το μοντέλο δημιουργήθηκε με επιτυχία.',
        'duplicate_set' => 'Ένα μοντέλο στοιχείων ενεργητικού με αυτό το όνομα, τον κατασκευαστή και τον αριθμό μοντέλου υπάρχει ήδη.',
    ],

    'update' => [
        'error' => 'Μοντέλο δεν ενημερώθηκε, παρακαλώ προσπαθήστε ξανά',
        'success' => 'Το μοντέλο ενημερώθηκε επιτυχώς.',
    ],

    'delete' => [
        'confirm' => 'Είστε σίγουροι ότι θέλετε να διαγράψετε αυτό το περιουσιακό μοντέλο;',
        'error' => 'Υπήρξε ένα ζήτημα διαγράφοντας αυτό το μοντέλο. Παρακαλώ δοκιμάστε ξανά.',
        'success' => 'Το μοντέλο διαγράφηκε με επιτυχία.',
    ],

    'restore' => [
        'error' => 'Το μοντέλο δεν δημιουργήθηκε, παρακαλώ προσπαθήστε ξανά',
        'success' => 'Το μοντέλο επαναφέρθηκε με επιτυχία.',
    ],

    'bulkedit' => [
        'error' => 'Δεν άλλαξαν πεδία, επομένως τίποτα δεν ενημερώθηκε.',
        'success' => 'Το μοντέλο ενημερώθηκε επιτυχώς. ":model_count μοντέλα ενημερώθηκαν επιτυχώς.',
        'warn' => 'Πρόκειται να ενημερώσετε τις ιδιότητες του ακόλουθου μοντέλου: "Πρόκειται να επεξεργαστείτε τις ιδιότητες των παρακάτω :model_count:',

    ],

    'bulkdelete' => [
        'error' => 'Δεν επιλέχθηκαν πεδία, επομένως τίποτα δεν διαγράφηκε.',
        'nothing_deletable' => 'None of the selected models can be deleted because they still have assets associated with them.',
        'success' => 'Το μοντέλο διαγράφηκε! :success_count μοντέλα διαγράφηκε!',
        'success_partial' => ':success_count model(s) μοντέλα διαγράφηκαν, ωστόσο το :fail_count δεν μπόρεσε να διαγραφεί επειδή εξακολουθούν να έχουν στοιχεία που σχετίζονται με αυτά.',
    ],

    'merge' => [
        'min_two' => 'Select at least two models to merge.',
        'no_target' => 'Select which model to keep before merging.',
        'not_found' => 'One or more of the selected models could not be loaded. Refresh the models list and try again.',
        'information' => 'You are about to merge :count models. Pick the model you want to keep. Every asset attached to the other models will be reassigned to the model you pick, then the source models will be deleted.',
        'warning' => 'This cannot be undone. Reassigned assets will inherit the surviving model\'s category, fieldset, and depreciation settings.',
        'pick_target' => 'Which model do you want to keep?',
        'success' => 'Merged :source_count model(s) into ":target". :asset_count asset(s) were reassigned.',
    ],

];

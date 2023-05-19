<?php

return array(

    'does_not_exist' => 'Το μοντέλο δεν υπάρχει.',
    'no_association' => 'NO MODEL ASSOCIATED.',
    'no_association_fix' => 'This will break things in weird and horrible ways. Edit this asset now to assign it a model.',
    'assoc_users'	 => 'Αυτό το μοντέλο συσχετίζεται επί του παρόντος με ένα ή περισσότερα στοιχεία και δεν μπορεί να διαγραφεί. Διαγράψτε τα στοιχεία και, στη συνέχεια, δοκιμάστε ξανά τη διαγραφή.',


    'create' => array(
        'error'   => 'Το μοντέλο δεν δημιουργήθηκε, παρακαλώ προσπαθήστε ξανά.',
        'success' => 'Το μοντέλο δημιουργήθηκε με επιτυχία.',
        'duplicate_set' => 'Ένα μοντέλο στοιχείων ενεργητικού με αυτό το όνομα, τον κατασκευαστή και τον αριθμό μοντέλου υπάρχει ήδη.',
    ),

    'update' => array(
        'error'   => 'Μοντέλο δεν ενημερώθηκε, παρακαλώ προσπαθήστε ξανά',
        'success' => 'Το μοντέλο ενημερώθηκε επιτυχώς.',
    ),

    'delete' => array(
        'confirm'   => 'Είστε σίγουροι ότι θέλετε να διαγράψετε αυτό το περιουσιακό μοντέλο;',
        'error'   => 'Υπήρξε ένα ζήτημα διαγράφοντας αυτό το μοντέλο. Παρακαλώ δοκιμάστε ξανά.',
        'success' => 'Το μοντέλο διαγράφηκε με επιτυχία.'
    ),

    'restore' => array(
        'error'   		=> 'Το μοντέλο δεν δημιουργήθηκε, παρακαλώ προσπαθήστε ξανά',
        'success' 		=> 'Το μοντέλο επαναφέρθηκε με επιτυχία.'
    ),

    'bulkedit' => array(
        'error'   		=> 'Δεν άλλαξαν πεδία, επομένως τίποτα δεν ενημερώθηκε.',
        'success' 		=> 'Model successfully updated. |:model_count models successfully updated.',
        'warn'          => 'You are about to update the properies of the following model: |You are about to edit the properties of the following :model_count models:',

    ),

    'bulkdelete' => array(
        'error'   		    => 'Δεν επιλέχθηκαν πεδία, επομένως τίποτα δεν διαγράφηκε.',
        'success' 		    => 'Model deleted!|:success_count models deleted!',
        'success_partial' 	=> ':success_count model(s) μοντέλα διαγράφηκαν, ωστόσο το :fail_count δεν μπόρεσε να διαγραφεί επειδή εξακολουθούν να έχουν στοιχεία που σχετίζονται με αυτά.'
    ),

);

<?php

return [

    'deleted' => 'Deleted asset model',
    'does_not_exist' => 'Model ne postoji.',
    'no_association' => 'WARNING! The asset model for this item is invalid or missing!',
    'no_association_fix' => 'This will break things in weird and horrible ways. Edit this asset now to assign it a model.',
    'assoc_users' => 'Ovaj je model trenutno povezan s jednom ili više imovine i ne može se izbrisati. Izbrišite imovinu pa pokušajte ponovo ukloniti.',
    'invalid_category_type' => 'This category must be an asset category.',

    'create' => [
        'error' => 'Model nije izrađen, pokušajte ponovo.',
        'success' => 'Model je uspješno izrađen.',
        'duplicate_set' => 'Model imovine s tim nazivom, proizvođačem i brojem modela već postoji.',
    ],

    'update' => [
        'error' => 'Model nije ažuriran, pokušajte ponovo',
        'success' => 'Model je uspješno ažuriran.',
    ],

    'delete' => [
        'confirm' => 'Jeste li sigurni da želite izbrisati ovaj model sredstva?',
        'error' => 'Došlo je do problema s brisanjem modela. Molim te pokušaj ponovno.',
        'success' => 'Model je uspješno izbrisan.',
    ],

    'restore' => [
        'error' => 'Model nije obnovljen, pokušajte ponovo',
        'success' => 'Model je uspješno obnovljen.',
    ],

    'bulkedit' => [
        'error' => 'Nijedna polja nisu promijenjena, tako da ništa nije ažurirano.',
        'success' => 'Model successfully updated. |:model_count models successfully updated.',
        'warn' => 'You are about to update the properties of the following model:|You are about to edit the properties of the following :model_count models:',

    ],

    'bulkdelete' => [
        'error' => 'Nijedan model nije odabran, tako da ništa nije izbrisano.',
        'nothing_deletable' => 'None of the selected models can be deleted because they still have assets associated with them.',
        'success' => 'Model deleted!|:success_count models deleted!',
        'success_partial' => ':success_count model(a) je izbrisano, no :fail_count nije bilo moguće izbrisati jer još uvijek imaju imovinu povezanu s njima.',
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

<?php

return [

    'deleted' => 'Izbrisan model sredstva',
    'does_not_exist' => 'Model ne obstaja.',
    'no_association' => 'OPOZORILO! Model sredstva za ta element je neveljaven ali manjka!',
    'no_association_fix' => 'To bo zrušilo stvari na čudne in grozljive načine. Uredite to sredstvo zdaj in mu dodelite model.',
    'assoc_users' => 'Ta model je trenutno povezan z enim ali več sredstvi in ​​ga ni mogoče izbrisati. Prosimo, izbrišite sredstva in poskusite zbrisati znova. ',
    'invalid_category_type' => 'Ta kategorija mora biti kategorija sredstva.',

    'create' => [
        'error' => 'Model ni bil ustvarjen, poskusite znova.',
        'success' => 'Model je bil uspešno ustvarjen.',
        'duplicate_set' => 'Model sredstva s tem imenom, proizvajalcem in številko modela že obstaja.',
    ],

    'update' => [
        'error' => 'Model ni bil posodobljen, poskusite znova',
        'success' => 'Model je bil uspešno posodobljen.',
    ],

    'delete' => [
        'confirm' => 'Ali ste prepričani, da želite izbrisati ta model sredstva?',
        'error' => 'Prišlo je do težave pri brisanju modela. Prosim poskusite ponovno.',
        'success' => 'Model je bil uspešno izbrisan.',
    ],

    'restore' => [
        'error' => 'Model ni bil obnovljen, poskusite znova',
        'success' => 'Model je bil uspešno obnovljen.',
    ],

    'bulkedit' => [
        'error' => 'Polja niso bila spremenjena, nič ni posodobljeno.',
        'success' => 'Model je bil uspešno posodobljen. |:model_count modeli uspešno posodobljeni.',
        'warn' => 'Posodobili boste lastnosti naslednjega modela:|Urejali boste lastnosti naslednjega :model_count modeli:',

    ],

    'bulkdelete' => [
        'error' => 'Modeli niso bili izbrani, nič ni izbrisano.',
        'nothing_deletable' => 'None of the selected models can be deleted because they still have assets associated with them.',
        'success' => 'Model izbrisan!|:success_count modeli izbrisani!',
        'success_partial' => ': modeli so bili izbrisani, vendar: fail_count ni bilo mogoče izbrisati, ker so še vedno sredstva, povezana z njimi.',
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

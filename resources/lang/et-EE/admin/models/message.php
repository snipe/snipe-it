<?php

return [

    'deleted' => 'Deleted asset model',
    'does_not_exist' => 'Mudelit pole olemas.',
    'no_association' => 'WARNING! The asset model for this item is invalid or missing!',
    'no_association_fix' => 'This will break things in weird and horrible ways. Edit this asset now to assign it a model.',
    'assoc_users' => 'See mudel on seostus ühe või mitme vahendiga ja seda ei saa kustutada. Palun kustuta vahendid ja seejärel proovi uuesti kustutada. ',
    'invalid_category_type' => 'This category must be an asset category.',

    'create' => [
        'error' => 'Mudelit ei loodud, proovi uuesti.',
        'success' => 'Mudeli loomine õnnestus.',
        'duplicate_set' => 'Sellise nime, tootja ja mudeli numbriga mudel on juba olemas.',
    ],

    'update' => [
        'error' => 'Mudelit ei uuendatud, proovige uuesti',
        'success' => 'Mudeli uuendamine õnnestus.',
    ],

    'delete' => [
        'confirm' => 'Kas oled kindel, et soovid selle mudeli kustutada?',
        'error' => 'Mudeli kustutamisel tekkis probleem. Palun proovi uuesti.',
        'success' => 'Mudeli kustutamine õnnestus.',
    ],

    'restore' => [
        'error' => 'Mudeli taastamine ei õnnestunud, proovi uuesti',
        'success' => 'Mudeli taastamine õnnestus.',
    ],

    'bulkedit' => [
        'error' => 'Ühtegi välja ei muudetud, uuendusi ei tehtud',
        'success' => 'Model successfully updated. |:model_count models successfully updated.',
        'warn' => 'You are about to update the properties of the following model:|You are about to edit the properties of the following :model_count models:',

    ],

    'bulkdelete' => [
        'error' => 'Mudeleid ei valitud, nii et midagi ei kustutatud.',
        'nothing_deletable' => 'None of the selected models can be deleted because they still have assets associated with them.',
        'success' => 'Model deleted!|:success_count models deleted!',
        'success_partial' => ':success_count mudel(it) kustutati, kuid :fail_count ei õnnestunud kustutada kuna nendega on ikka veel vara seotud.',
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

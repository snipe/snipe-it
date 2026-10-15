<?php

return [

    'deleted' => 'Deleted asset model',
    'does_not_exist' => 'Ang modelo ay hindi umiiral.',
    'no_association' => 'WARNING! The asset model for this item is invalid or missing!',
    'no_association_fix' => 'This will break things in weird and horrible ways. Edit this asset now to assign it a model.',
    'assoc_users' => 'Ang modelong ito ay kasalukuyang nai-ugnay sa isa o higit pang mga asset at hindi maaaring mai-delete. Paki-delete ng mga model na ito, at pagkatapos subukang i-delete muli. ',
    'invalid_category_type' => 'This category must be an asset category.',

    'create' => [
        'error' => 'Ang modelo ay hindi naisagawa, mangyaring subukang muli.',
        'success' => 'Ang modelo ay matagumpay na naisagawa.',
        'duplicate_set' => 'Ang modelo ng asset na may ganyang pangalan, ang tagapagsagawa at ang modelo ay umiiral na.',
    ],

    'update' => [
        'error' => 'Ang modelo ay hindi nai-update, mangyaring subukang muli',
        'success' => 'Ang modelo ay matagumpay na nai-update.',
    ],

    'delete' => [
        'confirm' => 'Sigurado kaba na gusto mong i-delete ang modelo ng asset?',
        'error' => 'Mayroong isyu sa pag-delete ng modelo. Mangyaring subukang muli.',
        'success' => 'Matagumpay na nai-delete ang modelo.',
    ],

    'restore' => [
        'error' => 'Ang modelo ay hindi naibalik sa dati, mangyaring subukang muli',
        'success' => 'Ang modelo ay matagumpay na naibalik.',
    ],

    'bulkedit' => [
        'error' => 'Walang nabagong mga field, kaya walang nai-update.',
        'success' => 'Model successfully updated. |:model_count models successfully updated.',
        'warn' => 'You are about to update the properties of the following model:|You are about to edit the properties of the following :model_count models:',

    ],

    'bulkdelete' => [
        'error' => 'Walang napiling mga model, kaya walang nai-delete.',
        'nothing_deletable' => 'None of the selected models can be deleted because they still have assets associated with them.',
        'success' => 'Model deleted!|:success_count models deleted!',
        'success_partial' => ':success_count ang mga modelo ay na-delete na, gayunpaman ::success_count ang mga modelo ay hindi mai-delete dahil sa mayron pa silang asset na naiuugnay sa kanila.',
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

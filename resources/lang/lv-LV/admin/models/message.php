<?php

return [

    'deleted' => 'Deleted asset model',
    'does_not_exist' => 'Modelis nepastāv.',
    'no_association' => 'WARNING! The asset model for this item is invalid or missing!',
    'no_association_fix' => 'This will break things in weird and horrible ways. Edit this asset now to assign it a model.',
    'assoc_users' => 'Šobrīd šis modelis ir saistīts ar vienu vai vairākiem aktīviem, un tos nevar izdzēst. Lūdzu, izdzēsiet aktīvus un pēc tam mēģiniet vēlreiz dzēst.',
    'invalid_category_type' => 'This category must be an asset category.',

    'create' => [
        'error' => 'Modelis netika izveidots, lūdzu, mēģiniet vēlreiz.',
        'success' => 'Modelis veiksmīgi izveidots.',
        'duplicate_set' => 'Aktīvu modelis ar šo nosaukumu, ražotāju un modeļa numuru jau pastāv.',
    ],

    'update' => [
        'error' => 'Modelis nav atjaunināts, lūdzu, mēģiniet vēlreiz',
        'success' => 'Modelis tika veiksmīgi atjaunināts.',
    ],

    'delete' => [
        'confirm' => 'Vai tiešām vēlaties dzēst šo aktīvu modeli?',
        'error' => 'Radās problēma, izdzēšot modeli. Lūdzu mēģiniet vēlreiz.',
        'success' => 'Modelis tika veiksmīgi dzēsts.',
    ],

    'restore' => [
        'error' => 'Modelis netika atjaunots, lūdzu, mēģiniet vēlreiz',
        'success' => 'Veiksmīgi atjaunots modelis.',
    ],

    'bulkedit' => [
        'error' => 'Neviens laukums netika mainīts, tāpēc nekas netika atjaunināts.',
        'success' => 'Model successfully updated. |:model_count models successfully updated.',
        'warn' => 'You are about to update the properties of the following model:|You are about to edit the properties of the following :model_count models:',

    ],

    'bulkdelete' => [
        'error' => 'Nav atlasītu modeļu, tāpēc nekas netika izdzēsts.',
        'nothing_deletable' => 'None of the selected models can be deleted because they still have assets associated with them.',
        'success' => 'Model deleted!|:success_count models deleted!',
        'success_partial' => ':success_count modeļi dzēsti, tomēr :fail_count nevarēja tik dzēsti, jo tiem ir piesaistītas aparatūras.',
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

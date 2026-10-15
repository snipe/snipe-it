<?php

return [

    'deleted' => 'Deleted asset model',
    'does_not_exist' => 'Kāore te tauira i te tīariari.',
    'no_association' => 'WARNING! The asset model for this item is invalid or missing!',
    'no_association_fix' => 'This will break things in weird and horrible ways. Edit this asset now to assign it a model.',
    'assoc_users' => 'Kei te hono tenei tauira ki te kotahi, neke atu ranei nga rawa, kaore e taea te muku. Nganahia nga rawa, ka ngana ki te muku ano.',
    'invalid_category_type' => 'This category must be an asset category.',

    'create' => [
        'error' => 'Kāore i hangaia te tauira, tēnā whakamātau anō.',
        'success' => 'I waihangahia te tauira i pai.',
        'duplicate_set' => 'Ko te tauira o te taonga me te ingoa, te kaiwhakanao me te tau tauira kei te noho tonu.',
    ],

    'update' => [
        'error' => 'Kāore i te whakahouhia te tauira, na me ngana ano',
        'success' => 'He pai te whakahoutanga o te tauira.',
    ],

    'delete' => [
        'confirm' => 'Kei te hiahia koe ki te muku i tenei tauira taonga?',
        'error' => 'I puta he take e whakakore ana i te tauira. Tena ngana ano.',
        'success' => 'Kua mukua te tauira.',
    ],

    'restore' => [
        'error' => 'Kaore ano kia whakahokia mai te tauira, na me ngana ano',
        'success' => 'He tauira kua whakahokia mai.',
    ],

    'bulkedit' => [
        'error' => 'Kaore i whakarereke nga mara, naore i whakahoutia.',
        'success' => 'Model successfully updated. |:model_count models successfully updated.',
        'warn' => 'You are about to update the properties of the following model:|You are about to edit the properties of the following :model_count models:',

    ],

    'bulkdelete' => [
        'error' => 'No models were selected, so nothing was deleted.',
        'nothing_deletable' => 'None of the selected models can be deleted because they still have assets associated with them.',
        'success' => 'Model deleted!|:success_count models deleted!',
        'success_partial' => ':success_count model(s) were deleted, however :fail_count were unable to be deleted because they still have assets associated with them.',
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

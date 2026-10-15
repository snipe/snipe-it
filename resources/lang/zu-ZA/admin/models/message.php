<?php

return [

    'deleted' => 'Deleted asset model',
    'does_not_exist' => 'Isibonelo asikho.',
    'no_association' => 'WARNING! The asset model for this item is invalid or missing!',
    'no_association_fix' => 'This will break things in weird and horrible ways. Edit this asset now to assign it a model.',
    'assoc_users' => 'Lo modeli okwamanje uhlotshaniswa nefa elilodwa noma ngaphezulu futhi alinakususwa. Sicela ususe amafa, bese uzama ukususa futhi.',
    'invalid_category_type' => 'This category must be an asset category.',

    'create' => [
        'error' => 'Isibonelo asizange sidalwe, sicela uzame futhi.',
        'success' => 'Isibonelo sidalwe ngempumelelo.',
        'duplicate_set' => 'Imodeli yezimpahla ngelo gama, umkhiqizi kanye nenombolo yomodeli kakade ikhona.',
    ],

    'update' => [
        'error' => 'Isibonelo asibuyekezwanga, sicela uzame futhi',
        'success' => 'Isibonelo sibuyekezwe ngempumelelo.',
    ],

    'delete' => [
        'confirm' => 'Ingabe uqinisekile ukuthi ufisa ukususa le model?',
        'error' => 'Kube nenkinga yokususa imodeli. Ngicela uzame futhi.',
        'success' => 'Imodeli isusiwe ngempumelelo.',
    ],

    'restore' => [
        'error' => 'Isibonelo asibuyisiwe, sicela uzame futhi',
        'success' => 'Isibonelo sibuyiselwe ngempumelelo.',
    ],

    'bulkedit' => [
        'error' => 'Azikho amasimu ashintshiwe, ngakho akukho lutho olubuyekeziwe.',
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

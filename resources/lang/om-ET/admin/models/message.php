<?php

return [

    'deleted' => 'Deleted asset model',
    'does_not_exist' => 'Model does not exist.',
    'no_association' => 'WARNING! The asset model for this item is invalid or missing!',
    'no_association_fix' => 'This will break things in weird and horrible ways. Edit this asset now to assign it a model.',
    'assoc_users' => 'This model is currently associated with one or more assets and cannot be deleted. Please delete the assets, and then try deleting again. ',
    'invalid_category_type' => 'This category must be an asset category.',

    'create' => [
        'error' => 'Model was not created, please try again.',
        'success' => 'Model created successfully.',
        'duplicate_set' => 'An asset model with that name, manufacturer and model number already exists.',
    ],

    'update' => [
        'error' => 'Model was not updated, please try again',
        'success' => 'Model updated successfully.',
    ],

    'delete' => [
        'confirm' => 'Are you sure you wish to delete this asset model?',
        'error' => 'There was an issue deleting the model. Please try again.',
        'success' => 'The model was deleted successfully.',
    ],

    'restore' => [
        'error' => 'Model was not restored, please try again',
        'success' => 'Model restored successfully.',
    ],

    'bulkedit' => [
        'error' => 'No fields were changed, so nothing was updated.',
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

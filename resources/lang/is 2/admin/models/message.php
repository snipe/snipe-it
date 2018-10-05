<?php

return array(

    'does_not_exist' => 'Model does not exist.',
    'assoc_users'	 => 'This model is currently associated with one or more assets and cannot be deleted. Please delete the assets, and then try deleting again. ',


    'create' => array(
        'error'   => 'Model was not created, please try again.',
        'success' => 'Model created successfully.',
        'duplicate_set' => 'An asset model with that name, manufacturer and model number already exists.',
    ),

    'update' => array(
        'error'   => 'Model was not updated, please try again',
        'success' => 'Model updated successfully.'
    ),

    'delete' => array(
        'confirm'   => 'Are you sure you wish to delete this asset model?',
        'error'   => 'There was an issue deleting the model. Please try again.',
        'success' => 'The model was deleted successfully.'
    ),

    'restore' => array(
        'error'   		=> 'Model was not restored, please try again',
        'success' 		=> 'Model restored successfully.'
    ),

    'bulkedit' => array(
        'error'   		=> 'No fields were changed, so nothing was updated.',
        'success' 		=> 'Models updated.'
    ),

    'bulkdelete' => array(
        'error'   		    => 'No models were selected, so nothing was deleted.',
        'success' 		    => ':success_count model(s) deleted!',
        'success_partial' 	=> ':success_count model(s) were deleted, however :fail_count were unable to be deleted because they still have assets associated with them.'
    ),

);

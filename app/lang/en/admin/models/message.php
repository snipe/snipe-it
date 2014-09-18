<?php

return array(

    'does_not_exist' => 'Model does not exist.',
    'assoc_users'	 => 'This model is currently associated with one or more assets and cannot '
                          . 'be deleted. Please delete the assets, and then try deleting again. ',


    'create' => array(
        'error'   => 'Model was not created, please try again.',
        'success' => 'Model created successfully.'
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
    
    'about'         => 'Asset models provide grouping and classification for different physical '
                    . 'assets. A model item should be created for each unique model number you want '
                    . 'to capture and track. <br><br>Models are assigned to physical assets by selecting the '
                    . 'model from the drop-down located on the asset edit/create form.',

);

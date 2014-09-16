<?php

return array(

    'does_not_exist' => 'Manufacturer does not exist.',
    'assoc_users'	 => 'This manufacturer is currently associated with at least one '
                            . 'model and cannot be deleted. Please update your models to no longer '
                            . 'reference this manufacturer and try again. ',

    'create' => array(
        'error'   => 'Manufacturer was not created, please try again.',
        'success' => 'Manufacturer created successfully.'
    ),

    'update' => array(
        'error'   => 'Manufacturer was not updated, please try again',
        'success' => 'Manufacturer updated successfully.'
    ),

    'delete' => array(
        'confirm'   => 'Are you sure you wish to delete this manufacturer?',
        'error'   => 'There was an issue deleting the blog post. Please try again.',
        'success' => 'The Manufacturer was deleted successfully.'
    ),
    
    'about'     => 'Assigning manufacturers will help you organize your assets and licenses '
                . 'by groups. Some examples include &quot;Cisco&quot;, &quot;Toshiba&quot;, '
                . '&quot;Microsoft&quot;, &quot;Adobe&quot;, etc., but you can use manufacturers '
                . 'any way that makes sense for you.<BR><BR>You cannot delete a manufacturer in '
                . 'use by assets or software licenses.',

);

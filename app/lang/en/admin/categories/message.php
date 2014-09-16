<?php

return array(

    'does_not_exist'    => 'Category does not exist.',
    
    'assoc_users'	=> 'This category is currently associated with at least one model '
                            . 'and cannot be deleted. Please update your models to no longer '
                            . 'reference this category and try again. ',
    
    'about'             => 'Asset categories help you organize your assets. Some example categories might '
                           . 'be &quot;Desktops&quot;, &quot;Laptops&quot;, &quot;Mobile Phones&quot;, &quot;Tablets&quot;, '
                           . 'and so on, but you can use asset categories any way that makes sense for you.<BR><BR>You cannot '
                           . 'delete an asset category in use by any assets.',

    'create' => array(
        'error'   => 'Category was not created, please try again.',
        'success' => 'Category created successfully.'
    ),

    'update' => array(
        'error'   => 'Category was not updated, please try again',
        'success' => 'Category updated successfully.'
    ),

    'delete' => array(
        'confirm'   => 'Are you sure you wish to delete this category?',
        'error'   => 'There was an issue deleting the category. Please try again.',
        'success' => 'The category was deleted successfully.'
    )

);

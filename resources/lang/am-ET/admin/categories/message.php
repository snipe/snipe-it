<?php

return [

    'does_not_exist' => 'መደቡ የለም አልተገኘም.',
    'assoc_models' => 'This category is currently associated with at least one model and cannot be deleted. Please update your models to no longer reference this category and try again. ',
    'assoc_items' => 'This category is currently associated with at least one :asset_type and cannot be deleted. Please update your :asset_type  to no longer reference this category and try again. ',

    'create' => [
        'error' => 'Category was not created, please try again.',
        'success' => 'Category created successfully.',
    ],

    'update' => [
        'error' => 'Category was not updated, please try again',
        'success' => 'Category updated successfully.',
        'cannot_change_category_type' => 'You cannot change the category type once it has been created',
    ],

    'delete' => [
        'confirm' => 'Are you sure you wish to delete this category?',
        'error' => 'There was an issue deleting the category. Please try again.',
        'success' => 'Category was deleted successfully.',
        'bulk_success' => 'Category deleted successfully.|:count categories were deleted successfully.',
        'partial_success' => 'Category deleted successfully. See additional information below. | :count categories were deleted successfully. See additional information below.',
    ],

    'bulkedit' => [
        'warn' => 'You are about to edit the properties of the following category:|You are about to edit the properties of the following :count categories:',
        'no_selection' => 'You must select at least one category to edit.',
        'no_changes' => 'No fields were changed, so nothing was updated.',
        'success' => 'Category successfully updated.|:count categories successfully updated.',
    ],

];

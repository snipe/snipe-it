<?php

return [

    'does_not_exist' => 'Component does not exist.',

    'create' => [
        'error' => 'Component was not created, please try again.',
        'success' => 'Component created successfully.',
    ],

    'update' => [
        'error' => 'Component was not updated, please try again',
        'success' => 'Component updated successfully.',
    ],

    'delete' => [
        'confirm' => 'Are you sure you wish to delete this component?',
        'error' => 'There was an issue deleting the component. Please try again.',
        'success' => 'The component was deleted successfully.',
        'error_qty' => 'Some components of this type are still checked out. Please check them in and try again.',
    ],

    'checkout' => [
        'error' => 'Component was not checked out, please try again',
        'success' => 'Component checked out successfully.',
        'user_does_not_exist' => 'That user is invalid. Please try again.',
        'unavailable' => 'Not enough components remaining: :remaining remaining, :requested requested ',
        'archived' => 'That component has been archived and cannot be checked out. Un-archive it first on the component edit screen.',
    ],

    'archived_blocked_by_checkouts' => 'This component still has active checkouts. Check them back in before archiving.',

    'bulk' => [
        'no_components_selected' => 'No components were selected.',
        'no_action_selected' => 'Please pick an action from the dropdown.',
        'no_fields_updated' => 'No fields were changed, so nothing was updated.',
        'skipped_unauthorized' => ':count component(s) were skipped because you do not have permission to update them.',

        'update' => [
            'success' => ':count component was updated.|:count components were updated.',
        ],

        'delete' => [
            'success' => ':count component was deleted.|:count components were deleted.',
            'partial_success' => ':count component was deleted. See errors below for the rest.|:count components were deleted. See errors below for the rest.',
        ],

        'checkin_selected' => [
            'no_rows_selected' => 'No checked-out components were selected.',
            'success' => ':count checked-out component was returned.|:count checked-out components were returned.',
        ],
    ],

    'checkin' => [
        'error' => 'Component was not checked in, please try again',
        'success' => 'Component checked in successfully.',
        'user_does_not_exist' => 'That user is invalid. Please try again.',
    ],

];

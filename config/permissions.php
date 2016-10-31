<?php

return array(

    'Global' => array(
        array(
            'permission' => 'superuser',
            'label'      => 'Super User',
            'note'       => 'Determines whether the user has full access to all aspects of the admin. This setting overrides any more specific permissions throughout the system. ',
            'display'    => true,
        ),
    ),

    'Admin' => array(
        array(
            'permission' => 'admin',
            'label'      => '',
            'note'       => 'Determines whether the user has access to most aspects of the admin. ',
            'display'    => true,
        ),
        array(
            'permission' => 'admin.api_key',
            'label'      => 'Create API Key',
            'note'       => 'Determines whether the user can access the API via API key.',
            'display'    => false,
        ),
    ),

    'Reports' => array(
        array(
            'permission' => 'reports.view',
            'label'      => 'View',
            'note'       => 'Determines whether the user has the ability to view reports.',
            'display'    => true,
        ),
    ),

    'Assets' => array(
        array(
            'permission' => 'assets.view',
            'label'      => 'View ',
            'note'       => '',
            'display'    => true,
        ),
        array(
            'permission' => 'assets.create',
            'label'      => 'Create ',
            'note'       => '',
            'display'    => true,
        ),
        array(
            'permission' => 'assets.edit',
            'label'      => 'Edit  ',
            'note'       => '',
            'display'    => true,
        ),
        array(
            'permission' => 'assets.delete',
            'label'      => 'Delete ',
            'note'       => '',
            'display'    => true,
        ),
        array(
            'permission' => 'assets.checkout',
            'label'      => 'Checkout ',
            'note'       => '',
            'display'    => false,
        ),

        array(
            'permission' => 'assets.checkin',
            'label'      => 'Checkin ',
            'note'       => '',
            'display'    => true,
        ),

        array(
            'permission' => 'assets.checkout',
            'label'      => 'Checkout ',
            'note'       => '',
            'display'    => true,
        ),

        array(
            'permission' => 'assets.audit',
            'label'      => 'Audit ',
            'note'       => '',
            'display'    => false,
        ),


        array(
            'permission' => 'assets.view.requestable',
            'label'      => 'View Requestable Assets',
            'note'       => '',
            'display'    => true,
        ),

    ),

    'Accessories' => array(
        array(
            'permission' => 'accessories.view',
            'label'      => 'View ',
            'note'       => '',
            'display'    => true,
        ),
        array(
            'permission' => 'accessories.create',
            'label'      => 'Create ',
            'note'       => '',
            'display'    => true,
        ),
        array(
            'permission' => 'accessories.edit',
            'label'      => 'Edit ',
            'note'       => '',
            'display'    => true,
        ),
        array(
            'permission' => 'accessories.delete',
            'label'      => 'Delete ',
            'note'       => '',
            'display'    => true,
        ),
        array(
            'permission' => 'accessories.checkout',
            'label'      => 'Checkout ',
            'note'       => '',
            'display'    => true,
        ),
        array(
            'permission' => 'accessories.checkin',
            'label'      => 'Checkin ',
            'note'       => '',
            'display'    => true,
        ),
    ),

    'Consumables' => array(
        array(
            'permission' => 'consumables.view',
            'label'      => 'View',
            'note'       => '',
            'display'    => true,
        ),
        array(
            'permission' => 'consumables.create',
            'label'      => 'Create ',
            'note'       => '',
            'display'    => true,
        ),
        array(
            'permission' => 'consumables.edit',
            'label'      => 'Edit ',
            'note'       => '',
            'display'    => true,
        ),
        array(
            'permission' => 'consumables.delete',
            'label'      => 'Delete ',
            'note'       => '',
            'display'    => true,
        ),
        array(
            'permission' => 'consumables.checkout',
            'label'      => 'Checkout ',
            'note'       => '',
            'display'    => true,
        ),
    ),


    'Licenses' => array(
        array(
            'permission' => 'licenses.view',
            'label'      => 'View',
            'note'       => '',
            'display'    => true,
        ),
        array(
            'permission' => 'licenses.create',
            'label'      => 'Create ',
            'note'       => '',
            'display'    => true,
        ),
        array(
            'permission' => 'licenses.edit',
            'label'      => 'Edit ',
            'note'       => '',
            'display'    => true,
        ),
        array(
            'permission' => 'licenses.delete',
            'label'      => 'Delete ',
            'note'       => '',
            'display'    => true,
        ),
        array(
            'permission' => 'licenses.checkout',
            'label'      => 'Checkout ',
            'note'       => '',
            'display'    => true,
        ),
        array(
            'permission' => 'licenses.keys',
            'label'      => 'View License Keys',
            'note'       => '',
            'display'    => true,
        ),
    ),


    'Components' => array(
        array(
            'permission' => 'components.view',
            'label'      => 'View',
            'note'       => '',
            'display'    => true,
        ),
        array(
            'permission' => 'components.create',
            'label'      => 'Create ',
            'note'       => '',
            'display'    => true,
        ),
        array(
            'permission' => 'components.edit',
            'label'      => 'Edit ',
            'note'       => '',
            'display'    => true,
        ),
        array(
            'permission' => 'components.delete',
            'label'      => 'Delete ',
            'note'       => '',
            'display'    => true,
        ),
        array(
            'permission' => 'components.checkout',
            'label'      => 'Checkout ',
            'note'       => '',
            'display'    => true,
        ),
        array(
            'permission' => 'components.checkin',
            'label'      => 'Checkin ',
            'note'       => '',
            'display'    => true,
        ),

    ),

    'Users' => array(
        array(
            'permission' => 'users.view',
            'label'      => 'View ',
            'note'       => '',
            'display'    => true,
        ),
        array(
            'permission' => 'users.create',
            'label'      => 'Create Users',
            'note'       => '',
            'display'    => true,
        ),
        array(
            'permission' => 'users.edit',
            'label'      => 'Edit Users',
            'note'       => '',
            'display'    => true,
        ),
        array(
            'permission' => 'users.delete',
            'label'      => 'Delete Users',
            'note'       => '',
            'display'    => true,
        ),

    ),

    'Self' => array(
        array(
            'permission' => 'self.two_factor',
            'label'      => 'Two-Factor Authentication',
            'note'       => 'The user may disable/enable two-factor authentication themselves if two-factor is enabled and set to selective.',
            'display'    => true,
        ),

    ),




);

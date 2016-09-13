<?php

return [

    'Global' => [
        [
            'permission' => 'superuser',
            'label'      => 'Super User',
            'note'       => 'Determines whether the user has full access to all aspects of the admin. This setting overrides any more specific permissions throughout the system. ',
            'display'    => true,
        ],
    ],

    'Admin' => [
        [
            'permission' => 'admin',
            'label'      => '',
            'note'       => 'Determines whether the user has access to most aspects of the admin. ',
            'display'    => true,
        ],
        [
            'permission' => 'admin.api_key',
            'label'      => 'Create API Key',
            'note'       => 'Determines whether the user can access the API via API key.',
            'display'    => false,
        ],
    ],

    'Reports' => [
        [
            'permission' => 'reports.view',
            'label'      => 'View',
            'note'       => 'Determines whether the user has the ability to view reports.',
            'display'    => true,
        ],
    ],

    'Assets' => [
        [
            'permission' => 'assets.view',
            'label'      => 'View ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'assets.create',
            'label'      => 'Create ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'assets.edit',
            'label'      => 'Edit  ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'assets.delete',
            'label'      => 'Delete ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'assets.checkout',
            'label'      => 'Checkout ',
            'note'       => '',
            'display'    => false,
        ],

        [
            'permission' => 'assets.checkin',
            'label'      => 'Checkin ',
            'note'       => '',
            'display'    => true,
        ],

        [
            'permission' => 'assets.checkout',
            'label'      => 'Checkout ',
            'note'       => '',
            'display'    => true,
        ],

        [
            'permission' => 'assets.audit',
            'label'      => 'Audit ',
            'note'       => '',
            'display'    => false,
        ],


        [
            'permission' => 'assets.view.requestable',
            'label'      => 'View Requestable Assets',
            'note'       => '',
            'display'    => true,
        ],

    ],

    'Accessories' => [
        [
            'permission' => 'accessories.view',
            'label'      => 'View ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'accessory.create',
            'label'      => 'Create ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'accessories.edit',
            'label'      => 'Edit ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'accessories.delete',
            'label'      => 'Delete ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'accessories.checkout',
            'label'      => 'Checkout ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'accessories.checkin',
            'label'      => 'Checkin ',
            'note'       => '',
            'display'    => true,
        ],
    ],

    'Consumables' => [
        [
            'permission' => 'consumables.view',
            'label'      => 'View',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'consumables.create',
            'label'      => 'Create ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'consumables.edit',
            'label'      => 'Edit ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'consumables.delete',
            'label'      => 'Delete ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'consumables.checkout',
            'label'      => 'Checkout ',
            'note'       => '',
            'display'    => true,
        ],
    ],


    'Licenses' => [
        [
            'permission' => 'licenses.view',
            'label'      => 'View',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'licenses.create',
            'label'      => 'Create ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'licenses.edit',
            'label'      => 'Edit ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'licenses.delete',
            'label'      => 'Delete ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'licenses.checkout',
            'label'      => 'Checkout ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'licenses.keys',
            'label'      => 'View License Keys',
            'note'       => '',
            'display'    => true,
        ],
    ],


    'Components' => [
        [
            'permission' => 'components.view',
            'label'      => 'View',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'components.create',
            'label'      => 'Create ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'components.edit',
            'label'      => 'Edit ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'components.delete',
            'label'      => 'Delete ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'components.checkout',
            'label'      => 'Checkout ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'components.checkin',
            'label'      => 'Checkin ',
            'note'       => '',
            'display'    => true,
        ],

    ],

    'Users' => [
        [
            'permission' => 'users.view',
            'label'      => 'View ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'users.create',
            'label'      => 'Create Users',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'users.edit',
            'label'      => 'Edit Users',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'users.delete',
            'label'      => 'Delete Users',
            'note'       => '',
            'display'    => true,
        ],

    ],




];

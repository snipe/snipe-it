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
            'display'    => false,
        ),
        array(
            'permission' => 'assets.edit',
            'label'      => 'Edit ',
            'note'       => '',
            'display'    => false,
        ),
        array(
            'permission' => 'assets.delete',
            'label'      => 'Delete ',
            'note'       => '',
            'display'    => false,
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
            'display'    => false,
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
            'permission' => 'accessory.create',
            'label'      => 'Create ',
            'note'       => '',
            'display'    => false,
        ),
        array(
            'permission' => 'accessories.edit',
            'label'      => 'Edit ',
            'note'       => '',
            'display'    => false,
        ),
        array(
            'permission' => 'accessories.delete',
            'label'      => 'Delete ',
            'note'       => '',
            'display'    => false,
        ),
        array(
            'permission' => 'accessories.checkout',
            'label'      => 'Checkout ',
            'note'       => '',
            'display'    => false,
        ),
        array(
            'permission' => 'accessories.checkin',
            'label'      => 'Checkin ',
            'note'       => '',
            'display'    => false,
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
            'display'    => false,
        ),
        array(
            'permission' => 'consumables.edit',
            'label'      => 'Edit ',
            'note'       => '',
            'display'    => false,
        ),
        array(
            'permission' => 'consumables.delete',
            'label'      => 'Delete ',
            'note'       => '',
            'display'    => false,
        ),
        array(
            'permission' => 'consumables.checkout',
            'label'      => 'Checkout ',
            'note'       => '',
            'display'    => false,
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
            'label'      => 'Create Licenses',
            'note'       => '',
            'display'    => false,
        ),
        array(
            'permission' => 'licenses.edit',
            'label'      => 'Edit Licenses',
            'note'       => '',
            'display'    => false,
        ),
        array(
            'permission' => 'licenses.delete',
            'label'      => 'Delete Licenses',
            'note'       => '',
            'display'    => false,
        ),
        array(
            'permission' => 'licenses.checkout',
            'label'      => 'Checkout Licenses',
            'note'       => '',
            'display'    => false,
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
            'label'      => 'Create Components',
            'note'       => '',
            'display'    => false,
        ),
        array(
            'permission' => 'components.edit',
            'label'      => 'Edit Components',
            'note'       => '',
            'display'    => false,
        ),
        array(
            'permission' => 'components.delete',
            'label'      => 'Delete Components',
            'note'       => '',
            'display'    => false,
        ),
        array(
            'permission' => 'components.checkout',
            'label'      => 'Checkout Components',
            'note'       => '',
            'display'    => false,
        ),
        array(
            'permission' => 'components.checkin',
            'label'      => 'Checkin Components',
            'note'       => '',
            'display'    => false,
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
            'display'    => false,
        ),
        array(
            'permission' => 'users.edit',
            'label'      => 'Edit Users',
            'note'       => '',
            'display'    => false,
        ),
        array(
            'permission' => 'users.delete',
            'label'      => 'Delete Users',
            'note'       => '',
            'display'    => false,
        ),

    ),




);

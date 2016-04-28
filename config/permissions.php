<?php

return array(

    'Global' => array(
        array(
            'permission' => 'superuser',
            'label'      => 'Super User',
            'note'       => 'Determines whether the user has full access to all aspects of the admin. ',
            'display'    => true,
        ),
    ),

    'Admin' => array(
        array(
            'permission' => 'admin',
            'label'      => '',
            'note'       => 'Determines whether the user has access to most aspects of the admin.',
            'display'    => true,
        ),
    ),

    'Reports' => array(
        array(
            'permission' => 'reports.view',
            'label'      => '',
            'note'       => 'Determines whether the user has the abiity to view reports.',
            'display'    => true,
        ),
    ),

    'Assets' => array(
        array(
            'permission' => 'assets.view',
            'label'      => '',
            'note'       => '',
            'display'    => false,
        ),
        array(
            'permission' => 'assets.create',
            'label'      => 'Create Assets',
            'note'       => '',
            'display'    => false,
        ),
        array(
            'permission' => 'assets.edit',
            'label'      => 'Edit Assets',
            'note'       => '',
            'display'    => false,
        ),
        array(
            'permission' => 'assets.delete',
            'label'      => 'Delete Assets',
            'note'       => '',
            'display'    => false,
        ),
        array(
            'permission' => 'assets.checkout',
            'label'      => 'View Assets',
            'note'       => '',
            'display'    => false,
        ),
    ),

    'Accessories' => array(
        array(
            'permission' => 'accessories.view',
            'label'      => '',
            'note'       => '',
            'display'    => false,
        ),
        array(
            'permission' => 'accessory.create',
            'label'      => 'Create Assets',
            'note'       => '',
            'display'    => false,
        ),
        array(
            'permission' => 'accessories.edit',
            'label'      => 'Edit Assets',
            'note'       => '',
            'display'    => false,
        ),
        array(
            'permission' => 'accessories.delete',
            'label'      => 'Delete Assets',
            'note'       => '',
            'display'    => false,
        ),
        array(
            'permission' => 'accessories.checkout',
            'label'      => 'View Assets',
            'note'       => '',
            'display'    => false,
        ),
    ),

    'Consumables' => array(
        array(
            'permission' => 'consumables.view',
            'label'      => '',
            'note'       => '',
            'display'    => false,
        ),
        array(
            'permission' => 'consumables.create',
            'label'      => 'Create Consumables',
            'note'       => '',
            'display'    => false,
        ),
        array(
            'permission' => 'consumables.edit',
            'label'      => 'Edit Consumables',
            'note'       => '',
            'display'    => false,
        ),
        array(
            'permission' => 'consumables.delete',
            'label'      => 'Delete Consumables',
            'note'       => '',
            'display'    => false,
        ),
        array(
            'permission' => 'consumables.checkout',
            'label'      => 'Checkout Consumables',
            'note'       => '',
            'display'    => false,
        ),
    ),


    'Licenses' => array(
        array(
            'permission' => 'licenses.view',
            'label'      => '',
            'note'       => '',
            'display'    => false,
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
            'label'      => '',
            'note'       => '',
            'display'    => false,
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

    ),

    'Users' => array(
        array(
            'permission' => 'users.view',
            'label'      => 'View Users',
            'note'       => '',
            'display'    => false,
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

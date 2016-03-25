<?php

return array(

    'Global' => array(
        array(
            'permission' => 'superuser',
            'label'      => 'Super User',
            'note'       => 'Determines whether the user has full access to all aspects of the admin. ',
        ),
    ),

    'Admin' => array(
        array(
            'permission' => 'admin',
            'label'      => 'Admin Rights',
            'note'       => 'Determines whether the user has access to most aspects of the admin.',
        ),
    ),

    'Reporting' => array(
        array(
            'permission' => 'reports',
            'label'      => 'View Reports',
            'note'       => 'Determines whether the user has the abiity to view reports.',
        ),
    ),

    'Licenses' => array(
        array(
            'permission' => 'license_keys',
            'label'      => 'View License Keys',
            'note'       => 'Determines whether the user has the ability to view the license keys assigned to them in their own profile. (Usually granted for lower-level permissions that wouldn\'t normally have access.)',
        ),
    ),


);

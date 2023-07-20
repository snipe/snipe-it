<?php

return array(
    'about_licenses_title'      => 'Acerca de las Licencias',
    'about_licenses'            => 'Las licencias son usadas para rastrear el software. Tienen un número específico de puestos que pueden ser asignados a individuos',
    'checkin'  					=> 'Registrar Puestos de Licencia',
    'checkout_history'  		=> 'Historial de Asignaciones',
    'checkout'  				=> 'Registrar Puesto de Licencia',
    'edit'  					=> 'Editar Licencia',
    'filetype_info'				=> 'Los tipos de archivo permitidos son png, gif, jpg, jpeg, doc, docx, pdf, txt, zip, y rar.',
    'clone'  					=> 'Clonar Licencia',
    'history_for'  				=> 'Historial de ',
    'in_out'  					=> 'Registrado / Asignado',
    'info'  					=> 'Información de licencia',
    'license_seats'  			=> 'Puestos de Licencia',
    'seat'  					=> 'Puesto',
    'seats'  					=> 'Puestos',
    'software_licenses'  		=> 'Licencias de Software',
    'user'  					=> 'Usuario',
    'view'  					=> 'Ver Licencia',
    'delete_disabled'           => 'This license cannot be deleted yet because some seats are still checked out.',
    'bulk'                      =>
        [
            'checkin_all'           => [
                'button'            => 'Checkin All Seats',
                'modal'             => 'This will action checkin one seat. | This action will checkin all :checkedout_seats_count seats for this license.',
                'enabled_tooltip'   => 'Checkin ALL seats for this license from both users and assets',
                'disabled_tooltip'  => 'This is disabled because there are no seats currently checked out',
                'success'           => 'License successfully checked in! | All licenses were successfully checked in!',
                'log_msg'           => 'Checked in via bulk license checkout in license GUI',
            ],

            'checkout_all'              => [
                'button'                => 'Checkout All Seats',
                'modal'                 => 'This action will checkout one seat to the first available user. | This action will checkout all :available_seats_count seats to the first available users. A user is considered available for this seat if they do not already have this license checked out to them, and the Auto-Assign License property is enabled on their user account.',
                'enabled_tooltip'   => 'Checkout ALL seats (or as many as are available) to ALL users',
                'disabled_tooltip'  => 'This is disabled because there are no seats currently available',
                'success'           => 'License successfully checked out! | :count licenses were successfully checked out!',
                'error_no_seats'    => 'There are no remaining seats left for this license.',
                'warn_not_enough_seats'    => ':count users were assigned this license, but we ran out of available license seats.',
                'warn_no_avail_users'    => 'Nothing to do. There are no users who do not already have this license assigned to them.',
                'log_msg'           => 'Checked out via bulk license checkout in license GUI',


            ],
    ],
);

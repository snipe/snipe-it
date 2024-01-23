<?php

return array(
    'about_licenses_title'      => 'Acerca de licencias',
    'about_licenses'            => 'Las licencias son para identificar software. Tienen un número específico de asientos que pueden ser asignados a individuos',
    'checkin'  					=> 'Quitar Instalación',
    'checkout_history'  		=> 'Historial Asignaciones',
    'checkout'  				=> 'Asignar Instalación',
    'edit'  					=> 'Editar Usuario',
    'filetype_info'				=> 'Tipos de archivos permitidos son png, gif, jpg, jpeg, doc, docx, pdf, txt, zip, y rar.',
    'clone'  					=> 'Clonar Usuario',
    'history_for'  				=> 'Historial para ',
    'in_out'  					=> 'Quita/Asigna',
    'info'  					=> 'Info Licencia',
    'license_seats'  			=> 'Num. Instalaciones',
    'seat'  					=> 'Instalación',
    'seats'  					=> 'Instalaciones',
    'software_licenses'  		=> 'Licencias Software',
    'user'  					=> 'Usuario',
    'view'  					=> 'Ver Licencias',
    'delete_disabled'           => 'Esta licencia no se puede eliminar aún porque algunos asientos todavía están retirados.',
    'bulk'                      =>
        [
            'checkin_all'           => [
                'button'            => 'Comprobar todos los asientos',
                'modal'             => 'Esto activará el checkin de un asiento. | Esta acción registrará todos los asientos :checkedout_seats_count para esta licencia.',
                'enabled_tooltip'   => 'Checkin TODOS los asientos para esta licencia tanto de usuarios como de activos',
                'disabled_tooltip'  => 'Esto está deshabilitado porque no hay asientos seleccionados actualmente',
                'disabled_tooltip_reassignable'  => 'Esto está desactivado porque la licencia no es reasignable',
                'success'           => '¡Licencia registrada con éxito! | ¡Todas las licencias fueron registradas con éxito!',
                'log_msg'           => 'Check-in a través de pago de licencia en licencia GUI',
            ],

            'checkout_all'              => [
                'button'                => 'Salir todos los asientos',
                'modal'                 => 'Esta acción comprobará un asiento para el primer usuario disponible. | Esta acción verificará todos los asientos :available_seats_count para los primeros usuarios disponibles. Se considera que un usuario está disponible para este asiento si aún no tiene esta licencia revisada para ellos, y la propiedad Auto-Asignación de Licencia está habilitada en su cuenta de usuario.',
                'enabled_tooltip'   => 'Checkout TODOS los asientos (o tantos como estén disponibles) para TODOS los usuarios',
                'disabled_tooltip'  => 'Esto está deshabilitado porque no hay asientos disponibles actualmente',
                'success'           => '¡Licencia retirada con éxito! | ¡Licencias :count fueron retiradas con éxito!',
                'error_no_seats'    => 'No quedan plazas restantes para esta licencia.',
                'warn_not_enough_seats'    => ':count usuarios fueron asignados a esta licencia, pero nos quedamos sin plazas de licencia disponibles.',
                'warn_no_avail_users'    => 'Nada que hacer. No hay usuarios que no tengan esta licencia asignada.',
                'log_msg'           => 'Checado mediante pago masivo de licencia en GUI licencia',


            ],
    ],
);

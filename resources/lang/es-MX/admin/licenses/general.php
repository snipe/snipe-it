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
    'delete_disabled'           => 'Esta licencia no se puede eliminar aún porque algunos asientos todavía están asignados.',
    'bulk'                      =>
        [
            'checkin_all'           => [
                'button'            => 'Desasignar todos los asientos',
                'modal'             => 'Esto activará la desasignación de un asiento. | Esta acción desasignará todos los asientos :checkedout_seats_count para esta licencia.',
                'enabled_tooltip'   => 'Desasignar TODOS los asientos para esta licencia tanto de usuarios como de activos',
                'disabled_tooltip'  => 'Esto está deshabilitado porque no hay asientos asignados actualmente',
                'success'           => '¡Licencia asignada con éxito! | ¡Todas las licencias fueron asignadas con éxito!',
                'log_msg'           => 'Asignación a través de asignación masiva en la interfaz de licencia',
            ],

            'checkout_all'              => [
                'button'                => 'Asignar todos los asientos',
                'modal'                 => 'Esta acción asignará un asiento para el primer usuario disponible. | Esta acción asignará todos los asientos :available_seats_count para los primeros usuarios disponibles. Se considera que un usuario está disponible para este asiento si aún no tiene esta licencia asignada a ellos, y la propiedad Auto-Asignación de Licencia está habilitada en su cuenta de usuario.',
                'enabled_tooltip'   => 'Asignar TODOS los asientos (o tantos como estén disponibles) para TODOS los usuarios',
                'disabled_tooltip'  => 'Esto está deshabilitado porque no hay asientos disponibles actualmente',
                'success'           => '¡Licencia asignada con éxito! | ¡:count Licencias fueron asignadas con éxito!',
                'error_no_seats'    => 'No quedan asientos restantes para esta licencia.',
                'warn_not_enough_seats'    => ':count usuarios fueron asignados a esta licencia, pero nos quedamos sin asientos de licencia disponibles.',
                'warn_no_avail_users'    => 'Nada que hacer. No hay usuarios que no tengan esta licencia asignada.',
                'log_msg'           => 'Asignación mediante asignación masiva de licencias en la interfaz de licencias',


            ],
    ],
);

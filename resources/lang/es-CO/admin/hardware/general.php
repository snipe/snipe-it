<?php

return [
    'about_assets_title'           => 'Acerca de los Equipos',
    'about_assets_text'            => 'Los activos son elementos con número de serie o etiqueta de activos. Tienden a ser artículos de alto valor donde es importante identificar un elemento específico.',
    'archived'  				=> 'Archivado',
    'asset'  					=> 'Equipo',
    'bulk_checkout'             => 'Asignar Equipos',
    'bulk_checkin'              => 'Quitar Equipo',
    'checkin'  					=> 'Devolver Equipo',
    'checkout'  				=> 'Asignar Equipo',
    'clone'  					=> 'Clonar Equipo',
    'deployable'  				=> 'Desplegable',
    'deleted'  					=> 'Este activo ha sido borrado.',
    'edit'  					=> 'Editar Equipo',
    'model_deleted'  			=> 'El modelo de este activo ha sido borrado. Debe restaurar el modelo antes de restaurar o crear el activo.',
    'model_invalid'             => 'El modelo de este activo no es válido.',
    'model_invalid_fix'         => 'El Activo debe ser editado para corregir esto antes de intentar retirarlo o asignarlo.',
    'requestable'               => 'Puede Solicitarse',
    'requested'				    => 'Solicitado',
    'not_requestable'           => 'No solicitable',
    'requestable_status_warning' => 'No cambie el esdo de solicitable',
    'restore'  					=> 'Restaurar equipo',
    'pending'  					=> 'Equipos Pendiente',
    'undeployable'  			=> 'No desplegable',
    'undeployable_tooltip'  	=> 'This asset has a status label that is undeployable and cannot be checked out at this time.',
    'view'  					=> 'Ver Equipo',
    'csv_error' => 'Tiene un error en su archivo CSV:',
    'import_text' => '
    <p>
    Sube un CSV que contenga historial de activos. Los activos y los usuarios DEBEN existir en el sistema, o se omitirán. Los activos coincidentes para importar el historial ocurren contra la etiqueta de activos. Intentaremos encontrar un usuario que coincida con el nombre del usuario que proporciones, y los criterios que seleccionas a continuación. Si no selecciona ningún criterio a continuación, simplemente tratará de coincidir con el formato de nombre de usuario que configuraste en el Administrador &gt; Configuración General.
    </p>

    <p>Los campos incluidos en el CSV deben coincidir con los encabezados: <strong>Etiqueta de activos, Nombre, Fecha de salida, Fecha de comprobación</strong>. Cualquier campo adicional será ignorado. </p>

    <p>Fecha de Checkin: las fechas de check-in en blanco o futuro comprobarán los elementos al usuario asociado. Excluyendo la columna Fecha de Checkin creará una fecha de check-in con la fecha de hoy.</p>
    ',
    'csv_import_match_f-l' => 'Trate de coincidir usuarios por medio del formato firstname.lastname (jane.smith)',
    'csv_import_match_initial_last' => 'Trate de coincidir el formato de usuarios por medio de la primera inicial y el apellido (jsmith)',
    'csv_import_match_first' => 'Intente coincidir usuarios mediante el formato de primer nombre (jane)',
    'csv_import_match_email' => 'Intentar coincidir con los usuarios por correo electrónico como nombre de usuario',
    'csv_import_match_username' => 'Intentar coincidir usuarios por nombre de usuario',
    'error_messages' => 'Mensajes de error:',
    'success_messages' => 'Mensajes de éxito:',
    'alert_details' => 'Por favor vea abajo para más detalles.',
    'custom_export' => 'Exportación personalizada',
    'mfg_warranty_lookup' => 'Búsqueda del estado de Garantía para :manufacturer',
];

<?php

return [
    'about_assets_title'           => 'Acerca de Activos',
    'about_assets_text'            => 'Los activos son elementos con número de serie o etiqueta de activos.  Tienden a ser artículos de alto valor donde es importante identificar un elemento específico.',
    'archived'  				=> 'Archivado',
    'asset'  					=> 'Equipo',
    'bulk_checkout'             => 'Checkout Assets',
    'bulk_checkin'              => 'Regresar/ingresar equipo',
    'checkin'  					=> 'Quitar Equipo',
    'checkout'  				=> 'Activo de pago',
    'clone'  					=> 'Clonar Equipo',
    'deployable'  				=> 'Desplegable',
    'deleted'  					=> 'Este activo ha sido eliminado.',
    'edit'  					=> 'Editar Equipo',
    'model_deleted'  			=> 'Este modelo de equipo fue eliminado. Debes restaurar el moldelo antes de restaurar el activo.',
    'model_invalid'             => 'El Modelo de este Activo no es válido.',
    'model_invalid_fix'         => 'Es necesario corregir esto antes de realizar movimientos con este Activo.',
    'requestable'               => 'Requerible',
    'requested'				    => 'Solicitado',
    'not_requestable'           => 'No solicitable',
    'requestable_status_warning' => 'No cambiar el estado solicitable',
    'restore'  					=> 'Restaurar equipo',
    'pending'  					=> 'Pendiente',
    'undeployable'  			=> 'No desplegable',
    'undeployable_tooltip'  	=> 'Este activo tiene una etiqueta de estado que no es desplegable y no puede ser asignado en este momento.',
    'view'  					=> 'Ver Equipo',
    'csv_error' => 'Hay un error en su archivo CSV:',
    'import_text' => '
    <p>
    Sube un CSV que contenga historial de activos. Los activos y los usuarios DEBEN existir en el sistema, o se omitirán. Los activos coincidentes para la importación del historial se buscan con la etiqueta de activos. Intentaremos encontrar un usuario que coincida con el nombre del usuario que proporcione y los criterios que seleccione a continuación. Si no selecciona ningún criterio a continuación, simplemente se intentará coincidir con el formato de nombre de usuario que configuraste en  Administrador &gt; Configuración General.
    </p>

    <p>Los campos incluidos en el CSV deben coincidir con los encabezados: <strong>Etiqueta de activos, Nombre, Fecha de salida, Fecha de comprobación</strong>. Cualquier campo adicional será ignorado. </p>

    <p>Fecha de Registro: las fechas de registro en blanco o futuro comprobarán los elementos al usuario asociado. Excluyendo la columna Fecha de Registro creará una fecha de registro con la fecha de hoy.</p>
    ',
    'csv_import_match_f-l' => 'Intentar coincidir con los usuarios por el formato firstname.lastname (juan.perez)',
    'csv_import_match_initial_last' => 'Intentar coincidir los usuarios con el formato inicial de nombre y primer apellido (jperez)',
    'csv_import_match_first' => 'Intentar coincidir con los usuarios por el formato de nombre de usuario (juan)',
    'csv_import_match_email' => 'Intentar coincidir con los usuarios por correo electrónico como nombre de usuario',
    'csv_import_match_username' => 'Intentar coincidir usuarios por nombre de usuario',
    'error_messages' => 'Mensajes de error:',
    'success_messages' => 'Mensajes de éxito:',
    'alert_details' => 'Por favor, vea abajo para más detalles.',
    'custom_export' => 'Exportación personalizada',
    'mfg_warranty_lookup' => 'Búsqueda del estado de Garantía para :manufacturer',
];

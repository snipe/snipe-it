<?php

return [
<<<<<<< HEAD
    'about_assets_title'           => 'Acerca de los activos',
    'about_assets_text'            => 'Los activos son artículos rastreados por número de serie o placa de activo.  Suelen ser artículos de alto valor en los que es importante identificar un elemento específico.',
    'archived'  				=> 'Archivado',
    'asset'  					=> 'Equipo',
    'bulk_checkout'             => 'Asignar activos',
    'bulk_checkin'              => 'Ingresar activos',
    'checkin'  					=> 'Ingresar activo',
    'checkout'  				=> 'Asignar activo',
    'clone'  					=> 'Clonar activo',
    'deployable'  				=> 'Utilizable',
    'deleted'  					=> 'Este activo ha sido eliminado.',
    'delete_confirm'            => '¿Está seguro de que desea eliminar este activo?',
    'edit'  					=> 'Editar activo',
    'model_deleted'  			=> 'Este modelo de activo ha sido eliminado. Debe restaurar este modelo antes de poder restaurar el activo.',
    'model_invalid'             => 'Este modelo para este activo es inválido.',
    'model_invalid_fix'         => 'El activo debe ser actualizado, use un modelo de activo válido antes de intentar ingresarlo, asignarlo o auditarlo.',
    'requestable'               => 'Puede solicitarse',
    'requested'				    => 'Solicitado',
    'not_requestable'           => 'No puede solicitarse',
    'requestable_status_warning' => 'No cambiar el estado solicitable',
    'restore'  					=> 'Restaurar equipo',
    'pending'  					=> 'Pendiente',
    'undeployable'  			=> 'No utilizable',
    'undeployable_tooltip'  	=> 'Este activo tiene una etiqueta de estado que es no utilizable y no puede ser asignado en este momento.',
    'view'  					=> 'Ver activo',
    'csv_error' => 'Hay un error en su archivo CSV:',
    'import_text' => '<p>Cargue un archivo CSV que contenga el historial de los activos. Los activos y los usuarios DEBEN existir ya en el sistema, o serán omitidos. La comparación de activos para importar el historial se realiza con la placa del activo. Intentaremos encontrar un usuario usando el nombre del usuario que proporcione y los criterios que seleccione a continuación. Si no selecciona ningún criterio, el sistema simplemente intentará usar el formato de nombre de usuario configurado en <code>Administrador &gt; Configuración General</code>.</p><p>Los campos incluidos en el CSV deben coincidir con los encabezados: <strong>Asset Tag, Name, Checkout Date, Checkin Date</strong>. Cualquier campo adicional será ignorado.</p><p>Checkin Date(Fecha de recepción): dejar en blanco o usar fechas futuras asignará los ítems al usuario asociado. Excluir la columna Checkin Date creará una fecha de recepción con la fecha de hoy.</p>    ',
    'csv_import_match_f-l' => 'Intente emparejar usuarios usando el formato <strong>nombre.apellido</strong> (<code>jane.smith</code>)',
    'csv_import_match_initial_last' => 'Intente emparejar los usuarios usando el formato <strong>inicial del nombre y apellido</strong> (<code>jsmith</code>)',
    'csv_import_match_first' => 'Intentar emparejar a los usuarios usando el formato <strong>primer nombre</strong> (<code>jane</code>)',
    'csv_import_match_email' => 'Intente emparejar los usuarios usando <strong>correo electrónico</strong> como nombre de usuario',
    'csv_import_match_username' => 'Intente emparejar los usuarios usando <strong>usuario</strong>',
    'error_messages' => 'Mensajes de error:',
    'success_messages' => 'Mensajes de éxito:',
    'alert_details' => 'Por favor, vea abajo para más detalles.',
    'custom_export' => 'Exportación personalizada',
    'mfg_warranty_lookup' => 'Búsqueda del estado de garantía para :manufacturer',
    'user_department' => 'Departamento',
=======
    'about_assets_title'           => 'Acerca de Activos',
    'about_assets_text'            => 'Los activos son elementos con número de serie o etiqueta de activos.  Tienden a ser artículos de alto valor donde es importante identificar un elemento específico.',
    'archived'  				=> 'Archivado',
    'asset'  					=> 'Equipo',
    'bulk_checkout'             => 'Checkout Assets',
    'checkin'  					=> 'Quitar Equipo',
    'checkout'  				=> 'Activo de pago',
    'clone'  					=> 'Clonar Equipo',
    'deployable'  				=> 'Desplegable',
    'deleted'  					=> 'Este activo ha sido eliminado.',
    'edit'  					=> 'Editar Equipo',
    'model_deleted'  			=> 'Este Modelo de activo fue eliminado. Debes restaurar este modelo antes de poder restaurar el Activo.',
    'requestable'               => 'Requerible',
    'requested'				    => 'Solicitado',
    'not_requestable'           => 'Not Requestable',
    'requestable_status_warning' => 'Do not change  requestable status',
    'restore'  					=> 'Restaurar equipo',
    'pending'  					=> 'Pendiente',
    'undeployable'  			=> 'No desplegable',
    'view'  					=> 'Ver Equipo',
    'csv_error' => 'You have an error in your CSV file:',
    'import_text' => '
    <p>
    Upload a CSV that contains asset history. The assets and users MUST already exist in the system, or they will be skipped. Matching assets for history import happens against the asset tag. We will try to find a matching user based on the user\'s name you provide, and the criteria you select below. If you do not select any criteria below, it will simply try to match on the username format you configured in the Admin &gt; General Settings.
    </p>

    <p>Fields included in the CSV must match the headers: <strong>Asset Tag, Name, Checkout Date, Checkin Date</strong>. Any additional fields will be ignored. </p>

    <p>Checkin Date: blank or future checkin dates will checkout items to associated user.  Excluding the Checkin Date column will create a checkin date with todays date.</p>
    ',
    'csv_import_match_f-l' => 'Try to match users by firstname.lastname (jane.smith) format',
    'csv_import_match_initial_last' => 'Try to match users by first initial last name (jsmith) format',
    'csv_import_match_first' => 'Try to match users by first name (jane) format',
    'csv_import_match_email' => 'Try to match users by email as username',
    'csv_import_match_username' => 'Try to match users by username',
    'error_messages' => 'Error messages:',
    'success_messages' => 'Success messages:',
    'alert_details' => 'Please see below for details.',
    'custom_export' => 'Custom Export'
>>>>>>> 64747d0fb (updates based on review)
];

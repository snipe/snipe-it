<?php

return array(

    'deleted' => 'Proveedor eliminado',
    'does_not_exist' => 'El proveedor no existe.',


    'create' => array(
        'error'   => 'Proveedor no fue creado, por favor inténtelo de nuevo.',
        'success' => 'Proveedor creado con éxito.'
    ),

    'update' => array(
        'error'   => 'Proveedor no actualizado, por favor inténtalo de nuevo',
        'success' => 'Proveedor actualizado correctamente.'
    ),

    'delete' => array(
        'confirm'   => '¿Está seguro de que desea eliminar este proveedor?',
        'error'   => 'Hubo un problema al eliminar el proveedor. Inténtalo de nuevo.',
        'success' => 'Proveedor eliminado correctamente.',
        'assoc_assets'	 => 'Este proveedor está asociado con :asset_count activo(s) y no puede ser eliminado. Por favor, actualice sus activos para dejar de hacer referencia a este proveedor y vuelva a intentarlo. ',
        'assoc_licenses'	 => 'Este proveedor está asociado actualmente con :licenses_count licences(s) y no puede ser eliminado. Por favor, actualice sus licencias para dejar de hacer referencia a este proveedor e inténtelo de nuevo. ',
        'assoc_maintenances'	 => 'Este proveedor está actualmente asociado con :asset_maintainances_count mantenimiento(s) y no puede ser eliminado. Por favor, actualice el mantenimiento de sus activos para no hacer referencia a este proveedor y vuelva a intentarlo. ',
    )

);

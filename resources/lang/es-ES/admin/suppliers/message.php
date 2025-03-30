<?php

return array(

    'deleted' => 'Proveedor eliminado',
    'does_not_exist' => 'El proveedor no existe.',


    'create' => array(
        'error'   => 'El proveedor no fue creado, por favor inténtelo de nuevo.',
        'success' => 'Proveedor creado con éxito.'
    ),

    'update' => array(
        'error'   => 'El proveedor no fue actualizado, por favor inténtelo de nuevo',
        'success' => 'Proveedor actualizado.'
    ),

    'delete' => array(
        'confirm'   => '¿Está seguro de que desea eliminar este proveedor?',
        'error'   => 'Hubo un problema al eliminar el proveedor, por favor inténtelo de nuevo.',
        'success' => 'Proveedor eliminado correctamente.',
        'assoc_assets'	 => 'Este proveedor está actualmente asociado con :asset_count activo(s) y no puede ser eliminado. Actualice sus activos para que ya no hagan referencia a este proveedor e inténtelo de nuevo. ',
        'assoc_licenses'	 => 'Este proveedor está asociado actualmente con :licenses_count licences(s) y no puede ser eliminado. Actualice sus licencias para que ya no hagan referencia a este proveedor e inténtelo de nuevo. ',
        'assoc_maintenances'	 => 'Este proveedor está actualmente asociado con :asset_maintainances_count mantenimiento(s) de activo(s) y no puede ser eliminado. Por favor, actualice el mantenimiento de sus activos para no hacer referencia a este proveedor y vuelva a intentarlo. ',
    )

);

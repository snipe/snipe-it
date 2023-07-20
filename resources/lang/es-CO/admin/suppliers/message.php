<?php

return array(

    'does_not_exist' => 'Proveedor does not exist.',


    'create' => array(
        'error'   => 'Proveedor no creado, Intentalo de nuevo.',
        'success' => 'Proveedor creado.'
    ),

    'update' => array(
        'error'   => 'Proveedor no actualizado, Intentalo de nuevo',
        'success' => 'Proveedor actualizado.'
    ),

    'delete' => array(
        'confirm'   => 'Estás seguro de querer eliminar este Proveedor?',
        'error'   => 'Ha habido un problema eliminando el Proveedor. Intentalo de nuevo.',
        'success' => 'Proveedor eliminado.',
        'assoc_assets'	 => 'Este proveedor esta asociado a uno o más modelos y no puede ser eliminado. ',
        'assoc_licenses'	 => 'Este proveedor está actualmente asociado con :licenses_count licencia(s) y no puede ser eliminado. Por favor, actualiza tus licencias para no referenciar este proveedor e inténtalo de nuevo. ',
        'assoc_maintenances'	 => 'Este proveedor está actualmente asociado con :asset_maintenances_count mantenedor(es) de activo y no puede ser eliminado. Por favor, actualiza tus mantenedores de activo para no referenciar este proveedor e inténtalo de nuevo. ',
    )

);

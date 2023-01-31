<?php

return array(

    'does_not_exist' => 'El proveedor no existe.',


    'create' => array(
        'error'   => 'El proveedor no ha sido creado, inténtalo de nuevo.',
        'success' => 'Proveedor creado con éxito.'
    ),

    'update' => array(
        'error'   => 'El proveedor no ha sido actualizado, por favor, inténtalo de nuevo',
        'success' => 'Proveedor actualizado con éxito.'
    ),

    'delete' => array(
        'confirm'   => '¿Estás seguro de que quieres borrar este proveedor?',
        'error'   => 'Hubo un problema borrando el proveedor. Por favor, inténtalo de nuevo.',
        'success' => 'El proveedor fue eliminado con éxito.',
        'assoc_assets'	 => 'Este proveedor está actualmente asociado con :asset_count activo(s) y no puede ser borrado. Por favor, actualiza tus activos para no referenciar más este proveedor e inténtalo de nuevo. ',
        'assoc_licenses'	 => 'Este proveedor está actualmente asociado con :licenses_count licencia(s) y no puede ser borrado. Por favor, actualiza tus licencias para no referenciar más este proveedor e inténtalo de nuevo. ',
        'assoc_maintenances'	 => 'Este proveedor está actualmente asociado con :asset_maintenances_count mantenedor(es) de activo y no puede ser eliminado. Por favor, actualiza tus mantenedores de activo para no referenciar este proveedor e inténtalo de nuevo. ',
    )

);

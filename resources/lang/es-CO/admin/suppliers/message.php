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
        'assoc_licenses'	 => 'This supplier is currently associated with :licenses_count licences(s) and cannot be deleted. Please update your licenses to no longer reference this supplier and try again. ',
        'assoc_maintenances'	 => 'This supplier is currently associated with :asset_maintenances_count asset maintenances(s) and cannot be deleted. Please update your asset maintenances to no longer reference this supplier and try again. ',
    )

);

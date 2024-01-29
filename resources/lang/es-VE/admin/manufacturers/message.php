<?php

return array(

    'support_url_help' => 'Variables <code>{LOCALE}</code>, <code>{SERIAL}</code>, <code>{MODEL_NUMBER}</code>, y <code>{MODEL_NAME}</code> se puede utilizar en tu URL para que esos valores se llenen automáticamente al ver los activos - por ejemplo https://checkcoverage. pple.com/{LOCALE}/{SERIAL}.',
    'does_not_exist' => 'El fabricante no existe.',
    'assoc_users'	 => 'Este fabricante está actualmente asociado con al menos un modelo y no puede ser borrado. Por favor, actualiza tus modelos para no referenciar este fabricante e inténtelo de nuevo. ',

    'create' => array(
        'error'   => 'El fabricante no ha sido creado, por favor, inténtalo de nuevo.',
        'success' => 'Fabricante creado con éxito.'
    ),

    'update' => array(
        'error'   => 'El fabricante no ha sido actualizado, por favor, inténtelo de nuevo',
        'success' => 'Fabricante actualizado con éxito.'
    ),

    'restore' => array(
        'error'   => 'El fabricante no ha sido restaurado, por favor inténtalo de nuevo',
        'success' => 'Fabricante restaurado con éxito.'
    ),

    'delete' => array(
        'confirm'   => '¿Estás seguro de querer borrar este fabricante?',
        'error'   => 'Hubo un problema borrando el fabricante. Por favor, inténtalo de nuevo.',
        'success' => 'Fabricante borrado con éxito.'
    )

);

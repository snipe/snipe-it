<?php

return array(

    'support_url_help' => 'Variables <code>{LOCALE}</code>, <code>{SERIAL}</code>, <code>{MODEL_NUMBER}</code>, y <code>{MODEL_NAME}</code> se puede utilizar en tu URL para que esos valores se llenen automáticamente al ver los activos - por ejemplo https://checkcoverage. pple.com/{LOCALE}/{SERIAL}.',
    'does_not_exist' => 'El fabricante no existe.',
    'assoc_users'	 => 'Este fabricante está actualmente asociado con al menos un modelo y no se puede eliminar. Por favor, actualice sus modelos para dejar de hacer referencia a este fabricante y vuelva a intentarlo. ',

    'create' => array(
        'error'   => 'El fabricante no ha sido creado, por favor inténtelo de nuevo.',
        'success' => 'Fabricante creado con éxito.'
    ),

    'update' => array(
        'error'   => 'El fabricante no ha sido actualizado, por favor inténtalo de nuevo',
        'success' => 'El fabricante se ha actualizado correctamente.'
    ),

    'restore' => array(
        'error'   => 'El fabricante no ha sido restaurado, por favor inténtalo de nuevo',
        'success' => 'Fabricante restaurado con éxito.'
    ),

    'delete' => array(
        'confirm'   => '¿Está seguro de que desea eliminar este fabricante?',
        'error'   => 'Hubo un problema al eliminar el fabricante. Por favor, inténtelo de nuevo.',
        'success' => 'El fabricante se ha eliminado correctamente.'
    )

);

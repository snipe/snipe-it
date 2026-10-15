<?php

return [
    'does_not_exist' => 'La compañía no existe.',
    'deleted' => 'Compañía eliminada',
    'assoc_users' => 'Esta compañía está actualmente asociada con al menos un modelo y no puede ser eliminada. Por favor actualice sus modelos para que no hagan referencia a esta compañía e inténtelo de nuevo. ',
    'create' => [
        'error' => 'La compañía no fue creada, por favor, inténtelo de nuevo.',
        'success' => 'Compañía creada satisfactoriamente.',
    ],
    'update' => [
        'error' => 'La compañía no se ha actualizado, por favor inténtelo de nuevo',
        'success' => 'Compañía actualizada correctamente.',
    ],
    'delete' => [
        'confirm' => '¿Está seguro de que quiere eliminar esta compañía?',
        'error' => 'Hubo un problema eliminando la compañía. Por favor, inténtelo de nuevo.',
        'success' => 'La compañía fue eliminada correctamente.',
        'bulk_success' => 'Compañía eliminada exitosamente.|:count empresas se eliminaron correctamente.',
        'partial_success' => 'Compañía eliminada con éxito. Ver información adicional a continuación. | :count empresas fueron eliminadas correctamente. Ver información adicional a continuación.',
    ],
];

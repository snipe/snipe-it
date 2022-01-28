<?php

return [

    'does_not_exist' => 'Etiqueta de Estado inexistente.',
    'assoc_assets'	 => 'Esta etiqueta de estado está asociada con al menos un equipo actualmente, por lo que no puede ser eliminada. Por favor actualiza tus equipos para que no hagan uso de esta etiqueta, e inténtalo de nuevo. ',

    'create' => [
        'error'   => 'La etiqueta de estado no pudo ser creada, por favor inténtalo de nuevo.',
        'success' => 'La etiqueta de estado fue creada exitosamente.',
    ],

    'update' => [
        'error'   => 'La etiqueta de estado no pudo ser actualizada, por favor inténtalo de nuevo',
        'success' => 'La etiqueta de estado fue actualizada exitosamente.',
    ],

    'delete' => [
        'confirm'   => '¿Estas seguro(a) de que quieres eliminar esta etiqueta de estado?',
        'error'   => 'Hubo un problema al eliminar la etiqueta de estado. Por favor inténtalo de nuevo.',
        'success' => 'La etiqueta de estado fue eliminada de forma exitosa.',
    ],

    'help' => [
        'undeployable'   => 'Estos equipos no pueden ser asignados.',
        'deployable'   => 'These assets can be checked out. Once they are assigned, they will assume a meta status of <i class="fas fa-circle text-blue"></i> <strong>Deployed</strong>.',
        'archived'   => 'Estos equipos no pueden ser asignados, y solo se mostrarán en la vista de Archivados. Esto es útil para retener información sobre equipos por razones de presupuesto/revisión histórica, mientras están fuera de la lista de equipos del día a día.',
        'pending'   => 'Estos equipos no pueden ser asignados, suele usarse para ítems que están en reparación, o que se espera que regresen a circulación eventualmente.',
    ],

];

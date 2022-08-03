<?php

return [

    'does_not_exist' => 'Etiqueta de estado no existe.',
<<<<<<< HEAD
    'deleted_label' => 'Etiqueta de estado borrado',
    'assoc_assets'	 => 'Esta etiqueta de estado está actualmente asociada con al menos un activo y no se puede eliminar. Por favor actualice sus activos para que ya no hagan referencia a este estado e inténtelo de nuevo. ',

    'create' => [
        'error'   => 'La etiqueta de estado no pudo ser creada, por favor inténtelo de nuevo.',
=======
    'assoc_assets'	 => 'Esta etiqueta de estado está actualmente asociado con al menos un Activo y no puede ser borrada. Por favor, actualiza tus activos para no referenciar más este estado e inténtalo de nuevo. ',

    'create' => [
        'error'   => 'La etiqueta de estado no fue creada, por favor, inténtalo de nuevo.',
>>>>>>> 64747d0fb (updates based on review)
        'success' => 'La etiqueta de estado fue creada con éxito.',
    ],

    'update' => [
<<<<<<< HEAD
        'error'   => 'La etiqueta de estado no se actualizó, por favor inténtelo de nuevo',
        'success' => 'La etiqueta de estado fue actualizada exitosamente.',
    ],

    'delete' => [
        'confirm'   => '¿Está seguro de que desea eliminar esta etiqueta de estado?',
        'error'   => 'Hubo un problema borrando la etiqueta de estado. Por favor, inténtelo de nuevo.',
=======
        'error'   => 'La etiqueta de estado no fue actualizada, por favor, inténtelo de nuevo',
        'success' => 'La etiqueta de estado fue actualizada con éxito.',
    ],

    'delete' => [
        'confirm'   => '¿Estás seguro de querer eliminar esta etiqueta de estado?',
        'error'   => 'Huno un problema borrando la etiqueta de estado. Por favor, inténtalo de nuevo.',
>>>>>>> 64747d0fb (updates based on review)
        'success' => 'La etiqueta de estado se ha eliminado con éxito.',
    ],

    'help' => [
<<<<<<< HEAD
        'undeployable'   => 'Estos equipos no pueden ser asignados.',
        'deployable'   => 'Estos activos pueden ser asignados. Una vez estén asignados, asumirán el meta estado de <i class="fas fa-circle text-blue"></i> <strong>Asignado</strong>.',
        'archived'   => 'Estos equipos no pueden ser asignados, y solo se mostrarán en la vista de Archivados. Esto es útil para retener información sobre activos por razones de presupuesto/revisión histórica, mientras están fuera de la lista de equipos del día a día.',
        'pending'   => 'Estos activos aún no pueden asignarse, y suelen utilizarse para elementos que están en reparación, pero que se espera que regresen a circulación.',
=======
        'undeployable'   => 'Estos activos no pueden asignarse a nadie.',
        'deployable'   => 'These assets can be checked out. Once they are assigned, they will assume a meta status of <i class="fas fa-circle text-blue"></i> <strong>Deployed</strong>.',
        'archived'   => 'Estos activos no pueden ser asignados, y sólo se mostrarán en la vista archivada. Esto es útil para retener información acerca de activos para propósitos históricos o de presupuesto, pero manteniéndolos fuera de la lista de activos del día a día.',
        'pending'   => 'Estos activos no pueden ser asignados a nadie aún, usados a menudo para artículos que son para reparar pero se espera que vuelvan a circulación.',
>>>>>>> 64747d0fb (updates based on review)
    ],

];

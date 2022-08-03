<?php

return [

    'does_not_exist' => 'Etiqueta de estado no existe.',
<<<<<<< HEAD
    'deleted_label' => 'Etiqueta de estado borrado',
    'assoc_assets'	 => 'Esta etiqueta de estado está actualmente asociada con al menos un activo y no se puede eliminar. Por favor actualice sus activos para que ya no hagan referencia a este estado e inténtelo de nuevo. ',

    'create' => [
        'error'   => 'La etiqueta de estado no pudo ser creada, por favor inténtelo de nuevo.',
=======
    'assoc_assets'	 => 'Esta etiqueta de estado esta actualmente asociado con al menos un activo y no se puede eliminar. Por favor actualice sus activos para ya no hacer referencia a este estado y vuelva a intentarlo. ',

    'create' => [
        'error'   => 'Etiqueta de estado no fue creada, por favor, inténtelo de nuevo.',
>>>>>>> 64747d0fb (updates based on review)
        'success' => 'Etiqueta de estado fue creada exitosamente.',
    ],

    'update' => [
<<<<<<< HEAD
        'error'   => 'La etiqueta de estado no se actualizó, por favor inténtelo de nuevo',
        'success' => 'La etiqueta de estado fue actualizada exitosamente.',
    ],

    'delete' => [
        'confirm'   => '¿Está seguro de que desea eliminar esta etiqueta de estado?',
=======
        'error'   => 'Etiqueta de estado no se ha actualizado, por favor, inténtelo de nuevo',
        'success' => 'Etiqueta de estado fue actualizada exitosamente.',
    ],

    'delete' => [
        'confirm'   => '¿Está seguro que desea eliminar esta etiqueta de estado?',
>>>>>>> 64747d0fb (updates based on review)
        'error'   => 'Hubo un problema borrando la etiqueta de estado. Por favor, inténtelo de nuevo.',
        'success' => 'La etiqueta de estado se ha eliminado exitosamente.',
    ],

    'help' => [
<<<<<<< HEAD
        'undeployable'   => 'Estos equipos no pueden ser asignados.',
        'deployable'   => 'Estos activos pueden ser asignados. Una vez estén asignados, asumirán el meta estado de <i class="fas fa-circle text-blue"></i> <strong>Asignado</strong>.',
        'archived'   => 'Estos equipos no pueden ser asignados y solo se mostrarán en la vista de Archivados. Esto es útil para mantener información de activos por razones de presupuesto o de revisión histórica y al mismo tiempo se excluyen de los activos que se pueden usar en el día a día.',
        'pending'   => 'Estos activos aún no pueden asignarse, y suelen utilizarse para elementos que están en reparación, pero que se espera que regresen a circulación.',
=======
        'undeployable'   => 'Estos activos no pueden asignarse a nadie.',
        'deployable'   => 'These assets can be checked out. Once they are assigned, they will assume a meta status of <i class="fas fa-circle text-blue"></i> <strong>Deployed</strong>.',
        'archived'   => 'Estos activos no pueden desprotegerse y solo aparecerán en la vista Archivada. Esto es útil para retener información sobre activos para presupuestos / propósitos históricos, pero mantenerlos fuera de la lista de activos del día a día.',
        'pending'   => 'Estos activos aún no se pueden asignar a nadie, a menudo se utilizan para artículos que están pendientes de reparación, pero se espera que vuelvan a la circulación.',
>>>>>>> 64747d0fb (updates based on review)
    ],

];

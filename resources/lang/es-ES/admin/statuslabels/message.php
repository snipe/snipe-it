<?php

return [

    'does_not_exist' => 'Etiqueta de estado no existe.',
    'assoc_assets'	 => 'Esta etiqueta de estado esta actualmente asociado con al menos un activo y no se puede eliminar. Por favor actualice sus activos para ya no hacer referencia a este estado y vuelva a intentarlo. ',

    'create' => [
        'error'   => 'Etiqueta de estado no fue creada, por favor, inténtelo de nuevo.',
        'success' => 'Etiqueta de estado fue creada exitosamente.',
    ],

    'update' => [
        'error'   => 'Etiqueta de estado no se ha actualizado, por favor, inténtelo de nuevo',
        'success' => 'Etiqueta de estado fue actualizada exitosamente.',
    ],

    'delete' => [
        'confirm'   => '¿Está seguro que desea eliminar esta etiqueta de estado?',
        'error'   => 'Hubo un problema borrando la etiqueta de estado. Por favor, inténtelo de nuevo.',
        'success' => 'La etiqueta de estado se ha eliminado exitosamente.',
    ],

    'help' => [
        'undeployable'   => 'Estos activos no pueden asignarse a nadie.',
        'deployable'   => 'Estos activos pueden ser retirados. Una vez asignados, asumirán un estado meta de <i class="fas fa-circle text-blue"></i> <strong>Desplegado</strong>.',
        'archived'   => 'Estos activos no pueden desprotegerse y solo aparecerán en la vista Archivada. Esto es útil para retener información sobre activos para presupuestos / propósitos históricos, pero mantenerlos fuera de la lista de activos del día a día.',
        'pending'   => 'Estos activos aún no se pueden asignar a nadie, a menudo se utilizan para artículos que están pendientes de reparación, pero se espera que vuelvan a la circulación.',
    ],

];

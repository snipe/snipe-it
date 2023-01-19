<?php

return [

    'does_not_exist' => 'Etiqueta de estado no existe.',
    'assoc_assets'	 => 'Esta etiqueta de estado está actualmente asociado con al menos un Activo y no puede ser borrada. Por favor, actualiza tus activos para no referenciar más este estado e inténtalo de nuevo. ',

    'create' => [
        'error'   => 'La etiqueta de estado no fue creada, por favor, inténtalo de nuevo.',
        'success' => 'La etiqueta de estado fue creada con éxito.',
    ],

    'update' => [
        'error'   => 'La etiqueta de estado no fue actualizada, por favor, inténtelo de nuevo',
        'success' => 'La etiqueta de estado fue actualizada con éxito.',
    ],

    'delete' => [
        'confirm'   => '¿Estás seguro de querer eliminar esta etiqueta de estado?',
        'error'   => 'Huno un problema borrando la etiqueta de estado. Por favor, inténtalo de nuevo.',
        'success' => 'La etiqueta de estado se ha eliminado con éxito.',
    ],

    'help' => [
        'undeployable'   => 'Estos activos no pueden asignarse a nadie.',
        'deployable'   => 'Estos activos pueden ser retirados. Una vez asignados, asumirán un estado meta de <i class="fas fa-circle text-blue"></i> <strong>Desplegado</strong>.',
        'archived'   => 'Estos activos no pueden ser asignados, y sólo se mostrarán en la vista archivada. Esto es útil para retener información acerca de activos para propósitos históricos o de presupuesto, pero manteniéndolos fuera de la lista de activos del día a día.',
        'pending'   => 'Estos activos no pueden ser asignados a nadie aún, usados a menudo para artículos que son para reparar pero se espera que vuelvan a circulación.',
    ],

];

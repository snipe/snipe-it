<?php

return [

    'does_not_exist' => 'Etiqueta de estado no existe.',
    'deleted_label' => 'Etiqueta de estado borrado',
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
        'deployable'   => 'Estos activos pueden ser asignados. Una vez estén asignados, asumirán el meta estado de <i class="fas fa-circle text-blue"></i> <strong>Asignado</strong>.',
        'archived'   => 'Estos equipos no pueden ser asignados, y solo se mostrarán en la vista de Archivados. Esto es útil para retener información sobre activos por razones de presupuesto/revisión histórica, mientras están fuera de la lista de equipos del día a día.',
        'pending'   => 'Estos equipos no pueden ser asignados, suele usarse para ítems que están en reparación, o que se espera que regresen a circulación eventualmente.',
    ],

];

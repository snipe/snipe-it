<?php

return [

    'does_not_exist' => 'Etiqueta de estado no existe.',
    'deleted_label' => 'Etiqueta de estado borrado',
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
        'deployable'   => 'Estos activos pueden ser asignados. Una vez estén asignados, asumirán el meta estado de <i class="fas fa-circle text-blue"></i> <strong>Asignado</strong>.',
        'archived'   => 'Estos equipos no pueden ser asignados y solo se mostrarán en la vista de Archivados. Esto es útil para mantener información de activos por razones de presupuesto o de revisión histórica y al mismo tiempo se excluyen de los activos que se pueden usar en el día a día.',
        'pending'   => 'Estos equipos no pueden ser asignados, suele usarse para ítems que están en reparación, o que se espera que regresen a circulación eventualmente.',
    ],

];

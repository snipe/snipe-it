<?php

return array(

    'does_not_exist' => 'Etiqueta de estado no existe.',
    'assoc_assets'	 => 'Esta etiqueta de estado esta actualmente asociado con al menos un activo y no se puede eliminar. Por favor actualice sus activos para ya no hacer referencia a este estado y vuelva a intentarlo. ',


    'create' => array(
        'error'   => 'Etiqueta de estado no fue creada, por favor, inténtelo de nuevo.',
        'success' => 'Etiqueta de estado fue creada exitosamente.'
    ),

    'update' => array(
        'error'   => 'Etiqueta de estado no se ha actualizado, por favor, inténtelo de nuevo',
        'success' => 'Etiqueta de estado fue actualizada exitosamente.'
    ),

    'delete' => array(
        'confirm'   => '¿Está seguro que desea eliminar esta etiqueta de estado?',
        'error'   => 'Hubo un problema borrando la etiqueta de estado. Por favor, inténtelo de nuevo.',
        'success' => 'La etiqueta de estado se ha eliminado exitosamente.'
    ),

    'help' => array(
        'undeployable'   => 'Estos activos no pueden asignarse a nadie.',
        'deployable'   => 'Estos activos se pueden desproteger. Una vez que se les asigna, asumirán un estado meta de <i class="fa fa-circle text-blue"></i> <strong>Deployed</strong>.',
        'archived'   => 'Estos activos no pueden desprotegerse y solo aparecerán en la vista Archivada. Esto es útil para retener información sobre activos para presupuestos / propósitos históricos, pero mantenerlos fuera de la lista de activos del día a día.',
        'pending'   => 'Estos activos aún no se pueden asignar a nadie, a menudo se utilizan para artículos que están pendientes de reparación, pero se espera que vuelvan a la circulación.',
    ),

);

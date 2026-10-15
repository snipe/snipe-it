<?php

return [

    'deleted' => 'Se eliminó el modelo del activo',
    'does_not_exist' => 'Modelo inexistente.',
    'no_association' => '¡ADVERTENCIA! ¡El modelo de activo para este artículo no es válido o no existe!',
    'no_association_fix' => 'Esto causará problemas raros y horribles. Edite este activo ahora para asignarle un modelo.',
    'assoc_users' => 'Este modelo está asociado a uno o más activos y no puede ser eliminado. Por favor, elimine los activos y vuelva a intentarlo. ',
    'invalid_category_type' => 'El tipo de esta categoría debe ser categoría de activos.',

    'create' => [
        'error' => 'El modelo no fue creado, por favor inténtelo de nuevo.',
        'success' => 'El modelo fue creado exitosamente.',
        'duplicate_set' => 'Ya existe un modelo de activo con el mismo nombre, fabricante y número de modelo.',
    ],

    'update' => [
        'error' => 'El modelo no pudo ser actualizado, por favor inténtelo de nuevo',
        'success' => 'El modelo fue actualizado exitosamente.',
    ],

    'delete' => [
        'confirm' => '¿Está seguro de que desea eliminar este modelo de activo?',
        'error' => 'Hubo un problema eliminando el modelo. Por favor, inténtelo de nuevo.',
        'success' => 'El modelo fue eliminado exitosamente.',
    ],

    'restore' => [
        'error' => 'El modelo no fue restaurado, por favor intente nuevamente',
        'success' => 'El modelo fue restaurado exitosamente.',
    ],

    'bulkedit' => [
        'error' => 'Ningún cambio fue cambiado, así que nada se actualizó.',
        'success' => 'Modelo actualizado correctamente. |:model_count modelos actualizados correctamente.',
        'warn' => 'Está a punto de actualizar las propiedades del siguiente modelo:|Está a punto de editar las propiedades de los siguientes :model_count modelos:',

    ],

    'bulkdelete' => [
        'error' => 'Ningún modelo fue seleccionado, no se eliminó nada.',
        'nothing_deletable' => 'None of the selected models can be deleted because they still have assets associated with them.',
        'success' => 'Modelo eliminado!|:success_count modelos eliminados!',
        'success_partial' => ':success_count modelo(s) fueron eliminados, sin embargo, :fail_count no pudieron ser eliminados debido a que aún tienen activos asociados a ellos.',
    ],

    'merge' => [
        'min_two' => 'Select at least two models to merge.',
        'no_target' => 'Select which model to keep before merging.',
        'not_found' => 'One or more of the selected models could not be loaded. Refresh the models list and try again.',
        'information' => 'You are about to merge :count models. Pick the model you want to keep. Every asset attached to the other models will be reassigned to the model you pick, then the source models will be deleted.',
        'warning' => 'This cannot be undone. Reassigned assets will inherit the surviving model\'s category, fieldset, and depreciation settings.',
        'pick_target' => 'Which model do you want to keep?',
        'success' => 'Merged :source_count model(s) into ":target". :asset_count asset(s) were reassigned.',
    ],

];

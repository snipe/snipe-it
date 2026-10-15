<?php

return [

    'deleted' => 'Modelo de ativo apagado',
    'does_not_exist' => 'O Modelo não existe.',
    'no_association' => 'AVISO! O modelo de artigo para este item é inválido ou está em falta!',
    'no_association_fix' => 'Isto estragará as coisas de maneiras estranhas e horríveis. Edite este artigo agora para lhe atribuir um modelo.',
    'assoc_users' => 'Este modelo está atualmente associado com pelo menos um artigo e não pode ser removido. Por favor, remova os artigos e depois tente novamente. ',
    'invalid_category_type' => 'This category must be an asset category.',

    'create' => [
        'error' => 'O Modelo não foi criado. Por favor tente novamente.',
        'success' => 'Modelo criado com sucesso.',
        'duplicate_set' => 'Já existe um Modelo de artigo com esse nome, fabricante e número de modelo.',
    ],

    'update' => [
        'error' => 'O Modelo não foi atualizado. Por favor tente novamente',
        'success' => 'Modelo atualizado com sucesso.',
    ],

    'delete' => [
        'confirm' => 'Tem a certeza que pretende remover este modelo de artigo?',
        'error' => 'Ocorreu um problema ao remover o modelo. Por favor, tente novamente.',
        'success' => 'O modelo foi removido com sucesso.',
    ],

    'restore' => [
        'error' => 'O Modelo não foi restaurado, por favor tente novamente',
        'success' => 'Modelo restaurado com sucesso.',
    ],

    'bulkedit' => [
        'error' => 'Nenhum campo foi alterado, portanto, nada foi atualizado.',
        'success' => 'Modelo foi atualizado com sucesso. |:model_count modelos atualizados com sucesso.',
        'warn' => 'Você está prestes a atualizar as propriedades do seguinte modelo: Você está prestes a editar as propriedades dos seguintes :model_count models:',

    ],

    'bulkdelete' => [
        'error' => 'Nenhum modelo selecionado, por isso nenhum modelo foi eliminado.',
        'nothing_deletable' => 'None of the selected models can be deleted because they still have assets associated with them.',
        'success' => 'Modelo apagado!|:success_count modelos apagados!',
        'success_partial' => ':sucess_count modelo(s) eliminados, no entanto :fail_count não foram eliminados, porque ainda têm artigos associados.',
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

<?php

return [

    'deleted' => 'Modelo de ativo excluído',
    'does_not_exist' => 'O modelo não existe.',
    'no_association' => 'ATENÇÃO! O modelo de ativo para este item é inválido ou está faltando!',
    'no_association_fix' => 'Isso quebrará as coisas de maneiras estranhas e horríveis. Edite este equipamento agora para atribuir um modelo a ele.',
    'assoc_users' => 'Este modelo está no momento associado com um ou mais ativos e não pode ser excluído. Exclua os ativos e então tente excluir novamente. ',
    'invalid_category_type' => 'Esta categoria deve ser uma categoria de ativo.',

    'create' => [
        'error' => 'O modelo não foi criado, tente novamente.',
        'success' => 'Modelo criado com sucesso.',
        'duplicate_set' => 'Um modelo de ativo com este nome, desse fabricante e desse modelo já existe.',
    ],

    'update' => [
        'error' => 'O modelo não foi atualizado, tente novamente',
        'success' => 'Modelo atualizado com sucesso.',
    ],

    'delete' => [
        'confirm' => 'Tem certeza de que quer excluir este modelo de ativo?',
        'error' => 'Houve um problema ao deletar o modelo. Por favor, tente novamente.',
        'success' => 'O modelo foi excluído com sucesso.',
    ],

    'restore' => [
        'error' => 'O modelo não foi restaurado, tente novamente',
        'success' => 'Modelo restaurado com sucesso.',
    ],

    'bulkedit' => [
        'error' => 'Nenhum campo foi alterado, então nada foi atualizado.',
        'success' => 'Modelo foi atualizado com sucesso. |:model_count modelos atualizados com sucesso.',
        'warn' => 'Você está prestes a atualizar as propriedades do seguinte modelo: Você está prestes a editar as propriedades dos seguintes :model_count models:',

    ],

    'bulkdelete' => [
        'error' => 'Nenhum modelo foi selecionado, então nada foi deletado.',
        'nothing_deletable' => 'None of the selected models can be deleted because they still have assets associated with them.',
        'success' => 'Modelo excluído!|:success_count modelos deletados!',
        'success_partial' => ':success_count model(s) foram deletados,no entando :fail_count não pode ser excluído porque eles ainda possuem ativos associados a eles.',
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

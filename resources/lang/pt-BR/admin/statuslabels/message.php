<?php

return [

    'does_not_exist' => 'Rótulo de estado não existe.',
    'assoc_assets'	 => 'Este rótulo de estado está associado com pelo menos um Asset e não pode ser removido. Por favor atualize seus assets para não referenciarem este rótulo e tente novamente. ',

    'create' => [
        'error'   => 'Rótulo de estado não foi criado, por favor tente novamente.',
        'success' => 'Rótulo de estado criado com sucesso.',
    ],

    'update' => [
        'error'   => 'Rótulo de estado não foi atualizado, por favor tente novamente',
        'success' => 'Rótulo de estado atualizado com sucesso.',
    ],

    'delete' => [
        'confirm'   => 'Tem certeza que deseja deletar este Rótulo de estado?',
        'error'   => 'Ocorreu um problema ao deletar o Rótulo de estado. Por favor tente novamente.',
        'success' => 'O Rótulo de estado foi deletado com sucesso.',
    ],

    'help' => [
        'undeployable'   => 'Esses ativos não podem ser atribuídos a ninguém.',
        'deployable'   => 'Esses ativos podem ser retirados. Uma vez que são retirados, eles assumirão um status meta de <i class="fas fa-circle text-blue"></i> <strong>Deployed</strong>.',
        'archived'   => 'Esses ativos não podem ser verificados, e só aparecerão na visão arquivada. Isso é útil para manter informações sobre recursos para fins orçamentários / históricos, mas mantendo-os fora da lista de ativos do dia-a-dia.',
        'pending'   => 'Esses ativos ainda não podem ser atribuídos a ninguém, muitas vezes usado para itens que estão fora para reparo, mas é esperado que retornem à circulação.',
    ],

];

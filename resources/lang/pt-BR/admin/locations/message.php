<?php

return array(

    'does_not_exist' => 'O local não existe.',
    'assoc_users'    => 'Este local não é deletado atualmente, porque é a localização do registro para pelo menos um ativo ou usuário, tem ativos atribuídos a ele, ou é a localização principal de outro local. Por favor, atualize os modelos para não referenciarem mais esta empresa e tente novamente. ',
    'assoc_assets'	 => 'Este local esta atualmente associado a pelo menos um ativo e não pode ser deletado. Por favor atualize seu ativo para não fazer mais referência a este local e tente novamente. ',
    'assoc_child_loc'	 => 'Este local é atualmente o principal de pelo menos local secundário e não pode ser deletado. Por favor atualize seus locais para não fazer mais referência a este local e tente novamente. ',
    'assigned_assets' => 'Ativos atribuídos',
    'current_location' => 'Localização Atual',


    'create' => array(
        'error'   => 'O local não foi criado, tente novamente.',
        'success' => 'Local criado com sucesso.'
    ),

    'update' => array(
        'error'   => 'O local não foi atualizado, tente novamente',
        'success' => 'Local atualizado com sucesso.'
    ),

    'delete' => array(
        'confirm'   	=> 'Tem certeza de que quer excluir este local?',
        'error'   => 'Houve um problema ao excluir o local. Tente novamente.',
        'success' => 'O local foi excluído com sucesso.'
    )

);

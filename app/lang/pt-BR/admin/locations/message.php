<?php

return array(

    'does_not_exist' => 'O local não existe.',
    'assoc_users'	 => 'Este local está no momento associado com pelo menos um usuário e não pode ser excluído. Atualize seus usuários para não referenciarem mais este local e tente novamente. ',
    'assoc_assets'	 => 'This location is currently associated with at least one asset and cannot be deleted. Please update your assets to no longer reference this location and try again. ',
    'assoc_child_loc'	 => 'This location is currently the parent of at least one child location and cannot be deleted. Please update your locations to no longer reference this location and try again. ',


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

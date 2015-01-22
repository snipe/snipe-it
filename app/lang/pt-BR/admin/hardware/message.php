<?php

return array(

    'undeployable' 		=> '<strong>Aviso:</strong> Este bem foi marcado como atualmente não implementável.                        Se este status mudou, por favor, atualize o status do bem.',
    'does_not_exist' 	=> 'O bem não existe.',
    'assoc_users'	 	=> 'Este bem está no momento associado com pelo menos um usuário e não pode ser deletado. Por favor, atualize seu bem para que não referencie mais este usuário e tente novamente. ',

    'create' => array(
        'error'   		=> 'O bem não foi criado, por favor, tente novamente. :(',
        'success' 		=> 'Bem criado com sucesso. :)'
    ),

    'update' => array(
        'error'   		=> 'O bem não foi atualizado, por favor, tente novamente',
        'success' 		=> 'Bem atualizado com sucesso.'
    ),

    'delete' => array(
        'confirm'   	=> 'Tem certeza de que deseja deletar este bem?',
        'error'   		=> 'Houve um problema ao deletar o bem. Por favor, tente novamente.',
        'success' 		=> 'O bem foi deletado com sucesso.'
    ),

    'checkout' => array(
        'error'   		=> 'Ativo não foi registrado, favor tentar novamente',
        'success' 		=> 'Ativo registrado com sucesso.',
        'user_does_not_exist' => 'Este usuário é inválido. Por favor, tente novamente.'
    ),

    'checkin' => array(
        'error'   		=> 'Ativo não foi retornado, favor tentar novamente',
        'success' 		=> 'Ativo retornado com sucesso.',
        'user_does_not_exist' => 'Este usuário é inválido. Por favor, tente novamente.'
    )

);

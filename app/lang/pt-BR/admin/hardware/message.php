<?php

return array(

    'undeployable' 		=> '<strong>Aviso:</strong> Este bem foi marcado como atualmente não implementável.                        Se este status mudou, por favor, atualize o status do bem.',
    'does_not_exist' 	=> 'O bem não existe.',
    'assoc_users'	 	=> 'This asset is currently checked out to a user and cannot be deleted. Please check the asset in first, and then try deleting again. ',

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
        'error'   		=> 'Asset was not checked out, please try again',
        'success' 		=> 'Asset checked out successfully.',
        'user_does_not_exist' => 'Este usuário é inválido. Por favor, tente novamente.'
    ),

    'checkin' => array(
        'error'   		=> 'Asset was not checked in, please try again',
        'success' 		=> 'Asset checked in successfully.',
        'user_does_not_exist' => 'Este usuário é inválido. Por favor, tente novamente.'
    )

);

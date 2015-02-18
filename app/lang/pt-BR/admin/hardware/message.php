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
        'error'   			=> 'O bem não foi atualizado, por favor, tente novamente',
        'success' 			=> 'Bem atualizado com sucesso.',
        'nothing_updated'	=>  'No fields were selected, so nothing was updated.',
    ),

    'restore' => array(
        'error'   		=> 'O bem não foi restaurado, por favor, tente novamente',
        'success' 		=> 'Bem restaurado com sucesso.'
    ),
    
    'deletefile' => array(
        'error'   => 'File not deleted. Please try again.',
        'success' => 'File successfully deleted.',
    ),

    'upload' => array(
        'error'   => 'File(s) not uploaded. Please try again.',
        'success' => 'File(s) successfully uploaded.',
        'nofiles' => 'You did not select any files for upload',
        'invalidfiles' => 'One or more of your files is too large or is a filetype that is not allowed. Allowed filetypes are png, gif, jpg, doc, docx, pdf, and txt.',
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

<?php

return array(

    'undeployable' 		=> '<strong>Aviso:</strong> Este ativo foi marcado como atualmente não implementável.                        Se este status mudou, atualize o status do ativo.',
    'does_not_exist' 	=> 'O ativo não existe.',
    'does_not_exist_or_not_requestable' => 'Boa tentativa. Este ativo não existe ou não pode ser requisitado.',
    'assoc_users'	 	=> 'Este bem está no momento associado com pelo menos um usuário e não pode ser deletado. Por favor, atualize seu bem para que não referencie mais este usuário e tente novamente. ',

    'create' => array(
        'error'   		=> 'O ativo não foi criado, tente novamente. :(',
        'success' 		=> 'Ativo criado com sucesso. :)'
    ),

    'update' => array(
        'error'   			=> 'O ativo não foi atualizado, tente novamente',
        'success' 			=> 'Ativo atualizado com sucesso.',
        'nothing_updated'	=>  'Nenhum campo foi selecionado, então nada foi atualizado.',
    ),

    'restore' => array(
        'error'   		=> 'O ativo não foi restaurado, tente novamente',
        'success' 		=> 'Ativo restaurado com sucesso.'
    ),

    'deletefile' => array(
        'error'   => 'O arquivo não foi excluído. Tente novamente.',
        'success' => 'Arquivo excluído com sucesso.',
    ),

    'upload' => array(
        'error'   => 'O(s) arquivo(s) não foi/foram carregado(s). Tente novamente.',
        'success' => 'Arquivo(s) carregado(s) com sucesso.',
        'nofiles' => 'Você não selecionou arquivos para carregar, ou o arquivo que você esta tentando carrega é muito grande',
        'invalidfiles' => 'Um ou mais de seus arquivos é muito grande ou está em um tipo de arquivo não permitido. Os tipos permitidos são png, gif, jpg, doc, docx, pdf, e txt.',
    ),

    'import' => array(
<<<<<<< HEAD
        'error'         => 'Some items did not import correctly.',
        'errorDetail'   => 'The following Items were not imported because of errors.',
        'success'       => "Your file has been imported",
=======
        'error'                 => 'Alguns itens não foram importados corretamente.',
        'errorDetail'           => 'Os seguintes itens não foram importados devido a erros.',
        'success'               => "O seu arquivo foi importado",
        'file_delete_success'   => "O arquivo foi excluído com sucesso",
        'file_delete_error'      => "Não foi possível excluir o arquivo",
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72
    ),


    'delete' => array(
        'confirm'   	=> 'Tem certeza de que deseja excluir este ativo?',
        'error'   		=> 'Houve um problema ao excluir o ativo. Tente novamente.',
        'success' 		=> 'O ativo foi excluído com sucesso.'
    ),

    'checkout' => array(
        'error'   		=> 'Ativo não foi registrado, favor tentar novamente',
        'success' 		=> 'Ativo registrado com sucesso.',
        'user_does_not_exist' => 'Este usuário é inválido. Tente novamente.',
<<<<<<< HEAD
        'not_available' => 'That asset is not available for checkout!'
=======
        'not_available' => 'Esse recurso não está disponível para checkout!'
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72
    ),

    'checkin' => array(
        'error'   		=> 'Ativo não foi retornado, favor tentar novamente',
        'success' 		=> 'Ativo retornado com sucesso.',
        'user_does_not_exist' => 'Este usuário é inválido. Tente novamente.',
        'already_checked_in'  => 'Este ativo já foi devolvido.',

    ),

    'requests' => array(
        'error'   		=> 'Ativo não foi solicitado, por favor tente novamente',
        'success' 		=> 'Ativo solicitado com sucesso.',
<<<<<<< HEAD
=======
        'canceled'      => 'Checkout request successfully canceled'
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72
    )

);

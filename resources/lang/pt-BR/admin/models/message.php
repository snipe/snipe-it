<?php

return array(

    'does_not_exist' => 'O modelo não existe.',
    'assoc_users'	 => 'Este modelo está no momento associado com um ou mais ativos e não pode ser excluído. Exclua os ativos e então tente excluir novamente. ',


    'create' => array(
        'error'   => 'O modelo não foi criado, tente novamente.',
        'success' => 'Modelo criado com sucesso.',
        'duplicate_set' => 'Um modelo de ativo com este nome, desse fabricante e desse modelo já existe.',
    ),

    'update' => array(
        'error'   => 'O modelo não foi atualizado, tente novamente',
        'success' => 'Modelo atualizado com sucesso.'
    ),

    'delete' => array(
        'confirm'   => 'Tem certeza de que quer excluir este modelo de ativo?',
        'error'   => 'Houve um problema ao deletar o modelo. Por favor, tente novamente.',
        'success' => 'O modelo foi excluído com sucesso.'
    ),

    'restore' => array(
        'error'   		=> 'O modelo não foi restaurado, tente novamente',
        'success' 		=> 'Modelo restaurado com sucesso.'
    ),

    'bulkedit' => array(
        'error'   		=> 'Nenhum campo foi alterado, então nada foi atualizado.',
        'success' 		=> 'Modelos atualizados.'
    ),

    'bulkdelete' => array(
        'error'   		    => 'Nenhum modelo foi selecionado, então nada foi deletado.',
        'success' 		    => '::succes_count model (s) deletados!',
        'success_partial' 	=> ':success_count model(s) foram deletados,no entando :fail_count não pode ser excluído porque eles ainda possuem ativos associados a eles.'
    ),

);

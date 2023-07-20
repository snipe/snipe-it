<?php

return array(

    'does_not_exist' => 'O Modelo não existe.',
    'no_association' => 'NO MODEL ASSOCIATED.',
    'no_association_fix' => 'This will break things in weird and horrible ways. Edit this asset now to assign it a model.',
    'assoc_users'	 => 'Este modelo está atualmente associado com pelo menos um artigo e não pode ser removido. Por favor, remova os artigos e depois tente novamente. ',


    'create' => array(
        'error'   => 'O Modelo não foi criado. Por favor tente novamente.',
        'success' => 'Modelo criado com sucesso.',
        'duplicate_set' => 'Já existe um Modelo de artigo com esse nome, fabricante e número de modelo.',
    ),

    'update' => array(
        'error'   => 'O Modelo não foi atualizado. Por favor tente novamente',
        'success' => 'Modelo atualizado com sucesso.',
    ),

    'delete' => array(
        'confirm'   => 'Tem a certeza que pretende remover este modelo de artigo?',
        'error'   => 'Ocorreu um problema ao remover o modelo. Por favor, tente novamente.',
        'success' => 'O modelo foi removido com sucesso.'
    ),

    'restore' => array(
        'error'   		=> 'O Modelo não foi restaurado, por favor tente novamente',
        'success' 		=> 'Modelo restaurado com sucesso.'
    ),

    'bulkedit' => array(
        'error'   		=> 'Nenhum campo foi alterado, portanto, nada foi atualizado.',
        'success' 		=> 'Model successfully updated. |:model_count models successfully updated.',
        'warn'          => 'You are about to update the properies of the following model: |You are about to edit the properties of the following :model_count models:',

    ),

    'bulkdelete' => array(
        'error'   		    => 'Nenhum modelo selecionado, por isso nenhum modelo foi eliminado.',
        'success' 		    => 'Model deleted!|:success_count models deleted!',
        'success_partial' 	=> ':sucess_count modelo(s) eliminados, no entanto :fail_count não foram eliminados, porque ainda têm artigos associados.'
    ),

);

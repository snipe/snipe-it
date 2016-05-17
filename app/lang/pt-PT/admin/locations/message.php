<?php

return array(

    'does_not_exist' => 'Localização não existe.',
    'assoc_users'	 => 'Esta localização está atualmente associada com pelo menos um utilizador e não pode ser removida. Atualize este utilizadores de modo a não referenciarem mais este local e tente novamente. ',
    'assoc_assets'	 => 'Esta localização está atualmente associada com pelo menos um artigo e não pode ser removida. Atualize este artigos de modo a não referenciarem mais este local e tente novamente. ',
    'assoc_child_loc'	 => 'Esta localização contém pelo menos uma sub-localização e não pode ser removida. Por favor, atualize as localizações para não referenciarem mais esta localização e tente novamente. ',


    'create' => array(
        'error'   => 'Não foi possível criar a localização. Por favor, tente novamente.',
        'success' => 'Localização criada com sucesso.'
    ),

    'update' => array(
        'error'   => 'A localização não foi atualizada. Por favor, tente novamente',
        'success' => 'Localização atualizada com sucesso.'
    ),

    'delete' => array(
        'confirm'   	=> 'Tem a certeza que pretende remover esta localização?',
        'error'   => 'Ocorreu um problema ao remover esta localização. Por favor, tente novamente.',
        'success' => 'A localização foi removida com sucesso.'
    )

);

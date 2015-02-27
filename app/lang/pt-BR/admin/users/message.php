<?php

return array(

    'user_exists'              	=> 'O usuário já existe!',
    'user_not_found'           	=> 'O usuário [:id] não existe.',
    'user_login_required'      	=> 'O campo entrar é requerido',
    'user_password_required'   	=> 'A senha é requerida.',
    'insufficient_permissions' 	=> 'Permissões Insuficientes.',
    'user_deleted_warning' 		=> 'Este usuário foi deletado. Você terá que restaurar este usuário para editá-los ou atribui-lós novos bens.',


    'success' => array(
        'create'    => 'O usuário foi criado com sucesso.',
        'update'    => 'O usuário foi atualizado com sucesso.',
        'delete'    => 'O usuário foi deletado com sucesso.',
        'ban'       => 'O usuário foi banido com sucesso.',
        'unban'     => 'O usuário foi desbanido com sucesso.',
        'suspend'   => 'O usuário foi suspenso com sucesso.',
        'unsuspend' => 'O usuário foi dessuspenso com sucesso.',
        'restored'  => 'O usuário foi restaurado com sucesso.',
+       'import'    => 'Usuários importados com sucesso.',
    ),

    'error' => array(
        'create' => 'Houve um problema ao criar o usuário. Por favor, tente novamente.',
        'update' => 'Houve um problema ao atualizar o usuário. Por favor, tente novamente.',
        'delete' => 'Houve um problema ao deletar o usuário. Por favor, tente novamente.',
        'unsuspend' => 'Houve um problema ao dessuspender o usuário. Por favor, tente novamente.',
        'import'    => 'Houve um problema ao importar os usuários. Tente novamente.',
    ),

);

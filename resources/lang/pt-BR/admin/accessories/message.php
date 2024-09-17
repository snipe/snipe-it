<?php

return array(

    'does_not_exist' => 'Este acessório [:id] não existe.',
    'not_found' => 'Esse acessório não foi encontrado.',
    'assoc_users'	 => 'Este acessório tem atualmente :count itens alocado para os usuários. Por favor, verifique em acessórios e e tente novamente. ',

    'create' => array(
        'error'   => 'Acessório não criado, Por favor tente novamente.',
        'success' => 'Acessório criado com sucesso.'
    ),

    'update' => array(
        'error'   => 'Acessório não atualizado, Por favor tente novamente',
        'success' => 'Acessório atualizado com sucesso.'
    ),

    'delete' => array(
        'confirm'   => 'Tem certeza de que deseja excluir este acessório?',
        'error'   => 'Ocorreu um problema ao remover o acessório. Por favor, tente novamente.',
        'success' => 'O acessório foi excluído com sucesso.'
    ),

     'checkout' => array(
        'error'   		=> 'O acessório não foi alocado, por favor tente novamente',
        'success' 		=> 'Acessório alocado com sucesso.',
        'unavailable'   => 'Acessório não está disponível para check-out. Verifique a quantidade disponível',
        'user_does_not_exist' => 'Este usuário é inválido. Tente novamente.',
         'checkout_qty' => array(
            'lte'  => 'There is currently only one available accessory of this type, and you are trying to check out :checkout_qty. Please adjust the checkout quantity or the total stock of this accessory and try again.|There are :number_currently_remaining total available accessories, and you are trying to check out :checkout_qty. Please adjust the checkout quantity or the total stock of this accessory and try again.',
            ),
           
    ),

    'checkin' => array(
        'error'   		=> 'O acessório não foi devolvido, por favor, tente novamente',
        'success' 		=> 'Acessório devolvido com sucesso.',
        'user_does_not_exist' => 'Este usuário é inválido. Tente novamente.'
    )


);

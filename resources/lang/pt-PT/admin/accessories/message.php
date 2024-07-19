<?php

return array(

    'does_not_exist' => 'O acessório [:id] não existe.',
    'not_found' => 'Esse acessório não foi encontrado.',
    'assoc_users'	 => 'Esta acessório tem atualmente :count items alocados a utilizadores. Por favor, devolva-os e tente novamente. ',

    'create' => array(
        'error'   => 'Acessório não foi criado, por favor tente novamente.',
        'success' => 'Acessório criado com sucesso.'
    ),

    'update' => array(
        'error'   => 'Acessório não foi actualizado, por favor tente novamente',
        'success' => 'Acessório actualizado com sucesso.'
    ),

    'delete' => array(
        'confirm'   => 'Tem a certeza que pretende remover este acessório?',
        'error'   => 'Ocorreu um problema ao remover o acessório. Por favor, tente novamente.',
        'success' => 'O acessório foi removido com sucesso.'
    ),

     'checkout' => array(
        'error'   		=> 'O acessório não foi alocado. Por favor, tente novamente',
        'success' 		=> 'Acessório alocado com sucesso.',
        'unavailable'   => 'O acessório não está disponível para check-out. Verifique a quantidade disponível',
        'user_does_not_exist' => 'O utilizador é inválido. Por favor, tente novamente.',
         'checkout_qty' => array(
            'lte'  => 'There is currently only one available accessory of this type, and you are trying to check out :checkout_qty. Please adjust the checkout quantity or the total stock of this accessory and try again.|There are :number_currently_remaining total available accessories, and you are trying to check out :checkout_qty. Please adjust the checkout quantity or the total stock of this accessory and try again.',
            ),
           
    ),

    'checkin' => array(
        'error'   		=> 'O acessório não foi devolvido. Por favor, tente novamente',
        'success' 		=> 'Acessório devolvido com sucesso.',
        'user_does_not_exist' => 'O utilizador é inválido. Por favor, tente novamente.'
    )


);

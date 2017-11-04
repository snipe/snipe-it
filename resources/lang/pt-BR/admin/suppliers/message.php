<?php

return array(

    'does_not_exist' => 'O fornecedor não existe.',


    'create' => array(
        'error'   => 'O fornecedor não foi criado, tente novamente.',
        'success' => 'Fornecedor criado com sucesso.'
    ),

    'update' => array(
        'error'   => 'O fornecedor não foi atualizado, tente novamente',
        'success' => 'Fornecedor atualizado com sucesso.'
    ),

    'delete' => array(
        'confirm'   => 'Tem certeza de que deseja excluir este fornecedor?',
        'error'   => 'Houve um problema ao excluir o fornecedor. Tente novamente.',
        'success' => 'O fornecedor foi excluído com sucesso.',
        'assoc_assets'	 => 'This supplier is currently associated with :asset_count asset(s) and cannot be deleted. Please update your assets to no longer reference this supplier and try again. ',
        'assoc_licenses'	 => 'This supplier is currently associated with :licenses_count licences(s) and cannot be deleted. Please update your licenses to no longer reference this supplier and try again. ',
        'assoc_maintenances'	 => 'This supplier is currently associated with :asset_maintenances_count asset maintenances(s) and cannot be deleted. Please update your asset maintenances to no longer reference this supplier and try again. ',
    )

);

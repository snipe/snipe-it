<?php

return array(

    'does_not_exist' => 'Fornecedor não existente.',


    'create' => array(
        'error'   => 'Não foi possível criar o Fornecedor, por favor tente novamente.',
        'success' => 'Fornecedor criado com sucesso.'
    ),

    'update' => array(
        'error'   => 'Não foi possível atualizar o Fornecedor, por favor tente novamente',
        'success' => 'Fornecedor atualizado com sucesso.'
    ),

    'delete' => array(
        'confirm'   => 'Tem a certeza que pretende remover este fornecedor?',
        'error'   => 'Ocorreu um problema ao remover este fornecedor. Por favor, tente novamente.',
        'success' => 'Fornecedor removido com sucesso.',
        'assoc_assets'	 => 'This supplier is currently associated with :asset_count asset(s) and cannot be deleted. Please update your assets to no longer reference this supplier and try again. ',
        'assoc_licenses'	 => 'This supplier is currently associated with :licenses_count licences(s) and cannot be deleted. Please update your licenses to no longer reference this supplier and try again. ',
        'assoc_maintenances'	 => 'This supplier is currently associated with :asset_maintenances_count asset maintenances(s) and cannot be deleted. Please update your asset maintenances to no longer reference this supplier and try again. ',
    )

);

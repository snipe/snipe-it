<?php

return [
    'about_assets_title'           => 'Sobre os artigos',
    'about_assets_text'            => 'Artigos são itens seguidos por números de serie ou "asset tags". Eles tendem a ser itens de maior valor, onde a identificação de um item específico importa.',
    'archived'  				=> 'Arquivado',
    'asset'  					=> 'Ativo',
    'bulk_checkout'             => 'Artigos em checktout',
    'bulk_checkin'              => 'Receber Artigos',
    'checkin'  					=> 'Devolver Ativo',
    'checkout'  				=> 'Ativo de compras',
    'clone'  					=> 'Clonar Ativo',
    'deployable'  				=> 'Implementável',
    'deleted'  					=> 'Este ativo foi excluído.',
    'delete_confirm'            => 'Tem a certeza de que pretende eliminar este equipamento?',
    'edit'  					=> 'Editar artigo',
    'model_deleted'  			=> 'Este modelo de artigo foi excluído. Deve restaurar o modelo antes de restaurar o artigo.',
    'model_invalid'             => 'O modelo deste artigo é inválido.',
    'model_invalid_fix'         => 'O artigo deve ser editado para corrigir isso antes de tentar recebe-lo ou entregá-lo.',
    'requestable'               => 'Solicitavel',
    'requested'				    => 'Requisitado',
    'not_requestable'           => 'Não solicitável',
    'requestable_status_warning' => 'Não altere o estado solicitável',
    'restore'  					=> 'Restaurar ativo',
    'pending'  					=> 'Pendente',
    'undeployable'  			=> 'Não implementável',
    'undeployable_tooltip'  	=> 'Este artigo possui uma etiqueta de estado que não é implantável e não pode ser entregue no momento.',
    'view'  					=> 'Ver Artigo',
    'csv_error' => 'Tem um erro no ficheiro CSV:',
    'import_text' => '
    <p>
    Carregar um CSV que contém o histórico de ativos. Os artigos e utilizadores DEVEM já existir no sistema, ou serão ignorados. Artigos para a importação de histórico corresponde com a etiqueta de artigo. Tentaremos encontrar um utilizador correspondente com base no nome de utilizador que fornecer, e nos critérios que selecionar abaixo. Se não selecionar nenhum critério abaixo, o sistema vai simplesmente tentar combinar com o formato de nome de utilizador configurado nas Configurações Gerais de Administração &gt;.
    </p>

    <p>campos incluídos no CSV devem corresponder aos cabeçalhos: <strong>Etiqueta de Artigo, Nome, Data de Entrega, Data de Receção</strong>. Quaisquer campos adicionais serão ignorados. </p>

    <p>Data de  Entrega: em branco ou datas futuras de entrega irão entregar os artigos o utilizador associado. Excluindo a coluna Data de Receção criará uma data de receção com a data de hoje.</p>
    ',
    'csv_import_match_f-l' => 'Tente corresponder aos utilizadores pelo formato primeiro nome.último nome (fulano.sicrano)',
    'csv_import_match_initial_last' => 'Tente combinar os utilizadores pelo formato primeira letra e sobrenome (fsicrano)',
    'csv_import_match_first' => 'Tente combinar os utilizadores pelo formato de primeiro nome (fulano)',
    'csv_import_match_email' => 'Tente combinar os utilizadores pelo endereço eletrónico como nome de utilizador',
    'csv_import_match_username' => 'Tente corresponder aos utilizadores pelo nome de utilizador',
    'error_messages' => 'Mensagens de erro:',
    'success_messages' => 'Mensagens de sucesso:',
    'alert_details' => 'Por favor, veja abaixo para detalhes.',
    'custom_export' => 'Exportação Personalizada',
    'mfg_warranty_lookup' => ':fabricante busca por estado de garantia',
    'user_department' => 'Departamento do Utilizador',
];

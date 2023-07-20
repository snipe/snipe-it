<?php

return [
    'about_assets_title'           => 'Sobre os Ativos',
    'about_assets_text'            => 'Ativos são itens que são controlados e rastreáveis pelo número de série ou por uma etiqueta de ativo (patrimônio). Eles tendem a ser de valor elevado onde a identificação de itens específicos é relevante.',
    'archived'  				=> 'Arquivado',
    'asset'  					=> 'Ativo',
    'bulk_checkout'             => 'Alocação de Ativos',
    'bulk_checkin'              => 'Check-in de Ativo',
    'checkin'  					=> 'Retornar Ativo',
    'checkout'  				=> 'Checkout de Ativo',
    'clone'  					=> 'Clonar Ativo',
    'deployable'  				=> 'Implementável',
    'deleted'  					=> 'Este modelo foi excluído.',
    'edit'  					=> 'Editar Ativo',
    'model_deleted'  			=> 'Este modelo de Ativos foi excluído. Você deve restaurar o modelo antes de restaurar o Ativo.',
    'model_invalid'             => 'O modelo deste ativo é inválido.',
    'model_invalid_fix'         => 'O Ativo deve ser editado para corrigir isso antes de tentar verificá-lo ou verificá-lo.',
    'requestable'               => 'Solicitável',
    'requested'				    => 'Solicitado',
    'not_requestable'           => 'Não solicitável',
    'requestable_status_warning' => 'Não altere o status solicitável',
    'restore'  					=> 'Restaurar Ativo',
    'pending'  					=> 'Pendente',
    'undeployable'  			=> 'Não implementável',
    'undeployable_tooltip'  	=> 'Este ativo possui uma etiqueta de status que não é implantável e não pode ser check-out no momento.',
    'view'  					=> 'Ver Ativo',
    'csv_error' => 'Você tem um erro no seu arquivo CSV:',
    'import_text' => '
    <p>
    Envie um CSV que contém o histórico de ativos. Os ativos e usuários DEVEM já existir no sistema, ou eles serão ignorados. Correspondendo mídias para a importação de histórico acontece com a tag de conteúdo. Tentaremos encontrar um usuário correspondente com base no nome de usuário que você fornece, e nos critérios que você selecionar abaixo. Se você não selecionar nenhum critério abaixo, ele vai simplesmente tentar combinar com o formato de nome de usuário configurado nas configurações de Administrador &gt; Geral.
    </p>

    <p>Campos incluídos no CSV devem corresponder os cabeçalhos: <strong>Marcador de Ativo, Nome, data de check-out, data</strong>. check-in. Quaisquer campos adicionais serão ignorados. </p>

    <p>Data de Checkin: em branco ou em datas futuras de check-in fará check-in dos itens para o usuário associado. Excluindo a coluna Data de check-in criará uma data de check-in com a data de hoje.</p>
    ',
    'csv_import_match_f-l' => 'Tente corresponder aos usuários pelo formato firstname.lastname (jane.smith)',
    'csv_import_match_initial_last' => 'Tente combinar os usuários pelo primeiro formato de sobrenome (jsmith)',
    'csv_import_match_first' => 'Tente combinar os usuários pelo formato do primeiro nome (jane)',
    'csv_import_match_email' => 'Tentar corresponder aos usuários por e-mail como nome de usuário',
    'csv_import_match_username' => 'Tente corresponder aos usuários pelo nome de usuário',
    'error_messages' => 'Mensagens de erro:',
    'success_messages' => 'Mensagens de sucesso:',
    'alert_details' => 'Por favor, veja abaixo para detalhes.',
    'custom_export' => 'Exportação Personalizada',
    'mfg_warranty_lookup' => ':manufacturer Busca por Situação de Garantia',
];

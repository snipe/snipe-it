<?php

return [
    'about_assets_title'           => 'Sobre os Ativos',
    'about_assets_text'            => 'Ativos são itens que são controlados e rastreáveis pelo número de série ou por uma etiqueta de ativo (patrimônio). Eles tendem a ser de valor elevado onde a identificação de itens específicos é relevante.',
    'archived'  				=> 'Arquivado',
    'asset'  					=> 'Ativo',
    'bulk_checkout'             => 'Alocação de Ativos',
    'bulk_checkin'              => 'Checkin Assets',
    'checkin'  					=> 'Retornar Ativo',
    'checkout'  				=> 'Checkout de Ativo',
    'clone'  					=> 'Clonar Ativo',
    'deployable'  				=> 'Implementável',
    'deleted'  					=> 'Este modelo foi excluído.',
    'edit'  					=> 'Editar Ativo',
    'model_deleted'  			=> 'Este modelo de Ativos foi excluído. Você deve restaurar o modelo antes de restaurar o Ativo.',
    'requestable'               => 'Solicitável',
    'requested'				    => 'Solicitado',
    'not_requestable'           => 'Not Requestable',
    'requestable_status_warning' => 'Do not change  requestable status',
    'restore'  					=> 'Restaurar Ativo',
    'pending'  					=> 'Pendente',
    'undeployable'  			=> 'Não implementável',
    'view'  					=> 'Ver Ativo',
    'csv_error' => 'You have an error in your CSV file:',
    'import_text' => '
    <p>
    Upload a CSV that contains asset history. The assets and users MUST already exist in the system, or they will be skipped. Matching assets for history import happens against the asset tag. We will try to find a matching user based on the user\'s name you provide, and the criteria you select below. If you do not select any criteria below, it will simply try to match on the username format you configured in the Admin &gt; General Settings.
    </p>

    <p>Fields included in the CSV must match the headers: <strong>Asset Tag, Name, Checkout Date, Checkin Date</strong>. Any additional fields will be ignored. </p>

    <p>Checkin Date: blank or future checkin dates will checkout items to associated user.  Excluding the Checkin Date column will create a checkin date with todays date.</p>
    ',
    'csv_import_match_f-l' => 'Try to match users by firstname.lastname (jane.smith) format',
    'csv_import_match_initial_last' => 'Try to match users by first initial last name (jsmith) format',
    'csv_import_match_first' => 'Try to match users by first name (jane) format',
    'csv_import_match_email' => 'Try to match users by email as username',
    'csv_import_match_username' => 'Try to match users by username',
    'error_messages' => 'Error messages:',
    'success_messages' => 'Success messages:',
    'alert_details' => 'Please see below for details.',
    'custom_export' => 'Custom Export'
];

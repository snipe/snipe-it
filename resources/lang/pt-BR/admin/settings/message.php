<?php

return [

    'update' => [
        'error'                 => 'Ocorreu um erro ao atualizar. ',
        'success'               => 'Configurações atualizadas com sucesso.',
    ],
    'backup' => [
        'delete_confirm'        => 'Você tem certeza que quer apagar este arquivo de backup? Esta ação não pode ser desfeita. ',
        'file_deleted'          => 'O arquivo de backup foi apagado com sucesso. ',
        'generated'             => 'Um novo arquivo de backup foi criado com sucesso.',
        'file_not_found'        => 'Arquivo de backup não foi encontrado no servidor.',
        'restore_warning'       => 'Yes, restore it. I acknowledge that this will overwrite any existing data currently in the database. This will also log out all of your existing users (including you).',
        'restore_confirm'       => 'Are you sure you wish to restore your database from :filename?'
    ],
    'purge' => [
        'error'     => 'Ocorreu um erro ao excluir os registros. ',
        'validation_failed'     => 'Sua confirmação de exclusão está incorreta. Por favor, digite a palavra "DELETE" na caixa de confirmação.',
        'success'               => 'Registros excluídos com sucesso.',
    ],
    'mail' => [
        'sending' => 'Sending Test Email...',
        'success' => 'Mail sent!',
        'error' => 'Mail could not be sent.',
        'additional' => 'No additional error message provided. Check your mail settings and your app log.'
    ],
    'ldap' => [
        'testing' => 'Testing LDAP Connection, Binding & Query ...',
        '500' => '500 Server Error. Please check your server logs for more information.',
        'error' => 'Something went wrong :(',
        'sync_success' => 'A sample of 10 users returned from the LDAP server based on your settings:',
        'testing_authentication' => 'Testing LDAP Authentication...',
        'authentication_success' => 'User authenticated against LDAP successfully!'
    ],
    'slack' => [
        'sending' => 'Sending Slack test message...',
        'success_pt1' => 'Success! Check the ',
        'success_pt2' => ' channel for your test message, and be sure to click SAVE below to store your settings.',
        '500' => '500 Server Error.',
        'error' => 'Something went wrong.',
    ]
];

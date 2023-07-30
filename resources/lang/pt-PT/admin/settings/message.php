<?php

return [

    'update' => [
        'error'                 => 'Ocorreu um erro ao atualizar. ',
        'success'               => 'Configurações atualizadas com sucesso.',
    ],
    'backup' => [
        'delete_confirm'        => 'Tem a certeza que pretende eliminar o ficheiro de backup? Não poderá reverter a acção. ',
        'file_deleted'          => 'Ficheiro de backup eliminado com sucesso. ',
        'generated'             => 'Ficheiro de backup criado com sucesso.',
        'file_not_found'        => 'O ficheiro de backup não foi encontrado no servidor.',
        'restore_warning'       => 'Yes, restore it. I acknowledge that this will overwrite any existing data currently in the database. This will also log out all of your existing users (including you).',
        'restore_confirm'       => 'Are you sure you wish to restore your database from :filename?'
    ],
    'purge' => [
        'error'     => 'Ocorreu um erro ao eliminar os dados. ',
        'validation_failed'     => 'A confirmação para limpar os dados correu mal. Digite a palavra "Apagar" na caixa de confirmação.',
        'success'               => 'Os dados foram apagados com sucesso.',
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
    'webhook' => [
        'sending' => 'Sending :app test message...',
        'success_pt1' => 'Success! Check the ',
        'success_pt2' => ' channel for your test message, and be sure to click SAVE below to store your settings.',
        '500' => '500 Server Error.',
        'error' => 'Something went wrong. :app responded with: :error_message',
        'error_misc' => 'Something went wrong. :( ',
    ]
];

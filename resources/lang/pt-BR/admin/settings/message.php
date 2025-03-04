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
        'restore_warning'       => 'Sim, restaurar. Eu reconheço que isso irá sobrescrever quaisquer dados existentes atualmente no banco de dados. Isto também desconectará todos os usuários existentes (incluindo você).',
        'restore_confirm'       => 'Tem certeza que deseja restaurar seu banco de dados a partir de :filename?'
    ],
    'restore' => [
        'success'               => 'Seu backup do sistema foi restaurado. Por favor, faça login novamente.'
    ],
    'purge' => [
        'error'     => 'Ocorreu um erro ao excluir os registros. ',
        'validation_failed'     => 'Sua confirmação de exclusão está incorreta. Por favor, digite a palavra "DELETE" na caixa de confirmação.',
        'success'               => 'Registros excluídos com sucesso.',
    ],
    'mail' => [
        'sending' => 'Enviando e-mail de teste...',
        'success' => 'Email enviado!',
        'error' => 'E-mail não pode ser enviado.',
        'additional' => 'Nenhuma mensagem de erro adicional foi fornecida. Verifique suas configurações de e-mail e o log do aplicativo.'
    ],
    'ldap' => [
        'testing' => 'Testando conexão LDAP, Binding & Query ...',
        '500' => '500 Erro de Servidor. Por favor, verifique os logs do servidor para mais informações.',
        'error' => 'Algo deu errado :(',
        'sync_success' => 'Uma amostra de 10 usuários retornaram do servidor LDAP com base em suas configurações:',
        'testing_authentication' => 'Testando Autenticação LDAP...',
        'authentication_success' => 'Usuário autenticado no LDAP com sucesso!'
    ],
    'labels' => [
        'null_template' => 'Label template not found. Please select a template.',
        ],
    'webhook' => [
        'sending' => 'Enviando mensagem :app de teste...',
        'success' => 'Sua integração com :webhook_name funciona!',
        'success_pt1' => 'Sucesso! Verifique o ',
        'success_pt2' => ' canal para sua mensagem de teste, e certifique-se de clicar em SALVAR abaixo para armazenar suas configurações.',
        '500' => '500 Erro no Servidor.',
        'error' => 'Algo deu errado. :app respondeu com: :error_message',
        'error_redirect' => 'ERRO: 301/302 :endpoint retorna um redirecionamento. Por razões de segurança, não seguimos redirecionamentos. Por favor, use o ponto de extremidade atual.',
        'error_misc' => 'Algo deu errado. :( ',
        'webhook_fail' => ' webhook notification failed: Check to make sure the URL is still valid.',
        'webhook_channel_not_found' => ' webhook channel not found.'
    ]
];

<?php

return [

    'does_not_exist' => 'O local não existe.',
    'assoc_users' => 'Este local não pode ser excluído no momento, pois é o local de registro de pelo menos um ativo ou usuário, possui ativos atribuídos a ele ou é o local principal de outro local. Atualize seus registros para que não façam mais referência a este local e tente novamente ',
    'assoc_assets' => 'Este local esta atualmente associado a pelo menos um ativo e não pode ser deletado. Por favor atualize seu ativo para não fazer mais referência a este local e tente novamente. ',
    'assoc_child_loc' => 'Este local é atualmente o principal de pelo menos local secundário e não pode ser deletado. Por favor atualize seus locais para não fazer mais referência a este local e tente novamente. ',
    'assigned_assets' => 'Ativos atribuídos',
    'current_location' => 'Localização Atual',
    'deleted_warning' => 'Esta localização foi deletado. Por favor, restaure-o antes de tentar fazer quaisquer alterações.',

    'create' => [
        'error' => 'O local não foi criado, tente novamente.',
        'success' => 'Local criado com sucesso.',
    ],

    'update' => [
        'error' => 'O local não foi atualizado, tente novamente',
        'success' => 'Local atualizado com sucesso.',
    ],

    'restore' => [
        'error' => 'A localização não foi restaurada, por favor, tente novamente',
        'success' => 'Localização restaurada com sucesso.',
    ],

    'delete' => [
        'confirm' => 'Tem certeza de que quer excluir este local?',
        'error' => 'Houve um problema ao excluir o local. Tente novamente.',
        'success' => 'O local foi excluído com sucesso.',
    ],

    'bulkedit' => [
        'error' => 'Nenhum campo foi alterado, então nada foi atualizado.',
        'success' => 'Location successfully updated.|:count locations successfully updated.',
        'warn' => 'Edit the fields below to update this location. Fields you leave blank will not change on the location.|Edit the fields below to update all :count selected locations. Fields you leave blank will not change on any of them.',
        'show_selected' => '1 selected location|:count selected locations',
        'company_scope_mismatch_partial' => 'The company was not changed on 1 location because items or users at that location belong to different companies. Update or move those first.|The company was not changed on :count locations because items or users at those locations belong to different companies. Update or move those first.',
        'company_scope_mismatch_all' => 'No locations were reassigned. The requested company does not match items or users at the selected location.|No locations were reassigned. The requested company does not match items or users at any of the :count selected locations.',
        'parent_company_mismatch_partial' => 'The parent or company was not changed on 1 location because it would leave the location in a different company than its parent.|The parent or company was not changed on :count locations because it would leave those locations in a different company than their parent.',
        'parent_company_mismatch_all' => 'No changes were saved. The requested parent or company would leave the location in a different company than its parent.|No changes were saved. The requested parent or company would leave every one of the :count selected locations in a different company than their parent.',
    ],

];

<?php

return [

    'does_not_exist' => 'Localização não existe.',
    'assoc_users' => 'This location is not currently deletable because it is the location of record for at least one item or user, has assets assigned to it, or is the parent location of another location. Please update your records to no longer reference this location and try again ',
    'assoc_assets' => 'Esta localização está atualmente associada com pelo menos um artigo e não pode ser removida. Atualize este artigos de modo a não referenciarem mais este local e tente novamente. ',
    'assoc_child_loc' => 'Esta localização contém pelo menos uma sub-localização e não pode ser removida. Por favor, atualize as localizações para não referenciarem mais esta localização e tente novamente. ',
    'assigned_assets' => 'Artigos atribuídos',
    'current_location' => 'Localização atual',
    'deleted_warning' => 'This location has been deleted. Please restore it before attempting to make any changes.',

    'create' => [
        'error' => 'Não foi possível criar a localização. Por favor, tente novamente.',
        'success' => 'Localização criada com sucesso.',
    ],

    'update' => [
        'error' => 'A localização não foi atualizada. Por favor, tente novamente',
        'success' => 'Localização atualizada com sucesso.',
    ],

    'restore' => [
        'error' => 'Location was not restored, please try again',
        'success' => 'Localização restaurada com sucesso.',
    ],

    'delete' => [
        'confirm' => 'Tem a certeza que pretende remover esta localização?',
        'error' => 'Ocorreu um problema ao remover esta localização. Por favor, tente novamente.',
        'success' => 'A localização foi removida com sucesso.',
    ],

    'bulkedit' => [
        'error' => 'Nenhum campo foi alterado, portanto, nada foi atualizado.',
        'success' => 'Location successfully updated.|:count locations successfully updated.',
        'warn' => 'Edit the fields below to update this location. Fields you leave blank will not change on the location.|Edit the fields below to update all :count selected locations. Fields you leave blank will not change on any of them.',
        'show_selected' => '1 selected location|:count selected locations',
        'company_scope_mismatch_partial' => 'The company was not changed on 1 location because items or users at that location belong to different companies. Update or move those first.|The company was not changed on :count locations because items or users at those locations belong to different companies. Update or move those first.',
        'company_scope_mismatch_all' => 'No locations were reassigned. The requested company does not match items or users at the selected location.|No locations were reassigned. The requested company does not match items or users at any of the :count selected locations.',
        'parent_company_mismatch_partial' => 'The parent or company was not changed on 1 location because it would leave the location in a different company than its parent.|The parent or company was not changed on :count locations because it would leave those locations in a different company than their parent.',
        'parent_company_mismatch_all' => 'No changes were saved. The requested parent or company would leave the location in a different company than its parent.|No changes were saved. The requested parent or company would leave every one of the :count selected locations in a different company than their parent.',
    ],

];

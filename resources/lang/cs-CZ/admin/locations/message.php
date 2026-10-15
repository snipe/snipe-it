<?php

return [

    'does_not_exist' => 'Místo neexistuje.',
    'assoc_users' => 'Toto umístění momentálně nelze smazat, protože je použito pro nejméně jednu položku nebo uživatele, jsou k němu přiřazena zařízení nebo je nadřazené jinému umístění. Prosím upravte své záznamy tak, aby toto umístění nebylo odkazováno a zkuste to znovu ',
    'assoc_assets' => 'Toto umístění je spojeno s alespoň jedním majetkem a nemůže být smazáno. Aktualizujte majetky tak aby nenáleželi k tomuto umístění a zkuste to znovu. ',
    'assoc_child_loc' => 'Toto umístění je nadřazené alespoň jednomu umístění a nelze jej smazat. Aktualizujte své umístění tak, aby na toto umístění již neodkazovalo a zkuste to znovu. ',
    'assigned_assets' => 'Přiřazený majetek',
    'current_location' => 'Současné umístění',
    'deleted_warning' => 'Toto umístění bylo smazáno. Před jakýmkoli pokusem o změny je prosím obnovte.',

    'create' => [
        'error' => 'Místo nebylo vytvořeno, zkuste to znovu prosím.',
        'success' => 'Místo bylo úspěšně vytvořeno.',
    ],

    'update' => [
        'error' => 'Místo nebylo aktualizováno, zkuste to znovu prosím',
        'success' => 'Místo úspěšně aktualizováno.',
    ],

    'restore' => [
        'error' => 'Umístění nebylo obnoveno, zkuste to prosím znovu',
        'success' => 'Umístění bylo úspěšně vytvořeno.',
    ],

    'delete' => [
        'confirm' => 'Opravdu si želáte vymazat tohle místo na trvalo?',
        'error' => 'Vyskytl se problém při mazání místa. Zkuste to znovu prosím.',
        'success' => 'Místo bylo úspěšně smazáno.',
    ],

    'bulkedit' => [
        'error' => 'Žádné pole nebyly změněny, takže nic nebylo aktualizováno.',
        'success' => 'Location successfully updated.|:count locations successfully updated.',
        'warn' => 'Edit the fields below to update this location. Fields you leave blank will not change on the location.|Edit the fields below to update all :count selected locations. Fields you leave blank will not change on any of them.',
        'show_selected' => '1 selected location|:count selected locations',
        'company_scope_mismatch_partial' => 'The company was not changed on 1 location because items or users at that location belong to different companies. Update or move those first.|The company was not changed on :count locations because items or users at those locations belong to different companies. Update or move those first.',
        'company_scope_mismatch_all' => 'No locations were reassigned. The requested company does not match items or users at the selected location.|No locations were reassigned. The requested company does not match items or users at any of the :count selected locations.',
        'parent_company_mismatch_partial' => 'The parent or company was not changed on 1 location because it would leave the location in a different company than its parent.|The parent or company was not changed on :count locations because it would leave those locations in a different company than their parent.',
        'parent_company_mismatch_all' => 'No changes were saved. The requested parent or company would leave the location in a different company than its parent.|No changes were saved. The requested parent or company would leave every one of the :count selected locations in a different company than their parent.',
    ],

];

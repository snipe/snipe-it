<?php

return [

    'deleted' => 'Model aktiva byl smazán',
    'does_not_exist' => 'Model neexistuje.',
    'no_association' => 'VAROVÁNÍ! Model majetku pro tuto položku je neplatný, nebo chybí!',
    'no_association_fix' => 'Tento stav může způsobit nedozírné problémy. Přiřaďte dotyčnému majetku správný model.',
    'assoc_users' => 'Tento model je spojen s alespoň jedním majetkem a nemůže být smazán. Prosím smažte tyto majetky a pak to zkuste znovu. ',
    'invalid_category_type' => 'Tato kategorie musí být kategorií zařízení.',

    'create' => [
        'error' => 'Model nebyl vytvořen, zkuste to znovu.',
        'success' => 'Model byl úspěšně vytvořen.',
        'duplicate_set' => 'Model majetku s tímto názvem, výrobcem a číslem modelu již existuje.',
    ],

    'update' => [
        'error' => 'Model nebyl aktualizován, zkuste to prosím znovu',
        'success' => 'Model byl úspěšně aktualizován.',
    ],

    'delete' => [
        'confirm' => 'Opravdu si přejete tento model majetku odstranit?',
        'error' => 'Vyskytl se problém se smazáním modelu. Zkuste to znovu.',
        'success' => 'Model byl úspěšně smazán.',
    ],

    'restore' => [
        'error' => 'Model nebyl obnoven, zkuste to prosím znovu',
        'success' => 'Model byl úspěšně obnoven.',
    ],

    'bulkedit' => [
        'error' => 'Žádné pole nebyly změněny, takže nic nebylo aktualizováno.',
        'success' => 'Model úspěšně upraven. |:model_count modelů bylo úspěšně upraveno.',
        'warn' => 'Chystáte se aktualizovat vlastnosti následujícího modelu:|Chystáte se upravit vlastnosti následujících :model_count modelů:',

    ],

    'bulkdelete' => [
        'error' => 'Nebyly vybrány žádné modely, takže nebylo nic smazáno.',
        'nothing_deletable' => 'None of the selected models can be deleted because they still have assets associated with them.',
        'success' => 'Model smazán!|:success_count modelů odstraněno!',
        'success_partial' => ':success_count modelů smazáno, ale :fail_count nebylo možné smazat protože pořád mají přiřazený majetek.',
    ],

    'merge' => [
        'min_two' => 'Select at least two models to merge.',
        'no_target' => 'Select which model to keep before merging.',
        'not_found' => 'One or more of the selected models could not be loaded. Refresh the models list and try again.',
        'information' => 'You are about to merge :count models. Pick the model you want to keep. Every asset attached to the other models will be reassigned to the model you pick, then the source models will be deleted.',
        'warning' => 'This cannot be undone. Reassigned assets will inherit the surviving model\'s category, fieldset, and depreciation settings.',
        'pick_target' => 'Which model do you want to keep?',
        'success' => 'Merged :source_count model(s) into ":target". :asset_count asset(s) were reassigned.',
    ],

];

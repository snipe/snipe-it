<?php

return [

    'does_not_exist' => 'La Sede non esiste.',
    'assoc_users' => 'Questa Sede al momento non è eliminabile, perché vi sono registrati almeno un oggetto o un utente, o ha Beni assegnati, o è la sede "madre" di un\'altra sede. Aggiorna i dati in modo che non facciano più riferimento a questa sede, e riprova. ',
    'assoc_assets' => 'Questa Sede è associata ad almeno un prodotto e non può essere cancellata. Si prega di aggiornare i vostri prodotti di riferimento e riprovare. ',
    'assoc_child_loc' => 'La Sede contiene almeno un\'altra Sede, pertanto non può essere eliminata. Aggiorna le Sedi in modo che non siano parte di questa Sede e riprova. ',
    'assigned_assets' => 'Beni Assegnati',
    'current_location' => 'Sede attuale',
    'deleted_warning' => 'Questa Sede è stata eliminata. Prima di provare a fare modifiche, ricorda di ripristinarla.',

    'create' => [
        'error' => 'La Sede non è stata creata, si prega di riprovare.',
        'success' => 'Sede creata con successo.',
    ],

    'update' => [
        'error' => 'La Sede non è stata aggiornata, si prega di riprovare',
        'success' => 'Sede aggiornata con successo.',
    ],

    'restore' => [
        'error' => 'La Sede non è stata ripristinata, si prega di riprovare',
        'success' => 'La Sede è stata ripristinata con successo.',
    ],

    'delete' => [
        'confirm' => 'Sei sicuro di voler cancellare questa Sede?',
        'error' => 'C\'è stato un problema nell\'eliminare la Sede. Riprova.',
        'success' => 'Sede eliminata con successo.',
    ],

    'bulkedit' => [
        'error' => 'Nessun campo è stato modificato, quindi niente è stato aggiornato.',
        'success' => 'Location successfully updated.|:count locations successfully updated.',
        'warn' => 'Edit the fields below to update this location. Fields you leave blank will not change on the location.|Edit the fields below to update all :count selected locations. Fields you leave blank will not change on any of them.',
        'show_selected' => '1 selected location|:count selected locations',
        'company_scope_mismatch_partial' => 'The company was not changed on 1 location because items or users at that location belong to different companies. Update or move those first.|The company was not changed on :count locations because items or users at those locations belong to different companies. Update or move those first.',
        'company_scope_mismatch_all' => 'No locations were reassigned. The requested company does not match items or users at the selected location.|No locations were reassigned. The requested company does not match items or users at any of the :count selected locations.',
        'parent_company_mismatch_partial' => 'The parent or company was not changed on 1 location because it would leave the location in a different company than its parent.|The parent or company was not changed on :count locations because it would leave those locations in a different company than their parent.',
        'parent_company_mismatch_all' => 'No changes were saved. The requested parent or company would leave the location in a different company than its parent.|No changes were saved. The requested parent or company would leave every one of the :count selected locations in a different company than their parent.',
    ],

];

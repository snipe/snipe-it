<?php

return [

    'deleted' => 'Usunięty model środka',
    'does_not_exist' => 'Model nie istnieje.',
    'no_association' => 'OSTRZEŻENIE! Model środka dla tego przedmiotu jest nieprawidłowy lub brakuje!',
    'no_association_fix' => 'To zepsuje rzeczy w dziwny i straszny sposób. Edytuj teraz ten środek, aby przypisać mu model.',
    'assoc_users' => 'Ten model jest przypisany do minimum jednego środka i nie może być usunięty. Proszę usunąć środki, a następnie spróbować ponownie. ',
    'invalid_category_type' => 'Kategoria musi być kategorią środka.',

    'create' => [
        'error' => 'Model nie został stworzony. Spróbuj ponownie.',
        'success' => 'Model utworzony pomyślnie.',
        'duplicate_set' => 'Istnieje już model środka o tej nazwie, producencie i numerze.',
    ],

    'update' => [
        'error' => 'Model nie został zaktualizowany, spróbuj ponownie',
        'success' => 'Model zaktualizowany pomyślnie.',
    ],

    'delete' => [
        'confirm' => 'Czy na pewno chcesz usunąć ten model środków?',
        'error' => 'Wystąpił błąd podczas usuwania modelu. Spróbuj ponownie.',
        'success' => 'Model usunięty poprawnie.',
    ],

    'restore' => [
        'error' => 'Model nie został przywrócony, spróbuj ponownie',
        'success' => 'Model został przywrócony pomyślnie.',
    ],

    'bulkedit' => [
        'error' => 'Żadne pole nie zostało zmodyfikowane, więc nic nie zostało zaktualizowane.',
        'success' => 'Model pomyślnie zaktualizowany. |:model_count modele pomyślnie zaktualizowane.',
        'warn' => 'Zamierzasz zaktualizować właściwości następującego modelu:|Zamierzasz edytować właściwości następujących modeli :model_count:',

    ],

    'bulkdelete' => [
        'error' => 'Nie wybrano modeli, więc nic nie zostało usunięte.',
        'nothing_deletable' => 'None of the selected models can be deleted because they still have assets associated with them.',
        'success' => 'Model usunięty!|:success_count modele usunięte!',
        'success_partial' => ':success_count model(i) zostało usuniętych, jednakże :fail_count nie udało się usunąć, ponieważ wciąż są powiązane z nimi środki.',
    ],

    'merge' => [
        'min_two' => 'Zaznacz co najmniej dwa modele do scalenia.',
        'no_target' => 'Wskaż model do zachowania przed scaleniem.',
        'not_found' => 'One or more of the selected models could not be loaded. Refresh the models list and try again.',
        'information' => 'You are about to merge :count models. Pick the model you want to keep. Every asset attached to the other models will be reassigned to the model you pick, then the source models will be deleted.',
        'warning' => 'This cannot be undone. Reassigned assets will inherit the surviving model\'s category, fieldset, and depreciation settings.',
        'pick_target' => 'Który model chcesz zachować?',
        'success' => 'Merged :source_count model(s) into ":target". :asset_count asset(s) were reassigned.',
    ],

];

<?php

return [

    'does_not_exist' => 'Diese Kategorie existiert nicht.',
    'assoc_models' => 'Diese Kategorie kann nicht gelöscht werden, da sie bereits einem Modell zugewiesen ist. Bitte entfernen Sie diese Kategorie von Ihren Modellen und versuchen Sie es erneut. ',
    'assoc_items' => 'Diese Kategorie kann nicht gelöscht werden da sie bereits mit einem :asset_type verbunden ist. Bitte trennen Sie diese Kategorie von Ihrem :asset_type und versuchen Sie es erneut. ',

    'create' => [
        'error' => 'Die Kategorie konnte nicht erstellt werden, bitte versuchen Sie es erneut.',
        'success' => 'Die Kategorie wurde erfolgreich erstellt.',
    ],

    'update' => [
        'error' => 'Die Kategorie konnte nicht aktualisiert werden, bitte versuchen Sie es erneut',
        'success' => 'Die Kategorie wurde erfolgreich aktualisiert.',
        'cannot_change_category_type' => 'Sie können den Kategorietyp nicht ändern, nachdem er erstellt wurde',
    ],

    'delete' => [
        'confirm' => 'Sind Sie sicher, dass Sie diese Kategorie löschen wollen?',
        'error' => 'Beim Löschen der Kategorie ist ein Problem aufgetreten. Bitte versuchen Sie es erneut.',
        'success' => 'Kategorie wurde erfolgreich gelöscht.',
        'bulk_success' => 'Kategorie erfolgreich gelöscht.|:count Kategorien wurden erfolgreich gelöscht.',
        'partial_success' => 'Kategorie wurde erfolgreich gelöscht. Siehe weitere Informationen unten. | :count Kategorien wurden erfolgreich gelöscht. Siehe weitere Informationen unten.',
    ],

    'bulkedit' => [
        'warn' => 'Sie sind dabei, die Eigenschaften der folgenden Kategorie zu aktualisieren:| Sie sind dabei, die Eigenschaften der folgenden :count Kategorien zu bearbeiten:',
        'no_selection' => 'Sie müssen mindestens eine Kategorie aus der Liste auswählen.',
        'no_changes' => 'Es wurden keine Felder geändert, daher wurde nichts aktualisiert.',
        'success' => 'Kategorie erfolgreich aktualisiert. |:count Kategorien erfolgreich aktualisiert.',
    ],

];

<?php

return [
    'not_found' => 'Die Wartung, nach der du suchst, wurde nicht gefunden!',
    'delete' => [
        'confirm' => 'Möchtest du die Wartung wirklich löschen?',
        'error' => 'Es gab Probleme beim Löschen der Wartung. Bitte versuche es erneut.',
        'success' => 'Die Wartung wurde erfolgreich gelöscht.',
    ],
    'create' => [
        'error' => 'Wartung wurde nicht erstellt. Bitte versuche es erneut.',
        'success' => 'Wartung erfolgreich erstellt.',
    ],
    'edit' => [
        'error' => 'Die Wartung wurde nicht bearbeitet, bitte versuche es erneut.',
        'success' => 'Wartung wurde erfolgreich bearbeitet.',
    ],
    'asset_maintenance_incomplete' => 'Noch nicht abgeschlossen',
    'warranty' => 'Garantie',
    'not_warranty' => 'Keine Garantie',
    'complete' => [
        'confirm' => 'Sind Sie sicher, dass Sie diese Wartung als abgeschlossen markieren möchten? Dies kann nicht rückgängig gemacht werden.',
        'success' => 'Wartung als abgeschlossen markiert.',
        'error' => 'Beim Abschließen der Wartung gab es einen Fehler. Bitte versuchen Sie es erneut.',
    ],
    'bulk_delete' => 'Es wurden keine Wartungsaufzeichnungen gelöscht (:skipped übersprungen).| :count Wartungsaufzeichnung gelöscht. (:skipped übersprungen)|:count Wartungsaufzeichnungen gelöscht. (:skipped übersprungen)',
    'bulk_complete' => 'Es wurden keine Wartungsaufzeichnungen als abgeschlossen markiert (:skipped übersprungen oder bereits abgeschlossen).| :count Wartungsaufzeichnung abgeschlossen. (:skipped übersprungen oder bereits abgeschlossen)|:count Wartungsaufzeichnungen abgeschlossen. (:skipped übersprungen oder beirets abgeschlossen)',
];

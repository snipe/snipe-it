<?php

return [

    'does_not_exist' => 'Modell existiert nicht.',
    'assoc_users'     => 'Dieses Modell ist zur Zeit mit einem oder mehreren Assets verknüpft und kann nicht gelöscht werden. Bitte lösche die Assets und versuche dann erneut das Modell zu löschen. ',

    'create' => [
        'error'   => 'Modell wurde nicht erstellt. Bitte versuch es noch einmal.',
        'success' => 'Modell wurde erfolgreich erstellt.',
        'duplicate_set' => 'Ein Asset Modell mit diesem Namen, Hersteller und Modell Nummer existiert bereits.',
    ],

    'update' => [
        'error'   => 'Modell wurde nicht aktualisiert. Bitte versuch es noch einmal',
        'success' => 'Modell wurde erfolgreich aktualisiert.',
    ],

    'delete' => [
        'confirm'   => 'Sind sie sicher, dass sie das Asset löschen wollen?',
        'error'   => 'Beim Löschen des Modell ist ein Fehler aufgetreten. Bitte probieren Sie es noch einmal.',
        'success' => 'Das Modell wurde erfolgreich gelöscht.',
    ],

    'restore' => [
        'error'        => 'Das Modell konnte nicht Wiederhergestellt werden, bitte versuchen Sie es erneut',
        'success'        => 'Das Modell wurde erfolgreich Wiederhergestellt.',
    ],

    'bulkedit' => [
        'error'        => 'Es wurden keine Felder ausgewählt, somit wurde auch nichts aktualisiert.',
        'success'        => 'Modelle aktualisiert.',
    ],

];

<?php

return [

    'deleted' => 'Gelöschtes Asset-Modell',
    'does_not_exist' => 'Modell existiert nicht.',
    'no_association' => 'WARNUNG! Das Asset Modell für dieses Element ist ungültig oder fehlt!',
    'no_association_fix' => 'Dies wird Dinge auf seltsame und schreckliche Weise zerstören. Bearbeite dieses Asset jetzt, um ihm ein Modell zuzuordnen.',
    'assoc_users' => 'Dieses Modell ist zur Zeit mit einem oder mehreren Assets verknüpft und kann nicht gelöscht werden. Bitte lösche die Assets und versuche dann erneut, das Modell zu löschen. ',
    'invalid_category_type' => 'Diese Kategorie muss eine Asset-Kategorie sein.',

    'create' => [
        'error' => 'Modell wurde nicht erstellt. Bitte versuche es noch einmal.',
        'success' => 'Modell wurde erfolgreich erstellt.',
        'duplicate_set' => 'Ein Asset-Modell mit diesem Namen, Hersteller und Modell Nummer existiert bereits.',
    ],

    'update' => [
        'error' => 'Modell wurde nicht aktualisiert. Bitte versuch es noch einmal',
        'success' => 'Modell wurde erfolgreich aktualisiert.',
    ],

    'delete' => [
        'confirm' => 'Bist du sicher, dass du dieses Asset-Modell entfernen möchtest?',
        'error' => 'Beim Löschen des Modell ist ein Fehler aufgetreten. Bitte versuche es noch einmal.',
        'success' => 'Das Modell wurde erfolgreich gelöscht.',
    ],

    'restore' => [
        'error' => 'Modell wurde nicht wiederhergestellt, bitte versuche es noch einmal',
        'success' => 'Modell wurde erfolgreich wiederhergestellt.',
    ],

    'bulkedit' => [
        'error' => 'Es wurden keine Felder geändert, somit wurde auch nichts aktualisiert.',
        'success' => 'Modell erfolgreich aktualisiert. |:model_count Modelle erfolgreich aktualisiert.',
        'warn' => 'Du bist dabei, die Eigenschaften des folgenden Modells zu aktualisieren: |Du bist dabei, die Eigenschaften der folgenden :model_count Modelle zu bearbeiten:',

    ],

    'bulkdelete' => [
        'error' => 'Es wurden keine Modelle ausgewählt. Somit wurde auch nichts gelöscht.',
        'nothing_deletable' => 'Keines der ausgewählten Modelle kann gelöscht werden, da ihnen noch Assets zugeordnet sind.',
        'success' => 'Modell gelöscht!|:success_count Modelle gelöscht!',
        'success_partial' => ':success_count Modell(e) wurden gelöscht. Jedoch konnten :fail_count nicht gelöscht werden, da ihnen noch Assets zugeordnet sind.',
    ],

    'merge' => [
        'min_two' => 'Wählen Sie mindestens zwei Modelle zum Zusammenführen aus.',
        'no_target' => 'Wählen Sie vor dem Zusammenführen das zu haltende Modell aus.',
        'not_found' => 'Ein oder mehrere der ausgewählten Modelle konnten nicht geladen werden. Aktualisieren Sie die Modellliste und versuchen Sie es erneut.',
        'information' => 'Sie sind dabei :count Modelle zusammenzuführen. Wählen Sie das Modell, das Sie behalten möchten. Jedes Asset, das an die anderen Modelle angehängt wird, wird dem von Ihnen gewählten Modell zugewiesen, dann werden die Ursprungsmodelle gelöscht.',
        'warning' => 'Dies kann nicht rückgängig gemacht werden. Wieder zugewiesene Assets erben die Kategorie, Feldsatz und Abschreibung des überlebenden Modells.',
        'pick_target' => 'Welches Modell möchten Sie beibehalten?',
        'success' => ':source_count Model(s) in ":target" zusammengefasst. :asset_count Asset(s) wurden neu zugewiesen.',
    ],

];

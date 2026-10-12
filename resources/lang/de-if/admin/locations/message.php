<?php

return [

    'does_not_exist' => 'Standort existiert nicht.',
    'assoc_users' => 'Dieser Standort kann aktuell nicht gelöscht werden, da ihm mindestens ein Asset, User oder anderer Standort zugewiesen ist. Bitte entferne alle Zuweisungen und versuche es erneut. ',
    'assoc_assets' => 'Dieser Standort ist mindestens einem Gegenstand zugewiesen und kann nicht gelöscht werden. Bitte entferne die Standortzuweisung bei den jeweiligen Gegenständen und versuche erneut, diesen Standort zu entfernen. ',
    'assoc_child_loc' => 'Dieser Standort ist mindestens einem anderen Ort übergeordnet und kann nicht gelöscht werden. Bitte aktualisiere Deine Standorte, so dass dieser Standort nicht mehr verknüpft ist, und versuche es erneut. ',
    'assigned_assets' => 'Zugeordnete Assets',
    'current_location' => 'Aktueller Standort',
    'deleted_warning' => 'Der Standort wurde entfernt. Bitte stellen Sie ihn wieder her, bevor sie versuchen Änderungen vorzunehmen.',

    'create' => [
        'error' => 'Standort wurde nicht erstellt, bitte versuche es erneut.',
        'success' => 'Standort erfolgreich erstellt.',
    ],

    'update' => [
        'error' => 'Standort wurde nicht aktualisiert, bitte versuche es erneut',
        'success' => 'Standort erfolgreich aktualisiert.',
    ],

    'restore' => [
        'error' => 'Der Standort wurde nicht wiederhergestellt. Bitte versuche es erneut',
        'success' => 'Standort erfolgreich wiederhergestellt.',
    ],

    'delete' => [
        'confirm' => 'Bist du sicher, dass du diesen Standort löschen willst?',
        'error' => 'Es gab einen Fehler beim Löschen des Standorts. Bitte erneut versuchen.',
        'success' => 'Der Standort wurde erfolgreich gelöscht.',
    ],

    'bulkedit' => [
        'error' => 'Es wurden keine Felder geändert, somit wurde auch nichts aktualisiert.',
        'success' => 'Standort erfolgreich aktualisiert. |:location_count Standorte erfolgreich aktualisiert.',
        'warn' => 'Bearbeiten Sie die Felder unten, um diesen Standort zu aktualisieren. Die Felder, die Sie leer lassen, werden sich am Standort nicht ändern. Bearbeiten Sie die Felder unten, um alle :count ausgewählten Orte zu aktualisieren. Die Felder, die Sie leer lassen, werden sich bei keinem von ihnen ändern.',
        'show_selected' => '1 ausgewählter Standort|:count ausgewählte Standorte',
        'company_scope_mismatch_partial' => 'Das Unternehmen wurde an einem Standort nicht geändert, da Elemente oder Benutzer an diesem Standort zu verschiedenen Unternehmen gehören. Aktualisieren oder verschieben Sie diese zuerst. Das Unternehmen wurde an :count Standorten nicht geändert, da Elemente oder Benutzer an diesen Standorten zu verschiedenen Unternehmen gehören. Aktualisieren oder verschieben Sie diese zuerst.',
        'company_scope_mismatch_all' => 'Es wurden keine Standorte neu zugewiesen. Die angeforderte Firma stimmt nicht mit Artikeln oder Benutzern am gewählten Standort überein. Es wurden keine Standorte neu zugewiesen. Die angeforderte Firma stimmt nicht mit Artikeln oder Benutzern an irgendeinem der :count ausgewählten Standorte überein.',
        'parent_company_mismatch_partial' => 'Das Mutter- oder Unternehmen wurde an einem Standort nicht geändert, da es den Standort in einem anderen Unternehmen als seinem Elternteil verlassen würde. An :count Standorten wurde die Muttergesellschaft oder das Unternehmen nicht geändert, da sie diese Standorte in einem anderen Unternehmen als ihrem Elternteil belassen würde.',
        'parent_company_mismatch_all' => 'Es wurden keine Änderungen gespeichert. Der angeforderte Elternteil oder das Unternehmen würde den Standort in einem anderen Unternehmen als seinem Elternteil verlassen.|Es wurden keine Änderungen gespeichert. Die gewünschte Muttergesellschaft oder Firma würde jeden der :count ausgewählten Standorte in einem anderen Unternehmen als ihrem Elternteil belassen.',
    ],

];

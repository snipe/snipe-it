<?php

return [

    'does_not_exist' => 'Standort nicht verfügbar.',
    'assoc_users' => 'Dieser Standort kann aktuell nicht gelöscht werden, da ihm mindestens ein Asset, User oder anderer Standort zugewiesen ist. Bitte entfernen Sie alle Zuweisungen und versuchen Sie es erneut. ',
    'assoc_assets' => 'Dieser Standort ist aktuell mindestens einem Gegenstand zugewiesen und kann nicht gelöscht werden. Bitte entfernen Sie die Standortzuweisung bei den jeweiligen Gegenständen und versuchen Sie es erneut diesen Standort zu entfernen. ',
    'assoc_child_loc' => 'Dieser Ort ist aktuell mindestens einem anderen Ort übergeordnet und kann nicht gelöscht werden. Bitte Orte aktualisieren, so dass dieser Standort nicht mehr verknüpft ist und erneut versuchen. ',
    'assigned_assets' => 'Zugeordnete Assets',
    'current_location' => 'Aktueller Standort',
    'deleted_warning' => 'Dieser Standort wurde gelöscht. Bitte stellen Sie ihn wieder her, bevor Sie Änderungen vornehmen.',

    'create' => [
        'error' => 'Standort wurde nicht erstellt, bitte versuchen Sie es erneut.',
        'success' => 'Standort erfolgreich erstellt.',
    ],

    'update' => [
        'error' => 'Standort wurde nicht aktualisiert, bitte erneut versuchen',
        'success' => 'Standort erfolgreich aktualisiert.',
    ],

    'restore' => [
        'error' => 'Der Standort wurde nicht wiederhergestellt. Bitte versuchen Sie es erneut',
        'success' => 'Standort erfolgreich wiederhergestellt.',
    ],

    'delete' => [
        'confirm' => 'Möchten Sie diesen Standort wirklich entfernen?',
        'error' => 'Es gab einen Fehler beim Löschen des Standorts. Bitte erneut versuchen.',
        'success' => 'Der Standort wurde erfolgreich gelöscht.',
    ],

    'bulkedit' => [
        'error' => 'Es wurden keine Felder geändert, daher wurde nichts aktualisiert.',
        'success' => 'Standort erfolgreich aktualisiert. |:location_count Standorte erfolgreich aktualisiert.',
        'warn' => 'Bearbeiten Sie die Felder unten, um diesen Standort zu aktualisieren. Die Felder, die Sie leer lassen, werden sich am Standort nicht ändern. Bearbeiten Sie die Felder unten, um alle :count ausgewählten Orte zu aktualisieren. Die Felder, die Sie leer lassen, werden sich bei keinem von ihnen ändern.',
        'show_selected' => '1 ausgewählter Standort|:count ausgewählte Standorte',
        'company_scope_mismatch_partial' => 'Das Unternehmen wurde an einem Standort nicht geändert, da Elemente oder Benutzer an diesem Standort zu verschiedenen Unternehmen gehören. Aktualisieren oder verschieben Sie diese zuerst. Das Unternehmen wurde an :count Standorten nicht geändert, da Elemente oder Benutzer an diesen Standorten zu verschiedenen Unternehmen gehören. Aktualisieren oder verschieben Sie diese zuerst.',
        'company_scope_mismatch_all' => 'Es wurden keine Standorte neu zugewiesen. Die angeforderte Firma stimmt nicht mit Artikeln oder Benutzern am gewählten Standort überein. Es wurden keine Standorte neu zugewiesen. Die angeforderte Firma stimmt nicht mit Artikeln oder Benutzern an irgendeinem der :count ausgewählten Standorte überein.',
        'parent_company_mismatch_partial' => 'Das Mutter- oder Unternehmen wurde an einem Standort nicht geändert, da es den Standort in einem anderen Unternehmen als seinem Elternteil verlassen würde. An :count Standorten wurde die Muttergesellschaft oder das Unternehmen nicht geändert, da sie diese Standorte in einem anderen Unternehmen als ihrem Elternteil belassen würde.',
        'parent_company_mismatch_all' => 'Es wurden keine Änderungen gespeichert. Der angeforderte Elternteil oder das Unternehmen würde den Standort in einem anderen Unternehmen als seinem Elternteil verlassen.|Es wurden keine Änderungen gespeichert. Die gewünschte Muttergesellschaft oder Firma würde jeden der :count ausgewählten Standorte in einem anderen Unternehmen als ihrem Elternteil belassen.',
    ],

];

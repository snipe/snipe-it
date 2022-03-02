<?php

return array(

    'accepted'                  => 'Sie haben diesen Gegenstand erfolgreich angenommen.',
    'declined'                  => 'Sie haben diesen Gegenstand abgelehnt.',
    'bulk_manager_warn'	        => 'Benutzer erfolgreich geändert. Vorgesetzter sollte auch bearbeitet werden und konnte nicht angepasst werden, weil er sich nicht selbst als Vorgesetzter eingetragen haben kann. Bitte Benutzer ohne den Vorgesetzten nochmal bearbeiten.',
    'user_exists'               => 'Benutzer existiert bereits!',
    'user_not_found'            => 'Benutzer [:id] existiert nicht.',
    'user_login_required'       => 'Das Loginfeld ist erforderlich',
    'user_password_required'    => 'Das Passswortfeld ist erforderlich.',
    'insufficient_permissions'  => 'Unzureichende Berechtigungen.',
    'user_deleted_warning'      => 'Dieser Benutzer wurde gelöscht. Sie müssen ihn wiederherstellen, um ihn zu bearbeiten oder neue Assets zuzuweisen.',
    'ldap_not_configured'        => 'LDAP Integration wurde für diese Installation nicht konfiguriert.',
    'password_resets_sent'      => 'Den ausgewählten Benutzern, die aktiviert sind und eine gültige E-Mail-Adresse haben, wurde ein Link zum Zurücksetzen des Passworts gesendet.',
    'password_reset_sent'       => 'Der Link zum Zurücksetzen des Passworts wurde an :email gesendet!',


    'success' => array(
        'create'    => 'Benutzer wurde erfolgreich erstellt.',
        'update'    => 'Benutzer wurde erfolgreich bearbeitet.',
        'update_bulk'    => 'Benutzer erfolgreich geändert!',
        'delete'    => 'Benutzer wurde erfolgreich gelöscht.',
        'ban'       => 'Benutzer wurde erfolgreich ausgeschlossen.',
        'unban'     => 'Benutzer wurde erfolgreich wieder eingeschlossen.',
        'suspend'   => 'Der Benutzer wurde erfolgreich deaktiviert.',
        'unsuspend' => 'Der Benutzer wurde erfolgreich reaktiviert.',
        'restored'  => 'Benutzer wurde erfolgreich wiederhergestellt.',
        'import'    => 'Benutzer erfolgreich Importiert.',
    ),

    'error' => array(
        'create' => 'Beim Erstellen des Benutzers ist ein Fehler aufgetreten. Bitte probieren Sie es noch einmal.',
        'update' => 'Beim Aktualisieren des Benutzers ist ein Fehler aufgetreten. Bitte probieren Sie es noch einmal.',
        'delete' => 'Beim Entfernen des Benutzers ist ein Fehler aufgetreten. Bitte versuchen Sie es erneut.',
        'delete_has_assets' => 'Der Benutzer konnte nicht gelöscht werden, da ihm Gegenstände zugeordnet sind.',
        'unsuspend' => 'Es gab ein Problem beim reaktivieren des Benutzers. Bitte versuche es erneut.',
        'import'    => 'Es gab ein Problem beim importieren der Benutzer. Bitte noch einmal versuchen.',
        'asset_already_accepted' => 'Dieses Asset wurde bereits akzeptiert.',
        'accept_or_decline' => 'Sie müssen diesen Gegenstand entweder annehmen oder ablehnen.',
        'incorrect_user_accepted' => 'Das Asset, welches Sie versuchen zu aktivieren, wurde nicht für Sie ausgebucht.',
        'ldap_could_not_connect' => 'Konnte keine Verbindung zum LDAP Server herstellen. Bitte LDAP Einstellungen in der LDAP Konfigurationsdatei prüfen. <br>Fehler vom LDAP Server:',
        'ldap_could_not_bind' => 'Konnte keine Verbindung zum LDAP Server herstellen. Bitte LDAP Einstellungen in der LDAP Konfigurationsdatei prüfen. <br>Fehler vom LDAP Server: ',
        'ldap_could_not_search' => 'Konnte LDAP Server nicht suchen. Bitte LDAP Einstellungen in der LDAP Konfigurationsdatei prüfen. <br>Fehler vom LDAP Server:',
        'ldap_could_not_get_entries' => 'Konnte keine Einträge vom LDAP Server abrufen. Bitte LDAP Einstellungen in der LDAP Konfigurationsdatei prüfen. <br>Fehler vom LDAP Server:',
        'password_ldap' => 'Das Passwort für diesen Account wird vom LDAP/Active Directory verwaltet. Bitte kontaktieren Sie Ihre IT-Abteilung, um Ihr Passwort zu ändern. ',
    ),

    'deletefile' => array(
        'error'   => 'Datei nicht gelöscht. Bitte versuchen Sie es nochmals.',
        'success' => 'Datei erfolgreich gelöscht.',
    ),

    'upload' => array(
        'error'   => 'Datei(en) wurden nicht erfolgreich hochgeladen. Bitte versuchen Sie es nochmals.',
        'success' => 'Datei(en) wurden erfolgreich hochgeladen.',
        'nofiles' => 'Sie haben keine Dateien zum Hochladen ausgewählt.',
        'invalidfiles' => 'Eine oder mehrere Ihrer Dateien ist zu groß oder deren Dateityp ist nicht zugelassen. Zugelassene Dateitypen sind png, gif, jpg, doc, docx, pdf, und txt.',
    ),

);

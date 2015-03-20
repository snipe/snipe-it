<?php

return array(

    'user_exists'              	=> 'Benutzer existiert bereits!',
    'user_not_found'           	=> 'Benutzer [:id] existiert nicht.',
    'user_login_required'      	=> 'Das Loginfeld ist erforderlich',
    'user_password_required'   	=> 'Das Passswortfeld ist erforderlich.',
    'insufficient_permissions' 	=> 'Unzureichende Berechtigungen.',
    'user_deleted_warning' 		=> 'Dieser Benutzer wurde gelöscht. Sie müssen ihn wiederherstellen, um ihn zu bearbeiten oder neue Assets zuzuweisen.',


    'success' => array(
        'create'    => 'Benutzer wurde erfolgreich erstellt.',
        'update'    => 'Benutzer wurde erfolgreich bearbeitet.',
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
        'unsuspend' => 'Es gab ein Problem beim reaktivieren des Benutzers. Bitte versuche es erneut.',
        'import'    => 'Es gab ein Problem beim importieren der Benutzer. Bitte noch einmal versuchen.',
        'asset_already_accepted' => 'Dieses Asset wurde bereits akzeptiert.',
    ),

);

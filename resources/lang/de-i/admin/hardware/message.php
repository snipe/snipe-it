<?php

return [

    'undeployable' 		=> '<strong>Achtung:</strong>Dieses Asset wurde kürzlich als nicht verteilbar markiert.
                        Falls sich dieser Status verändert hat, aktualisiere bitte den Asset Status.',
    'does_not_exist' 	=> 'Asset existiert nicht.',
    'does_not_exist_or_not_requestable' => 'Dieses Asset existiert nicht oder kann nicht angefordert werden.',
    'assoc_users'	 	=> 'Dieses Asset ist im Moment an einen Benutzer herausgegeben und kann nicht entfernt werden. Bitte buche das Asset wieder ein und versuche dann erneut, es zu entfernen. ',

    'create' => [
        'error'   		=> 'Asset wurde nicht erstellt. Bitte versuche es erneut. :(',
        'success' 		=> 'Asset wurde erfolgreich erstellt. :)',
    ],

    'update' => [
        'error'   			=> 'Asset wurde nicht aktualisiert. Bitte versuche es erneut',
        'success' 			=> 'Asset wurde erfolgreich aktualisiert.',
        'nothing_updated'	=>  'Es wurden keine Felder ausgewählt, somit wurde auch nichts aktualisiert.',
        'no_assets_selected'  =>  'Es wurden keine Assets ausgewählt, somit wurde auch nichts aktualisiert.',
    ],

    'restore' => [
        'error'   		=> 'Asset wurde nicht wiederhergestellt, bitte versuche es noch einmal',
        'success' 		=> 'Asset erfolgreich wiederhergestellt.',
        'bulk_success' 		=> 'Asset erfolgreich wiederhergestellt.',
        'nothing_updated'   => 'Es wurden keine Assets ausgewählt, also wurde nichts wiederhergestellt.', 
    ],

    'audit' => [
        'error'   		=> 'Asset Audit war nicht erfolgreich. Bitte versuche es erneut.',
        'success' 		=> 'Asset-Audit erfolgreich protokolliert.',
    ],


    'deletefile' => [
        'error'   => 'Datei wurde nicht gelöscht. Bitte versuche es erneut.',
        'success' => 'Datei erfolgreich gelöscht.',
    ],

    'upload' => [
        'error'   => 'Datei(en) wurde(n) nicht hochgeladen. Bitte versuche es erneut.',
        'success' => 'Datei(en) wurden erfolgreich hochgeladen.',
        'nofiles' => 'Du hast keine Datei zum Hochladen ausgewählt, oder die Datei, die Du hochladen möchtest, ist zu groß',
        'invalidfiles' => 'Eine oder mehrere Deiner Dateien sind zu groß, oder deren Dateityp ist nicht zugelassen. Zugelassene Dateitypen sind png, gif, jpg, doc, docx, pdf, und txt.',
    ],

    'import' => [
        'error'                 => 'Einige Elemente wurden nicht korrekt importiert.',
        'errorDetail'           => 'Die folgenden Elemente wurden aufgrund von Fehlern nicht importiert.',
        'success'               => 'Deine Datei wurde importiert',
        'file_delete_success'   => 'Deine Datei wurde erfolgreich gelöscht',
        'file_delete_error'      => 'Die Datei konnte nicht gelöscht werden',
        'header_row_has_malformed_characters' => 'Ein oder mehrere Attribute in der Kopfzeile enthalten fehlerhafte UTF-8 Zeichen',
        'content_row_has_malformed_characters' => 'Ein oder mehrere Attribute in der ersten Zeile des Inhalts enthalten fehlerhafte UTF-8-Zeichen',
    ],


    'delete' => [
        'confirm'   	=> 'Bist Du sicher, dass Du dieses Asset entfernen möchtest?',
        'error'   		=> 'Beim Entfernen dieses Assets ist ein Fehler aufgetreten. Bitte versuche es erneut.',
        'nothing_updated'   => 'Es wurden keine Assets ausgewählt, somit wurde auch nichts gelöscht.',
        'success' 		=> 'Dass Asset wurde erfolgreich entfernt.',
    ],

    'checkout' => [
        'error'   		=> 'Asset konnte nicht herausgegeben werden. Bitte versuche es erneut',
        'success' 		=> 'Asset wurde erfolgreich herausgegeben.',
        'user_does_not_exist' => 'Dieser Benutzer ist ungültig. Bitte versuche es erneut.',
        'not_available' => 'Dieses Asset kann nicht herausgegeben werden!',
        'no_assets_selected' => 'Du musst mindestens ein Asset aus der Liste auswählen',
    ],

    'checkin' => [
        'error'   		=> 'Asset konnte nicht zurückgenommen werden. Bitte versuche es erneut',
        'success' 		=> 'Asset wurde erfolgreich zurückgenommen.',
        'user_does_not_exist' => 'Dieser Benutzer ist ungültig. Bitte versuche es erneut.',
        'already_checked_in'  => 'Dieses Asset ist bereits zurückgenommen.',

    ],

    'requests' => [
        'error'   		=> 'Das Asset wurde nicht angefordert, bitte versuche es erneut',
        'success' 		=> 'Asset erfolgreich angefordert.',
        'canceled'      => 'Herausgeben erfolgreich abgebrochen',
    ],

];

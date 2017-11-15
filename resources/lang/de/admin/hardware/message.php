<?php

return array(

    'undeployable' 		=> '<strong>Achtung:</strong>Dieses Asset wurde kürzlich als nicht verteilbar markiert.
                        Falls sich dieser Status verändert hat, aktualisieren Sie bitte den Asset Status.',
    'does_not_exist' 	=> 'Asset existiert nicht.',
    'does_not_exist_or_not_requestable' => 'Netter Versuch. Das Asset existiert nicht oder ist nicht abrufbar.',
    'assoc_users'	 	=> 'Dieses Asset ist im Moment an einen Benutzer herausgegeben und kann nicht entfernt werden. Bitte buchen sie das Asset wieder ein und versuchen Sie dann erneut es zu entfernen. ',

    'create' => array(
        'error'   		=> 'Asset wurde nicht erstellt. Bitte versuchen Sie es erneut. :(',
        'success' 		=> 'Asset wurde erfolgreich erstellt. :)'
    ),

    'update' => array(
        'error'   			=> 'Asset wurde nicht aktualisiert. Bitte versuchen Sie es erneut',
        'success' 			=> 'Asset wurde erfolgreich aktualisiert.',
        'nothing_updated'	=>  'Es wurden keine Felder ausgewählt, somit wurde auch nichts aktualisiert.',
    ),

    'restore' => array(
        'error'   		=> 'Asset wurde nicht wiederhergestellt, bitte versuchen Sie es noch einmal',
        'success' 		=> 'Asset erfolgreich wiederhergestellt.'
    ),

    'audit' => array(
        'error'   		=> 'Asset Audit war nicht erfolgreich. Bitte versuche es erneut.',
        'success' 		=> 'Asset-Audit erfolgreich protokolliert.'
    ),


    'deletefile' => array(
        'error'   => 'Datei wurde nicht gelöscht. Bitte noch einmal Probieren.',
        'success' => 'Datei erfolgreich gelöscht.',
    ),

    'upload' => array(
        'error'   => 'Datei(en) wurde nicht hochgeladen. Bitte noch einmal Probieren.',
        'success' => 'Datei(en) erfolgreich hochgeladen.',
        'nofiles' => 'Es wurde keine Datei für den Upload ausgewählt, oder die Datei ist zu groß',
        'invalidfiles' => 'Eine oder mehrere Ihrer Dateien ist zu groß oder deren Dateityp ist nicht zugelassen. Zugelassene Dateitypen sind png, gif, jpg, doc, docx, pdf, und txt.',
    ),

    'import' => array(
        'error'                 => 'Einige Elemente wurden nicht korrekt importiert.',
        'errorDetail'           => 'Die folgenden Elemente wurden aufgrund von Fehlern nicht importiert.',
        'success'               => "Ihre Datei wurde importiert",
        'file_delete_success'   => "Die Datei wurde erfolgreich gelöscht",
        'file_delete_error'      => "Die Datei konnte nicht gelöscht werden",
    ),


    'delete' => array(
        'confirm'   	=> 'Sind Sie sicher, dass Sie dieses Asset entfernen möchten?',
        'error'   		=> 'Beim Entfernen dieses Assets ist ein Fehler aufgetreten. Bitte versuchen Sie es erneut.',
        'nothing_updated'   => 'Es wurden keine Assets ausgewählt, somit wurde auch nichts gelöscht.',
        'success' 		=> 'Dieses Asset wurde erfolgreich entfernt.'
    ),

    'checkout' => array(
        'error'   		=> 'Asset konnte nicht herausgegeben werden. Bitte versuchen Sie es erneut',
        'success' 		=> 'Asset wurde erfolgreich herausgegeben.',
        'user_does_not_exist' => 'Dieser Benutzer existiert nicht. Bitte versuchen Sie es erneut.',
        'not_available' => 'Dieses Asset kann nicht herausgegeben werden!',
        'no_assets_selected' => 'Mind. 1 Eintrag muss ausgewählt werden'
    ),

    'checkin' => array(
        'error'   		=> 'Asset konnte nicht eingebucht werden. Bitte versuchen Sie es erneut',
        'success' 		=> 'Asset wurde erfolgreich eingebucht.',
        'user_does_not_exist' => 'Dieser Benutzer existiert nicht. Bitte versuchen Sie es erneut.',
        'already_checked_in'  => 'Dieses Asset ist bereits eingebucht.',

    ),

    'requests' => array(
        'error'   		=> 'Das Asset wurde nicht angefordert, bitte versuchen Sie es erneut',
        'success' 		=> 'Asset erfolgreich angefordert.',
        'canceled'      => 'Herausgeben erfolgreich abgebrochen'
    )

);

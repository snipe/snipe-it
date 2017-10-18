<?php

return array(

    'does_not_exist' => 'Die Kategorie existiert nicht.',
    'user_does_not_exist' => 'Benutzer existiert nicht.',
    'asset_does_not_exist' 	=> 'Der Gegenstand den du mit dieser Lizenz verknüpfen willst existiert nicht.',
    'owner_doesnt_match_asset' => 'Der Gegenstand den du mit dieser Lizenz verknüpfen willst gehört jemand anderem als der im Dropdown-Feld ausgewählten Person.',
    'assoc_users'	 => 'Diese Kategorie ist derzeit mindestens einem Modell zugeordnet und kann nicht gelöscht werden. Bitte aktualisieren Sie Ihre Modelle, um nicht mehr auf diese Kategorie zu verweisen und versuchen Sie es erneut.',
    'select_asset_or_person' => 'Sie müssen ein Asset oder einen Benutzer auswählen, aber nicht beides.',


    'create' => array(
        'error'   => 'Die Kategorie wurde nicht erstellt, bitte versuchen Sie es erneut.',
        'success' => 'Die Kategorie wurde erfolgreich erstellt.'
    ),

    'deletefile' => array(
        'error'   => 'Datei nicht gelöscht. Bitte versuchen Sie es noch einmal.',
        'success' => 'Datei erfolgreich gelöscht.',
    ),

    'upload' => array(
        'error'   => 'Datei(en) wurden nicht hochgeladen. Bitte versuchen Sie es noch einmal.',
        'success' => 'Datei(en) erfolgreich hochgeladen.',
        'nofiles' => 'Es wurde keine Datei für den Upload ausgewählt, oder die Datei ist zu groß',
        'invalidfiles' => 'Eine oder mehrere Ihrer Dateien sind zu groß oder ist ein Dateityp, der nicht zulässig ist. Erlaubte Dateitypen sind png, gif, jpg, jpeg, doc, docx, pdf, txt, zip, rar, rtf, xml und lic.',
    ),

    'update' => array(
        'error'   => 'Die Kategorie wurde nicht aktualisiert, bitte versuchen Sie es erneut.',
        'success' => 'Die Kategorie wurde erfolgreich aktualisiert.'
    ),

    'delete' => array(
        'confirm'   => 'Sind Sie sicher, dass Sie diese Kategorie löschen wollen?',
        'error'   => 'Beim Löschen der Kategorie ist ein Problem aufgetreten. Bitte versuchen Sie es erneut.',
        'success' => 'Die Kategorie wurde erfolgreich gelöscht.'
    ),

    'checkout' => array(
        'error'   => 'Asset was not checked out, please try again',
        'success' => 'Asset checked out successfully.'
    ),

    'checkin' => array(
        'error'   => 'Asset was not checked in, please try again',
        'success' => 'Asset checked in successfully.'
    ),

);

<?php

return array(

    'does_not_exist' => 'Die Lizenz existiert nicht.',
    'user_does_not_exist' => 'Benutzer existiert nicht.',
    'asset_does_not_exist' 	=> 'Der Gegenstand, mit dem Sie diese Lizenz verknüpfen möchten, existiert nicht.',
    'owner_doesnt_match_asset' => 'Der Gegenstand, den Sie mit dieser Lizenz verknüpfen möchten, gehört jemand anderem als der im Dropdown-Feld ausgewählten Person.',
    'assoc_users'	 => 'Diese Lizenz ist derzeit mindestens einem Benutzer zugeordnet und kann nicht gelöscht werden. Bitte nehmen Sie die Lizenz zurück und versuchen Sie anschließend erneut diese zu löschen. ',
    'select_asset_or_person' => 'Sie müssen ein Asset oder einen Benutzer auswählen, aber nicht beides.',


    'create' => array(
        'error'   => 'Lizenz wurde nicht erstellt, bitte versuchen Sie es erneut.',
        'success' => 'Die Lizenz wurde erfolgreich erstellt.'
    ),

    'deletefile' => array(
        'error'   => 'Datei wurde nicht gelöscht. Bitte versuchen Sie es erneut.',
        'success' => 'Datei erfolgreich gelöscht.',
    ),

    'upload' => array(
        'error'   => 'Datei(en) wurden nicht hochgeladen. Bitte versuchen Sie es erneut.',
        'success' => 'Datei(en) erfolgreich hochgeladen.',
        'nofiles' => 'Sie haben keine Datei zum Hochladen ausgewählt oder die Datei, die Sie hochladen möchten, ist zu groß',
        'invalidfiles' => 'Eine oder mehrere Ihrer Dateien sind zu groß oder ist ein Dateityp, der nicht zulässig ist. Erlaubte Dateitypen sind png, gif, jpg, jpeg, doc, docx, pdf, txt, zip, rar, rtf, xml und lic.',
    ),

    'update' => array(
        'error'   => 'Die Lizenz wurde nicht aktualisiert, bitte versuchen Sie es erneut',
        'success' => 'Die Lizenz wurde erfolgreich aktualisiert.'
    ),

    'delete' => array(
        'confirm'   => 'Sind Sie sicher, dass Sie diese Lizenz löschen wollen?',
        'error'   => 'Beim Löschen der Lizenz ist ein Problem aufgetreten. Bitte versuchen Sie es erneut.',
        'success' => 'Die Lizenz wurde erfolgreich gelöscht.'
    ),

    'checkout' => array(
        'error'   => 'Lizenz wurde nicht herausgegeben, bitte versuchen Sie es erneut.',
        'success' => 'Lizenz wurde erfolgreich herausgegeben'
    ),

    'checkin' => array(
        'error'   => 'Lizenz wurde nicht zurückgenommen, bitte versuchen Sie es erneut.',
        'success' => 'Die Lizenz wurde erfolgreich zurückgenommen'
    ),

);

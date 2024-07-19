<?php

return array(

    'does_not_exist' => 'Das Zubehör [:id] existiert nicht.',
    'not_found' => 'Dieses Zubehör wurde nicht gefunden.',
    'assoc_users'	 => 'Dieses Zubehör ist derzeit an :count Benutzern zur Verwendung ausgegeben worden. Bitte buchen Sie das Zubehör wieder ein und versuchen es dann erneut. ',

    'create' => array(
        'error'   => 'Zubehör wurde nicht erzeugt, bitte versuchen Sie es erneut.',
        'success' => 'Zubehör erfolgreich angelegt.'
    ),

    'update' => array(
        'error'   => 'Zubehör wurde nicht aktualisiert, bitte versuchen Sie es erneut',
        'success' => 'Zubehör wurde erfolgreich aktualisiert.'
    ),

    'delete' => array(
        'confirm'   => 'Sind Sie sicher, dass Sie dieses Zubehör löschen möchten?',
        'error'   => 'Beim Löschen dieses Zubehörs ist ein Problem aufgetreten. Bitte versuchen Sie es erneut.',
        'success' => 'Das Zubehör wurde erfolgreich gelöscht.'
    ),

     'checkout' => array(
        'error'   		=> 'Zubehör konnte nicht herausgegeben werden. Bitte versuchen Sie es erneut',
        'success' 		=> 'Zubehör erfolgreich herausgegeben.',
        'unavailable'   => 'Zubehör ist nicht verfügbar, um herausgegeben zu werden. Prüfen Sie die verfügbare Menge',
        'user_does_not_exist' => 'Dieser Benutzer existiert nicht. Bitte versuchen Sie es erneut.',
         'checkout_qty' => array(
            'lte'  => 'There is currently only one available accessory of this type, and you are trying to check out :checkout_qty. Please adjust the checkout quantity or the total stock of this accessory and try again.|There are :number_currently_remaining total available accessories, and you are trying to check out :checkout_qty. Please adjust the checkout quantity or the total stock of this accessory and try again.',
            ),
           
    ),

    'checkin' => array(
        'error'   		=> 'Das Zubehör wurde nicht erfolgreich zurückgenommen. Bitte versuchen Sie es erneut',
        'success' 		=> 'Zubehör erfolgreich zurückgenommen.',
        'user_does_not_exist' => 'Dieser Benutzer existiert nicht. Bitte versuchen Sie es erneut.'
    )


);

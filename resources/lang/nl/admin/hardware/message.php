<?php

return array(

    'undeployable' 		=> '<strong>Waarschuwing: </strong>Het gereedschap is gemarkeerd als niet uitrolbaar. Als de status is veranderd, verander dan de status van het gereedschap.',
    'does_not_exist' 	=> 'Dit gereedschap bestaat niet.',
    'does_not_exist_or_not_requestable' => 'Leuk geprobeerd. Het product bestaat niet of is niet aanvraagbaar.',
    'assoc_users'	 	=> 'Dit gereedschap is op dit moment toegewezen aan een gebruiker en kan niet verwijderd worden. Verwijder het gereedschap eerst, en probeer op nieuw.',

    'create' => array(
        'error'   		=> 'Aanmaken van gereedschap is mislukt. Probeer opnieuw :(',
        'success' 		=> 'Gereedschap is succesvol aangemaakt :)'
    ),

    'update' => array(
        'error'   			=> 'Gereedschap is niet aangepast. Probeer opnieuw',
        'success' 			=> 'Gereedschap is succesvol aangepast.',
        'nothing_updated'	=>  'Geen veld is geselecteerd, er is dus niks gewijzigd.',
    ),

    'restore' => array(
        'error'   		=> 'Gereedschap is niet hersteld. Probeer opnieuw',
        'success' 		=> 'Gereedschap is succesvol hersteld.'
    ),

    'audit' => array(
        'error'   		=> 'Product audit is mislukt. probeer het nogmaals.',
        'success' 		=> 'Product audit succesvol gelogd.'
    ),


    'deletefile' => array(
        'error'   => 'Bestand is niet verwijderd. Probeer het opnieuw.',
        'success' => 'Bestand is met succes verwijderd.',
    ),

    'upload' => array(
        'error'   => 'Bestand(en) zijn niet geüpload. Probeer het opnieuw.',
        'success' => 'Bestand(en) zijn met succes geüpload.',
        'nofiles' => 'Je hebt geen bestanden geselecteerd om te uploaden, of het bestand wat je probeert te uploaden is te groot',
        'invalidfiles' => 'Een of meer van uw bestanden is te groot of is een bestandstype dat niet is toegestaan. Toegestaande bestandstypen png, gif, jpg, doc, docx, pdf en txt.',
    ),

    'import' => array(
        'error'                 => 'Sommige items zijn niet goed geïmporteerd.',
        'errorDetail'           => 'De volgende items zijn niet geïmporteerd vanwege fouten.',
        'success'               => "Je bestand is geïmporteerd",
        'file_delete_success'   => "Je bestand is succesvol verwijderd",
        'file_delete_error'      => "Het bestand kon niet worden verwijderd",
    ),


    'delete' => array(
        'confirm'   	=> 'Weet je zeker dat je dit product wilt verwijderen?',
        'error'   		=> 'Er was een probleem tijdens het verwijderen van het product. Probeer opnieuw.',
        'nothing_updated'   => 'Er was geen product geselecteerd dus is er niks verwijderd.',
        'success' 		=> 'Het product is met succes verwijderd.'
    ),

    'checkout' => array(
        'error'   		=> 'Product is niet uitgecheckt, probeer het opnieuw',
        'success' 		=> 'Product is met succes uitgecheckt.',
        'user_does_not_exist' => 'De gebruiker is ongeldig. Probeer het opnieuw.',
        'not_available' => 'Dat item is niet beschikbaar om uit te leveren!',
        'no_assets_selected' => 'U dient ten minste één item te selecteren uit de lijst'
    ),

    'checkin' => array(
        'error'   		=> 'Product is niet ingecheckt, probeer het opnieuw',
        'success' 		=> 'Product is met succes ingecheckt.',
        'user_does_not_exist' => 'De gebruiker is ongeldig. Probeer het opnieuw.',
        'already_checked_in'  => 'Product is reeds ingecheckt.',

    ),

    'requests' => array(
        'error'   		=> 'Product is niet aangevraagd, probeer het opnieuw',
        'success' 		=> 'Product is met succes aangevraagd.',
        'canceled'      => 'Aanvraag succesvol geannuleerd'
    )

);

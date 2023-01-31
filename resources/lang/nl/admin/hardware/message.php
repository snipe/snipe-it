<?php

return [

    'undeployable' 		=> '<strong>Waarschuwing: </strong> Dit bestand is gemarkeerd als niet-uitgeefbaar.
                        Als deze status is veranderd, update dan de asset status.',
    'does_not_exist' 	=> 'Dit asset bestaat niet.',
    'does_not_exist_or_not_requestable' => 'Die asset bestaat niet of is niet aanvraagbaar.',
    'assoc_users'	 	=> 'Dit asset is momenteel toegewezen aan een gebruiker en kan niet worden verwijderd. Controleer het asset eerst en probeer het opnieuw. ',

    'create' => [
        'error'   		=> 'Asset is niet aangemaakt, probeer het opnieuw :(',
        'success' 		=> 'Asset is succesvol aangemaakt. :)',
    ],

    'update' => [
        'error'   			=> 'Asset is niet gewijzigd, probeer het opnieuw',
        'success' 			=> 'Asset is succesvol bijgewerkt.',
        'nothing_updated'	=>  'Geen veld is geselecteerd, er is dus niks gewijzigd.',
        'no_assets_selected'  =>  'Er zijn geen assets geselecteerd, er is dus niets bijgewerkt.',
    ],

    'restore' => [
        'error'   		=> 'Asset is niet hersteld, probeer het opnieuw',
        'success' 		=> 'Asset is succesvol hersteld.',
    ],

    'audit' => [
        'error'   		=> 'Asset audit is mislukt. Probeer het opnieuw.',
        'success' 		=> 'Asset audit succesvol geregistreerd.',
    ],


    'deletefile' => [
        'error'   => 'Bestand is niet verwijderd. Probeer het opnieuw.',
        'success' => 'Bestand is met succes verwijderd.',
    ],

    'upload' => [
        'error'   => 'Bestand(en) zijn niet geüpload. Probeer het opnieuw.',
        'success' => 'Bestand(en) zijn met succes geüpload.',
        'nofiles' => 'Je hebt geen bestanden geselecteerd om te uploaden, of het bestand wat je probeert te uploaden is te groot',
        'invalidfiles' => 'Een of meer van uw bestanden is te groot of is een bestandstype dat niet is toegestaan. Toegestaande bestandstypen png, gif, jpg, doc, docx, pdf en txt.',
    ],

    'import' => [
        'error'                 => 'Sommige items zijn niet goed geïmporteerd.',
        'errorDetail'           => 'De volgende items zijn niet geïmporteerd vanwege fouten.',
        'success'               => 'Je bestand is geïmporteerd',
        'file_delete_success'   => 'Je bestand is succesvol verwijderd',
        'file_delete_error'      => 'Het bestand kon niet worden verwijderd',
    ],


    'delete' => [
        'confirm'   	=> 'Weet je zeker dat je dit asset wilt verwijderen?',
        'error'   		=> 'Er was een probleem tijdens het verwijderen van het asset. Probeer het opnieuw.',
        'nothing_updated'   => 'Er zijn geen assets geselecteerd, er is dus niets verwijderd.',
        'success' 		=> 'Het asset is succesvol verwijderd.',
    ],

    'checkout' => [
        'error'   		=> 'Asset is niet uitgecheckt, probeer het opnieuw',
        'success' 		=> 'Asset is met succes uitgecheckt.',
        'user_does_not_exist' => 'De gebruiker is ongeldig. Probeer het opnieuw.',
        'not_available' => 'Dat asset is niet beschikbaar voor check-out!',
        'no_assets_selected' => 'U moet minstens één asset selecteren uit de lijst',
    ],

    'checkin' => [
        'error'   		=> 'Asset is niet ingecheckt, probeer het opnieuw',
        'success' 		=> 'Asset is met succes ingecheckt.',
        'user_does_not_exist' => 'De gebruiker is ongeldig. Probeer het opnieuw.',
        'already_checked_in'  => 'Dat asset is al ingecheckt.',

    ],

    'requests' => [
        'error'   		=> 'Asset is niet aangevraagd. Probeer het opnieuw',
        'success' 		=> 'Asset is succesvol aangevraagd.',
        'canceled'      => 'Checkout aanvraag succesvol geannuleerd',
    ],

];

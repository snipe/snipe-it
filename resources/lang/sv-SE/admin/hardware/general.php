<?php

return [
    'about_assets_title'           => 'Om tillgångar',
    'about_assets_text'            => 'Tillgångar är poster som spåras med serienummer eller tillgångstagg. De tenderar att vara mer värdefulla saker där identifiering av en viss sak är viktig.',
    'archived'  				=> 'Arkiverade',
    'asset'  					=> 'Tillgång',
    'bulk_checkout'             => 'Checkout tillgångar',
    'bulk_checkin'              => 'Återta tillgångar',
    'checkin'  					=> 'Checkin Asset',
    'checkout'  				=> 'Checkout Asset',
    'clone'  					=> 'Klon tillgång',
    'deployable'  				=> 'Deployable',
    'deleted'  					=> 'Denna tillgång har tagits bort.',
    'edit'  					=> 'Redigera tillgång',
    'model_deleted'  			=> 'Denna tillgångsmodell har tagits bort. Du måste återställa modellen innan du kan återställa tillgången.',
    'requestable'               => 'Tillgängliga',
    'requested'				    => 'Begärda',
    'not_requestable'           => 'Inte begärbar',
    'requestable_status_warning' => 'Ändra inte begärbar status',
    'restore'  					=> 'Återställ tillgången',
    'pending'  					=> 'Väntande',
    'undeployable'  			=> 'Undeployable',
    'view'  					=> 'Visa tillgång',
    'csv_error' => 'Du har ett fel i din CSV-fil:',
    'import_text' => '
    <p>
    Ladda upp en CSV som innehåller tillgångshistorik. Tillgångar och användare MÅSTE redan finns i systemet, annars kommer de att hoppas över. Matchande tillgångar för historikimport sker mot tillgångstaggen. Vi kommer att försöka hitta en matchande användare baserat på användarens namn du anger, och kriterierna du väljer nedan. Om du inte väljer några kriterier nedan, kommer den helt enkelt att försöka matcha användarnamn formatet du konfigurerat i Admin &gt; Allmänna inställningar.
    </p>

    <p>Fält som ingår i CSV måste matcha rubrikerna: <strong>Asset Tag, Namn, Checkout datum, Checkin datum</strong>. Eventuella ytterligare fält kommer att ignoreras. </p>

    <p>Checkin Datum: tomt eller framtida checkin datum kommer att checka ut objekt till associerad användare. Exklusive kolumnen Checkin Date kommer en checkin datum med dagens datum.</p>
    ',
    'csv_import_match_f-l' => 'Försök att matcha användare med firstname.lastname (jane.smith) format',
    'csv_import_match_initial_last' => 'Försök att matcha användare med första förnamnet (jsmith) format',
    'csv_import_match_first' => 'Försök att matcha användare med förnamn (jane) format',
    'csv_import_match_email' => 'Försök att matcha användare via e-post som användarnamn',
    'csv_import_match_username' => 'Försök att matcha användare med användarnamn',
    'error_messages' => 'Felmeddelanden:',
    'success_messages' => 'Lyckade meddelande:',
    'alert_details' => 'Se nedan för detaljer.',
    'custom_export' => 'Anpassad export'
];

<?php

return [
    'about_assets_title'           => 'Over assets',
    'about_assets_text'            => 'Assets zijn items die worden bijgehouden op serienummer of een tag van het product. Het zijn meestal items met een hogere waarde waarbij het identificeren van een specifiek item belangrijk is.',
    'archived'  				=> 'Gearchiveerd',
    'asset'  					=> 'Asset',
    'bulk_checkout'             => 'Asset uitchecken',
    'bulk_checkin'              => 'Assets inchecken',
    'checkin'  					=> 'Asset inchecken',
    'checkout'  				=> 'Asset uitchecken',
    'clone'  					=> 'Dupliceer Asset',
    'deployable'  				=> 'Uitgeefbaar',
    'deleted'  					=> 'Deze asset is verwijderd.',
    'edit'  					=> 'Asset bewerken',
    'model_deleted'  			=> 'Dit Assets model is verwijderd. U moet het model herstellen voordat u het Asset kunt herstellen.',
    'requestable'               => 'Aanvraagbaar',
    'requested'				    => 'Aangevraagd',
    'not_requestable'           => 'Niet aanvraagbaar',
    'requestable_status_warning' => 'Verander de aanvraagbare status niet',
    'restore'  					=> 'Herstel Asset',
    'pending'  					=> 'In behandeling',
    'undeployable'  			=> 'Niet uitgeefbaar',
    'view'  					=> 'Bekijk Asset',
    'csv_error' => 'Je hebt een fout in je CSV-bestand:',
    'import_text' => '
    <p>
    Upload een CSV bestand dat de asset historie bevat. De assets en gebruikers MOETEN al in het systeem staan anders worden ze overgeslagen. Het koppelen van assets gebeurt op basis van assets Tag. We proberen om een gebruiker te vinden op basis van de gebruikersnaam die je hebt opgegeven en de onderstaande criteria. Indien je geen criteria selecteert proberen we te koppelen op het gebruikersnaam formaat zoals geconfigureerd in de Admin &gt; Algemene Instellingen.
    </p>

    <p>Velden in de CSV moet overeenkomen met de headers: <strong>Asset Tag, Naam, Check-out Datum, Check-in Datum</strong>. Alle additionele velden worden overgeslagen. </p>

    <p>Check-in Datum: lege of toekomstige check-in datum worden ingecheckt aan de betreffende gebruiker. Zonder Check-in kolom maken we een check-in datum met vandaag als datum.</p>
    ',
    'csv_import_match_f-l' => 'Probeer gebruikers te koppelen via voornaam.achternaam (Jan.Janssen) opmaak',
    'csv_import_match_initial_last' => 'Probeer gebruikers te koppelen via eerste initiaal en achternaam (jjanssen) opmaak',
    'csv_import_match_first' => 'Probeer gebruikers te koppelen via voornaam (jan) opmaak',
    'csv_import_match_email' => 'Probeer gebruikers te koppelen via e-mail als gebruikersnaam',
    'csv_import_match_username' => 'Probeer gebruikers te koppelen via gebruikersnaam',
    'error_messages' => 'Foutmeldingen:',
    'success_messages' => 'Succesvolle berichten:',
    'alert_details' => 'Zie hieronder voor details.',
    'custom_export' => 'Aangepaste export'
];

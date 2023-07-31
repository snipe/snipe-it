<?php

return [
    'about_assets_title'           => 'Om assets',
    'about_assets_text'            => 'Eiendeler er sporet av serienummer eller assetsmerke.  De pleier å være høyere verdi f. eks for å identifisere spesielle ting.',
    'archived'  				=> 'Arkivert',
    'asset'  					=> 'Eiendel',
    'bulk_checkout'             => 'Sjekk ut Eiendeler',
    'bulk_checkin'              => 'Checkin Assets',
    'checkin'  					=> 'Sjekk inn eiendel',
    'checkout'  				=> 'Sjekk ut asset',
    'clone'  					=> 'Klon eiendel',
    'deployable'  				=> 'Utleverbar',
    'deleted'  					=> 'Denne eiendelen har blitt slettet.',
    'edit'  					=> 'Rediger eiendel',
    'model_deleted'  			=> 'Denne eiendelsmodellen er slettet. Du må gjenopprette modellen før du kan gjenopprette eiendelen.',
    'model_invalid'             => 'The Model of this Asset is invalid.',
    'model_invalid_fix'         => 'The Asset should be edited to correct this before attempting to check it in or out.',
    'requestable'               => 'Forespørrbar',
    'requested'				    => 'Forespurt',
    'not_requestable'           => 'Ikke mulig å spørre etter',
    'requestable_status_warning' => 'Ikke endre forespørselsstatus',
    'restore'  					=> 'Gjenopprett eiendel',
    'pending'  					=> 'Under arbeid',
    'undeployable'  			=> 'Ikke utleverbar',
    'undeployable_tooltip'  	=> 'This asset has a status label that is undeployable and cannot be checked out at this time.',
    'view'  					=> 'Vis eiendel',
    'csv_error' => 'Du har en feil i din CSV-fil:',
    'import_text' => '
<p>
    Last opp en CSV-fil som inneholder eiendelshistorikk. Eiendeler og brukere i fila MÅ allerede finnes i systemet, hvis ikke blir de oversett. Eiendelene blir matchet mot Eiendelsmerke (Asset Tag). Vi vil forsøke å finne en matchende bruker basert på brukerens navn og de kriteriene du spesifiserer under. Hvis du ikke spesifiserer noen kriterier vil vi forsøke å matche brukere på brukernavn-formatet som er satt opp i Admin &gt; Generelle innstillinger
</p>

    <p>CSV-fila må inneholde headerne <strong>Asset Tag, Name, Checkout Data, Checkin Date</strong>. Ekstra felter blir oversett.</p>

    <p>Checkin Date: Tomme eller datoer i fremtiden vil sjekke ut eiendelen til den tilknyttede brukeren. Manger Checkin Date-kolonnen vil det føre til at innsjekk blir dagens dato.</p>
    ',
    'csv_import_match_f-l' => 'Prøv å matche brukere med formatet fornavn.etternavn (eli.nordmann)',
    'csv_import_match_initial_last' => 'Prøv å matche brukere med formatet initial+etternavn (enordmann)',
    'csv_import_match_first' => 'Prøv å matche brukere med formatet fornavn (eli)',
    'csv_import_match_email' => 'Prøv å matche brukere med e-post som brukernavn',
    'csv_import_match_username' => 'Prøv å matche brukere med brukernavn',
    'error_messages' => 'Feilmeldinger:',
    'success_messages' => 'Suksessmeldinger:',
    'alert_details' => 'Vennligst se nedenfor for detaljer.',
    'custom_export' => 'Egendefinert eksport',
    'mfg_warranty_lookup' => ':manufacturer Warranty Status Lookup',
];

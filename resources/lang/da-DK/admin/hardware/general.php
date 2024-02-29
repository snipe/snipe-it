<?php

return [
    'about_assets_title'           => 'Om aktiver',
    'about_assets_text'            => 'Aktiver er poster sporet af serienummer eller aktiv tag. De har tendens til at være højere værdi elementer, hvor identifikation af en bestemt genstand betyder noget.',
    'archived'  				=> 'arkiverede',
    'asset'  					=> 'Asset',
    'bulk_checkout'             => 'Udtjek aktiv',
    'bulk_checkin'              => 'Checkin Assets',
    'checkin'  					=> 'Checkin Asset',
    'checkout'  				=> 'Checkout Asset',
    'clone'  					=> 'Klonaktiver',
    'deployable'  				=> 'Deployable',
    'deleted'  					=> 'Dette aktiv er blevet slettet.',
    'delete_confirm'            => 'Er du sikker på, at du vil slette dette aktiv?',
    'edit'  					=> 'Rediger aktiv',
    'model_deleted'  			=> 'Denne aktivmodel er blevet slettet. Du skal gendanne modellen, før du kan gendanne aktivet.',
    'model_invalid'             => 'Modellen af dette aktiv er ugyldig.',
    'model_invalid_fix'         => 'Aktivet skal redigeres for at korrigere dette, før du forsøger at tjekke det ind eller ud.',
    'requestable'               => 'kan anmodes',
    'requested'				    => 'Anmodet',
    'not_requestable'           => 'Ikke Anmodet',
    'requestable_status_warning' => 'Ændr ikke status for anfordring',
    'restore'  					=> 'Gendan aktiv',
    'pending'  					=> 'Verserende',
    'undeployable'  			=> 'Undeployable',
    'undeployable_tooltip'  	=> 'Dette aktiv har en status etiket, der ikke kan installeres og kan ikke tjekkes ud på dette tidspunkt.',
    'view'  					=> 'Se aktiv',
    'csv_error' => 'Du har en fejl i din CSV-fil:',
    'import_text' => '
    <p>
    Upload en CSV, der indeholder aktivhistorik. Aktiver og brugere SKAL allerede findes i systemet, eller de vil blive sprunget over. Matchende aktiver for historik import sker mod asset tag. Vi vil forsøge at finde en matchende bruger baseret på den brugers navn, du giver, og de kriterier, du vælger nedenfor. Hvis du ikke vælger nogen kriterier nedenfor, det vil blot forsøge at matche på det brugernavn format, du har konfigureret i Admin &gt; Generelle indstillinger.
    </p>

    <p>Felter inkluderet i CSV skal matche overskrifterne: <strong>Asset Tag, Navn, Checkout Dato, Checkin Dato</strong>. Eventuelle yderligere felter vil blive ignoreret. </p>

    <p>Checkin Dato: blank eller fremtidige checkin datoer vil checkout elementer til tilknyttet bruger. Eksklusive Checkin Date kolonnen vil oprette en checkin dato med dagens dato.</p>
    ',
    'csv_import_match_f-l' => 'Prøv at matche brugere med fornavn.Efternavn (jane.smith) format',
    'csv_import_match_initial_last' => 'Prøv at matche brugere med det første efternavn (jsmith) format',
    'csv_import_match_first' => 'Prøv at matche brugere efter fornavn (jane) format',
    'csv_import_match_email' => 'Prøv at matche brugere via e-mail som brugernavn',
    'csv_import_match_username' => 'Prøv at matche brugere med brugernavn',
    'error_messages' => 'Fejlmeddelelser:',
    'success_messages' => 'Beskeder med succes:',
    'alert_details' => 'Se venligst nedenfor for detaljer.',
    'custom_export' => 'Brugerdefineret Eksport',
    'mfg_warranty_lookup' => ':manufacturer Garanti Status Opslag',
    'user_department' => 'Bruger Afdeling',
];

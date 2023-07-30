<?php

return [
    'about_assets_title'           => 'O majetku',
    'about_assets_text'            => 'Majetky jsou položky sledované sériovým číslem nebo značkou. Mají tendenci mít vyšší hodnotou, tam kde je důležitá identifikace určité položky.',
    'archived'  				=> 'Archivováno',
    'asset'  					=> 'Majetek',
    'bulk_checkout'             => 'Vyskladnit majetek',
    'bulk_checkin'              => 'Převzít majetek',
    'checkin'  					=> 'Převzít majetek',
    'checkout'  				=> 'Pokladní majetek',
    'clone'  					=> 'Klonovat majetek',
    'deployable'  				=> 'Připraveno k nasazení',
    'deleted'  					=> 'Tento majetek byl odstraněn.',
    'edit'  					=> 'Upravit majetek',
    'model_deleted'  			=> 'Tento model majetku byl odstraněn. Před obnovením majetku musíte model obnovit.',
    'model_invalid'             => 'Model tohoto majetku je neplatný.',
    'model_invalid_fix'         => 'Měli byste tento majetek upravit dříve, než jej vydáte, či přijmete.',
    'requestable'               => 'Lze vyžádat',
    'requested'				    => 'Požadováno',
    'not_requestable'           => 'Nelze vyžádat',
    'requestable_status_warning' => 'Neměnit požadovaný stav',
    'restore'  					=> 'Obnovit zařízení',
    'pending'  					=> 'Čekající',
    'undeployable'  			=> 'Nelze vyskladnit',
    'undeployable_tooltip'  	=> 'This asset has a status label that is undeployable and cannot be checked out at this time.',
    'view'  					=> 'Zobrazit majetek',
    'csv_error' => 'Máte chybu v souboru CSV:',
    'import_text' => '
    <p>
    Nahrajte CSV obsahující historii aktiv. Majetek a uživatelé MUSÍ již v systému existovat, nebo budou přeskočeni. Odpovídající aktiva se dopárují přes inventární číslo. Pokusíme se najít odpovídající uživatele na základě uživatelského jména a kritérií, která vyberete níže. Pokud nevyberete žádná kritéria níže, pokusíme se data spárovat pomocí uživatelského jména, který jste nakonfigurovali v Admin &gt; Obecná nastavení.
    </p>

    <p>Pole zahrnutá do CSV musí odpovídat hlavičkám: <strong>Inventární číslo, Jméno, Datum převzetí majetku, Datum vydání majetku</strong>. Všechna další pole budou ignorována. </p>

    <p>Odevzdání majetku: prázdná nebo budoucí data automaticky odhlásí majetek přidruženému uživateli. Vyloučením sloupce odevzdání majetku nastaví datum odevzdání na dnešek.</p>
    ',
    'csv_import_match_f-l' => 'Formát jmeno.prijmeni (karel.novak)',
    'csv_import_match_initial_last' => 'Formát jprijmeni (knovak)',
    'csv_import_match_first' => 'Formát jmeno (karel)',
    'csv_import_match_email' => 'Email jako uživatelské jméno',
    'csv_import_match_username' => 'Uživatelské jméno podle uživatelského jména',
    'error_messages' => 'Chybové zprávy:',
    'success_messages' => 'Úspěšné zprávy:',
    'alert_details' => 'Podrobnosti naleznete níže.',
    'custom_export' => 'Uživatelsky definovaný export',
    'mfg_warranty_lookup' => ':manufacturer Warranty Status Lookup',
];

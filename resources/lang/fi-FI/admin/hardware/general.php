<?php

return [
    'about_assets_title'           => 'Tietoja laitteista',
    'about_assets_text'            => 'Laitteita ovat nimikeitä joita seurataan sarjanumeron tai laitetunnisteen avulla. Laitteiksi määritellään yleensä arvokkaampaa omaisuutta, joiden tunnistaminen yksilöllisesti on tärkeää. Pienemmät laitteet voi määrittää lisävarusteiksi.',
    'archived'  				=> 'Arkistoitu',
    'asset'  					=> 'Laite',
    'bulk_checkout'             => 'Laitteiden luovutus',
    'bulk_checkin'              => 'Palauta laitteita',
    'checkin'  					=> 'Palauta laite',
    'checkout'  				=> 'Luovuta laite',
    'clone'  					=> 'Monista laite',
    'deployable'  				=> 'Käyttöönotettavissa',
    'deleted'  					=> 'Tämä laite on poistettu.',
    'delete_confirm'            => 'Are you sure you want to delete this asset?',
    'edit'  					=> 'Muokkaa laitetta',
    'model_deleted'  			=> 'Laitemalli on poistettu. Voit palauttaa laitteen kun olet ensin palauttanut poistetun laitemallin.',
    'model_invalid'             => 'Tämän laitteen malli on virheellinen.',
    'model_invalid_fix'         => 'Laitetta tulee muokata tilanteen korjaamiseksi, ennen kuin se yritetään lainata tai palauttaa.',
    'requestable'               => 'Pyydettävissä',
    'requested'				    => 'Pyydetty',
    'not_requestable'           => 'Ei pyydettävissä',
    'requestable_status_warning' => 'Älä muuta pyydettävyyden tilaa',
    'restore'  					=> 'Palauta laite',
    'pending'  					=> 'Odottaa',
    'undeployable'  			=> 'Ei käytettävissä',
    'undeployable_tooltip'  	=> 'Tällä laitteella on tilamerkintä joka ei mahdollista käyttöä, jonka takia laitetta ei voi lainata tällä hetkellä.',
    'view'  					=> 'Näytä laite',
    'csv_error' => 'Sinulla on virhe CSV tiedostossasi:',
    'import_text' => '
    <p>
    Lataa laitehistoria csv-tiedostona. Laitteiden ja käyttäjien TÄYTYY olla jo järjestelmässä, tai ne ohitetaan. Laitteden tiedot yhdistetään laitetunnisteen avulla. Käyttäjät yhdestetään käyttäjänimen perusteella käyttäen kriteerejä  jotka voit antaa alla. Oletuksena tiedot yhistetään käyttäjännimeen k muodossa jonka asetit Admin &gt; Yleiset asetukset.
    </p>

    <p>CSV tiedoston tulee sisältää seuraavat sarakkeet: <strong>Asset Tag, Name, Checkout Date, Checkin Date</strong> eli laitetunniste, käytäjänimi, luovutus pvm ja palautus pvm. Kaikki muut kentät jätetään huomiotta. </p>

    <p>Palautuspvm : tyhjä tai tulevat palautuspäivämäärät kuittaavat laiteen ulos kyseiselle käyttäjälle.</p>
    ',
    'csv_import_match_f-l' => 'Yritä sovittaa käyttäjät etunimi.sukunimi (jane.smith) muodossa',
    'csv_import_match_initial_last' => 'Yritä sovittaa käyttäjät ensimmäinen etunimestä sukunimi (jsmith) muodossa',
    'csv_import_match_first' => 'Yritä sovittaa käyttäjät etunimi (jane) muodossa',
    'csv_import_match_email' => 'Yritä sovittaa käyttäjiä sähköposti käyttäjätunnuksena',
    'csv_import_match_username' => 'Yritä sovittaa käyttäjiä käyttäjänimen mukaan',
    'error_messages' => 'Virheilmoitukset:',
    'success_messages' => 'Onnistuneet:',
    'alert_details' => 'Tarkempia tietoja on alla.',
    'custom_export' => 'Mukautettu vienti',
    'mfg_warranty_lookup' => ':manufacturer Warranty Status Lookup',
    'user_department' => 'User Department',
];

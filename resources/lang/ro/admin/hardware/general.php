<?php

return [
    'about_assets_title'           => 'Despre Active',
    'about_assets_text'            => 'Activele sunt elemente urmărite prin numărul de serie sau eticheta de activ. Ele tind să fie elemente de valoare mai mare în cazul în care identificarea unui anumit element contează.',
    'archived'  				=> 'Arhivate',
    'asset'  					=> 'Activ',
    'bulk_checkout'             => 'Predă activ',
    'bulk_checkin'              => 'Checkin Assets',
    'checkin'  					=> 'Verifica activ',
    'checkout'  				=> 'Checkout Asset',
    'clone'  					=> 'Cloneaza activ',
    'deployable'  				=> 'Lansabil',
    'deleted'  					=> 'Acest activ a fost șters.',
    'edit'  					=> 'Editeaza activ',
    'model_deleted'  			=> 'Acest model de active a fost șters. Trebuie să restaurați modelul înainte de a putea restaura activul.',
    'model_invalid'             => 'The Model of this Asset is invalid.',
    'model_invalid_fix'         => 'The Asset should be edited to correct this before attempting to check it in or out.',
    'requestable'               => 'Requestable',
    'requested'				    => 'Solicitat',
    'not_requestable'           => 'Nu poate fi solicitat',
    'requestable_status_warning' => 'Do not change  requestable status',
    'restore'  					=> 'Restabilirea activului',
    'pending'  					=> 'In asteptare',
    'undeployable'  			=> 'Nelansabil',
    'undeployable_tooltip'  	=> 'This asset has a status label that is undeployable and cannot be checked out at this time.',
    'view'  					=> 'Vizualizeaza activ',
    'csv_error' => 'Aveți o eroare în fișierul dvs. CSV:',
    'import_text' => '
    <p>
    Încărcați un CSV care conține istoricul activelor. Activele și utilizatorii TREBUIE să existe deja în sistem sau acestea vor fi ignorate. Potrivirea activelor pentru importul istoricului  se face pe baza etichetei activului. Vom încerca să găsim un utilizator care se potrivește pe baza numelui de utilizator pe care îl furnizați, și a criteriilor pe care le selectați mai jos. Dacă nu selectați niciun criteriu de mai jos, va încerca potrivirea pe baza formatul numelui de utilizator configurat în Admin &gt; Setări Generale.
    </p>

    <p>Câmpurile incluse în CSV trebuie să se potrivească cu antetul: <strong>Etichetă Activ, Nume, Dată Predare, Dată Primire</strong>. Alte câmpuri suplimentare vor fi ignorate. </p>

    <p>Dată Primire: datele de primire în gestiune necompletate sau viitoare vor marca produsele ca predate către utilizatorul asociat. Dacă coloana Dată Primire este exclusă, data primirii în gestiune va fi data curentă.</p>
    ',
    'csv_import_match_f-l' => 'Încercați potrivirea utilizatorilor după prenume.nume de familie (de ex. jane.smith)',
    'csv_import_match_initial_last' => 'Încercați potrivirea utilizatorilor după inițiala numelui și numele de familie (de ex. jsmith)',
    'csv_import_match_first' => 'Încercați potrivirea utilizatorilor după prenume (de ex. jane)',
    'csv_import_match_email' => 'Încercați potrivirea utilizatorilor folosind emailul ca nume utilizator',
    'csv_import_match_username' => 'Încercați potrivirea utilizatorilor după numele de utilizator',
    'error_messages' => 'Mesaje de eroare:',
    'success_messages' => 'Mesaje de succes:',
    'alert_details' => 'Vezi mai jos pentru detalii.',
    'custom_export' => 'Export date personalizat',
    'mfg_warranty_lookup' => ':manufacturer Warranty Status Lookup',
];

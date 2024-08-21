<?php

return [

    'update' => [
        'error'                 => 'A aparut o eroare la actualizare. ',
        'success'               => 'Setari au fost actualizate.',
    ],
    'backup' => [
        'delete_confirm'        => 'Sigur doriți să ștergeți acest fișier de rezervă? Această acțiune nu poate fi anulată.',
        'file_deleted'          => 'Fișierul de rezervă a fost șters cu succes.',
        'generated'             => 'Un nou dosar de rezervă a fost creat cu succes.',
        'file_not_found'        => 'Acest fișier de rezervă nu a putut fi găsit pe server.',
        'restore_warning'       => 'Da, restaurează. Confirm suprascrierea tuturor datelor existente în baza de date. Acest lucru va deconecta și pe toți utilizatorii curenți (inclusiv pe tine).',
        'restore_confirm'       => 'Sunteți sigur că doriți restaurarea bazei de date din fișierul :filename?'
    ],
    'restore' => [
        'success'               => 'Your system backup has been restored. Please log in again.'
    ],
    'purge' => [
        'error'     => 'A apărut o eroare în timpul epurării.',
        'validation_failed'     => 'Confirmarea dvs. de purjare este incorectă. Introduceți cuvântul "DELETE" în caseta de confirmare.',
        'success'               => 'Înregistrările șterse au fost eliminate cu succes.',
    ],
    'mail' => [
        'sending' => 'Se trimite email-ul de test...',
        'success' => 'Email trimis!',
        'error' => 'Email-ul nu a putut fi trimis.',
        'additional' => 'Nu a fost furnizat nici un mesaj de eroare suplimentar. Verificați setările de email și logurile aplicației.'
    ],
    'ldap' => [
        'testing' => 'Testare conexiune LDAP, îmbinare și interogare...',
        '500' => 'Eroare 500 Server. Vă rugăm să verificaţi jurnalele serverului pentru mai multe informaţii.',
        'error' => 'Ceva a mers prost :(',
        'sync_success' => 'Un eșantion de 10 utilizatori returnați de pe serverul LDAP, în funcție de setările dvs.:',
        'testing_authentication' => 'Testare autentificare LDAP...',
        'authentication_success' => 'Utilizatorul s-a autentificat cu succes împotriva LDAP!'
    ],
    'webhook' => [
        'sending' => 'Se trimite mesajul de testare :app...',
        'success' => 'Integrarea ta :webhook_name funcționează!',
        'success_pt1' => 'Succes! Verifică ',
        'success_pt2' => ' canalul pentru mesajul de testare şi asiguraţi-vă că faceţi clic pe ECONOMISEŞTE mai jos pentru a stoca setările.',
        '500' => 'Eroare 500 Server',
        'error' => 'Ceva nu a funcționat. :app a răspuns cu: :error_message',
        'error_redirect' => 'EROARE: 301/302 :endpoint returnează o redirecționare. Din motive de securitate, nu urmărim redirecționările. Vă rugăm să folosiți obiectivul final.',
        'error_misc' => 'Ceva nu a mers bine. :( ',
    ]
];

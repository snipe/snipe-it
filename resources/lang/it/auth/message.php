<?php

return [

    'account_already_exists' => 'Un account con questa email già esiste.',
    'account_not_found'      => 'Nome utente o password non corretto.',
    'account_not_activated'  => 'Questo account non è attivo.',
    'account_suspended'      => 'Questo account è sospeso.',
    'account_banned'         => 'Questo account è bannato.',
    'throttle'               => 'Troppi tentativi di login falliti. Per favore riprova entro :minutes minuti.',

    'two_factor' => [
        'already_enrolled'      => 'Il tuo dispositivo è già registrato.',
        'success'               => 'Accesso eseguito correttamente.',
        'code_required'         => 'Codice a due fattori richiesto.',
        'invalid_code'          => 'Codice a due fattori non valido.',
    ],

    'signin' => [
        'error'   => 'C\'è stato un problema durante il tentativo di accesso, riprova.',
        'success' => 'Accesso eseguito correttamente.',
    ],

    'logout' => [
        'error'   => 'C\'è stato un problema durante il tentativo di logout, riprova per favore.',
        'success' => 'Ti sei disconnesso con successo.',
    ],

    'signup' => [
        'error'   => 'C\'è stato un problema durante la creazione del tuo account, per favore riprova.',
        'success' => 'Account creato con successo.',
    ],

    'forgot-password' => [
        'error'   => 'C\'è stato un problema durante il tentativo di reset password, per favore riprova.',
        'success' => 'Se l\'indirizzo email esiste nel nostro sistema, è stata inviata una email di recupero password.',
    ],

    'forgot-password-confirm' => [
        'error'   => 'C\'è stato un problema durante il tentativo di reset password, per favore riprova.',
        'success' => 'La tua password è stata resettata con successo.',
    ],

];

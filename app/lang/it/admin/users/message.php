<?php

return array(

    'accepted'                  => 'Hai accettato con successo questo prodotto.',
    'declined'                  => 'Hai rifiutato con successo questo prodotto.',
    'user_exists'               => 'Utente già esistente!',
    'user_not_found'            => 'L\'utente [:id] non esite.',
    'user_login_required'       => 'È necessario il campo login',
    'user_password_required'    => 'È richiesta la password.',
    'insufficient_permissions'  => 'Permessi Insufficienti.',
    'user_deleted_warning'      => 'Questo utente è stato eliminato. Si dovrà ripristinare questo utente per modificare o assegnare nuovi beni.',
    'ldap_not_configured'        => 'L\'integrazione con LDAP non è stata configurata per questa installazione.',


    'success' => array(
        'create'    => 'Utente creato con successo.',
        'update'    => 'Utente aggiornato con successo.',
        'delete'    => 'Utente eliminato con successo.',
        'ban'       => 'Utente bloccato con successo.',
        'unban'     => 'Utente sbloccato con successo.',
        'suspend'   => 'Utente sospeso con successo.',
        'unsuspend' => 'Utente riabilitato con successo.',
        'restored'  => 'Utente ripristinato con successo.',
        'import'    => 'Utenti importati con successo.',
    ),

    'error' => array(
        'create' => 'C\'è stato un problema durante la creazione dell\'utente. Per favore riprova.',
        'update' => 'C\'è stato un problema durante l\'aggiornamento dell\'utente. Per favore riprova.',
        'delete' => 'C\'è stato un problema durante la cancellazione dell\'utente. Riprova per favore.',
        'unsuspend' => 'C\'è stato un problema durante la riabilitazione dell\'utente. Riprova per favore.',
        'import'    => 'C\'è stato un problema durante l\'importazione degli utenti. Riprova per favore.',
        'asset_already_accepted' => 'Questo bene è già stato accettato.',
        'accept_or_decline' => 'Devi accettare o rifiutare questo prodotto.',
        'incorrect_user_accepted' => 'The asset you have attempted to accept was not checked out to you.',
        'ldap_could_not_connect' => 'Impossibile connettersi al server LDAP. Controlla la configurazione del tuo server LDAP nel file di configurazione LDAP.<br>Errori dal server LDAP:',
        'ldap_could_not_bind' => 'Impossibile unirsi al server LDAP. Controlla la configurazione del tuo server LDAP nel file di configurazione LDAP.<br>Errori dal server LDAP: ',
        'ldap_could_not_search' => 'Impossibile trovare il server LDAP. Controlla la configurazione del tuo server LDAP nel file di configurazione LDAP.<br>Errori dal server LDAP:',
        'ldap_could_not_get_entries' => 'Impossibile ottenere voci dal server LDAP. Controlla la configurazione del tuo server LDAP nel file di configurazione LDAP.<br>Errori dal server LDAP:',
    ),

    'deletefile' => array(
        'error'   => 'File non cancellato. Riprova.',
        'success' => 'File cancellato con successo.',
    ),

    'upload' => array(
        'error'   => 'File non caricato/i. Riprova.',
        'success' => 'File caricato/i con successo.',
        'nofiles' => 'Non hai selezionato i file per il caricamento',
        'invalidfiles' => 'Uno o più file è troppo grande o è un tipo di file non consentito. Tipi di file ammessi sono png, gif, jpg, doc, docx, pdf, txt.',
    ),

);

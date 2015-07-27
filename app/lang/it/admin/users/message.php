<?php

return array(

    'accepted'                  => 'You have successfully accepted this asset.',
    'declined'                  => 'You have successfully declined this asset.',
    'user_exists'               => 'Utente già esistente!',
    'user_not_found'            => 'L\'utente [:id] non esite.',
    'user_login_required'       => 'È necessario il campo login',
    'user_password_required'    => 'È richiesta la password.',
    'insufficient_permissions'  => 'Permessi Insufficienti.',
    'user_deleted_warning'      => 'Questo utente è stato eliminato. Si dovrà ripristinare questo utente per modificare o assegnare nuovi beni.',


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
        'accept_or_decline' => 'You must either accept or decline this asset.',
    ),

    'deletefile' => array(
        'error'   => 'File not deleted. Please try again.',
        'success' => 'File successfully deleted.',
    ),

    'upload' => array(
        'error'   => 'File(s) not uploaded. Please try again.',
        'success' => 'File(s) successfully uploaded.',
        'nofiles' => 'You did not select any files for upload',
        'invalidfiles' => 'One or more of your files is too large or is a filetype that is not allowed. Allowed filetypes are png, gif, jpg, doc, docx, pdf, and txt.',
    ),

);

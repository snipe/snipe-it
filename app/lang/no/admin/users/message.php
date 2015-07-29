<?php

return array(

    'accepted'                  => 'You have successfully accepted this asset.',
    'declined'                  => 'You have successfully declined this asset.',
    'user_exists'               => 'Bruker finnes allerede!',
    'user_not_found'            => 'Bruker [:id] finnes ikke.',
    'user_login_required'       => 'Login-feltet er påkrevd',
    'user_password_required'    => 'Passord er påkrevd.',
    'insufficient_permissions'  => 'Utilstrekkelige rettigheter.',
    'user_deleted_warning'      => 'Denne brukeren er slettet. Du vil må gjenopprette denne brukeren for å redigere, eller tildele nye eiendeler.',


    'success' => array(
        'create'    => 'Opprettelse av bruker vellykket.',
        'update'    => 'Oppdatering av bruker vellykket.',
        'delete'    => 'Sletting av bruker vellykket.',
        'ban'       => 'Vellykket forbud av bruker.',
        'unban'     => 'Forbud av bruker ble opphevet.',
        'suspend'   => 'Vellykket deaktivering av bruker.',
        'unsuspend' => 'Vellykket aktivering av bruker.',
        'restored'  => 'Vellykket gjenopprettelse av bruker.',
        'import'    => 'Vellykket import av brukere.',
    ),

    'error' => array(
        'create' => 'Det oppstod et problem under opprettelse av bruker. Prøv igjen.',
        'update' => 'Det oppstod et problem under oppdatering av bruker. Prøv igjen.',
        'delete' => 'Det oppstod et problem under sletting av bruker. Prøv igjen.',
        'unsuspend' => 'Det oppstod et problem under aktivering av bruker. Prøv igjen.',
        'import'    => 'Det oppstod et problem under import av brukere. Prøv igjen.',
        'asset_already_accepted' => 'Denne eiendelen er allerede akseptert.',
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

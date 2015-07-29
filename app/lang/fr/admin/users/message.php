<?php

return array(

    'accepted'                  => 'You have successfully accepted this asset.',
    'declined'                  => 'You have successfully declined this asset.',
    'user_exists'               => 'L\'utilisateur existe déjà !',
    'user_not_found'            => 'L\'utilisateur [:id] n\'existe pas.',
    'user_login_required'       => 'Le champ identifiant est obligatoire',
    'user_password_required'    => 'Le mot de passe est obligatoire.',
    'insufficient_permissions'  => 'Droits insuffisants.',
    'user_deleted_warning'      => 'Cet utilisateur a été supprimé. Vous devez le restaurer pour pouvoir l\'éditer ou lui assigner de nouveaux actifs.',


    'success' => array(
        'create'    => 'L’utilisateur a été créé avec succès.',
        'update'    => 'L’utilisateur a été mis à jour avec succès.',
        'delete'    => 'L’utilisateur a été supprimé avec succès.',
        'ban'       => 'L’utilisateur a été banni avec succès.',
        'unban'     => 'L’utilisateur a été réhabilité avec succès.',
        'suspend'   => 'L’utilisateur a été suspendu avec succès.',
        'unsuspend' => 'L’utilisateur a été activé avec succès.',
        'restored'  => 'L’utilisateur a été restauré avec succès.',
        'import'    => 'Users imported successfully.',
    ),

    'error' => array(
        'create' => 'Un problème a eu lieu pendant la création de l\'utilisateur. Veuillez essayer à nouveau.',
        'update' => 'Un problème a eu lieu pendant la mise à jour de l\'utilisateur. Veuillez essayer à nouveau.',
        'delete' => 'Un problème a eu lieu pendant la suppression de l\'utilisateur. Veuillez essayer à nouveau.',
        'unsuspend' => 'Un problème a eu lieu pendant la réhabilitation de l\'utilisateur. Veuillez essayer à nouveau.',
        'import'    => 'There was an issue importing users. Please try again.',
        'asset_already_accepted' => 'This asset has already been accepted.',
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

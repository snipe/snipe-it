<?php

return array(

    'accepted'                  => 'You have successfully accepted this asset.',
    'declined'                  => 'You have successfully declined this asset.',
    'user_exists'               => 'Użytkownik już istnieje!',
    'user_not_found'            => 'User [:id] nie istnieje.',
    'user_login_required'       => 'Pole login jest wymagane',
    'user_password_required'    => 'Pole hasło jest wymagane.',
    'insufficient_permissions'  => 'Brak uprawnień.',
    'user_deleted_warning'      => 'This user has been deleted. You will have to restore this user to edit them or assign them new assets.',


    'success' => array(
        'create'    => 'Użytkownik utworzony pomyślnie.',
        'update'    => 'Użytkownik zaktualizowany pomyślnie.',
        'delete'    => 'Użytkownik został usunięty pomyślnie.',
        'ban'       => 'Użytkownik został zablokowany.',
        'unban'     => 'Użytkownik został odblokowany.',
        'suspend'   => 'Konto użytkownika zostało wyłączone.',
        'unsuspend' => 'Konto użytkownika zostało włączone.',
        'restored'  => 'Użytkownik został przywrócony pomyślnie.',
        'import'    => 'Import użytkowników zakończony sukcesem.',
    ),

    'error' => array(
        'create' => 'Podczas tworzenia użytkownika wystąpił problem. Spróbuj ponownie.',
        'update' => 'Podczas aktualizacji użytkownika wystąpił problem. Spróbuj ponownie.',
        'delete' => 'Wystąpił błąd podczas usuwania użytkownika. Spróbuj ponownie.',
        'unsuspend' => 'There was an issue unsuspending the user. Please try again.',
        'import'    => 'Podczas importowania użytkowników wystąpił błąd. Spróbuj ponownie.',
        'asset_already_accepted' => 'This asset has already been accepted.',
        'accept_or_decline' => 'You must either accept or decline this asset.',
    ),

    'deletefile' => array(
        'error'   => 'Pliki nie zostały usunięte. Spróbuj ponownie.',
        'success' => 'Pliki zostały usunięte.',
    ),

    'upload' => array(
        'error'   => 'Plik(i) nie zostały wysłane. Spróbuj ponownie.',
        'success' => 'Plik(i) zostały wysłane poprawnie.',
        'nofiles' => 'Nie wybrałeś żadnych plików do wysłania',
        'invalidfiles' => 'One or more of your files is too large or is a filetype that is not allowed. Allowed filetypes are png, gif, jpg, doc, docx, pdf, and txt.',
    ),

);

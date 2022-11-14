<?php

return array(

    'does_not_exist' => 'License does not exist or you do not have permission to view it.',
    'user_does_not_exist' => 'Användare finns inte.',
    'asset_does_not_exist' 	=> 'Den tillgång du försöker associera med denna licens existerar inte.',
    'owner_doesnt_match_asset' => 'Den tillgång du försöker associera med denna licens ägs av någon annan än den person som valts i den tilldelade till rullgardinsmenyn.',
    'assoc_users'	 => 'Licensen är nu utcheckad till en användare och kan inte raderas. Var god kontrollera licensen först och försök sedan radera igen.',
    'select_asset_or_person' => 'Du måste välja en tillgång eller en användare, men inte båda.',
    'not_found' => 'Licensen hittades inte',


    'create' => array(
        'error'   => 'Licensen skapades inte, försök igen.',
        'success' => 'Licensen skapades framgångsrikt.'
    ),

    'deletefile' => array(
        'error'   => 'Filen har inte tagits bort. Var god försök igen.',
        'success' => 'Filen har tagits bort.',
    ),

    'upload' => array(
        'error'   => 'Fil (er) inte uppladdade. Var god försök igen.',
        'success' => 'Filer som har laddats upp.',
        'nofiles' => 'Du valde inte några filer för uppladdning, eller filen du försöker ladda upp är för stor',
        'invalidfiles' => 'En eller flera av dina filer är för stora eller är en filtyp som inte är tillåten. Tillåtna filtyper är png, gif, jpg, jpeg, doc, docx, pdf, txt, zip, rar, rtf, xml och lic.',
    ),

    'update' => array(
        'error'   => 'Licensen uppdaterades inte, var god försök igen',
        'success' => 'Licensen uppdateras framgångsrikt.'
    ),

    'delete' => array(
        'confirm'   => 'Är du säker på att du vill radera denna licens?',
        'error'   => 'Det gick inte att ta bort licensen. Var god försök igen.',
        'success' => 'Licensen har tagits bort.'
    ),

    'checkout' => array(
        'error'   => 'Det gick inte att kontrollera licensen. Var god försök igen.',
        'success' => 'Licensen utcheckades framgångsrikt'
    ),

    'checkin' => array(
        'error'   => 'Det gick inte att kontrollera licensen. Var god försök igen.',
        'success' => 'Licensen incheckades med framgång'
    ),

);

<?php

return [

    'undeployable' 		=> '<strong>Waarskuwing: </strong> Hierdie bate is gemerk as tans onbruikbaar. As hierdie status verander het, verander asseblief die batestatus.',
    'does_not_exist' 	=> 'Bate bestaan ​​nie.',
    'does_not_exist_or_not_requestable' => 'That asset does not exist or is not requestable.',
    'assoc_users'	 	=> 'Hierdie bate word tans na \'n gebruiker nagegaan en kan nie uitgevee word nie. Gaan asseblief die bate eers in, en probeer dan weer uitvee.',

    'create' => [
        'error'   		=> 'Bate is nie geskep nie, probeer asseblief weer. :(',
        'success' 		=> 'Bate geskep suksesvol. :)',
    ],

    'update' => [
        'error'   			=> 'Bate is nie opgedateer nie, probeer asseblief weer',
        'success' 			=> 'Bate is suksesvol opgedateer.',
        'nothing_updated'	=>  'Geen velde is gekies nie, dus niks is opgedateer nie.',
        'no_assets_selected'  =>  'No assets were selected, so nothing was updated.',
    ],

    'restore' => [
        'error'   		=> 'Bate is nie herstel nie, probeer asseblief weer',
        'success' 		=> 'Bate herstel suksesvol.',
    ],

    'audit' => [
        'error'   		=> 'Bate-oudit was onsuksesvol. Probeer asseblief weer.',
        'success' 		=> 'Bate oudit suksesvol aangemeld.',
    ],


    'deletefile' => [
        'error'   => 'Lêer nie verwyder nie. Probeer asseblief weer.',
        'success' => 'Lêer suksesvol uitgevee.',
    ],

    'upload' => [
        'error'   => 'Lêer (s) nie opgelaai nie. Probeer asseblief weer.',
        'success' => 'Lêer (s) suksesvol opgelaai.',
        'nofiles' => 'Jy het nie enige lêers vir oplaai gekies nie, of die lêer wat jy probeer oplaai is te groot',
        'invalidfiles' => 'Een of meer van jou lêers is te groot of is \'n filetipe wat nie toegelaat word nie. Toegelate filetipes is png, gif, jpg, doc, docx, pdf en txt.',
    ],

    'import' => [
        'error'                 => 'Sommige items is nie korrek ingevoer nie.',
        'errorDetail'           => 'Die volgende items is nie ingevoer as gevolg van foute nie.',
        'success'               => 'Jou lêer is ingevoer',
        'file_delete_success'   => 'Jou lêer is suksesvol verwyder',
        'file_delete_error'      => 'Die lêer kon nie uitgevee word nie',
    ],


    'delete' => [
        'confirm'   	=> 'Is jy seker jy wil hierdie bate uitvee?',
        'error'   		=> 'Daar was \'n probleem met die verwydering van die bate. Probeer asseblief weer.',
        'nothing_updated'   => 'Geen bates is gekies nie, so niks is verwyder nie.',
        'success' 		=> 'Die bate is suksesvol verwyder.',
    ],

    'checkout' => [
        'error'   		=> 'Bate is nie nagegaan nie, probeer asseblief weer',
        'success' 		=> 'Die bate is suksesvol nagegaan.',
        'user_does_not_exist' => 'Die gebruiker is ongeldig. Probeer asseblief weer.',
        'not_available' => 'Die bate is nie beskikbaar vir die kassa nie!',
        'no_assets_selected' => 'You must select at least one asset from the list',
    ],

    'checkin' => [
        'error'   		=> 'Bate is nie nagegaan nie, probeer asseblief weer',
        'success' 		=> 'Die bate is suksesvol nagegaan.',
        'user_does_not_exist' => 'Die gebruiker is ongeldig. Probeer asseblief weer.',
        'already_checked_in'  => 'Daardie bate is reeds nagegaan.',

    ],

    'requests' => [
        'error'   		=> 'Bate is nie aangevra nie, probeer asseblief weer',
        'success' 		=> 'Die bate is suksesvol aangevra.',
        'canceled'      => 'Afhandeling versoek suksesvol gekanselleer',
    ],

];

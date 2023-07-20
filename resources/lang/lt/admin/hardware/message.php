<?php

return [

    'undeployable' 		=> '<strong>Dėmesio: </strong> Ši įranga pažymėta kaip negalima naudoti. Jei būklė  pasikeitė, prašome atnaujinti įrangos būklę.',
    'does_not_exist' 	=> 'Tokios įrangos nėra.',
    'does_not_exist_or_not_requestable' => 'That asset does not exist or is not requestable.',
    'assoc_users'	 	=> 'Ši įranga šiuo metu yra išduota naudotojui ir negali būti ištrinta. Prašome pirmiausia patikrinkite įrangą, tuomet bandykite ištrinti vėl. ',

    'create' => [
        'error'   		=> 'Įrangos sukurti nepavyko, prašome bandykite dar kartą. :(',
        'success' 		=> 'Įranga sėkminga sukurta. :)',
    ],

    'update' => [
        'error'   			=> 'Įrangos atnaujinti nepavyko, prašome bandykite dar kartą',
        'success' 			=> 'Įranga sėkmingai atnaujinta.',
        'nothing_updated'	=>  'Nei vienas laukelis nepasirinktas, tad niekas nebuvo atnaujinta.',
        'no_assets_selected'  =>  'No assets were selected, so nothing was updated.',
    ],

    'restore' => [
        'error'   		=> 'Įranga nebuvo atkurta, prašome bandykite dar kartą',
        'success' 		=> 'Įranga atkurta sėkmingai.',
        'bulk_success' 		=> 'Asset restored successfully.',
        'nothing_updated'   => 'No assets were selected, so nothing was restored.', 
    ],

    'audit' => [
        'error'   		=> 'Turto auditas buvo nesėkmingas. Prašau, pabandykite dar kartą.',
        'success' 		=> 'Turto auditas sėkmingai registruotas.',
    ],


    'deletefile' => [
        'error'   => 'Failas neištrintas. Prašome bandykite dar kartą.',
        'success' => 'Failas sėkmingai ištrintas.',
    ],

    'upload' => [
        'error'   => 'Failas (-ai) neįkelti. Prašome bandykite dar kartą.',
        'success' => 'Failas (-ai) sėkmingai įkelti.',
        'nofiles' => 'Jūs nepasirinkote nė vieno failo įkėlimui arba failai, kuriuos ketinate įkelti yra per dideli',
        'invalidfiles' => 'Vienas ar keli failai yra per didelis arba neleidžiamas šis failų formatas. primename, kad leidžiami sekantys formatai png, gif, jpg, doc, docx, pdf, txt.',
    ],

    'import' => [
        'error'                 => 'Nepavyko teisingai importuoti kai kurių įrašų.',
        'errorDetail'           => 'Šie elementai nebuvo importuoti dėl klaidų.',
        'success'               => 'Jūsų failas importuotas',
        'file_delete_success'   => 'Jūsų failas buvo sėkmingai ištrintas',
        'file_delete_error'      => 'Nepavyko ištrinti failo',
        'header_row_has_malformed_characters' => 'One or more attributes in the header row contain malformed UTF-8 characters',
        'content_row_has_malformed_characters' => 'One or more attributes in the first row of content contain malformed UTF-8 characters',
    ],


    'delete' => [
        'confirm'   	=> 'Ar jūs tikrai norite ištrinti šią įrangą?',
        'error'   		=> 'Nepavyko ištrinti įrangos. Prašome bandykite dar kartą.',
        'nothing_updated'   => 'Nebuvo pasirinkta jokio turto, taigi niekas nebuvo ištrintas.',
        'success' 		=> 'Įranga sėkmingai ištrinta.',
    ],

    'checkout' => [
        'error'   		=> 'Įranga neišduota, prašome bandyti dar kartą',
        'success' 		=> 'Įranga išduota sėkmingai.',
        'user_does_not_exist' => 'Netinkamas naudotojas. Prašome bandykite dar kartą.',
        'not_available' => 'Šis turtas negali būti išsiunčiamas!',
        'no_assets_selected' => 'Jūs turite pasirinkti bent vieną turtą iš sąrašo',
    ],

    'checkin' => [
        'error'   		=> 'Įranga neišduota, prašome bandyti dar kartą',
        'success' 		=> 'Įranga išduota sėkmingai.',
        'user_does_not_exist' => 'Šis naudotojas neteisingas. Prašome bandykite dar kartą.',
        'already_checked_in'  => 'Šis turtas jau yra registruotas.',

    ],

    'requests' => [
        'error'   		=> 'Įranga nebuvo užklausta, prašome bandyti dar kartą',
        'success' 		=> 'Įrangos užklausa sėkmingai išsiusta.',
        'canceled'      => 'Patikros užklausa sėkmingai atšaukta',
    ],

];

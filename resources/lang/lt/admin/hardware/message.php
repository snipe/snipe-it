<?php

return array(

    'undeployable' 		=> '<strong>Dėmesio: </strong> Ši įranga pažymėta kaip negalima naudoti. Jei būklė  pasikeitė, prašome atnaujinti įrangos būklę.',
    'does_not_exist' 	=> 'Tokios įrangos nėra.',
    'does_not_exist_or_not_requestable' => 'Tokios įrangos nėra arba jos negalima užklausti.',
    'assoc_users'	 	=> 'Ši įranga šiuo metu yra išduota naudotojui ir negali būti ištrinta. Prašome pirmiausia patikrinkite įrangą, tuomet bandykite ištrinti vėl. ',

    'create' => array(
        'error'   		=> 'Įrangos sukurti nepavyko, prašome bandykite dar kartą. :(',
        'success' 		=> 'Įranga sėkminga sukurta. :)'
    ),

    'update' => array(
        'error'   			=> 'Įrangos atnaujinti nepavyko, prašome bandykite dar kartą',
        'success' 			=> 'Įranga sėkmingai atnaujinta.',
        'nothing_updated'	=>  'Nei vienas laukelis nepasirinktas, tad niekas nebuvo atnaujinta.',
    ),

    'restore' => array(
        'error'   		=> 'Įranga nebuvo atkurta, prašome bandykite dar kartą',
        'success' 		=> 'Įranga atkurta sėkmingai.'
    ),

    'deletefile' => array(
        'error'   => 'Failas neištrintas. Prašome bandykite dar kartą.',
        'success' => 'Failas sėkmingai ištrintas.',
    ),

    'upload' => array(
        'error'   => 'Failas (-ai) neįkelti. Prašome bandykite dar kartą.',
        'success' => 'Failas (-ai) sėkmingai įkelti.',
        'nofiles' => 'Jūs nepasirinkote nė vieno failo įkėlimui arba failai, kuriuos ketinate įkelti yra per dideli',
        'invalidfiles' => 'Vienas ar keli failai yra per didelis arba neleidžiamas šis failų formatas. primename, kad leidžiami sekantys formatai png, gif, jpg, doc, docx, pdf, txt.',
    ),

    'import' => array(
        'error'                 => 'Nepavyko teisingai importuoti kai kurių įrašų.',
        'errorDetail'           => 'The following Items were not imported because of errors.',
        'success'               => "Jūsų failas importuotas",
        'file_delete_success'   => "Your file has been been successfully deleted",
        'file_delete_error'      => "Nepavyko ištrinti failo",
    ),


    'delete' => array(
        'confirm'   	=> 'Ar jūs tikrai norite ištrinti šią įrangą?',
        'error'   		=> 'Nepavyko ištrinti įrangos. Prašome bandykite dar kartą.',
        'success' 		=> 'Įranga sėkmingai ištrinta.'
    ),

    'checkout' => array(
        'error'   		=> 'Įranga neišduota, prašome bandyti dar kartą',
        'success' 		=> 'Įranga išduota sėkmingai.',
        'user_does_not_exist' => 'Netinkamas naudotojas. Prašome bandykite dar kartą.',
        'not_available' => 'That asset is not available for checkout!'
    ),

    'checkin' => array(
        'error'   		=> 'Įranga neišduota, prašome bandyti dar kartą',
        'success' 		=> 'Įranga išduota sėkmingai.',
        'user_does_not_exist' => 'Šis naudotojas neteisingas. Prašome bandykite dar kartą.',
        'already_checked_in'  => 'That asset is already checked in.',

    ),

    'requests' => array(
        'error'   		=> 'Įranga nebuvo užklausta, prašome bandyti dar kartą',
        'success' 		=> 'Įrangos užklausa sėkmingai išsiusta.',
        'canceled'      => 'Checkout request successfully canceled'
    )

);

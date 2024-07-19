<?php

return [

    'undeployable' 		=> '<strong>Warning: </strong> This asset has been marked as currently undeployable. If this status has changed, please update the asset status.',
    'does_not_exist' 	=> 'Tokios įrangos nėra.',
    'does_not_exist_var'=> 'Įranga su numeriu :asset_tag nerasta.',
    'no_tag' 	        => 'Nenurodytas inventorinis numeris.',
    'does_not_exist_or_not_requestable' => 'Tokios įrangos nėra arba jos negalima užsakyti.',
    'assoc_users'	 	=> 'Ši įranga šiuo metu yra išduota naudotojui ir negali būti panaikinta. Pirmiausia paimkite įrangą ir tuomet vėl bandykite panaikinti. ',
    'warning_audit_date_mismatch' 	=> 'Šios įrangos kito audito data (:next_audit_date) yra ankstesnė už paskutinio audito datą (:last_audit_date). Atnaujinkite kito audito datą.',

    'create' => [
        'error'   		=> 'Įrangos sukurti nepavyko, bandykite dar kartą.',
        'success' 		=> 'Įranga sukurta sėkmingai.',
        'success_linked' => 'Įranga su žyma :tag sukurta sėkmingai. <strong><a href=":link" style="color: white;">Spustelėkite čia, kad peržiūrėtumėte</a></strong>.',
    ],

    'update' => [
        'error'   			=> 'Įrangos atnaujinti nepavyko, bandykite dar kartą',
        'success' 			=> 'Įranga atnaujinta sėkmingai.',
        'encrypted_warning' => 'Įranga buvo atnaujinta sėkmingai, tačiau dėl trūkstamų teisių, užšifruoti pasirinktiniai laukai nebuvo atnaujinti',
        'nothing_updated'	=>  'Nebuvo pasirinktas nei vienas laukas, todėl niekas nebuvo atnaujinta.',
        'no_assets_selected'  =>  'Nebuvo pasirinkta jokia įranga, todėl nieko nebuvo atnaujinta.',
        'assets_do_not_exist_or_are_invalid' => 'Pasirinkta įranga negali būti atnaujinta.',
    ],

    'restore' => [
        'error'   		=> 'Įrangos atkurti nepavyko, bandykite dar kartą',
        'success' 		=> 'Įranga atkurta sėkmingai.',
        'bulk_success' 		=> 'Įranga atkurta sėkmingai.',
        'nothing_updated'   => 'Nebuvo pasirinkta jokia įranga, todėl nieko nebuvo atkurta.', 
    ],

    'audit' => [
        'error'   		=> 'Įrangos auditas nesėkmingas: :error ',
        'success' 		=> 'Turto auditas sėkmingai užregistruotas.',
    ],


    'deletefile' => [
        'error'   => 'Failas neištrintas. Bandykite dar kartą.',
        'success' => 'Failas sėkmingai ištrintas.',
    ],

    'upload' => [
        'error'   => 'Failo (-ų) įkelti nepavyko. Bandykite dar kartą.',
        'success' => 'Failas (-ai) įkelti sėkmingai.',
        'nofiles' => 'Nepasirinkote jokio failo įkėlimui arba failas, kurį bandote įkelti, yra per didelis',
        'invalidfiles' => 'Vienas ar keli failai yra per dideli arba neleistinas šis failų formatas. Leidžiami failų tipai yra: png, gif, jpg, doc, docx, pdf ir txt.',
    ],

    'import' => [
        'import_button'         => 'Process Import',
        'error'                 => 'Kai kurie elementai nebuvo tinkamai importuoti.',
        'errorDetail'           => 'Šie elementai nebuvo importuoti dėl klaidų.',
        'success'               => 'Jūsų failas buvo importuotas',
        'file_delete_success'   => 'Jūsų failas buvo sėkmingai ištrintas',
        'file_delete_error'      => 'Šio failo ištrinti nepavyko',
        'file_missing' => 'Pažymėtas failas nerastas',
        'header_row_has_malformed_characters' => 'Vienas ar keli antraštinės eilutės atributai turi netinkamai suformuotų UTF-8 simbolių',
        'content_row_has_malformed_characters' => 'Vienas ar keli pirmosios eilutės atributai turi netinkamai suformuotų UTF-8 simbolių',
    ],


    'delete' => [
        'confirm'   	=> 'Ar tikrai norite panaikinti šią įrangą?',
        'error'   		=> 'Bandant panaikinti įrangą įvyko klaida. Bandykite dar kartą.',
        'nothing_updated'   => 'Nebuvo pasirinkta jokia įranga, todėl nieko nebuvo panaikinta.',
        'success' 		=> 'Įranga sėkmingai panaikinta.',
    ],

    'checkout' => [
        'error'   		=> 'Įranga nebuvo išduota, bandykite dar kartą',
        'success' 		=> 'Įranga išduota sėkmingai.',
        'user_does_not_exist' => 'Neteisingas naudotojas. Bandykite dar kartą.',
        'not_available' => 'Ši įranga negali būti išduodama!',
        'no_assets_selected' => 'Turite pasirinkti bent vieną įrangą iš sąrašo',
    ],

    'checkin' => [
        'error'   		=> 'Įranga nebuvo paimta, bandykite dar kartą',
        'success' 		=> 'Įranga paimta sėkmingai.',
        'user_does_not_exist' => 'Neteisingas naudotojas. Bandykite dar kartą.',
        'already_checked_in'  => 'Ši įranga jau yra paimta.',

    ],

    'requests' => [
        'error'   		=> 'Įranga nebuvo užsakyta, bandykite dar kartą',
        'success' 		=> 'Įranga užsakyta sėkmingai.',
        'canceled'      => 'Išdavimo prašymas sėkmingai atšauktas',
    ],

];

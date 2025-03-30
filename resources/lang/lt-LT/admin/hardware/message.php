<?php

return [

    'undeployable' 		 => '<strong>Įspėjimas:</strong> Šis turtas pažymėtas kaip negalimas išduoti. Jei šio turto būsena pasikeitė, atnaujinkite būsenos žymą.',
    'does_not_exist' 	 => 'Tokio turto nėra.',
    'does_not_exist_var' => 'Turtas su numeriu :asset_tag nerastas.',
    'no_tag' 	         => 'Nenurodytas inventorinis numeris.',
    'does_not_exist_or_not_requestable' => 'Tokio turto nėra arba jo negalima užsakyti.',
    'assoc_users'	 	 => 'Šis turtas šiuo metu yra išduotas naudotojui ir negali būti panaikintas. Pirmiausia paimkite turtą ir tuomet vėl bandykite jį panaikinti. ',
    'warning_audit_date_mismatch' 	=> 'Šio turto kito audito data (:next_audit_date) yra ankstesnė už paskutinio audito datą (:last_audit_date). Atnaujinkite kito audito datą.',
    'labels_generated'   => 'Etiketės sugeneruotos sėkmingai.',
    'error_generating_labels' => 'Generuojant etiketes įvyko klaida.',
    'no_assets_selected' => 'Nepasirinktas joks turtas.',

    'create' => [
        'error'   		=> 'Turto sukurti nepavyko, bandykite dar kartą.',
        'success' 		=> 'Turtas sukurtas sėkmingai.',
        'success_linked' => 'Turtas su žyma :tag sukurtas sėkmingai. <strong><a href=":link" style="color: white;">Spustelėkite čia, kad peržiūrėtumėte</a></strong>.',
        'multi_success_linked' => 'Turtas su inventoriniu numeriu :links sukurtas sėkmingai.|:count turto vienetai(-ų) sukurti sėkmingai. :links.',
        'partial_failure' => 'Nepavyko sukurti turto. Priežastis: :failures|:count turto vienetų nepavyko sukurti. Priežastys: :failures',
    ],

    'update' => [
        'error'   			=> 'Turto atnaujinti nepavyko, bandykite dar kartą',
        'success' 			=> 'Turtas atnaujintas sėkmingai.',
        'encrypted_warning' => 'Turtas buvo atnaujintas sėkmingai, tačiau dėl nepakankamų teisių, užšifruoti pasirinktiniai laukai nebuvo atnaujinti',
        'nothing_updated'	=>  'Nebuvo pasirinktas nei vienas laukas, todėl niekas nebuvo atnaujinta.',
        'no_assets_selected'  =>  'Nebuvo pasirinkta jokio turto, todėl nieko nebuvo atnaujinta.',
        'assets_do_not_exist_or_are_invalid' => 'Pasirinktas turtas negali būti atnaujintas.',
    ],

    'restore' => [
        'error'   		=> 'Turto atkurti nepavyko, bandykite dar kartą',
        'success' 		=> 'Turtas atkurtas sėkmingai.',
        'bulk_success' 		=> 'Turtas atkurtas sėkmingai.',
        'nothing_updated'   => 'Nebuvo pasirinkta jokio turto, todėl nieko nebuvo atkurta.', 
    ],

    'audit' => [
        'error'   		=> 'Turto auditas nesėkmingas: :error ',
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
        'import_button'         => 'Vykdyti importavimą',
        'error'                 => 'Kai kurie elementai nebuvo tinkamai importuoti.',
        'errorDetail'           => 'Šie elementai nebuvo importuoti dėl klaidų.',
        'success'               => 'Jūsų failas buvo importuotas',
        'file_delete_success'   => 'Jūsų failas buvo sėkmingai ištrintas',
        'file_delete_error'      => 'Šio failo ištrinti nepavyko',
        'file_missing' => 'Pažymėtas failas nerastas',
        'file_already_deleted' => 'Pasirinktas failas jau buvo panaikintas',
        'header_row_has_malformed_characters' => 'Vienas ar keli antraštinės eilutės atributai turi netinkamai suformuotų UTF-8 simbolių',
        'content_row_has_malformed_characters' => 'Vienas ar keli pirmosios eilutės atributai turi netinkamai suformuotų UTF-8 simbolių',
    ],


    'delete' => [
        'confirm'   	=> 'Ar tikrai norite panaikinti šį turtą?',
        'error'   		=> 'Bandant panaikinti turtą įvyko klaida. Bandykite dar kartą.',
        'assigned_to_error' => '{1}Asset Tag: :asset_tag is currently checked out. Check in this device before deletion.|[2,*]Asset Tags: :asset_tag are currently checked out. Check in these devices before deletion.',
        'nothing_updated'   => 'Nebuvo pasirinkta jokio turto, todėl nieko nebuvo panaikinta.',
        'success' 		=> 'Turtas sėkmingai panaikintas.',
    ],

    'checkout' => [
        'error'   		=> 'Turtas nebuvo išduotas, bandykite dar kartą',
        'success' 		=> 'Turtas išduotas sėkmingai.',
        'user_does_not_exist' => 'Neteisingas naudotojas. Bandykite dar kartą.',
        'not_available' => 'Šis turtas negali būti išduodamas!',
        'no_assets_selected' => 'Turite pasirinkti bent vieną turto vienetą iš sąrašo',
    ],

    'multi-checkout' => [
        'error'   => 'Turtas nebuvo išduotas, bandykite dar kartą|Turtas nebuvo išduotas, bandykite dar kartą',
        'success' => 'Turtas išduotas sėkmingai.|Turtas išduotas sėkmingai.',
    ],

    'checkin' => [
        'error'   		=> 'Turtas nebuvo paimtas, bandykite dar kartą',
        'success' 		=> 'Turtas paimtas sėkmingai.',
        'user_does_not_exist' => 'Neteisingas naudotojas. Bandykite dar kartą.',
        'already_checked_in'  => 'Šis turtas jau yra paimtas.',

    ],

    'requests' => [
        'error'   		=> 'Turtas nebuvo užsakytas, bandykite dar kartą',
        'success' 		=> 'Turtas užsakytas sėkmingai.',
        'canceled'      => 'Išdavimo prašymas sėkmingai atšauktas',
    ],

];

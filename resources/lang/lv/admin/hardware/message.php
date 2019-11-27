<?php

return array(

    'undeployable' 		=> '<strong>Brīdinājums: </strong> Šis aktīvs ir atzīmēts kā pašlaik neizvietojams. Ja šis statuss ir mainījies, lūdzu, atjauniniet aktīva statusu.',
    'does_not_exist' 	=> 'Aktīvs neeksistē.',
    'does_not_exist_or_not_requestable' => 'Labs mēģinājums. Šis aktīvs neeksistē vai nav pieprasāms.',
    'assoc_users'	 	=> 'Šobrīd šis aktīvs ir izsniegts lietotājam un to nevar izdzēst. Vispirms pārbaudiet aktīvu, un pēc tam mēģiniet izdzēst vēlreiz.',

    'create' => array(
        'error'   		=> 'Neizdevās izveidot aktīvu, lūdzu, mēģiniet vēlreiz. :(',
        'success' 		=> 'Aktīvs tika veiksmīgi izveidots. :)'
    ),

    'update' => array(
        'error'   			=> 'Neizdevās atjaunināt aktīvu, lūdzu, mēģiniet vēlreiz',
        'success' 			=> 'Aktīvs tika veiksmīgi atjaunināts.',
        'nothing_updated'	=>  'Netika atlasīts neviens lauks, tāpēc nekas netika atjaunināts.',
    ),

    'restore' => array(
        'error'   		=> 'Neizdevās atjaunot aktīvu, lūdzu, mēģiniet vēlreiz',
        'success' 		=> 'Aktīvs tika veiksmīgi atjaunots.'
    ),

    'audit' => array(
        'error'   		=> 'Neizdevās veikt aktīva auditu. Lūdzu, mēģiniet vēlreiz.',
        'success' 		=> 'Aktīva audits tika veiksmīgi reģistrēts.'
    ),


    'deletefile' => array(
        'error'   => 'Neizdevās izdzēst datni. Lūdzu, mēģiniet vēlreiz.',
        'success' => 'Datne tika veiksmīgi izdzēsta.',
    ),

    'upload' => array(
        'error'   => 'Neizdevās augšupielādēt datni(-es). Lūdzu, mēģiniet vēlreiz.',
        'success' => 'Datne(s) tika veiksmīgi augšupielādēta(s).',
        'nofiles' => 'Jūs neesat atlasījis augšupielādējamās datnes, vai arī datne, kuru mēģināt augšupielādēt, ir pārāk liela',
        'invalidfiles' => 'Viena vai vairākas jūsu datnes ir pārāk lielas vai neatļauts faila tips. Atļautie failu tipi ir png, gif, jpg, doc, docx, pdf un txt.',
    ),

    'import' => array(
        'error'                 => 'Dažas vienības netika pareizi importētas.',
        'errorDetail'           => 'Kļūdu dēļ tālāk minētās vienības netika importētas.',
        'success'               => "Jūsu datne tika veiksmīgi importēta",
        'file_delete_success'   => "Jūsu datne tika veiksmīgi izdzēsta",
        'file_delete_error'      => "Neizdevās izdzēst datni",
    ),


    'delete' => array(
        'confirm'   	=> 'Vai tiešām vēlaties izdzēst šo aktīvu?',
        'error'   		=> 'Radās problēma, idzēšot aktīvu. Lūdzu, mēģiniet vēlreiz.',
        'nothing_updated'   => 'Netika atlasīts neviens aktīvs, tāpēc nekas netika izdzēsts.',
        'success' 		=> 'Aktīvs tika veiksmīgi izdzēsts.'
    ),

    'checkout' => array(
        'error'   		=> 'Neizdevās izsniegt aktīvu, lūdzu, mēģiniet vēlreiz',
        'success' 		=> 'Aktīvs tika izsniegts veiksmīgi.',
        'user_does_not_exist' => 'Šis lietotājs ir nederīgs. Lūdzu, mēģiniet vēlreiz.',
        'not_available' => 'Šis aktīvs nav pieejams izsniegšanai!',
        'no_assets_selected' => 'Jums jāizvēlas no saraksta vismaz viens aktīvs'
    ),

    'checkin' => array(
        'error'   		=> 'Neizdevās atgriezt aktīvu, lūdzu, mēģiniet vēlreiz',
        'success' 		=> 'Aktīvs tika atgriezts veiksmīgi.',
        'user_does_not_exist' => 'Šis lietotājs ir nederīgs. Lūdzu, mēģiniet vēlreiz.',
        'already_checked_in'  => 'Šis aktīvs jau ir atgriezts.',

    ),

    'requests' => array(
        'error'   		=> 'Neizdevās pieprasīt aktīvu, lūdzu, mēģiniet vēlreiz',
        'success' 		=> 'Aktīvs tika veiksmīgi pieprasīts.',
        'canceled'      => 'Izsniegšanas pieprasījums tika veiksmīgi atcelts'
    )

);

<?php

return array(

    'accepted'                  => 'Jūs esat veiksmīgi akceptējis šo aktīvu.',
    'declined'                  => 'Jūs esat veiksmīgi noraidījis šo aktīvu.',
    'bulk_manager_warn'	        => 'Jūsu lietotāji ir veiksmīgi atjaunināti, tomēr jūsu vadītāja ieraksts netika saglabāts, jo atlasītais vadītījs arī bija rediģējamo lietotāju sarakstā, un lietotāji nevar paši sevi pārvaldīt. Lūdzu, vēlreiz atlasiet lietotājus, neiekļaujot pārvaldnieku.',
    'user_exists'               => 'Lietotājs jau eksistē!',
    'user_not_found'            => 'Lietotājs [:id] nepastāv.',
    'user_login_required'       => 'Nepieciešams lietotājvādra lauks',
    'user_password_required'    => 'Nepieciešama parole.',
    'insufficient_permissions'  => 'Nepietiekamas atļaujas.',
    'user_deleted_warning'      => 'Šis lietotājs ir izdzēsts. Jums šis lietotājs ir jāatjauno, lai to rediģētu vai piešķirtu tam jaunus aktīvus.',
    'ldap_not_configured'        => 'Šai instalācijai nav konfigurēta LDAP integrācija.',


    'success' => array(
        'create'    => 'Lietotājs tika veiksmīgi izveidots.',
        'update'    => 'Lietotājs tika veiksmīgi atjaunināts.',
        'update_bulk'    => 'Lietotāji tika veiksmīgi atjaunināti!',
        'delete'    => 'Lietotājs tika veiksmīgi izdzēsts.',
        'ban'       => 'Lietotājs tika veiksmīgi aizliegts.',
        'unban'     => 'Lietotājs tika veiksmīgi aizliegts.',
        'suspend'   => 'Lietotājs tika veiksmīgi apturēts.',
        'unsuspend' => 'Lietotājs tika veiksmīgi atcelts.',
        'restored'  => 'Lietotājs tika veiksmīgi atjaunots.',
        'import'    => 'Lietotāji veiksmīgi importēti.',
    ),

    'error' => array(
        'create' => 'Radās problēma, izveidojot lietotāju. Lūdzu, mēģiniet vēlreiz.',
        'update' => 'Radās problēma, atjauninot lietotāju. Lūdzu, mēģiniet vēlreiz.',
        'delete' => 'Radās problēma, izdzēšot lietotāju. Lūdzu, mēģiniet vēlreiz.',
        'delete_has_assets' => 'Šim lietotājam ir piešķirtas vienības, un to nevar izdzēst.',
        'unsuspend' => 'Radās problēma, apturot lietotāju. Lūdzu, mēģiniet vēlreiz.',
        'import'    => 'Radās problēma, importējot lietotājus. Lūdzu, mēģiniet vēlreiz.',
        'asset_already_accepted' => 'Šis aktīvs jau ir pieņemts.',
        'accept_or_decline' => 'Jums ir vai nu jāpieņem vai jāatsakās no šī aktīva.',
        'incorrect_user_accepted' => 'Aktīvs, kuru jūs mēģinājāt pieņemt, netika izrakstīts uz jums.',
        'ldap_could_not_connect' => 'Nevarēja izveidot savienojumu ar LDAP serveri. Lūdzu, pārbaudiet LDAP servera konfigurāciju LDAP konfigurācijas failā. <br>Kļūda no LDAP servera:',
        'ldap_could_not_bind' => 'Nevarēja piesaistīties LDAP serverim. Lūdzu, pārbaudiet LDAP servera konfigurāciju LDAP konfigurācijas failā. <br>Kļūda no LDAP servera: ',
        'ldap_could_not_search' => 'Nevarēja atrast LDAP serveri. Lūdzu, pārbaudiet LDAP servera konfigurāciju LDAP konfigurācijas failā. <br>Kļūda no LDAP servera:',
        'ldap_could_not_get_entries' => 'Nevarēja iegūt ierakstus no LDAP servera. Lūdzu, pārbaudiet LDAP servera konfigurāciju LDAP konfigurācijas failā. <br>Kļūda no LDAP servera:',
        'password_ldap' => 'Šī konta paroli pārvalda LDAP / Active Directory. Lai mainītu savu paroli, lūdzu, sazinieties ar IT nodaļu.',
    ),

    'deletefile' => array(
        'error'   => 'Neizdevās izdzēst datni. Lūdzu, mēģiniet vēlreiz.',
        'success' => 'Datne tika veiksmīgi dzēsta.',
    ),

    'upload' => array(
        'error'   => 'Neizdevās augšupielādēt datni(-es). Lūdzu, mēģiniet vēlreiz.',
        'success' => 'Datne(-s) tika veiksmīgi augšupielādēta(-s).',
        'nofiles' => 'Jūs neesat atlasījis nevienu augšupielādes datni',
        'invalidfiles' => 'Viena vai vairākas datnes ir pārāk lielas vai arī tās nav atļautas. Atļautie failu tipi ir png, gif, jpg, doc, docx, pdf un txt.',
    ),

);

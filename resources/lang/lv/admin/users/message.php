<?php

return array(

    'accepted'                  => 'Jūs esat veiksmīgi pieņēmuši šo aktīvu.',
    'declined'                  => 'Jūs esat veiksmīgi atteicies no šī īpašuma.',
    'bulk_manager_warn'	        => 'Jūsu lietotāji ir veiksmīgi atjaunināti, taču jūsu pārvaldnieka ieraksts netika saglabāts, jo izvēlētā pārvaldnieks bija arī rediģējamo lietotāju sarakstā, un lietotāji, iespējams, nav viņu īpašnieks. Lūdzu, vēlreiz atlasiet savus lietotājus, izņemot pārvaldnieku.',
    'user_exists'               => 'Lietotājs jau eksistē!',
    'user_not_found'            => 'Lietotājs [: id] nepastāv.',
    'user_login_required'       => 'Ievades lauks ir nepieciešams',
    'user_password_required'    => 'Parole ir nepieciešama.',
    'insufficient_permissions'  => 'Nepietiekamas atļaujas.',
    'user_deleted_warning'      => 'Šis lietotājs ir izdzēsts. Jums būs jāatjauno šis lietotājs, lai tos rediģētu vai piešķirtu tiem jaunus aktīvus.',
    'ldap_not_configured'        => 'LDAP integrācija nav konfigurēta šai instalācijai.',
    'password_resets_sent'      => 'The selected users who are activated and have a valid email addresses have been sent a password reset link.',
    'password_reset_sent'       => 'A password reset link has been sent to :email!',


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
        'create' => 'Radās problēma, izveidojot lietotāju. Lūdzu mēģiniet vēlreiz.',
        'update' => 'Radās problēma, atjauninot lietotāju. Lūdzu mēģiniet vēlreiz.',
        'delete' => 'Radās problēma, izdzēšot lietotāju. Lūdzu mēģiniet vēlreiz.',
        'delete_has_assets' => 'Šim lietotājam ir piešķirti priekšmeti un to nevarēja dzēst.',
        'unsuspend' => 'Nebija saistīta problēma, kas saistītu ar lietotāju. Lūdzu mēģiniet vēlreiz.',
        'import'    => 'Bija problēma importēt lietotājus. Lūdzu mēģiniet vēlreiz.',
        'asset_already_accepted' => 'Šis aktīvs jau ir pieņemts.',
        'accept_or_decline' => 'Jums ir vai nu jāpieņem vai jāatsakās no šī īpašuma.',
        'incorrect_user_accepted' => 'Aktīvs, kuru jūs mēģinājāt pieņemt, netika izrakstīts jums.',
        'ldap_could_not_connect' => 'Nevarēja izveidot savienojumu ar LDAP serveri. Lūdzu, pārbaudiet LDAP servera konfigurāciju LDAP konfigurācijas failā. <br>Par LDAP servera kļūda:',
        'ldap_could_not_bind' => 'Nevarēja saistīties ar LDAP serveri. Lūdzu, pārbaudiet LDAP servera konfigurāciju LDAP konfigurācijas failā. <br>Par LDAP servera kļūda:',
        'ldap_could_not_search' => 'Nevarēja meklēt LDAP serverī. Lūdzu, pārbaudiet LDAP servera konfigurāciju LDAP konfigurācijas failā. <br>Par LDAP servera kļūda:',
        'ldap_could_not_get_entries' => 'Nevarēja iegūt ierakstus no LDAP servera. Lūdzu, pārbaudiet LDAP servera konfigurāciju LDAP konfigurācijas failā. <br>Par LDAP servera kļūda:',
        'password_ldap' => 'Šī konta paroli pārvalda LDAP / Active Directory. Lai mainītu savu paroli, lūdzu, sazinieties ar IT nodaļu.',
    ),

    'deletefile' => array(
        'error'   => 'Fails nav izdzēsts. Lūdzu mēģiniet vēlreiz.',
        'success' => 'Fails veiksmīgi izdzēsts.',
    ),

    'upload' => array(
        'error'   => 'Faili nav augšupielādēti. Lūdzu mēģiniet vēlreiz.',
        'success' => 'Faili (-i) ir veiksmīgi augšupielādēti.',
        'nofiles' => 'Jūs neesat atlasījis augšupielādes failus',
        'invalidfiles' => 'Viens vai vairāki jūsu faili ir pārāk lieli vai nav atļauto faila tipu. Atļautie failu tipi ir png, gif, jpg, doc, docx, pdf un txt.',
    ),

);

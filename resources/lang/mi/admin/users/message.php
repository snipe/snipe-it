<?php

return array(

    'accepted'                  => 'Kua whakaaetia e koe tenei taonga.',
    'declined'                  => 'Kua paopao angitu koe ki tenei taonga.',
    'bulk_manager_warn'	        => 'Kua angitu te whakahoutia o nga kaiwhakamahi, heoi kihai i tohua to tautuhinga kaiwhakahaere no te mea ko te kaiwhakahaere i tohua e koe i roto i te rarangi kaiwhakamahi kia whakatikaia, kaore ano hoki nga kaiwhakamahi i to ratou ake kaiwhakahaere. Tēnā koa tīpako anō i ō kaiwhakamahi, kaore i te kaiwhakahaere.',
    'user_exists'               => 'Kua noho kē te Kaiwhakamahi!',
    'user_not_found'            => 'User does not exist.',
    'user_login_required'       => 'Kei te hiahiatia te mara takiuru',
    'user_password_required'    => 'Kei te hiahiatia te kupuhipa.',
    'insufficient_permissions'  => 'Nga Whakaae Korero.',
    'user_deleted_warning'      => 'Kua mukua tenei kaiwhakamahi. Me whakahou e koe tenei kaiwhakamahi ki te whakatika i aua mea, ki te tuku ranei i nga taonga hou.',
    'ldap_not_configured'        => 'Ko te whakaurutanga LDAP kua kore i whirihorahia mo tenei whakauru.',
    'password_resets_sent'      => 'The selected users who are activated and have a valid email addresses have been sent a password reset link.',
    'password_reset_sent'       => 'A password reset link has been sent to :email!',
    'user_has_no_email'         => 'This user does not have an email address in their profile.',
    'user_has_no_assets_assigned'   => 'This user does not have any assets assigned',


    'success' => array(
        'create'    => 'I hanga angitu te Kaiwhakamahi.',
        'update'    => 'I whakahoutia te kaiwhakamahi.',
        'update_bulk'    => 'Kua pai te whakahou o nga kaiwhakamahi!',
        'delete'    => 'Kua mukua te Kaiwhakamahi.',
        'ban'       => 'I whakatinanahia te Kaiwhakamahi.',
        'unban'     => 'I pai te whakakorea o te Kaiwhakamahi.',
        'suspend'   => 'Kua tohua te kaiwhakamahi.',
        'unsuspend' => 'I tino angitu te Kaiwhakamahi.',
        'restored'  => 'I angitu te ora o te Kaiwhakamahi.',
        'import'    => 'He pai te kawemai o nga kaiwhakamahi.',
    ),

    'error' => array(
        'create' => 'He raruraru kei te hanga i te kaiwhakamahi. Tena ngana ano.',
        'update' => 'He raru kei te whakahou i te kaiwhakamahi. Tena ngana ano.',
        'delete' => 'He raru kei te whakakore i te kaiwhakamahi. Tena ngana ano.',
        'delete_has_assets' => 'Kei a tenei kaiwhakamahi nga mea kua tohua me te kore e taea te muku.',
        'unsuspend' => 'He raruraru kaore i te whakautu i te kaiwhakamahi. Tena ngana ano.',
        'import'    => 'He raruraru e kawemai ana i nga kaiwhakamahi. Tena ngana ano.',
        'asset_already_accepted' => 'Kua whakaaetia tenei taonga.',
        'accept_or_decline' => 'Me whakaae ranei koe ki te whakakore i tenei taonga.',
        'incorrect_user_accepted' => 'Ko te taonga i whaia e koe ki te whakaae kihai i tukuna ki a koe.',
        'ldap_could_not_connect' => 'Kāore i taea te hono atu ki te tūmau LDAP. Titiro koa ki te whirihoranga o tō tūmau LDAP i te kōnae whirihora LDAP. <br>Error mai i te Tūmau LDAP:',
        'ldap_could_not_bind' => 'Kāore i taea te here ki te tūmau LDAP. Titiro koa ki te whirihoranga o tō tūmau LDAP i te kōnae whirihora LDAP. <br>Error mai i te Tūmau LDAP:',
        'ldap_could_not_search' => 'Kāore i taea te rapu i te tūmau LDAP. Titiro koa ki te whirihoranga o tō tūmau LDAP i te kōnae whirihora LDAP. <br>Error mai i te Tūmau LDAP:',
        'ldap_could_not_get_entries' => 'Kāore i taea te tiki tuhinga mai i te tūmau LDAP. Titiro koa ki te whirihoranga o tō tūmau LDAP i te kōnae whirihora LDAP. <br>Error mai i te Tūmau LDAP:',
        'password_ldap' => 'Ko te kupuhipa mo tenei kaute kei te whakahaeretia e LDAP / Active Directory. Tēnā whakapā atu ki tō tari IT hei huri i tō kupuhipa.',
    ),

    'deletefile' => array(
        'error'   => 'Kāore te kōnae i mukua. Tena ngana ano.',
        'success' => 'Kua mukua te kōnae.',
    ),

    'upload' => array(
        'error'   => 'Ko nga kōnae kāore i tukuna. Tena ngana ano.',
        'success' => 'Ko te (ngā) kōnae i tukuna paihia.',
        'nofiles' => 'Kāore i tīpakohia e koe tetahi kōnae hei tuku ake',
        'invalidfiles' => 'Kotahi, nui atu ranei o ou kōnae he nui rawa atu, he waaahi ranei e kore e whakaaetia. Ko nga kōnae e whakaaetia ana he png, gif, jpg, doc, docx, pdf, me te txt.',
    ),

    'inventorynotification' => array(
        'error'   => 'This user has no email set.',
        'success' => 'The user has been notified about their current inventory.'
    )
);
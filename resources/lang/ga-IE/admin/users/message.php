<?php

return array(

    'accepted'                  => 'Ghlac tú leis an tsócmhainn seo go rathúil.',
    'declined'                  => 'Dhiúltaigh tú an tsócmhainn seo go rathúil.',
    'bulk_manager_warn'	        => 'Rinneadh do chuid úsáideoirí a nuashonrú go rathúil, áfach, níor shábháil do iontráil bainisteora toisc go raibh an bainisteoir a roghnaigh tú chomh maith sa liosta úsáideora le bheith in eagar, agus b\'fhéidir nach mbainfeadh úsáideoirí a mbainisteoir féin. Roghnaigh d\'úsáideoirí arís, gan an bainisteoir a áireamh.',
    'user_exists'               => 'Úsáideoir ann cheana!',
    'user_not_found'            => 'Ní Úsáideoir [: id] ann.',
    'user_login_required'       => 'Is gá an réimse logála isteach',
    'user_password_required'    => 'Tá an focal faire ag teastáil.',
    'insufficient_permissions'  => 'Ceadanna Easpa.',
    'user_deleted_warning'      => 'Scriosadh an t-úsáideoir seo. Beidh ort an t-úsáideoir seo a athchóiriú chun iad a eagrú nó sócmhainní nua a shannadh dóibh.',
    'ldap_not_configured'        => 'Níl cumasc LDAP cumraithe don suiteáil seo.',


    'success' => array(
        'create'    => 'Úsáideadh an t-úsáideoir go rathúil.',
        'update'    => 'Rinneadh an nuashonrú ar an úsáideoir.',
        'update_bulk'    => 'Tugadh cothrom le dáta d\'úsáideoirí!',
        'delete'    => 'Scriosadh an t-úsáideoir go rathúil',
        'ban'       => 'Cuireadh cosc ​​ar an úsáideoir go rathúil.',
        'unban'     => 'Níor aimsíodh an t-úsáideoir go rathúil.',
        'suspend'   => 'Fionraíodh an t-úsáideoir go rathúil.',
        'unsuspend' => 'Rinneadh an t-úsáideoir a neamhshlánú go rathúil.',
        'restored'  => 'Cuireadh an t-úsáideoir ar ais go rathúil.',
        'import'    => 'Allmhairítear úsáideoirí go rathúil.',
    ),

    'error' => array(
        'create' => 'Bhí ceist ann a chruthaigh an t-úsáideoir. Arís, le d\'thoil.',
        'update' => 'Bhí ceist ann ag nuashonrú an úsáideora. Arís, le d\'thoil.',
        'delete' => 'Bhí ceist ann a scriosadh an t-úsáideoir. Arís, le d\'thoil.',
        'delete_has_assets' => 'Tá míreanna sannta ag an úsáideoir seo agus ní fhéadfaí iad a scriosadh.',
        'unsuspend' => 'Bhí ceist ann gan an t-úsáideoir a chaitheamh. Arís, le d\'thoil.',
        'import'    => 'Bhí ceist ann a bhí ag iompórtáil úsáideoirí. Arís, le d\'thoil.',
        'asset_already_accepted' => 'Glactar leis an tsócmhainn seo cheana féin.',
        'accept_or_decline' => 'Ní mór duit an tsócmhainn seo a ghlacadh nó a laghdú.',
        'incorrect_user_accepted' => 'Níor seiceáladh an tsócmhainn a d\'iarr tú glacadh leis.',
        'ldap_could_not_connect' => 'Níorbh fhéidir ceangal leis an bhfreastalaí LDAP. Seiceáil do chumraíocht an fhreastalaí LDAP sa chomhad cumraíochta LDAP. <br>Error ó Freastalaí LDAP:',
        'ldap_could_not_bind' => 'Níorbh fhéidir ceangal leis an bhfreastalaí LDAP. Seiceáil do chumraíocht an fhreastalaí LDAP sa chomhad cumraíochta LDAP. <br>Error ó Freastalaí LDAP:',
        'ldap_could_not_search' => 'Níorbh fhéidir an freastalaí LDAP a chuardach. Seiceáil do chumraíocht an fhreastalaí LDAP sa chomhad cumraíochta LDAP. <br>Error ó Freastalaí LDAP:',
        'ldap_could_not_get_entries' => 'Níorbh fhéidir iontrálacha a fháil ón fhreastalaí LDAP. Seiceáil do chumraíocht an fhreastalaí LDAP sa chomhad cumraíochta LDAP. <br>Error ó Freastalaí LDAP:',
        'password_ldap' => 'Bainistíonn LDAP / Active Directory an focal faire don chuntas seo. Téigh i dteagmháil le do roinn TF chun do phasfhocal a athrú.',
    ),

    'deletefile' => array(
        'error'   => 'Ní scriosadh an comhad. Arís, le d\'thoil.',
        'success' => 'Comhad a scriosadh go rathúil',
    ),

    'upload' => array(
        'error'   => 'Comhad (í) nach bhfuil uaslódáil. Arís, le d\'thoil.',
        'success' => 'Comhad (í) uaslódáil go rathúil.',
        'nofiles' => 'Níor roghnaigh tú aon chomhaid le híoslódáil',
        'invalidfiles' => 'Tá ceann amháin nó níos mó de do chuid comhad ró-mhór nó is comhad í nach bhfuil ceadaithe. Tá píopaí comhaid a cheadaítear png, gif, jpg, doc, docx, pdf, and txt.',
    ),

);

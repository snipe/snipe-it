<?php

return array(

    'accepted'                  => 'Le athollen sen gwen veleg.',
    'declined'                  => 'Le aphollen sen gwen veleg.',
    'bulk_manager_warn'	        => 'I-nírad lín ú-dolui, dan ú-chedir i-gwend lin ah ú-dorthon in-gwend i-annonen na cened; ú-celu leno gwend gerithron aglar thent. Lebero sui gwenn linn, bacho i-harth veleg.',
    'user_exists'               => 'Gwend al-len!',
    'user_not_found'            => 'Ú-bedithon gwend hen ah ú-doron an echel.',
    'user_login_required'       => 'I-hened na-erui!',
    'user_has_no_assets_assigned' => 'Ú-beriad gwen vi-cened na gwend.',
    'user_password_required'    => 'I-thened na-erui.',
    'insufficient_permissions'  => 'Doron ú-teled.',
    'user_deleted_warning'      => 'Gwend hen bedithon. Le ma ad-beriad gwend hen an edhel no aphenath.',
    'ldap_not_configured'       => 'LDAP ú-geledir en-gogol lin.',
    'password_resets_sent'      => 'I-nírad lín aglar ui gwend hen na-gogol naion aphin lin; aphoriel aphadon.',
    'password_reset_sent'       => 'I-aphadon aphoriel na: :email!',
    'user_has_no_email'         => 'Ú-bedithon gwend hen aphadon vi-dhon sen.',
    'log_record_not_found'      => 'I-nirath na gwend hen ú-bedithon.',

    'success' => array(
        'create'    => 'Gwend hen aglannath veleg.',
        'update'    => 'Gwend hen na-chenneth veleg.',
        'update_bulk'    => 'Gwenn hen na-chenneth veleg!',
        'delete'    => 'Gwend hen bedith veleg.',
        'ban'       => 'Gwend hen darnath veleg.',
        'unban'     => 'Gwend hen ú-darnath veleg.',
        'suspend'   => 'Gwend hen nedarnath veleg.',
        'unsuspend' => 'Gwend hen ú-nedarnath veleg.',
        'restored'  => 'Gwend hen ad-bedith veleg.',
        'import'    => 'Gwenn hen in-naogol ad-chennath veleg.',
    ),

    'error' => array(
        'create' => 'Tangol nedril gwend hen. Aníron na-chebin.',
        'update' => 'Tangol nedril gwend hen an-uir. Aníron na-chebin.',
        'delete' => 'Tangol nedril bedir gwend hen. Aníron na-chebin.',
        'delete_has_assets' => 'Gwend hen iû tangnen a ú-chenir bedir.',
        'delete_has_assets_var' => 'Gwend hen tangnen er. Aphado iû an na-gweth i naid.|Gwend hen tangnen :count; aphado naid hen i na-gweth iû.',
        'delete_has_licenses_var' => 'Gwend hen tangnen ir aphadon hên. Aphado aphadon hen i naid.|Gwend hen aphadon hên :count; aphado naid hen aphadon iû.',
        'delete_has_accessories_var' => 'Gwend hen aphadon edyr hên. Aphado aphadon hên.|Gwend hen aphadon hên :count aphadon hên an aphado.',
        'delete_has_locations_var' => 'Gwend hen ethlaid lann hen. Ú-chend lann nedril.|Gwend hen ethlaid lann :count. Ú-chend lann nedril na-lam.',
        'delete_has_users_var' => 'Gwend hen ethlaid edloth hen. Aphado nedril gwend hîr na-lam hen.|Gwend hen ethlaid edloth :count; aphado gwend hîr na-lam hen.',
        'unsuspend' => 'Tangol nedril nedarnath gwend hen. Aníron na-chebin.',
        'import'    => 'Tangol nedril na-chebin gwend hen. Aníron na-chebin.',
        'asset_already_accepted' => 'Gwen hen na-chenneth veleg.',
        'accept_or_decline' => 'Maen or athollen nedril gwen hen veleg.',
        'cannot_delete_yourself' => 'Ú-chend ú-dirin nedril veleg. Aphado!',
        'incorrect_user_accepted' => 'Gwen hen tangnen hen ú-aphado na-lam edh le.',
        'ldap_could_not_connect' => 'Tangol nedril na-chebin na LDAP nedril. Aphado nedril file.',
        'ldap_could_not_bind' => 'Tangol nedril na-chebin file LDAP. Aphado nedril file.',
        'ldap_could_not_search' => 'Tangol nedril na-chedor file LDAP. Aphado nedril file.',
        'ldap_could_not_get_entries' => 'Tangol nedril na-chedor nedril LDAP.',
        'password_ldap' => 'I-thened nedril hen na-chedir LDAP. Athollen.',
        'multi_company_items_assigned' => 'Gwend hen tangnen ad-iu gwen lin.',
    ),


    'deletefile' => array(
        'error'   => 'I-dharthol ú-bedith. Aníron na-chebin.',
        'success' => 'I-dharthol bedith veleg.',
    ),

    'upload' => array(
        'error'   => 'I-dharthol in-naogol ú-lybannin. Aníron na-chebin.',
        'success' => 'I-dharthol in-naogol lybannin veleg.',
        'nofiles' => 'Ú-bênil dharthol nedril aeth nedril nauth.',
        'invalidfiles' => 'Hen dharthol hen ú-gar naug beleg ben eneg ah i-dharthol allowed ben png, gif, jpg, doc, docx, pdf, ah txt.',
    ),

    'inventorynotification' => array(
        'error'   => 'Naur hên iû ú-gar dharthol nedril.',
        'success' => 'Gwend hen nauth bedith veleg i naid lin.',
    )
);
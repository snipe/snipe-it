<?php

return array(

    'accepted'                  => 'Úspešne ste potvrdili prijatie majetku.',
    'declined'                  => 'Odmietnutie majetku bolo úspešné.',
    'bulk_manager_warn'	        => 'Používatelia boli úspešné aktualizovaný, avčak položka manažér nebola uložená, pretože zvolený manažér sa taktiež nachádzal v zoznam na úpravu a používatel nemôže byť sám sebe manazérom. Prosim zvoľte Vašich používateľov znovu s vynechaním manažéera.',
    'user_exists'               => 'Používateľ už existuje!',
    'user_not_found'            => 'User does not exist or you do not have permission view them.',
    'user_login_required'       => 'Prihlasovacie meno je povinné',
    'user_has_no_assets_assigned' => 'No assets currently assigned to user.',
    'user_password_required'    => 'Heslo je povinné.',
    'insufficient_permissions'  => 'Nedostatočné oprávnenia.',
    'user_deleted_warning'      => 'Tento používateľ bol odstránený. Používateľa musíte obnoviť, ak ho chcete upraviť alebo mu priradiť majetok.',
    'ldap_not_configured'        => 'LDAP prepojenie nebolo nastavené pre túto inštaláciu.',
    'password_resets_sent'      => 'Vybraní používatelia sú aktivovaný. Na ich adresu bola zaslaný okaz na resetovanie hesla.',
    'password_reset_sent'       => 'A password reset link has been sent to :email!',
    'user_has_no_email'         => 'This user does not have an email address in their profile.',
    'log_record_not_found'        => 'A matching log record for this user could not be found.',


    'success' => array(
        'create'    => 'Používateľ bol úspešne vytovrený.',
        'update'    => 'Používateľ bol úspešne upravený.',
        'update_bulk'    => 'Používatelia boli úspešne upravení!',
        'delete'    => 'Používateľ bol úspešne odstránený.',
        'ban'       => 'Používateľ bol úspešné zablokovaný.',
        'unban'     => 'Používateľ bol úspešne odblokovaný.',
        'suspend'   => 'Používateľ bol úspešne pozastavený.',
        'unsuspend' => 'Používateľ bol úspešne obnovený.',
        'restored'  => 'Používateľ bol úspešne obnovený.',
        'import'    => 'Používatelia boli úspešne importovaní.',
    ),

    'error' => array(
        'create' => 'Pri vytváraní používateľa sa vyskytla chby. Skúste prosím znovu.',
        'update' => 'Pri aktualizácií používateľa sa vyskytla chyba. Prosím skúste znovu.',
        'delete' => 'Pri odstraňovaní používateľa sa vyskytla chyba. Skúste prosím neskôr.',
        'delete_has_assets' => 'Tento používateľ ma priradené položky a nemôže byť odstránený.',
        'delete_has_assets_var' => 'This user still has an asset assigned. Please check it in first.|This user still has :count assets assigned. Please check their assets in first.',
        'delete_has_licenses_var' => 'This user still has a license seats assigned. Please check it in first.|This user still has :count license seats assigned. Please check them in first.',
        'delete_has_accessories_var' => 'This user still has an accessory assigned. Please check it in first.|This user still has :count accessories assigned. Please check their assets in first.',
        'delete_has_locations_var' => 'This user still manages a location. Please select another manager first.|This user still manages :count locations. Please select another manager first.',
        'delete_has_users_var' => 'This user still manages another user. Please select another manager for that user first.|This user still manages :count users. Please select another manager for them first.',
        'unsuspend' => 'Pri pokuse o zrušenie pozastavenia používateľa nastala chyba. Skúste prosím znovu.',
        'import'    => 'Pri importovaní používateľov nastala chyba. Prosím skúste znovu.',
        'asset_already_accepted' => 'Tento majetok bol už prijatý.',
        'accept_or_decline' => 'Musíte prijať alebo odmietnuť tento majetok.',
        'cannot_delete_yourself' => 'We would feel really bad if you deleted yourself, please reconsider.',
        'incorrect_user_accepted' => 'Majetok, ktorý sa pokúšate prijať, Vám nebol priradený.',
        'ldap_could_not_connect' => 'Nepodarilo sa pripojiť k LDAP serveru. Prosím skontrolujte nastavenia LDAP serveru v Admin nastavenia > LDAP/AD <br>Chyba LDAP serveru:',
        'ldap_could_not_bind' => 'Nepodarilo sa napojiť na LDAP server. Prosím skontrolujte nastavenia LDAP serveru v Admin nastavenia > LDAP/AD <br>Chyba LDAP serveru: ',
        'ldap_could_not_search' => 'Nepodarilo sa vyhladať v rámci LDAP serveru. Prosím skontrolujte nastavenia LDAP serveru v Admin nastavenia > LDAP/AD a všetky lokality ktoré môžu mať nastavené OU. <br>Chyba LDAP serveru:',
        'ldap_could_not_get_entries' => 'Nepodarilo sa získať záznamy z LDAP servera. Prosím skontrolujte nastavenia LDAP serveru v Admin nastavenia > LDAP/AD a všetky lokality ktoré môžu mať nastavené OU. <br>Chyba LDAP serveru:',
        'password_ldap' => 'Heslo pre tento účet je spravované cez LDAP/Active Directory. Pre zmneu hesla prosím kontaktujte Vaše IT oddelenie. ',
        'multi_company_items_assigned' => 'This user has items assigned that belong to a different company. Please check them in or edit their company.'
    ),

    'deletefile' => array(
        'error'   => 'Súbor nebol odstránený. Prosím skúste znovu.',
        'success' => 'Súbor bol úspešne odstránený.',
    ),

    'upload' => array(
        'error'   => 'Súbor(y) sa nepodarilo nahrať. Skúste prosím znovu.',
        'success' => 'Súbor(y) bol úspešne nahraté.',
        'nofiles' => 'Nevybrali ste žiadne súbre pre nahratie',
        'invalidfiles' => 'Jeden alebo viacero Vašich súborov je príliš veľkých alebo nie su podporované. Podporované typy súborov sú png, gif, jpg, doc, docx, pdf a txt.',
    ),

    'inventorynotification' => array(
        'error'   => 'This user has no email set.',
        'success' => 'The user has been notified about their current inventory.'
    )
);
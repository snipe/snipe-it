<?php

return array(

    'accepted'                  => 'Úspešne ste potvrdili prijatie majetku.',
    'declined'                  => 'Odmietnutie majetku bolo úspešné.',
    'bulk_manager_warn'	        => 'Používatelia boli úspešné aktualizovaný, avčak položka manažér nebola uložená, pretože zvolený manažér sa taktiež nachádzal v zoznam na úpravu a používatel nemôže byť sám sebe manazérom. Prosim zvoľte Vašich používateľov znovu s vynechaním manažéera.',
    'user_exists'               => 'Používateľ už existuje!',
    'user_not_found'            => 'User does not exist.',
    'user_login_required'       => 'Prihlasovacie meno je povinné',
    'user_password_required'    => 'Heslo je povinné.',
    'insufficient_permissions'  => 'Nedostatočné oprávnenia.',
    'user_deleted_warning'      => 'Tento používateľ bol odstránený. Používateľa musíte obnoviť, ak ho chcete upraviť alebo mu priradiť majetok.',
    'ldap_not_configured'        => 'LDAP prepojenie nebolo nastavené pre túto inštaláciu.',
    'password_resets_sent'      => 'Vybraní používatelia sú aktivovaný. Na ich adresu bola zaslaný okaz na resetovanie hesla.',
    'password_reset_sent'       => 'A password reset link has been sent to :email!',
    'user_has_no_email'         => 'This user does not have an email address in their profile.',
    'user_has_no_assets_assigned'   => 'This user does not have any assets assigned',


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
        'unsuspend' => 'Pri pokuse o zrušenie pozastavenia používateľa nastala chyba. Skúste prosím znovu.',
        'import'    => 'Pri importovaní používateľov nastala chyba. Prosím skúste znovu.',
        'asset_already_accepted' => 'Tento majetok bol už prijatý.',
        'accept_or_decline' => 'Musíte prijať alebo odmietnuť tento majetok.',
        'incorrect_user_accepted' => 'Majetok, ktorý sa pokúšate prijať, Vám nebol priradený.',
        'ldap_could_not_connect' => 'Nepodarilo sa pripojiť k LDAP serveru. Prosím skontrolujte nastavenia LDAP serveru v Admin nastavenia > LDAP/AD <br>Chyba LDAP serveru:',
        'ldap_could_not_bind' => 'Nepodarilo sa napojiť na LDAP server. Prosím skontrolujte nastavenia LDAP serveru v Admin nastavenia > LDAP/AD <br>Chyba LDAP serveru: ',
        'ldap_could_not_search' => 'Nepodarilo sa vyhladať v rámci LDAP serveru. Prosím skontrolujte nastavenia LDAP serveru v Admin nastavenia > LDAP/AD a všetky lokality ktoré môžu mať nastavené OU. <br>Chyba LDAP serveru:',
        'ldap_could_not_get_entries' => 'Nepodarilo sa získať záznamy z LDAP servera. Prosím skontrolujte nastavenia LDAP serveru v Admin nastavenia > LDAP/AD a všetky lokality ktoré môžu mať nastavené OU. <br>Chyba LDAP serveru:',
        'password_ldap' => 'Heslo pre tento účet je spravované cez LDAP/Active Directory. Pre zmneu hesla prosím kontaktujte Vaše IT oddelenie. ',
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
<?php

return array(

    'accepted'                  => 'Jūs sėkmingai priėmėte šią įrangą.',
    'declined'                  => 'Jūs sėkmingai atšaukėte šią įrangą.',
    'bulk_manager_warn'	        => 'Jūsų vartotojai buvo sėkmingai atnaujinti, tačiau jūsų valdytojo įrašas nebuvo išsaugotas, nes pasirinktas valdytojas taip pat buvo naudotojo sąraše, kurį reikia redaguoti, o vartotojai gali būti ne jų valdytojai. Prašome vėl pasirinkti naudotojus, išskyrus valdytoją.',
    'user_exists'               => 'Naudotojas jau yra!',
    'user_not_found'            => 'Naudotojo nėra.',
    'user_login_required'       => 'Prisijungimo laukelis privalomas',
    'user_has_no_assets_assigned' => 'No assets currently assigned to user.',
    'user_password_required'    => 'Slaptažodis būtinas.',
    'insufficient_permissions'  => 'Nepakankamos teisės.',
    'user_deleted_warning'      => 'Šis naudotojas ištrintas. Jūs turėsite atkurti naudotoją norėdami redaguoto ar priskirti jam naują įrangą.',
    'ldap_not_configured'        => 'LDAP integracija nebuvo sukonfikuruota šiam diegimui.',
    'password_resets_sent'      => 'The selected users who are activated and have a valid email addresses have been sent a password reset link.',
    'password_reset_sent'       => 'A password reset link has been sent to :email!',
    'user_has_no_email'         => 'This user does not have an email address in their profile.',
    'log_record_not_found'        => 'Atitinkamas log įrašas šiam naudotojui nerastas.',


    'success' => array(
        'create'    => 'Naudotojas sėkmingai sukurtas.',
        'update'    => 'Naudotojas sėkmingai atnaujintas.',
        'update_bulk'    => 'Vartotojai buvo sėkmingai atnaujinti!',
        'delete'    => 'Naudotojas sėkmingai ištrintas.',
        'ban'       => 'Naudotojas sėkmingai užblokuotas.',
        'unban'     => 'Naudotojas sėkmingai atblokuotas.',
        'suspend'   => 'Naudotojas sėkmingai užšaldytas.',
        'unsuspend' => 'Naudotojas sėkmingai atšaldytas.',
        'restored'  => 'Naudotojas sėkmingai atkurtas.',
        'import'    => 'Naudotojai sėkmingai įkelti.',
    ),

    'error' => array(
        'create' => 'Nepavyko sukurti naudotojo. Prašome bandykite dar kartą.',
        'update' => 'Nepavyko atnaujinti naudotojo. Prašome bandykite dar kartą.',
        'delete' => 'Nepavyko ištrinti naudotojo. Prašome bandykite dar kartą.',
        'delete_has_assets' => 'Šis vartotojas turi priskirtus elementus, kurių negalima ištrinti.',
        'delete_has_assets_var' => 'This user still has an asset assigned. Please check it in first.|This user still has :count assets assigned. Please check their assets in first.',
        'delete_has_licenses_var' => 'This user still has a license seats assigned. Please check it in first.|This user still has :count license seats assigned. Please check them in first.',
        'delete_has_accessories_var' => 'This user still has an accessory assigned. Please check it in first.|This user still has :count accessories assigned. Please check their assets in first.',
        'delete_has_locations_var' => 'This user still manages a location. Please select another manager first.|This user still manages :count locations. Please select another manager first.',
        'delete_has_users_var' => 'This user still manages another user. Please select another manager for that user first.|This user still manages :count users. Please select another manager for them first.',
        'unsuspend' => 'Nepavyko atšaldyti naudotojo. Prašome bandykite dar kartą.',
        'import'    => 'Nepavyko įkelti naudotojų. Prašome bandykite dar kartą.',
        'asset_already_accepted' => 'ši įranga jau buvo priimta.',
        'accept_or_decline' => 'Jūs turite arba priimti arba atmesti šią įrangą.',
        'cannot_delete_yourself' => 'We would feel really bad if you deleted yourself, please reconsider.',
        'incorrect_user_accepted' => 'Įranga kurią bandote priimti, nebuvo priskirta Jums.',
        'ldap_could_not_connect' => 'Negali prisijungti prie LDAP serverio. Prašome patikrinkite savo LDAP serverio konfigūraciją LDAP konfigūracijos faile. <br>Klaida iš LDAP Serverio:',
        'ldap_could_not_bind' => 'Negali nustatyti vartotojo prisijungiant prie LDAP serverio. Prašome patikrinkite savo LDAP serverio konfigūraciją LDAP konfigūracijos faile. <br>Klaida iš LDAP Serverio: ',
        'ldap_could_not_search' => 'Negali rasti LDAP serverio. Prašome patikrinkite savo LDAP serverio konfigūraciją LDAP konfigūracijos faile. <br>Klaida iš LDAP Serverio:',
        'ldap_could_not_get_entries' => 'Negali gauti prieigos prie LDAP serverio. Prašome patikrinkite savo LDAP serverio konfigūraciją LDAP konfigūracijos faile. <br>Klaida iš LDAP Serverio:',
        'password_ldap' => 'Šios paskyros slaptažodį tvarko LDAP / Active Directory. Prašome susisiekti su savo IT departamentu, kad pakeistumėte slaptažodį.',
    ),

    'deletefile' => array(
        'error'   => 'Failas neištrintas. Prašome bandykite dar kartą.',
        'success' => 'Failas sėkmingai ištrintas.',
    ),

    'upload' => array(
        'error'   => 'Failas (-ai) neįkelti. Prašome bandykite dar kartą.',
        'success' => 'Failas (-ai) sėkmingai įkelti.',
        'nofiles' => 'Įkėlimui jūs nepasirinkote jokių failų',
        'invalidfiles' => 'Vienas ar keli failai yra per dideli arba neleidžiamas šis failų formatas. Primename, kad leidžiami sekantys formatai png, gif, jpg, doc, docx, pdf, txt.',
    ),

    'inventorynotification' => array(
        'error'   => 'This user has no email set.',
        'success' => 'The user has been notified about their current inventory.'
    )
);
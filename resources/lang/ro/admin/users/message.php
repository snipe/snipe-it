<?php

return array(

    'accepted'                  => 'Ați acceptat cu succes acest activ.',
    'declined'                  => 'Ați refuzat cu succes acest activ.',
    'bulk_manager_warn'	        => 'Utilizatorii dvs. au fost actualizați cu succes, cu toate acestea, intrarea managerului dvs. nu a fost salvată, deoarece managerul pe care l-ați selectat a fost, de asemenea, în lista de utilizatori care urmează să fie editat și este posibil ca utilizatorii să nu fie propriul manager. Selectați din nou utilizatorii dvs., cu excepția managerului.',
    'user_exists'               => 'Utilizatorul exista deja!',
    'user_not_found'            => 'Utilizatorul [:id] nu exista.',
    'user_login_required'       => 'Campul de login este necesar',
    'user_password_required'    => 'Este necesara parola.',
    'insufficient_permissions'  => 'Nu aveti permisiuni suficiente.',
    'user_deleted_warning'      => 'Acest utilizator a fost sters. Trebuie sa restaurati utilizator ca sa-l editati sau sa-i desemnati active noi.',
    'ldap_not_configured'        => 'Integrarea LDAP nu a fost configurată pentru această instalare.',
    'password_resets_sent'      => 'The selected users who are activated and have a valid email addresses have been sent a password reset link.',
    'password_reset_sent'       => 'A password reset link has been sent to :email!',
    'user_has_no_email'         => 'This user does not have an email address in their profile.',


    'success' => array(
        'create'    => 'Utilizatorul a fost creat.',
        'update'    => 'Utilizatorul a fost actualizat.',
        'update_bulk'    => 'Utilizatorii au fost actualizați cu succes!',
        'delete'    => 'Utilizatorul a fost sters.',
        'ban'       => 'Utilizatorul a fost banat.',
        'unban'     => 'Utilizatorul a fost debanat.',
        'suspend'   => 'Utilizatorul a fost suspendat.',
        'unsuspend' => 'Utilizatorul a fost activat.',
        'restored'  => 'Utilizatorul a fost restaurat.',
        'import'    => 'Utilizatorii importați cu succes.',
    ),

    'error' => array(
        'create' => 'A aparut o problema la crearea utilizatorului. Incercati iar.',
        'update' => 'A aparut o problema la actualizarea utilizatorului. Incercati iar.',
        'delete' => 'A aparut o problema la stergerea utilizatorului. Incercati iar.',
        'delete_has_assets' => 'Acest utilizator are elemente atribuite și nu a putut fi șters.',
        'unsuspend' => 'A aparut o problema la reactivarea utilizatorului. Incercati iar.',
        'import'    => 'A apărut o problemă la importarea utilizatorilor. Vă rugăm să încercați din nou.',
        'asset_already_accepted' => 'Acest activ a fost deja acceptat.',
        'accept_or_decline' => 'Trebuie să acceptați sau să refuzați acest activ.',
        'incorrect_user_accepted' => 'Activitatea pe care ați încercat să o acceptați nu a fost verificată de dvs.',
        'ldap_could_not_connect' => 'Nu s-a putut conecta la serverul LDAP. Verificați configurația serverului LDAP în fișierul de configurare LDAP. <br>Error de la LDAP Server:',
        'ldap_could_not_bind' => 'Nu s-a putut lega la serverul LDAP. Verificați configurația serverului LDAP în fișierul de configurare LDAP. <br>Error de la LDAP Server:',
        'ldap_could_not_search' => 'Căutarea serverului LDAP nu a putut fi efectuată. Verificați configurația serverului LDAP în fișierul de configurare LDAP. <br>Error de la LDAP Server:',
        'ldap_could_not_get_entries' => 'Nu s-au putut obține intrări de pe serverul LDAP. Verificați configurația serverului LDAP în fișierul de configurare LDAP. <br>Error de la LDAP Server:',
        'password_ldap' => 'Parola pentru acest cont este gestionată de LDAP / Active Directory. Contactați departamentul IT pentru a vă schimba parola.',
    ),

    'deletefile' => array(
        'error'   => 'Fișierul nu a fost șters. Vă rugăm să încercați din nou.',
        'success' => 'Fișierul a fost șters cu succes.',
    ),

    'upload' => array(
        'error'   => 'Fișierul nu a fost încărcat. Vă rugăm să încercați din nou.',
        'success' => 'Fișierul a fost încărcat cu succes.',
        'nofiles' => 'Nu ați selectat niciun fișier pentru încărcare',
        'invalidfiles' => 'Unul sau mai multe fișiere este prea mare sau este un tip de fișier care nu este permis. Tipurile de fișiere permise sunt png, gif, jpg, doc, docx, pdf și txt.',
    ),

);
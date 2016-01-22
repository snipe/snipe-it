<?php

return array(

    'accepted'                  => 'You have successfully accepted this asset.',
    'declined'                  => 'You have successfully declined this asset.',
    'user_exists'               => 'المستخدم موجود مسبقاً!',
    'user_not_found'            => 'المستخدم [id:] غير موجود.',
    'user_login_required'       => 'حقل "الدخول" مطلوب',
    'user_password_required'    => 'كلمة السر مطلوبة.',
    'insufficient_permissions'  => 'صلاحيات غير كافية.',
    'user_deleted_warning'      => 'تم حذف المستخدم. سيكون عليك استعادة هذا المستخدم للتعديل عليه او تسليمه اجهزة جديدة.',
    'ldap_not_configured'        => 'LDAP integration has not been configured for this installation.',


    'success' => array(
        'create'    => 'تم إنشاء المستخدم بنجاح.',
        'update'    => 'تم تعديل المستخدم بنجاح.',
        'delete'    => 'تم حذف المستخدم بنجاح.',
        'ban'       => 'تم حظر المستخدم بنجاح.',
        'unban'     => 'تم إلغاء الحظر عن المستخدم بنجاح.',
        'suspend'   => 'تم تعليق المستخدم بنجاح.',
        'unsuspend' => 'تم إلغاء التعليق عن المستخدم بنجاح.',
        'restored'  => 'تم استعادة المستخدم بنجاح.',
        'import'    => 'تم استيراد المستخدمين بنجاح.',
    ),

    'error' => array(
        'create' => 'حدث خطأ ما أثناء إنشاء هذا المستخدم. حاول مرة أخرى.',
        'update' => 'حدث خطأ أثناء تحديث هذا المستخدم. حاول مرة أخرى.',
        'delete' => 'حدث خطأ ما أثناء حذف هذا المستخدم. حاول مرة أخرى.',
        'unsuspend' => 'حدث خطأ ما أثناء إلغاء التعليق عن المستخدم. حاول مرة أخرى.',
        'import'    => 'حدث خطأ أثناء استيراد المستخدمين. حاول مرة أخرى.',
        'asset_already_accepted' => 'هذا الجهاز تم قبوله مسبقاً.',
        'accept_or_decline' => 'You must either accept or decline this asset.',
        'incorrect_user_accepted' => 'The asset you have attempted to accept was not checked out to you.',
        'ldap_could_not_connect' => 'Could not connect to the LDAP server. Please check your LDAP server configuration in the LDAP config file. <br>Error from LDAP Server:',
        'ldap_could_not_bind' => 'Could not bind to the LDAP server. Please check your LDAP server configuration in the LDAP config file. <br>Error from LDAP Server: ',
        'ldap_could_not_search' => 'Could not search the LDAP server. Please check your LDAP server configuration in the LDAP config file. <br>Error from LDAP Server:',
        'ldap_could_not_get_entries' => 'Could not get entries from the LDAP server. Please check your LDAP server configuration in the LDAP config file. <br>Error from LDAP Server:',
    ),

    'deletefile' => array(
        'error'   => 'File not deleted. Please try again.',
        'success' => 'File successfully deleted.',
    ),

    'upload' => array(
        'error'   => 'File(s) not uploaded. Please try again.',
        'success' => 'File(s) successfully uploaded.',
        'nofiles' => 'You did not select any files for upload',
        'invalidfiles' => 'One or more of your files is too large or is a filetype that is not allowed. Allowed filetypes are png, gif, jpg, doc, docx, pdf, and txt.',
    ),

);

<?php

return [

    'undeployable' 		=> '<strong> تحذير: </strong> تم تحديد الحالة لهذا الأصل بانه غير قابل للتوزيع حاليا. إذا تغيرت هذه الحالة، يرجى تحديث حالة الأصل.',
    'does_not_exist' 	=> 'الأصل غير موجود.',
    'does_not_exist_or_not_requestable' => 'That asset does not exist or is not requestable.',
    'assoc_users'	 	=> 'هذا الأصل مخرج حاليا لمستخدم ولا يمكن حذفه. يرجى التحقق من الأصل أولا، ثم حاول الحذف مرة أخرى. ',

    'create' => [
        'error'   		=> 'لم يتم إنشاء الأصل، يرجى إعادة المحاولة. :(',
        'success' 		=> 'تم إنشاء الأصل بنجاح. :)',
    ],

    'update' => [
        'error'   			=> 'لم يتم تحديث الأصل، يرجى إعادة المحاولة',
        'success' 			=> 'تم تحديث الأصل بنجاح.',
        'nothing_updated'	=>  'لم يتم اختيار أي حقول، لذلك لم يتم تحديث أي شيء.',
        'no_assets_selected'  =>  'No assets were selected, so nothing was updated.',
    ],

    'restore' => [
        'error'   		=> 'لم تتم استعادة الأصل، يرجى إعادة المحاولة',
        'success' 		=> 'تمت استعادة الأصل بنجاح.',
        'bulk_success' 		=> 'تمت استعادة الأصل بنجاح.',
        'nothing_updated'   => 'ولم يتم اختيار أي أصول، وبالتالي لم يتم استعادة أي شيء.', 
    ],

    'audit' => [
        'error'   		=> 'لم تنجح مراجعة الأصل. حاول مرة اخرى.',
        'success' 		=> 'تم تسجيل تدقيق الأصل بنجاح.',
    ],


    'deletefile' => [
        'error'   => 'لم يتم حذف الملف. الرجاء المحاولة مرة اخرى.',
        'success' => 'تم حذف الملف بنجاح.',
    ],

    'upload' => [
        'error'   => 'لم يتم تحميل الملف. حاول مرة اخرى.',
        'success' => 'تم تحميل الملف بنجاح.',
        'nofiles' => 'لم تحدد أي ملفات للتحميل، أو أن الملف الذي تحاول تحميله كبير جدا',
        'invalidfiles' => 'واحد أو أكثر من الملفات كبيرة جداً أو نوع الملف غير مسموح. أنواع الملفات المسموح بها هي png, gif, jpg, doc, docx, pdf, و txt.',
    ],

    'import' => [
        'error'                 => 'لم يتم استيراد بعض العناصر بشكل صحيح.',
        'errorDetail'           => 'لم يتم استيراد العناصر التالية بسبب الأخطاء.',
        'success'               => 'تم استيراد الملف الخاص بك',
        'file_delete_success'   => 'تم حذف ملفك بنجاح',
        'file_delete_error'      => 'تعذر حذف الملف',
        'header_row_has_malformed_characters' => 'One or more attributes in the header row contain malformed UTF-8 characters',
        'content_row_has_malformed_characters' => 'One or more attributes in the first row of content contain malformed UTF-8 characters',
    ],


    'delete' => [
        'confirm'   	=> 'هل تريد بالتأكيد حذف هذا الأصل؟',
        'error'   		=> 'حدثت مشكلة أثناء حذف هذا الأصل. حاول مرة اخرى.',
        'nothing_updated'   => 'لم يتم اختيار أي أصول، لذلك لم يتم حذف أي شيء.',
        'success' 		=> 'تم حذف الأصل بنجاح.',
    ],

    'checkout' => [
        'error'   		=> 'لم يتم اخراج الأصل، يرجى إعادة المحاولة',
        'success' 		=> 'تم اخراج الأصل بنجاح.',
        'user_does_not_exist' => 'هذا المستخدم غير صالح. حاول مرة اخرى.',
        'not_available' => 'هذا الأصل غير متاح للخروج!',
        'no_assets_selected' => 'يجب عليك تحديد أصل واحد على الأقل من القائمة',
    ],

    'checkin' => [
        'error'   		=> 'لم يتم ادخال الأصل، يرجى إعادة المحاولة',
        'success' 		=> 'تم ادخال الأصل بنجاح.',
        'user_does_not_exist' => 'هذا المستخدم غير صالح. حاول مرة اخرى.',
        'already_checked_in'  => 'تم ادخال هذا الأصل مسبقا.',

    ],

    'requests' => [
        'error'   		=> 'لم يتم طلب الأصل، يرجى إعادة المحاولة',
        'success' 		=> 'تم طلب الأصل بنجاح.',
        'canceled'      => 'تم إلغاء طلب الاخراج بنجاح',
    ],

];

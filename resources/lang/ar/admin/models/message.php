<?php

return array(

    'does_not_exist' => 'الموديل غير موجود.',
    'assoc_users'	 => 'هذا الموديل مرتبط حاليا بواحد أو أكثر من الأصول ولا يمكن حذفه. يرجى حذف الأصول، ثم محاولة الحذف مرة أخرى. ',


    'create' => array(
        'error'   => 'لم يتم انشاء الموديل، يرجى إعادة المحاولة.',
        'success' => 'تم إنشاء الموديل بنجاح.',
        'duplicate_set' => 'يوجد مسبقا موديل بهذا الاسم، الشركة المصنعة ورقم الموديل.',
    ),

    'update' => array(
        'error'   => 'لم يتم تحديث الموديل، يرجى إعادة المحاولة',
        'success' => 'تم تحديث الموديل بنجاح.'
    ),

    'delete' => array(
        'confirm'   => 'هل تريد بالتأكيد حذف موديل الأصل هذا؟',
        'error'   => 'حدثت مشكلة أثناء حذف الموديل. حاول مرة اخرى.',
        'success' => 'تم حذف الموديل بنجاح.'
    ),

    'restore' => array(
        'error'   		=> 'لم تتم استعادة الموديل، يرجى إعادة المحاولة',
        'success' 		=> 'تم إستعادة الموديل بنجاح.'
    ),

    'bulkedit' => array(
        'error'   		=> 'لم يتم تغيير أي حقول، لذلك لم يتم تحديث أي شيء.',
        'success' 		=> 'تم تحديث الموديل.'
    ),

    'bulkdelete' => array(
        'error'   		    => 'No models were selected, so nothing was deleted.',
        'success' 		    => ':success_count model(s) deleted!',
        'success_partial' 	=> ':success_count model(s) were deleted, however :fail_count were unable to be deleted because they still have assets associated with them.'
    ),

);

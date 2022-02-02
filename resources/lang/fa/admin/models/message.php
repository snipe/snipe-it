<?php

return array(

    'does_not_exist' => 'مدل موجود نیست.',
    'assoc_users'	 => 'این مدل در حال حاضر همراه یک یا بیشتر از یک دارایی است و نمی تواند حذف شود. لطفا دارایی ها را حذف کنید و سپس برای حذف کردن مجددا تلاش کنید. ',


    'create' => array(
        'error'   => 'مدل ساخته نشده است، لطفا دوباره تلاش کنید.',
        'success' => 'مدل با موفقیت ساخته شد.',
        'duplicate_set' => 'یک مدل دارایی با آن نام، سازنده و شماره ی مدل در حال حاضر موجود است.',
    ),

    'update' => array(
        'error'   => 'مدل به روزرسانی نشده است، لطفا دوباره تلاش کنید',
        'success' => 'مدل با موفقیت به روز رسانی شد.'
    ),

    'delete' => array(
        'confirm'   => 'آیا شما مطمئن هستید که می خواهید این مدل دارایی را حذف کنید؟',
        'error'   => 'در زمان حذف کردن مدل، مشکلی وجود داشت. لطفا دوباره تلاش کنید.',
        'success' => 'مدل با موفقیت حذف شد.'
    ),

    'restore' => array(
        'error'   		=> 'مدل بازیابی نشد، لطفا دوباره تلاش کنید',
        'success' 		=> 'مدل با موفقیت بازیابی شد.'
    ),

    'bulkedit' => array(
        'error'   		=> 'هیچ فیلدی تغییر نکرده بود، بنابراین چیزی به روز نشد.',
        'success' 		=> 'مدل های به روز شده'
    ),

    'bulkdelete' => array(
        'error'   		    => 'No models were selected, so nothing was deleted.',
        'success' 		    => ':success_count model(s) deleted!',
        'success_partial' 	=> ':success_count model(s) were deleted, however :fail_count were unable to be deleted because they still have assets associated with them.'
    ),

);

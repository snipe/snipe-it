<?php

return array(

    'does_not_exist' => 'ابزار/وسیله [:id] وجود ندارد.',
    'not_found' => 'That accessory was not found.',
    'assoc_users'	 => 'این وسیله هم اکنون:آیتم های چک شده به کاربران را حساب کنید.لطفا در لوازم جانبی چک کنید و دوباره امتحان کنید',

    'create' => array(
        'error'   => 'وسیله ایجاد نشد.لطفا دوباره امتحان کنید.',
        'success' => 'وسیله با موفقیت ایجاد شد'
    ),

    'update' => array(
        'error'   => 'وسیله به روزرسانی نشد لطفا دوباره امتحان کنید',
        'success' => 'وسیله با موفقیت به روزرسانی شد.'
    ),

    'delete' => array(
        'confirm'   => 'آیا مطمئن هستید می خواهید این وسیله حذف شود?',
        'error'   => 'اشکال در حذف دسته بندی.لطفا دوباره امتحان کنید.',
        'success' => 'دسته بندی با موفقیت حذف شد.'
    ),

     'checkout' => array(
        'error'   		=> 'وسیله چک نشده بود. لطفا دوباره امتحان کنید',
        'success' 		=> 'وسیله با موفقیت چک شد.',
        'unavailable'   => 'Accessory is not available for checkout. Check quantity available',
        'user_does_not_exist' => 'کاربر نامعتبر است. لطفا دوباره امتحان کنید.',
         'checkout_qty' => array(
            'lte'  => 'There is currently only one available accessory of this type, and you are trying to check out :checkout_qty. Please adjust the checkout quantity or the total stock of this accessory and try again.|There are :number_currently_remaining total available accessories, and you are trying to check out :checkout_qty. Please adjust the checkout quantity or the total stock of this accessory and try again.',
            ),
           
    ),

    'checkin' => array(
        'error'   		=> 'وسیله چک نشده.لطفا دوباره امتحان کنید',
        'success' 		=> 'وسیله با موفقیت چک شد.',
        'user_does_not_exist' => 'کاربر نامعتبر است لطفا دوباره امتحان کنید.'
    )


);

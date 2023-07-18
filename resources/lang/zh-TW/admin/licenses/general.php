<?php

return array(
    'about_licenses_title'      => '關於授權',
    'about_licenses'            => '授權是用來追踨可供借出的軟體數量。',
    'checkin'  					=> '繳回授權數量',
    'checkout_history'  		=> '借出歷史記錄',
    'checkout'  				=> '借出授權數量',
    'edit'  					=> '編輯授權',
    'filetype_info'				=> '允許檔案類型：png, gif, jpg, jpeg, doc, docx, pdf, txt, zip, rar。',
    'clone'  					=> '複製授權',
    'history_for'  				=> '歷史記錄',
    'in_out'  					=> '進/出',
    'info'  					=> '授權訊息',
    'license_seats'  			=> '授權數量',
    'seat'  					=> '數量',
    'seats'  					=> '數量',
    'software_licenses'  		=> '軟體授權',
    'user'  					=> '使用者
',
    'view'  					=> '檢視授權',
    'delete_disabled'           => 'This license cannot be deleted yet because some seats are still checked out.',
    'bulk'                      =>
        [
            'checkin_all'           => [
                'button'            => 'Checkin All Seats',
                'modal'             => 'This will action checkin one seat. | This action will checkin all :checkedout_seats_count seats for this license.',
                'enabled_tooltip'   => 'Checkin ALL seats for this license from both users and assets',
                'disabled_tooltip'  => 'This is disabled because there are no seats currently checked out',
                'success'           => 'License successfully checked in! | All licenses were successfully checked in!',
                'log_msg'           => 'Checked in via bulk license checkout in license GUI',
            ],

            'checkout_all'              => [
                'button'                => '借出所有座位',
                'modal'                 => 'This action will checkout one seat to the first available user. | This action will checkout all :available_seats_count seats to the first available users. A user is considered available for this seat if they do not already have this license checked out to them, and the Auto-Assign License property is enabled on their user account.',
                'enabled_tooltip'   => 'Checkout ALL seats (or as many as are available) to ALL users',
                'disabled_tooltip'  => 'This is disabled because there are no seats currently available',
                'success'           => '執照成功借出! | :count 份執照成功被借出!',
                'error_no_seats'    => 'There are no remaining seats left for this license.',
                'warn_not_enough_seats'    => ':count users were assigned this license, but we ran out of available license seats.',
                'warn_no_avail_users'    => '無需任何操作. 所有使用者皆已分配此執照.',
                'log_msg'           => '透過圖形化介面的執照大量借出功能借出執照.',


            ],
    ],
);

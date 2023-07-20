<?php

return array(
    'about_licenses_title'      => '关于许可证',
    'about_licenses'            => '许可证用于跟踪软件。 它们包含特殊位数的数字，可以借出给个人。',
    'checkin'  					=> '接入许可证数量',
    'checkout_history'  		=> '借出历史记录',
    'checkout'  				=> '借出许可证数量',
    'edit'  					=> '编辑许可证',
    'filetype_info'				=> '允许的文件类型有： png, gif, jpg, jpeg, doc, docx, pdf, txt, zip, rar',
    'clone'  					=> '克隆许可证',
    'history_for'  				=> '历史记录',
    'in_out'  					=> '进/出',
    'info'  					=> '授权信息',
    'license_seats'  			=> '授权数量',
    'seat'  					=> '次数',
    'seats'  					=> '允许使用次数',
    'software_licenses'  		=> '软件许可证',
    'user'  					=> '用户',
    'view'  					=> '查看许可证',
    'delete_disabled'           => '此许可证不能被删除，因为有些席位仍然被借出。',
    'bulk'                      =>
        [
            'checkin_all'           => [
                'button'            => '归还所有席位',
                'modal'             => '此操作将归还一个席位。| 此操作将归还此许可证的所有 :checkedout_seas_count 个座位。',
                'enabled_tooltip'   => '从用户和资产中归还此许可证的所有席位',
                'disabled_tooltip'  => '此功能已禁用，因为当前没有借出的席位',
                'success'           => '许可证归还成功！| 所有许可证都已归还成功！',
                'log_msg'           => 'Checked in via bulk license checkout in license GUI',
            ],

            'checkout_all'              => [
                'button'                => '借出所有席位',
                'modal'                 => '此操作将借出一个席位给第一个可用的用户。| 此操作将借出所有 :available _seas_count 个席位给第一个可用的用户。 如果此许可证尚未借出给用户，并且在该用户账户上启用了“自动分配许可证”属性，则认定该用户可以使用此席位。',
                'enabled_tooltip'   => '向所有用户借出所有（或尽可能多）的席位',
                'disabled_tooltip'  => '此功能已禁用，因为当前没有可用的席位',
                'success'           => '许可证成功借出！ | :count 个许可证成功借出！',
                'error_no_seats'    => '此许可证已无剩余席位。',
                'warn_not_enough_seats'    => ':count 个用户被分配了此许可证，但我们没有可用的许可证席位。',
                'warn_no_avail_users'    => '没有什么要做的。没有尚未分配此许可证的用户。',
                'log_msg'           => 'Checked out via bulk license checkout in license GUI',


            ],
    ],
);

<?php

return [
    'about_licenses_title' => '라이선스 란',
    'about_licenses' => '라이선스는 소프트웨어를 추적하는데 사용됩니다. 개인에게 반출 할 수 있는 수량이 정의되어 있습니다',
    'checkin' => '라이선스 Seat 확인',
    'checkout_history' => '반출 이력',
    'checkout' => '반출 라이선스 Seat',
    'edit' => '라이선스 편집',
    'filetype_info' => '허용되는 형식들은 png, gif, jpeg, doc, docx, pdf, txt, zip, rar 입니다.',
    'clone' => '라이선스 복제',
    'history_for' => '이력 ',
    'in_out' => '입/출',
    'info' => '라이선스 정보',
    'license_seats' => '라이선스 Seats',
    'seat' => 'Seat',
    'seat_count' => '시트 :count',
    'seats' => 'Seats',
    'software_licenses' => '소프트웨어 라이선스',
    'user' => '사용자',
    'view' => '라이선스 보기',
    'delete_disabled' => '일부 좌석이 아직 반출 중이므로 이 라이선스는 아직 삭제할 수 없습니다.',
    'bulk' => [
        'checkin_all' => [
            'button' => '모든 좌석 반입',
            'modal' => '이 작업은 시트 하나를 반입합니다. | 이 작업은 이 라이선스의 모든 :checkedout_seats_count개 시트를 반입합니다.',
            'enabled_tooltip' => '이 라이선스의 모든 좌석을 사용자와 자산 양쪽에서 반입',
            'disabled_tooltip' => '현재 반출된 좌석이 없어 비활성화됨',
            'disabled_tooltip_reassignable' => '라이선스를 재할당할 수 없어 비활성화됨',
            'success' => '라이선스가 성공적으로 반입되었습니다! | 모든 라이선스가 성공적으로 반입되었습니다!',
            'log_msg' => '라이선스 GUI에서 일괄 라이선스 반입으로 반입됨',
        ],

        'checkin_selected' => [
            'success' => ':count개 시트가 성공적으로 반입됨. | :count개 시트가 성공적으로 반입됨.',
            'no_seats_selected' => '선택된 시트가 없습니다.',
        ],

        'checkout_all' => [
            'button' => '모든 좌석 반출',
            'modal' => '이 작업은 첫 번째 사용 가능한 사용자에게 좌석 하나를 반출합니다. | 이 작업은 :available_seats_count개의 모든 좌석을 첫 번째 사용 가능한 사용자들에게 반출합니다. 사용자가 이미 이 라이선스를 반출받지 않았고 사용자 계정에 라이선스 자동 할당 속성이 활성화된 경우 해당 좌석에 사용 가능한 것으로 간주됩니다.',
            'enabled_tooltip' => '모든 좌석(또는 사용 가능한 만큼)을 모든 사용자에게 반출',
            'disabled_tooltip' => '현재 사용 가능한 좌석이 없어 비활성화됨',
            'success' => '라이선스가 성공적으로 반출되었습니다! | :count개의 라이선스가 성공적으로 반출되었습니다!',
            'error_no_seats' => '이 라이선스에 남은 좌석이 없습니다.',
            'warn_not_enough_seats' => ':count명의 사용자에게 이 라이선스가 할당되었으나 사용 가능한 라이선스 좌석이 부족합니다.',
            'warn_no_avail_users' => '수행할 작업이 없습니다. 이 라이선스가 아직 할당되지 않은 사용자가 없습니다.',
            'log_msg' => '라이선스 GUI의 일괄 라이선스 반출을 통해 반출됨',

        ],

        'delete_with_checkin' => [
            'label' => 'Check in seats and delete',
            'log_msg' => 'Checked in via bulk delete-with-checkin in license index',
        ],
    ],

    'below_threshold' => '이 라이선스의 남은 시트가 :remaining_count개뿐이며 최소 수량은 :min_amt개입니다. 시트를 추가 구매하는 것을 고려하세요.',
    'below_threshold_short' => '이 항목이 최소 필요 수량 미만입니다.',
];

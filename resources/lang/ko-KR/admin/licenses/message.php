<?php

return [

    'does_not_exist' => '라이선스가 존재하지 않거나 조회 권한이 없습니다.',
    'user_does_not_exist' => '사용자가 존재하지 않거나 조회 권한이 없습니다.',
    'asset_does_not_exist' => '이 라이선스와 연결하려는 자산이 존재하지 않습니다.',
    'owner_doesnt_match_asset' => '이 라이센스와 연결하려고하는 자산은 드롭 다운 목록에서 선택한 사람이 아닌 다른 누군가가 소유하고 있습니다.',
    'assoc_users' => '이 자산은 현재 사용자에게 반출 중이어서 삭제 할 수 없습니다. 먼저 자산을 확인해 보고 다시 삭제를 시도해 주세요. ',
    'select_asset_or_person' => '애셋이나 사용자 중 하나만 선택해야하며 둘 다 선택할 수는 없습니다.',
    'not_found' => '라이센스를 찾을 수 없음',
    'seats_available' => ':seat_count개의 시트 사용 가능',

    'create' => [
        'error' => '라이선스가 생성되지 않았습니다. 다시 시도해 주세요.',
        'success' => '라이선스가 생성되었습니다.',
    ],

    'deletefile' => [
        'error' => '파일이 삭제되지 않았습니다. 다시 시도해 주세요.',
        'success' => '파일이 삭제되었습니다.',
    ],

    'upload' => [
        'error' => '파일(들)이 업로드 되지 않았습니다. 다시 시도해 주세요.',
        'success' => '파일(들)이 업로드 되었습니다.',
        'nofiles' => '업로드 하기 위한 파일이 선택되지 않았거나, 업로드 할 파일이 너무 큽니다.',
        'invalidfiles' => '하나 이상의 파일이 너무 크거나 허용되지 않는 형식입니다. 허용되는 형식은 png, gif, jpg, jpeg, doc, docx, pdf, txt, zip, rar, rtf, xml, lic 입니다.',
    ],

    'update' => [
        'error' => '라이선스가 갱신되지 않았습니다. 다시 시도해 주세요.',
        'success' => '라이선스가 갱신되었습니다.',
    ],

    'delete' => [
        'confirm' => '이 라이선스를 삭제하시겠습니까?',
        'error' => '라이선스 삭제 중 문제가 발생했습니다. 다시 시도해 주세요.',
        'success' => '라이선스가 삭제되었습니다.',
        'bulk_success' => '선택한 라이선스가 성공적으로 삭제되었습니다.',
        'partial_success' => '라이선스가 성공적으로 삭제되었습니다. 아래 추가 정보를 확인하세요. | :count개의 라이선스가 성공적으로 삭제되었습니다. 아래 추가 정보를 확인하세요.',
        'bulk_checkout_warning' => ':license_name에 현재 반출된 시트가 있어 삭제할 수 없습니다. 삭제하기 전에 모든 시트를 반입하세요.',
    ],

    'delete_with_checkin' => [
        'bulk_success' => ':count licenses were deleted successfully after checking in :seats seats.',
        'partial_success' => ':count licenses were deleted successfully after checking in :seats seats. See additional information below.',
    ],

    'checkout' => [
        'error' => '라이선스 반출 중 문제가 발생했습니다. 다시 시도해 주세요.',
        'success' => '라이선스가 반출 되었습니다.',
        'not_enough_seats' => '반출에 사용할 수 있는 라이선스 시트가 부족합니다',
        'mismatch' => '제공된 라이선스 시트가 라이선스와 일치하지 않습니다',
        'unavailable' => '이 시트는 반출할 수 없습니다.',
        'license_is_inactive' => '이 라이선스는 만료되었거나 해지되었습니다.',
    ],

    'checkin' => [
        'error' => '라이선스 반입 중 문제가 발생했습니다. 다시 시도해 주세요.',
        'not_reassignable' => '시트가 이미 사용되었습니다',
        'success' => '라이선스가 반입 되었습니다.',
    ],

    'import' => [
        'no_free_seats' => 'License ":license" has no free seats. ":target" was not assigned to a seat.',
    ],

];

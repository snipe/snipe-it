<?php

return [

    'does_not_exist' => '부품이 존재하지 않습니다.',

    'create' => [
        'error' => '부품이 생성되지 않았습니다. 다시 시도해 주세요.',
        'success' => '부품이 생성되었습니다.',
    ],

    'update' => [
        'error' => '부품이 갱신되지 않았습니다. 다시 시도해 주세요.',
        'success' => '부품이 갱신 되었습니다.',
    ],

    'delete' => [
        'confirm' => '이 부품을 삭제하시겠습니까?',
        'error' => '부품 삭제시 문제가 발생했습니다. 다시 시도해 주세요.',
        'success' => '부품이 삭제되었습니다.',
        'error_qty' => '이 유형의 일부 부품이 여전히 반출되어 있습니다. 반입 후 다시 시도하세요.',
    ],

    'checkout' => [
        'error' => '부품이 반출되지 않았습니다. 다시 시도해 주세요.',
        'success' => '부품이 반출 되었습니다.',
        'user_does_not_exist' => '잘못된 사용자 입니다. 다시 시도해 주세요.',
        'unavailable' => '남은 부품 부족: :remaining 개 남음, :requested 개 요청됨',
    ],

    'checkin' => [
        'error' => '부품이 반입되지 않았습니다. 다시 시도해 주세요.',
        'success' => '부품이 반입되었습니다.',
        'user_does_not_exist' => '잘못된 사용자 입니다. 다시 시도해 주세요.',
    ],

];

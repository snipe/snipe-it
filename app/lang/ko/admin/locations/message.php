<?php

return array(

    'does_not_exist' => '장소가 존재하지 않습니다.',
    'assoc_users'	 => '이 장소는 현재 적어도 한명의 사용자와 연결되어 있어서 삭제할 수 없습니다. 사용자가 더 이상 이 장소를 참조하지 않게 갱신하고 다시 시도해주세요. ',
    'assoc_assets'	 => 'This location is currently associated with at least one asset and cannot be deleted. Please update your assets to no longer reference this location and try again. ',
    'assoc_child_loc'	 => 'This location is currently the parent of at least one child location and cannot be deleted. Please update your locations to no longer reference this location and try again. ',


    'create' => array(
        'error'   => '장소가 생성되지 않았습니다. 다시 시도해 주세요.',
        'success' => '장소가 생성되었습니다.'
    ),

    'update' => array(
        'error'   => '장소가 갱신되지 않았습니다. 다시 시도해 주세요.',
        'success' => '장소가 갱신되었습니다.'
    ),

    'delete' => array(
        'confirm'   	=> '이 장소를 삭제하시겠습니까?',
        'error'   => '장소 삭제 중에 문제가 발생했습니다. 다시 시도해 주세요.',
        'success' => '장소가 삭제되었습니다.'
    )

);

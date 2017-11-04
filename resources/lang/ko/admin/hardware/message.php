<?php

return array(

    'undeployable' 		=> '<strong>경고: </strong> 이 자산은 현재 사용불가 상태입니다.
                        이 상태를 변경하시려면, 자산 상태를 갱신하세요.',
    'does_not_exist' 	=> '자산이 존재하지 않습니다.',
    'does_not_exist_or_not_requestable' => '좋은 시도지만, 그 자산은 존재하지 않거나 요청가능하지 않습니다.',
    'assoc_users'	 	=> '이 자산은 현재 사용자에게 반출 중이어서 삭제 할 수 없습니다. 먼저 자산을 확인해 보고 다시 삭제를 시도해 주세요. ',

    'create' => array(
        'error'   		=> '자산이 생성되지 않았습니다. 다시 시도해 주세요. :(',
        'success' 		=> '자산이 생성되었습니다. :)'
    ),

    'update' => array(
        'error'   			=> '자산이 갱신되지 않았습니다. 다시 시도해 주세요.',
        'success' 			=> '자산이 갱신되었습니다.',
        'nothing_updated'	=>  '선택된 항목이 없어서, 갱신 되지 않습니다.',
    ),

    'restore' => array(
        'error'   		=> '자산이 복원되지 않았습니다. 다시 시도해 주세요.',
        'success' 		=> '자산이 복원되었습니다.'
    ),

    'audit' => array(
        'error'   		=> '자산 감사가 실패했습니다. 다시 시도해 주세요.',
        'success' 		=> '자산 감사가 성공적으로 기록되었습니다.'
    ),


    'deletefile' => array(
        'error'   => '파일이 삭제되지 않았습니다. 다시 시도해 주세요.',
        'success' => '파일이 삭제되었습니다.',
    ),

    'upload' => array(
        'error'   => '파일(들)이 업로드 되지 않았습니다. 다시 시도해 주세요.',
        'success' => '파일(들)이 업로드 되었습니다.',
        'nofiles' => '업로드 하기 위한 파일이 선택되지 않았거나, 업로드 할 파일이 너무 큽니다.',
        'invalidfiles' => '하나 이상의 파일이 너무 크거나 허용되지 않는  형식입니다. 허용되는 형식은 png, gif, jpg, doc, docx, pdf, txt 입니다.',
    ),

    'import' => array(
        'error'                 => '몇몇 품목들을 정확하게 읽어오지 못했습니다.',
        'errorDetail'           => '다음 품목들은 오류로 읽어오지 못했습니다.',
        'success'               => "파일에서 읽어오기가 완료되었습니다",
        'file_delete_success'   => "파일 삭제가 완료되었습니다",
        'file_delete_error'      => "파일을 삭제할 수 없습니다",
    ),


    'delete' => array(
        'confirm'   	=> '이 자산을 삭제하시겠습니까?',
        'error'   		=> '그룹을 삭제하는 중 문제가 발생했습니다. 다시 시도해 주세요.',
        'nothing_updated'   => '선택된 자산이 없기에, 삭제되지 않습니다.',
        'success' 		=> '자산이 삭제되었습니다.'
    ),

    'checkout' => array(
        'error'   		=> '자산이 반출되지 않았습니다. 다시 시도해 주세요.',
        'success' 		=> '자산이 반출되었습니다.',
        'user_does_not_exist' => '잘못된 사용자 입니다. 다시 시도해 주세요.',
        'not_available' => '그 자산은 반출 할 수 없습니다!',
        'no_assets_selected' => 'You must select at least one asset from the list'
    ),

    'checkin' => array(
        'error'   		=> '자산이 반입되지 않았습니다. 다시 시도해 주세요.',
        'success' 		=> '자산이 반입되었습니다.',
        'user_does_not_exist' => '잘못된 사용자 입니다. 다시 시도해 주세요.',
        'already_checked_in'  => '그 자산은 이미 반입되었습니다.',

    ),

    'requests' => array(
        'error'   		=> '자산을 불러오지 못했습니다. 재시도해 주십시오.',
        'success' 		=> '자산을 불러왔습니다.',
        'canceled'      => '반출 요청이 취소되었습니다'
    )

);

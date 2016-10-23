<?php

return array(

    'accepted'                  => '이 자산이 승인되었습니다.',
    'declined'                  => '이 자산이 거부되었습니다.',
    'user_exists'               => '사용자가 이미 존재합니다!',
    'user_not_found'            => '사용자 [:id]는 존재하지 않습니다.',
    'user_login_required'       => '로그인 항목을 입력해 주세요.',
    'user_password_required'    => '비밀번호를 입력해 주세요.',
    'insufficient_permissions'  => '승인 불충분.',
    'user_deleted_warning'      => '이 사용자는 삭제되었습니다. 그것들을 수정하려면 이 사용자를 복원하던가 새 자산들을 생성하세요.',
    'ldap_not_configured'        => '이 설치의 LDAP 통합이 구성이 되지 않았습니다.',


    'success' => array(
        'create'    => '사용자가 생성되었습니다.',
        'update'    => '사용자가 갱신 되었습니다.',
        'delete'    => '사용자가 삭제 되었습니다.',
        'ban'       => '사용자가 금지 처리 되었습니다.',
        'unban'     => '사용자의 금지 처리가 해제 되었습니다.',
        'suspend'   => '사용자를 대기 시켰습니다.',
        'unsuspend' => '사용자의 대기를 해제하였습니다.',
        'restored'  => '사용자를 복원하였습니다.',
        'import'    => '사용자를 내보냈습니다.',
    ),

    'error' => array(
        'create' => '사용자를 생성하는 중 문제가 발생했습니다. 다시 시도해 주세요.',
        'update' => '사용자를 갱신하는 중 오류가 발생했습니다. 다시 시도해 주세요.',
        'delete' => '사용자를 삭제하는 중 문제가 발생했습니다. 다시 시도해 주세요.',
        'unsuspend' => '사용자의 대기 해제 중 문제가 발생했습니다. 다시 시도하세요.',
        'import'    => '사용자를 내보내기 할 때 문제가 발생했습니다. 다시 시도하세요.',
        'asset_already_accepted' => '이 자산은 이미 수락되었습니다.',
        'accept_or_decline' => '이 자산을 승인 하거나 거부 하셔야 합니다.',
        'incorrect_user_accepted' => '승인하려는 자산이 체크아웃되지 않았습니다.',
        'ldap_could_not_connect' => 'LDAP 서버에 접속 할 수 없습니다. LDAP 설정 파일의 LDAP 서버 구성을 확인해 보세요.<br>LDAP 서버 오류:',
        'ldap_could_not_bind' => 'LDAP 서버와 동기화 할 수 없습니다. LDAP 설정 파일의 LDAP 서버 구성을 확인해 보세요.<br>LDAP 서버 오류: ',
        'ldap_could_not_search' => 'LDAP 서버를 찾을 수 없습니다. LDAP 설정 파일의 LDAP 서버 구성을 확인해 보세요.<br>LDAP 서버 오류:',
        'ldap_could_not_get_entries' => 'LDAP 서버 목록을 가져올 수 없습니다. LDAP 설정 파일의 LDAP 서버 구성을 확인해 보세요.<br>LDAP 서버 오류:',
    ),

    'deletefile' => array(
        'error'   => '파일이 삭제되지 않았습니다. 다시 시도해 주세요.',
        'success' => '파일이 삭제되었습니다.',
    ),

    'upload' => array(
        'error'   => '파일(들) 이 업로드 되지 않았습니다. 다시 시도해 주세요.',
        'success' => '파일(들) 이 업로드 되었습니다.',
        'nofiles' => '업로드 할 파일을 선택해 주세요',
        'invalidfiles' => '하나 이상의 파일이 너무 크거나 허용되지 않는 형식입니다. 허용되는 형식은 png, gif, jpg, doc, docx, pdf, txt 입니다.',
    ),

);

<?php

return [
    'exception_message' => '예외 메시지: :message',
    'exception_trace' => '예외 추적: :trace',
    'exception_message_title' => '예외 메시지',
    'exception_trace_title' => '예외 추적',

    'backup_failed_subject' => ':application_name 백업 실패',
    'backup_failed_body' => '중요: :application_name 백업 중 오류 발생',

    'backup_successful_subject' => ':application_name 백업 성공',
    'backup_successful_subject_title' => '백업이 성공적으로 완료되었습니다!',
    'backup_successful_body' => '좋은 소식입니다. :disk_name 디스크에 :application_name 백업이 성공적으로 완료되었습니다.',

    'cleanup_failed_subject' => ':application_name 백업 정리 실패',
    'cleanup_failed_body' => ':application_name 백업 정리 중 오류 발생',

    'cleanup_successful_subject' => ':application_name 백업 정리 성공',
    'cleanup_successful_subject_title' => '백업 정리가 성공적으로 완료되었습니다!',
    'cleanup_successful_body' => ':disk_name 디스크에 저장된 :application_name 백업 정리가 성공적으로 완료되었습니다.',

    'healthy_backup_found_subject' => ':application_name 백업은 정상입니다.',
    'healthy_backup_found_subject_title' => ':application_name 백업은 정상입니다.',
    'healthy_backup_found_body' => ':application_name 백업은 정상입니다. 수고하셨습니다!',

    'unhealthy_backup_found_subject' => '중요: :application_name 백업에 문제가 있습니다.',
    'unhealthy_backup_found_subject_title' => '중요: :application_name 백업에 문제가 있습니다. :problem',
    'unhealthy_backup_found_body' => ':disk_name 디스크에 :application_name 백업에 문제가 있습니다.',
    'unhealthy_backup_found_not_reachable' => '백업 위치에 액세스할 수 없습니다. :error',
    'unhealthy_backup_found_empty' => '이 애플리케이션에는 백업이 없습니다.',
    'unhealthy_backup_found_old' => ':date에 저장된 최신 백업이 너무 오래되었습니다.',
    'unhealthy_backup_found_unknown' => '죄송합니다. 예기치 않은 오류가 발생했습니다.',
    'unhealthy_backup_found_full' => '백업이 디스크 공간을 다 차지하고 있습니다. 현재 사용량 :disk_usage는 허용 한도 :disk_limit을 초과합니다.',

    'no_backups_info' => '아직 백업이 생성되지 않았습니다.',
    'application_name' => '애플리케이션 이름',
    'backup_name' => '백업 이름',
    'disk' => '디스크',
    'newest_backup_size' => '최신 백업 크기',
    'number_of_backups' => '백업 수',
    'total_storage_used' => '총 사용 스토리지',
    'newest_backup_date' => '최신 백업 날짜',
    'oldest_backup_date' => '가장 오래된 백업 날짜',
];

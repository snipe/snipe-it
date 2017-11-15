<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | such as the size rules. Feel free to tweak each of these messages.
    |
    */

    'accepted'             => ':attribute 가 수락되었습니다.',
    'active_url'           => ':attribute 는 잘못된 URL 입니다.',
    'after'                => ':attribute 는 :date 뒤에 오는 날짜 형식이어야 합니다.',
    'after_or_equal'       => ':attribute 는 :date 이후거나 같아야 합니다.',
    'alpha'                => ':attribute 는 문자만 포함해야 합니다.',
    'alpha_dash'           => ':attribute는 문자, 숫자, 대쉬기호만 포함 할 수 있습니다.',
    'alpha_num'            => ':attribute 는 문자와 숫자만 포함할 수 있습니다.',
    'array'                => ':attribute는 배열이어야 합니다.',
    'before'               => ':attribute 는 :date 앞의 날짜 형식이 되야 합니다.',
    'before_or_equal'      => ':attribute 는 :date 이전이거나 같아야 합니다.',
    'between'              => [
        'numeric' => ':attribute 는 :min - :max 사이의 값입니다.',
        'file'    => ':attribute 는 :min - :max Kbyte 사이의 값입니다.',
        'string'  => ':attribute 는 :min - :max 자 사이의 문자입니다.',
        'array'   => ':attribute 는 :min - :max 품목 사이여야 합니다.',
    ],
    'boolean'              => ':attribute 는 참 또는 거짓의 속성만 지정 가능합니다.',
    'confirmed'            => ':attribute 확인이 일치 하지 않습니다.',
    'date'                 => ':attribute 는 잘못된 날짜 입니다.',
    'date_format'          => ':attribute 는 :format 형식과 일치하지 않습니다.',
    'different'            => ':attribute 와 :other 는 서로 달라야 합니다.',
    'digits'               => ':attribute 는 :digits 자리수여야 합니다.',
    'digits_between'       => ':attribute 는 :min - :max 자릿수 사이여야 합니다.',
    'dimensions'           => ':attribute에 잘못된 이미지 크기가 있습니다.',
    'distinct'             => ':attribute 항목은 중복된 값입니다.',
    'email'                => ':attribute 형식이 부정확 합니다.',
    'exists'               => '선택한 :attribute 가 부정확 합니다.',
    'file'                 => ':attribute는 파일이어야 합니다.',
    'filled'               => ':attribute 항목은 값이 있어야 합니다.',
    'image'                => ':attribute 는 이미지 형식만 가능합니다.',
    'in'                   => '선택한 :attribute 가 부정확 합니다.',
    'in_array'             => ':attribute항목이 :other에 없습니다.',
    'integer'              => ':attribute 는 정수이어야 합니다.',
    'ip'                   => ':attribute 는 유효한 IP 주소이어야 합니다.',
    'ipv4'                 => ':attribute는 유효한 IPv4 주소여야 합니다.',
    'ipv6'                 => ':attribute는 유효한 IPv6 주소여야 합니다.',
    'json'                 => ':attribute는 유효한 JSON 문자값이어야 합니다.',
    'max'                  => [
        'numeric' => ':attribute 는 :max 보다 작아야 합니다.',
        'file'    => ':attribute 는 :max Kbyte보다 작아야 합니다.',
        'string'  => ':attribute 는 :max 자보다 작아야 합니다.',
        'array'   => ':attribute는 :max 항목보다 작어야 합니다.',
    ],
    'mimes'                => ':attribute 는 :values 형식의 파일만 가능합니다.',
    'mimetypes'            => ':attribute 는 :values 형식의 파일만 가능합니다.',
    'min'                  => [
        'numeric' => ':attribute 는 최소 :min 이어야 합니다.',
        'file'    => ':attribute 는 최소 :min Kbyte 이어야 합니다.',
        'string'  => ':attribute 는 최소 :min 자 이어야 합니다.',
        'array'   => ':attribute는 최소 :min 항목이어야 합니다.',
    ],
    'not_in'               => '선택한 :attribute 가 부정확 합니다.',
    'numeric'              => ':attribute 는 숫자만 가능합니다.',
    'present'              => ':attribute 항목이 있어야 합니다.',
    'valid_regex'          => 'That is not a valid regex. ',
    'regex'                => ':attribute 형식이 부정확 합니다.',
    'required'             => ':attribute 항목을 입력해 주세요.',
    'required_if'          => ':attribute 항목은 :other가 :value 일때 필요합니다.',
    'required_unless'      => ':values에 :other가 있는 경우 : attribute 항목은 필요하지 않습니다.',
    'required_with'        => ':attribute 항목은 :values 가 존재할 때 필요합니다.',
    'required_with_all'    => ':attribute 항목은 :values가 있을 때 필요합니다.',
    'required_without'     => ':attribute 항목은 :values 가 존재하지 않을 때 필요합니다.',
    'required_without_all' => ':attribute 항목은 :values 가 전혀 없다면 필수입니다.',
    'same'                 => ':attribute 와 :other 는 일치해야 합니다.',
    'size'                 => [
        'numeric' => ':attribute 는 :size 가 되야 합니다.',
        'file'    => ':attribute 는 :size Kbyte 가 되야 합니다.',
        'string'  => ':attribute 는 :size 자가 되야 합니다.',
        'array'   => ':attribute 는 :size 품목에 포함되야 합니다.',
    ],
    'string'               => ':attribute는 글자여야 합니다.',
    'timezone'             => ':attribute는 유효한 지역이어야 합니다.',
    'unique'               => ':attribute 는 이미 획득하였습니다.',
    'uploaded'             => ':attribute는 업로드 하지 못했습니다.',
    'url'                  => ':attribute 형식이 부정확 합니다.',
    "unique_undeleted"     => "The :attribute must be unique.",

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */


    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'alpha_space' => ":attribute 항목에는 문자를 입력할 수 없습니다.",
        "email_array"      => "하나 이상의 이메일 주소가 유효하지 않습니다.",
        "hashed_pass"      => "현재 비밀번호가 잘못되었습니다.",
        'dumbpwd'          => '그 비밀번호는 너무 일반적입니다.',
        "statuslabel_type" => "유효한 상태 라벨 형식을 선택해 주셔야 합니다",
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

);

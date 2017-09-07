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

    'accepted'             => ':attribute phải được chấp nhận.',
    'active_url'           => ':attribute thì không phải URL hợp lệ.',
    'after'                => ':attribute phải có ngày sau ngày :date.',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => ':attribute có thể chỉ chứa chữ.',
    'alpha_dash'           => ':attribute có thể chỉ chứa chữ, số và dấu phẩy.',
    'alpha_num'            => ':attribute có thể chỉ chứa chữ và số.',
    'array'                => 'The :attribute must be an array.',
    'before'               => ':attribute phải có ngày trước ngày :date.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => ':attribute phải nằm giữa :min - :max.',
        'file'    => ':attribute phải nằm giữa :min - :max kilobytes.',
        'string'  => ':attribute phải nằm :min - :max ký tự.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
    'confirmed'            => ':attribute xác nhận không đúng.',
    'date'                 => ':attribute có ngày không hợp lý.',
    'date_format'          => ':attribute không phù hợp định dạng :format.',
    'different'            => ':attribute và :other phải khác nhau.',
    'digits'               => ':attribute phải có :digits số.',
    'digits_between'       => ':attribute phải ở giữa :min và :max số.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => 'Định dạng :attribute thì không phù hợp.',
    'exists'               => ':attribute đã chọn không phù hợp.',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field must have a value.',
    'image'                => ':attribute phải là một hình.',
    'in'                   => ':attribute đã lựa chọn không hợp lý.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => ':attribute phải là một số nguyên.',
    'ip'                   => ':attribute phải là một địa chỉ IP.',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => ':attribute có thể không lớn hơn :max.',
        'file'    => ':attribute có thể không lớn hơn :max kilobytes.',
        'string'  => ':attribute có thể không lớn hơn :max ký tự.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => ':attribute phải là một tập tin có phần mở rộng là: :values.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => ':attribute phải có ít nhất :min.',
        'file'    => ':attribute phải ít nhất :min kilobytes.',
        'string'  => ':attribute phải ít nhất :min ký tự.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => ':attribute đã chọn không hợp lý.',
    'numeric'              => ':attribute phải là một số.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'Định dạng :attribute thì không hợp lý.',
    'required'             => 'Trường :attribute thì bắt buộc.',
    'required_if'          => 'Trường :attribute thì bắt buộc khi :other là :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'Trường :attribute thì bắt buộc khi :values là hiện hành.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'Trường :attribute thì bắt buộc khi :values không hiện hành.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => ':attribute và :other phải giống nhau.',
    'size'                 => [
        'numeric' => ':attribute phải có cỡ :size.',
        'file'    => ':attribute phải có cỡ :size kilobytes.',
        'string'  => ':attribute phải có :size ký tự.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => ':attribute đã sẵn sàng.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'Định dạng :attribute thì không hợp lý.',

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
        'alpha_space' => "The :attribute field contains a character that is not allowed.",
        "email_array"      => "One or more email addresses is invalid.",
        "hashed_pass"      => "Your current password is incorrect",
        'dumbpwd'          => 'That password is too common.',
        "statuslabel_type" => "You must select a valid status label type",
        "unique_undeleted" => "The :attribute must be unique.",
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

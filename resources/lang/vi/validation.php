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
    'after_or_equal'       => 'Thuộc tính: phải là một ngày sau hoặc bằng: date.',
    'alpha'                => ':attribute có thể chỉ chứa chữ.',
    'alpha_dash'           => ':attribute có thể chỉ chứa chữ, số và dấu phẩy.',
    'alpha_num'            => ':attribute có thể chỉ chứa chữ và số.',
    'array'                => 'Thuộc tính: phải là một mảng.',
    'before'               => ':attribute phải có ngày trước ngày :date.',
    'before_or_equal'      => 'Thuộc tính: phải là ngày trước hoặc bằng: ngày.',
    'between'              => [
        'numeric' => ':attribute phải nằm giữa :min - :max.',
        'file'    => ':attribute phải nằm giữa :min - :max kilobytes.',
        'string'  => ':attribute phải nằm :min - :max ký tự.',
        'array'   => 'Thuộc tính: phải có từ: min và: max items.',
    ],
    'boolean'              => 'Trường thuộc tính: phải là đúng hoặc sai.',
    'confirmed'            => ':attribute xác nhận không đúng.',
    'date'                 => ':attribute có ngày không hợp lý.',
    'date_format'          => ':attribute không phù hợp định dạng :format.',
    'different'            => ':attribute và :other phải khác nhau.',
    'digits'               => ':attribute phải có :digits số.',
    'digits_between'       => ':attribute phải ở giữa :min và :max số.',
    'dimensions'           => 'Thuộc tính: có kích thước hình ảnh không hợp lệ.',
    'distinct'             => 'Trường thuộc tính: có một giá trị trùng lặp.',
    'email'                => 'Định dạng :attribute thì không phù hợp.',
    'exists'               => ':attribute đã chọn không phù hợp.',
    'file'                 => 'Thuộc tính: phải là một tệp.',
    'filled'               => 'Trường: attribute phải có giá trị.',
    'image'                => ':attribute phải là một hình.',
    'in'                   => ':attribute đã lựa chọn không hợp lý.',
    'in_array'             => 'Trường thuộc tính: không tồn tại trong: other.',
    'integer'              => ':attribute phải là một số nguyên.',
    'ip'                   => ':attribute phải là một địa chỉ IP.',
    'ipv4'                 => 'Thuộc tính: phải là địa chỉ IPv4 hợp lệ',
    'ipv6'                 => 'Thuộc tính: phải là địa chỉ IPv6 hợp lệ',
    'json'                 => 'Thuộc tính: phải là một chuỗi JSON hợp lệ',
    'max'                  => [
        'numeric' => ':attribute có thể không lớn hơn :max.',
        'file'    => ':attribute có thể không lớn hơn :max kilobytes.',
        'string'  => ':attribute có thể không lớn hơn :max ký tự.',
        'array'   => 'Thuộc tính: không có nhiều hơn: các mục tối đa.',
    ],
    'mimes'                => ':attribute phải là một tập tin có phần mở rộng là: :values.',
    'mimetypes'            => 'Thuộc tính: phải là tệp kiểu:: values.',
    'min'                  => [
        'numeric' => ':attribute phải có ít nhất :min.',
        'file'    => ':attribute phải ít nhất :min kilobytes.',
        'string'  => ':attribute phải ít nhất :min ký tự.',
        'array'   => 'Thuộc tính: phải có ít nhất: min items.',
    ],
    'not_in'               => ':attribute đã chọn không hợp lý.',
    'numeric'              => ':attribute phải là một số.',
    'present'              => 'Trường thuộc tính: phải có mặt.',
    'valid_regex'          => 'That is not a valid regex. ',
    'regex'                => 'Định dạng :attribute thì không hợp lý.',
    'required'             => 'Trường :attribute thì bắt buộc.',
    'required_if'          => 'Trường :attribute thì bắt buộc khi :other là :value.',
    'required_unless'      => 'Trường thuộc tính: required required trừ khi: other is in: values.',
    'required_with'        => 'Trường :attribute thì bắt buộc khi :values là hiện hành.',
    'required_with_all'    => 'Lĩnh vực thuộc tính: được yêu cầu khi: các giá trị hiện diện.',
    'required_without'     => 'Trường :attribute thì bắt buộc khi :values không hiện hành.',
    'required_without_all' => 'Lĩnh vực thuộc tính: được yêu cầu khi không có: giá trị hiện diện.',
    'same'                 => ':attribute và :other phải giống nhau.',
    'size'                 => [
        'numeric' => ':attribute phải có cỡ :size.',
        'file'    => ':attribute phải có cỡ :size kilobytes.',
        'string'  => ':attribute phải có :size ký tự.',
        'array'   => 'Thuộc tính: phải chứa: các mục kích thước.',
    ],
    'string'               => 'Thuộc tính: phải là một chuỗi.',
    'timezone'             => 'Thuộc tính: phải là một vùng hợp lệ.',
    'unique'               => ':attribute đã sẵn sàng.',
    'uploaded'             => 'Thuộc tính: không thể tải lên.',
    'url'                  => 'Định dạng :attribute thì không hợp lý.',
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
        'alpha_space' => "Trường: attribute chứa một ký tự không được phép.",
        "email_array"      => "Một hoặc nhiều địa chỉ email không hợp lệ.",
        "hashed_pass"      => "Mật khẩu hiện tại của bạn không chính xác",
        'dumbpwd'          => 'Mật khẩu đó quá phổ biến.',
        "statuslabel_type" => "Bạn phải chọn một loại nhãn tình trạng hợp lệ",
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

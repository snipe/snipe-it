<?php

return [

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
    'import_field_empty'    => 'Giá trị của :fieldname không thể trống.',
    'in'                   => ':attribute đã lựa chọn không hợp lý.',
    'in_array'             => 'Trường thuộc tính: không tồn tại trong: other.',
    'integer'              => ':attribute phải là một số nguyên.',
    'ip'                   => ':attribute phải là một địa chỉ IP.',
    'ipv4'                 => 'Thuộc tính: phải là địa chỉ IPv4 hợp lệ',
    'ipv6'                 => 'Thuộc tính: phải là địa chỉ IPv6 hợp lệ',
    'is_unique_department' => 'Thuộc tính :attribute phải là duy nhất cho Địa điểm công ty này',
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
    'starts_with'          => 'Trường :attribute phải kết thúc bằng một trong những giá trị sau: :values',
    'ends_with'            => 'Thuộc tính :attribute phải kết thúc bằng một trong các giá trị sau: :values.',

    'not_in'               => ':attribute đã chọn không hợp lý.',
    'numeric'              => ':attribute phải là một số.',
    'present'              => 'Trường thuộc tính: phải có mặt.',
    'valid_regex'          => 'Đây không phải là một đơn hàng hợp lệ.',
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
    'two_column_unique_undeleted' => 'The :attribute must be unique across :table1 and :table2. ',
    'unique'               => ':attribute đã sẵn sàng.',
    'uploaded'             => 'Thuộc tính: không thể tải lên.',
    'url'                  => 'Định dạng :attribute thì không hợp lý.',
    'unique_undeleted'     => 'Thuộc tính: phải là duy nhất.',
    'non_circular'         => 'The :attribute must not create a circular reference.',
    'not_array'            => ':attribute cannot be an array.',
    'disallow_same_pwd_as_user_fields' => 'Mật khẩu không thể giống với tên người dùng.',
    'letters'              => 'Mật khẩu phải chứa ít nhất một chữ cái.',
    'numbers'              => 'Mật khẩu phải chứa ít nhất một chữ số.',
    'case_diff'            => 'Mật khẩu phải sử dụng chữ hoa chữ thường.',
    'symbols'              => 'Mật khẩu phải chứa các ký tự đặc biệt.',
    'gte'                  => [
        'numeric'          => 'Giá trị không thể âm'
    ],


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
        'alpha_space' => 'Trường: attribute chứa một ký tự không được phép.',
        'email_array'      => 'Một hoặc nhiều địa chỉ email không hợp lệ.',
        'hashed_pass'      => 'Mật khẩu hiện tại của bạn không chính xác',
        'dumbpwd'          => 'Mật khẩu đó quá phổ biến.',
        'statuslabel_type' => 'Bạn phải chọn một loại nhãn tình trạng hợp lệ',

        // date_format validation with slightly less stupid messages. It duplicates a lot, but it gets the job done :(
        // We use this because the default error message for date_format is reflects php Y-m-d, which non-PHP
        // people won't know how to format. 
        'purchase_date.date_format'     => ':attribute phải là ngày hợp lệ ở định dạng YYYY-MM-DD',
        'last_audit_date.date_format'   =>  ':attribute phải là ngày hợp lệ ở định dạng YYYY-MM-DD hh:mm:ss',
        'expiration_date.date_format'   =>  ':attribute phải là ngày hợp lệ ở định dạng YYYY-MM-DD',
        'termination_date.date_format'  =>  ':attribute phải là ngày hợp lệ ở định dạng YYYY-MM-DD',
        'expected_checkin.date_format'  =>  ':attribute phải là ngày hợp lệ ở định dạng YYYY-MM-DD',
        'start_date.date_format'        =>  ':attribute phải là ngày hợp lệ ở định dạng YYYY-MM-DD',
        'end_date.date_format'          =>  ':attribute phải là ngày hợp lệ ở định dạng YYYY-MM-DD',

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

];

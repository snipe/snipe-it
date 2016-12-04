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

    "accepted"         => ":attribute phải được chấp nhận.",
    "active_url"       => ":attribute thì không phải URL hợp lệ.",
    "after"            => ":attribute phải có ngày sau ngày :date.",
    "alpha"            => ":attribute có thể chỉ chứa chữ.",
    "alpha_dash"       => ":attribute có thể chỉ chứa chữ, số và dấu phẩy.",
    "alpha_num"        => ":attribute có thể chỉ chứa chữ và số.",
    "before"           => ":attribute phải có ngày trước ngày :date.",
    "between"          => array(
        "numeric" => ":attribute phải nằm giữa :min - :max.",
        "file"    => ":attribute phải nằm giữa :min - :max kilobytes.",
        "string"  => ":attribute phải nằm :min - :max ký tự.",
    ),
    "confirmed"        => ":attribute xác nhận không đúng.",
    "date"             => ":attribute có ngày không hợp lý.",
    "date_format"      => ":attribute không phù hợp định dạng :format.",
    "different"        => ":attribute và :other phải khác nhau.",
    "digits"           => ":attribute phải có :digits số.",
    "digits_between"   => ":attribute phải ở giữa :min và :max số.",
    "email"            => "Định dạng :attribute thì không phù hợp.",
    "exists"           => ":attribute đã chọn không phù hợp.",
    "email_array"      => "Một hoặc nhiều địa chỉ email không hợp lệ.",
    "image"            => ":attribute phải là một hình.",
    "in"               => ":attribute đã lựa chọn không hợp lý.",
    "integer"          => ":attribute phải là một số nguyên.",
    "ip"               => ":attribute phải là một địa chỉ IP.",
    "max"              => array(
        "numeric" => ":attribute có thể không lớn hơn :max.",
        "file"    => ":attribute có thể không lớn hơn :max kilobytes.",
        "string"  => ":attribute có thể không lớn hơn :max ký tự.",
    ),
    "mimes"            => ":attribute phải là một tập tin có phần mở rộng là: :values.",
    "min"              => array(
        "numeric" => ":attribute phải có ít nhất :min.",
        "file"    => ":attribute phải ít nhất :min kilobytes.",
        "string"  => ":attribute phải ít nhất :min ký tự.",
    ),
    "not_in"           => ":attribute đã chọn không hợp lý.",
    "numeric"          => ":attribute phải là một số.",
    "regex"            => "Định dạng :attribute thì không hợp lý.",
    "required"         => "Trường :attribute thì bắt buộc.",
    "required_if"      => "Trường :attribute thì bắt buộc khi :other là :value.",
    "required_with"    => "Trường :attribute thì bắt buộc khi :values là hiện hành.",
    "required_without" => "Trường :attribute thì bắt buộc khi :values không hiện hành.",
    "same"             => ":attribute và :other phải giống nhau.",
    "size"             => array(
        "numeric" => ":attribute phải có cỡ :size.",
        "file"    => ":attribute phải có cỡ :size kilobytes.",
        "string"  => ":attribute phải có :size ký tự.",
    ),
    "unique"           => ":attribute đã sẵn sàng.",
    "url"              => "Định dạng :attribute thì không hợp lý.",
    "statuslabel_type" => "Bạn phải chọn một loại nhãn trạng thái hợp lệ",
    "unique_undeleted" => ":attribute phải là duy nhất.",


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

    'custom' => array(),
    'alpha_space' => "Trường :attribute chứa đựng một ký tự không được phép.",

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

    'attributes' => array(),

);

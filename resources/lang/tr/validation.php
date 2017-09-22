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

    'accepted'             => ': attribute benzersiz olması gerekir.',
    'active_url'           => ':attribute geçersiz URL.',
    'after'                => ':attribute :date sonra olmalı.',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => ':attribute sadece harf içermeli.',
    'alpha_dash'           => ':attribute sadece harf, rakam ve noktalama işaretleri olabilir.',
    'alpha_num'            => ':attribute sadece harf ve rakam olabilir.',
    'array'                => 'The :attribute must be an array.',
    'before'               => ':attribute :date den önce olmalı.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => ':attribute :min - :max arasında olmalı.',
        'file'    => ':attribute :min - :max Kb arasında olmalı.',
        'string'  => ':attribute :min - :max karakter arasında olmalı.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => ':attribute doğru veya yanlış olabilir.',
    'confirmed'            => ':attribute doğrulama uyuşmuyor.',
    'date'                 => ':attribute geçerli bir tarih değil.',
    'date_format'          => ':attribute biçim geçersiz.',
    'different'            => ':attribute ve :other farklı olmalı.',
    'digits'               => ':attribute :digits numara olmalı.',
    'digits_between'       => ':attribute :min ve :max numara.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => ':attribute biçim geçersiz.',
    'exists'               => ':attribute seçim geçersiz.',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field must have a value.',
    'image'                => ':attribute bir görüntü olması gerekir.',
    'in'                   => ':attribute geçersiz.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => ':attribute bir tamsayı olmalıdır.',
    'ip'                   => ':attribute geçerli bir IP adresi olması gerekir.',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => ':attribute :max dan büyük olmalı.',
        'file'    => ':attribute :max Kb tan büyük olmalı.',
        'string'  => ':attribute :max karakterden büyük olamaz.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => ':attribute :values türleri olmalı.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => ':attribute :min den küçük olmalı.',
        'file'    => ':attribute :min Kb tan küçük olmalı.',
        'string'  => ':attribute :min karakterden küçük olmalı.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => ':attribute geçersiz.',
    'numeric'              => ':attribute sayı olmalıdır.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => ':attribute formatı geçersiz.',
    'required'             => ':attribute alanı zorunludur.',
    'required_if'          => ':attribute :other :value geçersiz.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => ':attribute :values geçersiz.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => ':attribute :values geçersiz.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => ':attribute ve :other aynı olmalı.',
    'size'                 => [
        'numeric' => ':attribute :size olmalı.',
        'file'    => ':attribute :size Kb olmalı.',
        'string'  => ':attribute :size karakter olmalı.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => ':attribute zaten alınmış.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => ':attribute biçim geçersiz.',

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

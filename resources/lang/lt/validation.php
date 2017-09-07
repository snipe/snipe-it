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

    'accepted'             => ':attribute turi būti patvirtintas.',
    'active_url'           => ':attribute nėra tinkamas interentinis puslapis.',
    'after'                => ':attribute privalo būti data po :date.',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => ':attribute gali būti tik raidės.',
    'alpha_dash'           => ':attribute gali būti tik raidės, skaičiai ir brūkšneliai.',
    'alpha_num'            => ':attribute gali būti tik raidės ir skaičiai.',
    'array'                => 'The :attribute must be an array.',
    'before'               => ':attribute turi būti data prieš :date.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => ':attribute privalo būti tarp :min - :max.',
        'file'    => ':attribute privalo būti tarp :min - :max kilobaitų.',
        'string'  => ':attribute privalo būti tarp :min - :max ženklų.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
    'confirmed'            => ':attribute patvirtinimas nesutampa.',
    'date'                 => ':attribute nėra galiojanti data.',
    'date_format'          => ':attribute nesutampa su formatu :format.',
    'different'            => ':attribute ir :other turi būti skirtingi.',
    'digits'               => ':attribute privalo būti :digits skaičiai.',
    'digits_between'       => ':attribute privalo būti tarp :min ir:max skaičių.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => ':attribute formatas neteisingas.',
    'exists'               => 'Pasirinktas :attribute neteisingas.',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field must have a value.',
    'image'                => ':attribute privalo būti paveikslėlis.',
    'in'                   => 'Pasirinktas :attribute neteisingas.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => ':attribute turi būti sveikas skaičius.',
    'ip'                   => ':attribute privalo būti tinkamas IP adresas.',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => ':attribute negali būti didesnis nei :max.',
        'file'    => ':attribute negali būti didesnis nei :max kilobaitų.',
        'string'  => ':attribute negali būti didesnis nei :max ženklai.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => ':attribute privalo būti failas, kurio formatas :values.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => ':attribute privalo būti ne mažesnis nei :min.',
        'file'    => ':attribute turi būti bent :min kilobaitų.',
        'string'  => ':attribute privalo būti bent :min ženklai.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'Pasirinktas :attribute neteisingas.',
    'numeric'              => ':attribute privalo būti skaičius.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => ':attribute formatas neteisingas.',
    'required'             => ':attribute laukelis privalomas.',
    'required_if'          => ':attribute laukelis yra privalomas kai :other yra :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => ':attribute laukelis privalomas kai :values yra nurodytas.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => ':attribute laukelis privalomas kai :values yra nenurodytas.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => ':attribute ir :other privalo sutapti.',
    'size'                 => [
        'numeric' => ':attribute privalo būti :size.',
        'file'    => ':attribute privalo būti :size kilobaitų.',
        'string'  => ':attribute privalo būti :size ženklų.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => ':attribute jau užimtas.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => ':attribute formatas neteisingas.',

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

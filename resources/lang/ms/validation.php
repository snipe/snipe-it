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

    "accepted"         => ":attribute mesti diterima.",
    "active_url"       => ":attribute URL yang tidak sah.",
    "after"            => ":attribute mesti tarik selepas must :date.",
    "alpha"            => ":attribute hanya boleh mengandungi huruf.",
    "alpha_dash"       => ":attribute hanya boleh mengandungi huruf, nombor dan tanda tolak.",
    "alpha_num"        => ":attribute hanya boleh mengadungi huruf dan nombor.",
    "before"           => ":attribute mestilah tarikh sebelum :date.",
    "between"          => array(
        "numeric" => ":attribute mesti berada diantara :min - :max.",
        "file"    => ":attribute mesti diantara :min - :max kilobytes.",
        "string"  => ":attribute mesti diantara :min - :max characters.",
    ),
    "confirmed"        => ":attribute pengesahan tidak sama.",
    "date"             => ":attribute  tarikh yang tidak sah.",
    "date_format"      => ":attribute tidak mengikut format :format.",
    "different"        => ":attribute dan :other mesti berbeza.",
    "digits"           => ":attribute mesti :digits digit.",
    "digits_between"   => ":attribute mesti diantara :min and :max digit.",
    "email"            => ":attribute format tidak sah.",
    "exists"           => "Piliah :attribute tidak sah.",
    "email_array"      => "One or more email addresses is invalid.",
    "image"            => ":attribute mesti imej.",
    "in"               => "Piliah :attribute tidak sah.",
    "integer"          => ":attribute mesti integer.",
    "ip"               => ":attribute mesti alamat IP yang sah.",
    "max"              => array(
        "numeric" => ":attribute tidak boleh lebih besar dari :max.",
        "file"    => ":attribute tidak boleh lebih besar dari :max kilobytes.",
        "string"  => ":attribute tidak boleh lebih besar dari :max characters.",
    ),
    "mimes"            => ":attribute mesti fail jenis: :values.",
    "min"              => array(
        "numeric" => ":attribute mesti sekurang2nya :min.",
        "file"    => ":attribute mesti sekurang2nya :min kilobytes.",
        "string"  => ":attribute mesti sekurang2nya :min characters.",
    ),
    "not_in"           => "Piliah :attribute tidak sah.",
    "numeric"          => ":attribute mesti nombor.",
    "regex"            => ":attribute format tidak sah.",
    "required"         => ":attribute ruangan diperlukan.",
    "required_if"      => ":attribute rungan diperlukan bila :other adalah :value.",
    "required_with"    => ":attribute ruangan diperlukan bila :values wujud.",
    "required_without" => ":attribute ruangan diperlukan bila :values tidak wujud.",
    "same"             => ":attribute dan :other mesti sama.",
    "size"             => array(
        "numeric" => ":attribute mesti :size.",
        "file"    => ":attribute mesti :size kilobytes.",
        "string"  => ":attribute mesti :size aksara.",
    ),
    "unique"           => ":attribute telah diambil.",
    "url"              => ":attribute format tidak sah.",
    "statuslabel_type" => "You must select a valid status label type",
    "unique_undeleted" => "The :attribute must be unique.",


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
    'alpha_space' => "The :attribute field contains a character that is not allowed.",

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

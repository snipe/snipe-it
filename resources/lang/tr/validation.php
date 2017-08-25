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

    "accepted"         => ": attribute benzersiz olması gerekir.",
    "active_url"       => ":attribute geçersiz URL.",
    "after"            => ":attribute :date sonra olmalı.",
    "alpha"            => ":attribute sadece harf içermeli.",
    "alpha_dash"       => ":attribute sadece harf, rakam ve noktalama işaretleri olabilir.",
    "alpha_num"        => ":attribute sadece harf ve rakam olabilir.",
    "before"           => ":attribute :date den önce olmalı.",
    "between"          => array(
        "numeric" => ":attribute :min - :max arasında olmalı.",
        "file"    => ":attribute :min - :max Kb arasında olmalı.",
        "string"  => ":attribute :min - :max karakter arasında olmalı.",
    ),
    "boolean"          => ":attribute doğru veya yanlış olabilir.",
    "confirmed"        => ":attribute doğrulama uyuşmuyor.",
    "date"             => ":attribute geçerli bir tarih değil.",
    "date_format"      => ":attribute biçim geçersiz.",
    "different"        => ":attribute ve :other farklı olmalı.",
    "digits"           => ":attribute :digits numara olmalı.",
    "digits_between"   => ":attribute :min ve :max numara.",
    "email"            => ":attribute biçim geçersiz.",
    "exists"           => ":attribute seçim geçersiz.",
    "email_array"      => "Bir veya daha fazla e-posta adresi geçerli değil.",
    "hashed_pass"      => "Your current password is incorrect",
    'dumbpwd'          => 'That password is too common.',
    "image"            => ":attribute bir görüntü olması gerekir.",
    "in"               => ":attribute geçersiz.",
    "integer"          => ":attribute bir tamsayı olmalıdır.",
    "ip"               => ":attribute geçerli bir IP adresi olması gerekir.",
    "max"              => array(
        "numeric" => ":attribute :max dan büyük olmalı.",
        "file"    => ":attribute :max Kb tan büyük olmalı.",
        "string"  => ":attribute :max karakterden büyük olamaz.",
    ),
    "mimes"            => ":attribute :values türleri olmalı.",
    "min"              => array(
        "numeric" => ":attribute :min den küçük olmalı.",
        "file"    => ":attribute :min Kb tan küçük olmalı.",
        "string"  => ":attribute :min karakterden küçük olmalı.",
    ),
    "not_in"           => ":attribute geçersiz.",
    "numeric"          => ":attribute sayı olmalıdır.",
    "regex"            => ":attribute formatı geçersiz.",
    "required"         => ":attribute alanı zorunludur.",
    "required_if"      => ":attribute :other :value geçersiz.",
    "required_with"    => ":attribute :values geçersiz.",
    "required_without" => ":attribute :values geçersiz.",
    "same"             => ":attribute ve :other aynı olmalı.",
    "size"             => array(
        "numeric" => ":attribute :size olmalı.",
        "file"    => ":attribute :size Kb olmalı.",
        "string"  => ":attribute :size karakter olmalı.",
    ),
    "unique"           => ":attribute zaten alınmış.",
    "url"              => ":attribute biçim geçersiz.",
    "statuslabel_type" => "Geçerli bir durum etiketi türü seçmelisiniz",
    "unique_undeleted" => ": attribute benzersiz olması gerekir.",


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
    'alpha_space' => ": attribute alanı izin verilmeyen bir karakter içeriyor.",

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

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

    'accepted'             => ':attribute muss akzeptiert werden.',
    'active_url'           => ':attribute ist keine gültige URL.',
    'after'                => ':attribute muss ein Datum nach dem :date sein.',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => ':attribute darf nur aus Buchstaben bestehen.',
    'alpha_dash'           => ':attribute darf nur aus Buchstaben, Zahlen und Gedankenstrichen bestehen.',
    'alpha_num'            => ':attribute darf nur aus Buchstaben und Zahlen bestehen.',
    'array'                => 'The :attribute must be an array.',
    'before'               => ':attribute muss ein Datum vor dem :date sein.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => ':attribute muss zwischen :min und :max liegen.',
        'file'    => ':attribute darf nur zwischen :min und :max kilobytes groß sein.',
        'string'  => ':attribute muss mindestens :min und maximal :max Zeichen enthalten.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => ':attribute muss wahr oder falsch sein.',
    'confirmed'            => ':attribute Bestätigung stimmt nicht überein.',
    'date'                 => ':attribute ist kein gültiges Datum.',
    'date_format'          => ':attribute passt nicht zur :format Formatierung.',
    'different'            => ':attribute und :other müssen sich unterscheiden.',
    'digits'               => ':attribute muss :digits Stellen haben.',
    'digits_between'       => ':attribute soll mindestens :min und darf maximal :max Stellen haben.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => 'Das Format von :attribute ist ungültig.',
    'exists'               => 'Das ausgewählte :attribute ist ungültig.',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field must have a value.',
    'image'                => ':attribute muss ein Bild sein.',
    'in'                   => 'Auswahl :attribute ist ungültig.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => ':attribute muss eine ganze Zahl sein.',
    'ip'                   => ':attribute muss eine gültige IP Adresse sein.',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => ':attribute darf nicht größer als :max sein.',
        'file'    => ':attribute darf nicht größer als :max Kilobyte sein.',
        'string'  => ':attribute darf nicht mehr als :max Zeichen sein.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => ':attribute muss eine Datei des Typs :values sein.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => ':attribute muss kleiner als :min sein.',
        'file'    => ':attribute muss mindestens :min Kilobyte groß sein.',
        'string'  => ':attribute benötigt mindestens :min Zeichen.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'Auswahl :attribute ist ungültig.',
    'numeric'              => ':attribute muss eine Zahl sein.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => ':attribute Format ungültig.',
    'required'             => ':attribute Feld muss ausgefüllt sein.',
    'required_if'          => ':attribute wird benötigt wenn :other :value entspricht.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => ':attribute wird benötigt wenn :value ausgewählt ist.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => ':attribute wird benötigt wenn :value nicht ausgewählt ist.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => ':attribute und :other müssen übereinstimmen.',
    'size'                 => [
        'numeric' => ':attribute muss :size groß sein.',
        'file'    => ':attribute muss :size Kilobyte groß sein.',
        'string'  => ':attribute muss :size Zeichen haben.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => ':attribute schon benutzt.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => ':attribute Format ist ungültig.',

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

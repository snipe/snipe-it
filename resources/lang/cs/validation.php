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

    'accepted'             => 'Je potřeba potvrdit :attribute.',
    'active_url'           => ':attribute není platnou URL.',
    'after'                => ':attribute nemůže být dříve než :date.',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => ':attribute může obsahovat pouze písmena.',
    'alpha_dash'           => ':attribute může obsahovat pouze písmena, čísla, a pomlčky.',
    'alpha_num'            => ':attribute může obsahovat pouze písmena čísla.',
    'array'                => 'The :attribute must be an array.',
    'before'               => ':attribute nemůže být později než :date.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => ':attribute musí být mezi :min - :max.',
        'file'    => ':attribute musí být mezi :min - :max kilobajtů.',
        'string'  => ':attribute smí obsahovat pouze :min - :max znaků.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => ':attribute musí být true nebo false.',
    'confirmed'            => 'Potvrzení :attribute se neshoduje.',
    'date'                 => ':attribute není platným datem.',
    'date_format'          => 'Atribut  :attribute nesouhlasí s formátem :format.',
    'different'            => ':attribute a  :other se musí lišit.',
    'digits'               => ':attribute musí být :digits číslo.',
    'digits_between'       => ':attribute musí být mezi hodnotami :min a :max.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => 'Formát :attribute je neplatný.',
    'exists'               => 'Zvolený :attribute je neplatný.',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field must have a value.',
    'image'                => ':attribute musí být obrázek.',
    'in'                   => 'Zvolený :attribute je neplatný.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => ':attribute musí být celočíselný.',
    'ip'                   => ':attribute musí být platná IP adresa.',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => ':attribute nesmí být větší než :max.',
        'file'    => ':attribute nesmí být větší než :max kilobajtů.',
        'string'  => ':attribute nesmí být větší než :max znaků.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => ':attribute musí být soubor typu: :values.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => ':attribute musí být minimálne :min.',
        'file'    => ':attribute musí být minimálně :min kilobajtů.',
        'string'  => ':attribute musí mít minimálně :min znaků.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'Zvolený :attribute je neplatný.',
    'numeric'              => ':attribute musí být číslo.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'Formát :attribute je neplatný.',
    'required'             => 'Pole :attribute je požadováno.',
    'required_if'          => 'Položka :attribute je vyžadována, když :other je :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'Hodnota :attribute je vyžadována, když je přítomno :values.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'Hodnota :attribute je vyžadována, když není přítomno :values.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => ':attribute a :other se musí shodovat.',
    'size'                 => [
        'numeric' => ':attribute musí být :size.',
        'file'    => ':attribute musí být :size kilobajtů.',
        'string'  => ':attribute musí mít :size znaků.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => ':attribute byl již vybrán.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'Formát :attribute je neplatný.',

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

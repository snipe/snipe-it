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

    'accepted'             => ':attribute musi zostać zaakceptowany.',
    'active_url'           => ':attribute nie jest poprawnym adresem URL.',
    'after'                => ':attribute musi być późniejszą datą w stosunku do :date.',
    'after_or_equal'       => ':attribute musi być datą po lub równa :date.',
    'alpha'                => ':attribute może zawierać tylko litery.',
    'alpha_dash'           => ':attribute może zawierać tylko litery, cyfry i myślniki.',
    'alpha_num'            => ':attribute może zawierać tylko litery i cyfry.',
    'array'                => ':attribute musi być zbiorem.',
    'before'               => ':attribute musi być późniejszą datą w stosunku do :date.',
    'before_or_equal'      => ':attribute musi być datą po lub równa :date.',
    'between'              => [
        'numeric' => ':attribute musi być pomiędzy :min - :max.',
        'file'    => ':attribute musi być pomiędzy :min - :max kilobajtów.',
        'string'  => ':attribute musi być pomiędzy :min - :max znaków.',
        'array'   => ':attribute musi być pomiędzy :min - :max.',
    ],
    'boolean'              => 'Pole atrybutu: musi być prawdziwe lub fałszywe.',
    'confirmed'            => 'Potwierdzenie :attribute nie pasuje.',
    'date'                 => ':attribute nie jest prawidłową datą.',
    'date_format'          => 'Format :attribute nie pasuje do :format.',
    'different'            => ':attribute musi różnić się od :other.',
    'digits'               => ':attribute musi posiadać cyfry :digits.',
    'digits_between'       => ':attribute musi być pomiędzy cyframi :min i :max.',
    'dimensions'           => 'Atrybut: atrybut ma nieprawidłowe wymiary obrazu.',
    'distinct'             => 'Pole :attribute ma zduplikowane wartości.',
    'email'                => 'Format pola :attribute jest niewłaściwy.',
    'exists'               => 'Wybrane :attribute jest niewłaściwe.',
    'file'                 => ':attribute musi być plikiem.',
    'filled'               => 'Pole :attribute musi posiadać wartość.',
    'image'                => ':attribute musi być obrazkiem.',
    'in'                   => 'Wybrane :attribute jest niewłaściwe.',
    'in_array'             => 'Pole: attribute nie istnieje w: other.',
    'integer'              => ':attribute must musi być liczbą całkowitą.',
    'ip'                   => ':attribute musi być poprawnym adresem IP.',
    'ipv4'                 => 'Atrybut: musi być prawidłowym adresem IPv4.',
    'ipv6'                 => 'Atrybut: musi być prawidłowym adresem IPv6.',
    'json'                 => 'Atrybut: musi być prawidłowym ciągiem JSON.',
    'max'                  => [
        'numeric' => ':attribute nie może być większy niż :max.',
        'file'    => ':attribute nie może być więszky niż :max kilobajtów.',
        'string'  => ':attribute nie może posiadać więcej znaków niż :max.',
        'array'   => 'Atrybut: atrybut nie może zawierać więcej niż: max elementów.',
    ],
    'mimes'                => ':attribute musi być plikiem z rozszerzeniami :values.',
    'mimetypes'            => 'Atrybut: atrybut musi być plikiem typu:: wartości.',
    'min'                  => [
        'numeric' => ':attribute musi być przynajmniej :min.',
        'file'    => ':attribute musi być przynajmniej wielkości :min kilobajtów.',
        'string'  => ':attribute musi być posiadać minimum :min znaki.',
        'array'   => 'Atrybut: musi zawierać co najmniej: min.',
    ],
    'not_in'               => 'Wybrany :attribute jest nieprawidłowy.',
    'numeric'              => ':attribute musi być liczbą.',
    'present'              => ':attribute nie może być puste.',
    'regex'                => 'Format :attribute jest niewłaściwy.',
    'required'             => ':attribute nie może być puste.',
    'required_if'          => 'Pole :attribute jest wymagane gdy :other jest :value.',
    'required_unless'      => 'Pole atrybutów: wymagane jest, chyba że inne są w: wartościach.',
    'required_with'        => 'Pole :attribute jest wymagane gdy :values jest podana.',
    'required_with_all'    => 'Pole atrybutu: atrybut jest wymagane, gdy: wartości są obecne.',
    'required_without'     => 'Pole :attribute jest wymagane gdy :values nie jest podana.',
    'required_without_all' => 'Pole atrybutu: attribute jest wymagane, gdy żadna z: wartości nie jest obecna.',
    'same'                 => ':attribute i :other muszą pasować.',
    'size'                 => [
        'numeric' => ':attribute musi być wielkości :size.',
        'file'    => ':attribute musi być :size kilobajtów.',
        'string'  => ':attribute musi być :size znakowy.',
        'array'   => 'Atrybut: musi zawierać: elementy rozmiaru.',
    ],
    'string'               => 'Atrybut: atrybut musi być ciągiem.',
    'timezone'             => 'Atrybut: musi być poprawną strefą.',
    'unique'               => ':attribute został już wzięty.',
    'uploaded'             => 'Nie udało się przesłać atrybutu:.',
    'url'                  => 'Format pola :attribute jest niewłaściwy.',
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
        'alpha_space' => "Pole: attribute zawiera znak, który nie jest dozwolony.",
        "email_array"      => "Jeden lub więcej adresów e-mail jest nieprawidłowy.",
        "hashed_pass"      => "Twoje bieżące hasło jest niepoprawne",
        'dumbpwd'          => 'To hasło jest zbyt powszechne.',
        "statuslabel_type" => "Musisz wybrać odpowiedni typ etykiety statusu",
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

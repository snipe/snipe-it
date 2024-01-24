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

    'accepted'             => ':attribute a fost acceptat.',
    'active_url'           => ':attribute nu este un URL valid.',
    'after'                => ':attribute trebuie sa fie o data dupa :date.',
    'after_or_equal'       => ': atribute trebuie să fie o dată mai mare sau egală cu :date.',
    'alpha'                => ':attribute trebuie sa contina numai litere.',
    'alpha_dash'           => ':attribute poate sa contina numai litere, cifre si linia de punctuatie.',
    'alpha_num'            => ':attribute poate sa contina numai litere si cifre.',
    'array'                => ': attribute trebuie să fie un șir/matrice.',
    'before'               => ':attribute trebuie sa contina o data inainte de :date.',
    'before_or_equal'      => ': atribute trebuie să fie o dată mai mică cu o zi sau egală cu :date.',
    'between'              => [
        'numeric' => ':attribute trebuie sa fie intre :min - :max.',
        'file'    => ':attribute trebuie sa fie intre  :min - :max kilobytes.',
        'string'  => ':attribute trebuie sa aiba intre :min - :max caractere.',
        'array'   => ': atribute trebuie să fie între: min şi: max.',
    ],
    'boolean'              => 'Câmpul atributului trebuie să fie adevărat sau fals.',
    'confirmed'            => 'Confirmarea la :attribute nu este asemanatoare.',
    'date'                 => ':attribute nu este o data.',
    'date_format'          => ':attribute nu se leaga cu formatul :format.',
    'different'            => ':attribute si :other trebuie sa fie diferite.',
    'digits'               => ':attribute trebuie sa fie de :digits cifre.',
    'digits_between'       => ':attribute trebuie sa fie intre :min si :max cifre.',
    'dimensions'           => 'Atributul: are dimensiuni de imagine nevalide.',
    'distinct'             => 'Câmpul atributului: are o valoare duplicat.',
    'email'                => 'Formatul :attribute nu este valid.',
    'exists'               => ':attribute selectat nu e valid.',
    'file'                 => 'Atributul: trebuie să fie un fișier.',
    'filled'               => 'Câmpul atributului trebuie să aibă o valoare.',
    'image'                => ':attribute trebuie sa fie o imagine.',
    'import_field_empty'    => 'Valoarea pentru :field name nu poate fi null.',
    'in'                   => ':attribute selectat nu este valid.',
    'in_array'             => 'Câmpul atributului nu există în: altul.',
    'integer'              => ':attribute trebuie sa fie numar intreg.',
    'ip'                   => ':attribute trebuie sa fie o adresa IP valida.',
    'ipv4'                 => 'Atributul: trebuie să fie o adresă IPv4 validă.',
    'ipv6'                 => 'Atributul: trebuie să fie o adresă IPv6 validă.',
    'is_unique_department' => ':attribute trebuie să fie unic pentru această companie locaţie',
    'json'                 => 'Atributul: trebuie să fie un șir JSON valid.',
    'max'                  => [
        'numeric' => ':attribute nu poate sa fie mai mare de :max.',
        'file'    => ':attribute nu poate sa fie mai mare de :max kilobytes.',
        'string'  => ':attribute nu trebuie sa fie mai mare de :max caractere.',
        'array'   => 'Atributul:: nu poate avea mai mult de: elemente max.',
    ],
    'mimes'                => ':attribute trebuie sa fie un fisier de tipul :values.',
    'mimetypes'            => 'Atributul: trebuie să fie un fișier de tip:: valori.',
    'min'                  => [
        'numeric' => ':attribute trebuie sa aiba cel putin :min.',
        'file'    => ':attribute trebuie sa aiba minim :min kilobytes.',
        'string'  => ':attribute trebuie sa aiba cel putin :min caractere.',
        'array'   => 'Atributul:: trebuie să aibă cel puțin: min.',
    ],
    'starts_with'          => ':attribute trebuie să înceapă cu una dintre următoarele: :values.',
    'ends_with'            => ':attribute trebuie să se termine cu una dintre următoarele: :values.',

    'not_in'               => ':attribute selectat nu e valid.',
    'numeric'              => ':attribute trebuie sa fie un numar.',
    'present'              => 'Câmpul atributului trebuie să fie prezent.',
    'valid_regex'          => 'Acesta nu este un regex valid. ',
    'regex'                => 'Formatul :attribute nu este valid.',
    'required'             => 'Campul :attribute este obligatoriu.',
    'required_if'          => ':attribute este obligatoriu atunci cand :other este :value.',
    'required_unless'      => 'Câmpul atributului este necesar dacă: altul nu este în: valori.',
    'required_with'        => ':attribute este obligatoriu atunci cand :values este prezent.',
    'required_with_all'    => 'Câmpul atributului este necesar când: există valori.',
    'required_without'     => ':attribute este obligatoriu atunci cand :values nu este prezent.',
    'required_without_all' => 'Câmpul atributului este necesar atunci când niciuna dintre valorile: nu este prezentă.',
    'same'                 => ':attribute si :other trebuie sa fie la fel.',
    'size'                 => [
        'numeric' => ':attribute trebuie sa aiba :size.',
        'file'    => ':attribute trebuie sa aiba :size kilobytes.',
        'string'  => ':attribute trebuie sa aiba :size caractere.',
        'array'   => 'Atributul:: trebuie să conțină: elemente de dimensiune.',
    ],
    'string'               => 'Atributul: trebuie să fie un șir.',
    'timezone'             => 'Atributul: trebuie să fie o zonă validă.',
    'two_column_unique_undeleted' => ':attribute trebuie să fie unic în :table1 și :table2. ',
    'unique'               => ':attribute este deja folosit.',
    'uploaded'             => 'Atributul: nu a reușit să se încarce.',
    'url'                  => 'Formatul :attribute nu este valid.',
    'unique_undeleted'     => 'Atributul: trebuie să fie unic.',
    'non_circular'         => ':attribute nu trebuie să creeze o referință circulară.',
    'not_array'            => ':attribute nu poate fi un array.',
    'disallow_same_pwd_as_user_fields' => 'Parola nu poate fi identică cu numele de utilizator.',
    'letters'              => 'Parola trebuie să conțină cel puțin o literă.',
    'numbers'              => 'Parola trebuie să conțină cel puțin un număr.',
    'case_diff'            => 'Parola trebuie să fie utilizată cu majuscule.',
    'symbols'              => 'Parola trebuie să conțină simboluri.',
    'gte'                  => [
        'numeric'          => 'Valoarea nu poate fi negativă'
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
        'alpha_space' => 'Câmpul atributului: conține un caracter care nu este permis.',
        'email_array'      => 'Una sau mai multe adrese de e-mail este nevalidă.',
        'hashed_pass'      => 'Parola curentă este incorectă',
        'dumbpwd'          => 'Această parolă este prea obișnuită.',
        'statuslabel_type' => 'Trebuie să selectați un tip de etichetă de stare validă',

        // date_format validation with slightly less stupid messages. It duplicates a lot, but it gets the job done :(
        // We use this because the default error message for date_format is reflects php Y-m-d, which non-PHP
        // people won't know how to format. 
        'purchase_date.date_format'     => ':attribute trebuie să fie o dată validă în formatul AAAA-LL-ZZ',
        'last_audit_date.date_format'   =>  ':attribute trebuie să fie o dată validă în AAAA-LL-ZZ hh:mm:ss format',
        'expiration_date.date_format'   =>  ':attribute trebuie să fie o dată validă în formatul AAAA-LL-ZZ',
        'termination_date.date_format'  =>  ':attribute trebuie să fie o dată validă în formatul AAAA-LL-ZZ',
        'expected_checkin.date_format'  =>  ':attribute trebuie să fie o dată validă în formatul AAAA-LL-ZZ',
        'start_date.date_format'        =>  ':attribute trebuie să fie o dată validă în formatul AAAA-LL-ZZ',
        'end_date.date_format'          =>  ':attribute trebuie să fie o dată validă în formatul AAAA-LL-ZZ',

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

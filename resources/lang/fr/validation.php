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

    'accepted'             => 'L\'attribut ":attribute" doit être accepté.',
    'active_url'           => 'L\'attribut ":attribute" n\'est pas une URL valide.',
    'after'                => 'L\'attribut ":attribute" doit être une date après :date.',
    'after_or_equal'       => 'L\'attribut: doit être une date après ou égale à: date.',
    'alpha'                => 'L\'attribut ":attribute" ne peut contenir que des lettres.',
    'alpha_dash'           => 'L\'attribut ":attribute" ne peut contenir que des lettres, des nombres, et des tirets.',
    'alpha_num'            => 'L\'attribut ":attribute" ne peut contenir que des caractères alphanumériques.',
    'array'                => 'L\'attribut: doit être un tableau.',
    'before'               => 'L\'attribut ":attribute" doit être une date avant :date.',
    'before_or_equal'      => 'L\'attribut: doit être une date antérieure ou égale à: date.',
    'between'              => [
        'numeric' => 'L\'attribut ":attribute" doit être entre :min et :max.',
        'file'    => 'L\'attribut ":attribute" doit être entre :min et :max kilo-octets.',
        'string'  => 'L\'attribut ":attribute" doit contenir entre :min et :max caractères.',
        'array'   => 'L\'attribut: doit avoir entre: min et: max items.',
    ],
    'boolean'              => 'L\'attribut : doit être vrai ou faux.',
    'confirmed'            => 'La confirmation et l\'attribut ":attribute" ne concordent pas.',
    'date'                 => 'L\'attribut ":attribute" n\'est pas une date valide.',
    'date_format'          => 'L\'attribut ":attribute" ne respecte pas le format ":format".',
    'different'            => 'L\'attribut ":attribute" et l\'attribut ":other" doivent être différents.',
    'digits'               => 'L\'attribut ":attribute" doit contenir :digits chiffres.',
    'digits_between'       => 'L\'attribut ":attribute" doit contenir entre :min et :max chiffres.',
    'dimensions'           => 'L\'attribut: a des dimensions d\'image invalides.',
    'distinct'             => 'Le champ d\'attribut: a une valeur en double.',
    'email'                => 'Le format de l\'attribut ":attribute" est invalide.',
    'exists'               => 'L\'attribut ":attribute" est invalide.',
    'file'                 => 'L\'attribut: doit être un fichier.',
    'filled'               => 'Le champ d\'attribut: doit avoir une valeur.',
    'image'                => 'L\'attribut ":attribute" doit être une image.',
    'in'                   => 'Le :attribute selectionné est invalide.',
    'in_array'             => 'Le champ d\'attribut: n\'existe pas dans autre.',
    'integer'              => 'L\'attribut ":attribute" doit être un nombre entier.',
    'ip'                   => 'L\'attribut ":attribute" doit être une adresse IP valide.',
    'ipv4'                 => 'L\'attribut: doit être une adresse IPv4 valide.',
    'ipv6'                 => 'L\'attribut: doit être une adresse IPv6 valide.',
    'json'                 => 'L\'attribut: doit être une chaîne JSON valide.',
    'max'                  => [
        'numeric' => 'L\'attribut ":attribute" ne peut pas être plus grand que :max.',
        'file'    => 'L\'attribut ":attribute" ne doit pas dépasser :max kilo-octets.',
        'string'  => 'L\'attribut ":attribute" ne doit pas faire plus de :max caractères.',
        'array'   => 'L\'attribut: peut ne pas avoir plus de: max items.',
    ],
    'mimes'                => 'Le fichier :attribute doit être de type :values.',
    'mimetypes'            => 'L\'attribut: doit être un fichier de type:: valeurs.',
    'min'                  => [
        'numeric' => 'L\'attribut ":attribute" doit être au moins :min.',
        'file'    => 'L\'attribut ":attribute" doit faire au moins :min kilo-octets.',
        'string'  => 'L\'attribut ":attribute" doit faire au moins :min caractères.',
        'array'   => 'L\'attribut: doit avoir au moins: éléments min.',
    ],
    'starts_with'          => 'L\'attribut :attribute doit commencer par l\'une des valeurs suivantes : :values.',
    'not_in'               => 'L\'attribut ":attribute" est invalide.',
    'numeric'              => 'L\'attribut ":attribute" doit être un nombre.',
    'present'              => 'Le champ d\'attribut: doit être présent.',
    'valid_regex'          => 'Ce n\'est pas une règle Regex valide. ',
    'regex'                => 'Le format de l\'attribut ":attribute" est invalide.',
    'required'             => 'Le champs :attribute est nécessaire.',
    'required_if'          => 'Le champ :attribute est nécessaire quand :other vaut :value.',
    'required_unless'      => 'Le champ d\'attribut: est obligatoire sauf si: autre est dans: valeurs.',
    'required_with'        => 'Le champ :attribute est nécessaire quand :values est présent.',
    'required_with_all'    => 'Le champ d\'attribut: est requis lorsque: les valeurs sont présentes.',
    'required_without'     => 'Le champ :attribute est nécessaire quand :values n\'est pas présent.',
    'required_without_all' => 'Le champ d\'attribut: est requis lorsque aucune des valeurs suivantes n\'est présente.',
    'same'                 => 'L\'attribut ":attribute" et :other doivent correspondre.',
    'size'                 => [
        'numeric' => 'L\'attribut ":attribute" doit faire :size.',
        'file'    => 'L\'attribut ":attribute" doit faire :size kilo-octets.',
        'string'  => 'L\'attribut ":attribute" doit faire :size caractères.',
        'array'   => 'L\'attribut: doit contenir: des éléments de taille.',
    ],
    'string'               => 'L\'attribut: doit être une chaîne.',
    'timezone'             => 'L\'attribut: doit être une zone valide.',
    'unique'               => 'Cet-te :attribute a déjà été pris-e.',
    'uploaded'             => 'L\'attribut: n\'a pas pu télécharger.',
    'url'                  => 'Le format de cet-te :attribute est invalide.',
    'unique_undeleted'     => ':attribute doit être unique.',
    'non_circular'         => 'Le champ :attribute ne doit pas créer de référence circulaire.',
    'disallow_same_pwd_as_user_fields' => 'Password cannot be the same as the username.',
    'letters'              => 'Password must contain at least one letter.',
    'numbers'              => 'Password must contain at least one number.',
    'case_diff'            => 'Password must use mixed case.',
    'symbols'              => 'Password must contain symbols.',
    'gte'                  => [
        'numeric'          => 'La valeur ne peut pas être négative'
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
        'alpha_space' => 'Le champ d\'attribut: contient un caractère qui n\'est pas autorisé.',
        'email_array'      => 'Une ou plusieurs adresses électroniques sont invalides.',
        'hashed_pass'      => 'Votre mot de passe actuel est incorrect',
        'dumbpwd'          => 'Ce mot de passe est trop commun.',
        'statuslabel_type' => 'Vous devez sélectionner un type d\'étiquette de statut valide',
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

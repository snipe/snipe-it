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

    'accepted'             => 'התכונה: חייבת להתקבל.',
    'active_url'           => 'התכונה: אינה כתובת אתר חוקית.',
    'after'                => 'התכונה: חייבת להיות תאריך לאחר: תאריך.',
    'after_or_equal'       => 'התכונה: חייבת להיות תאריך אחרי או שווה ל: תאריך.',
    'alpha'                => 'התכונה: יכולה להכיל רק אותיות.',
    'alpha_dash'           => 'התכונה: עשויה להכיל רק אותיות, מספרים וקווים.',
    'alpha_num'            => 'התכונה: עשויה להכיל רק אותיות ומספרים.',
    'array'                => 'התכונה: חייבת להיות מערך.',
    'before'               => 'התכונה: חייבת להיות תאריך לפני: תאריך.',
    'before_or_equal'      => 'התכונה: חייבת להיות תאריך לפני או שווה ל: תאריך.',
    'between'              => [
        'numeric' => 'התכונה: חייבת להיות בין: min ו-: max.',
        'file'    => 'התכונה: חייבת להיות בין: min ו-: max kilobytes.',
        'string'  => 'התכונה: חייבת להיות בין: דקות ו-: תווים מקסימליים.',
        'array'   => 'התכונה: חייבת להיות בין: min ו-: max items.',
    ],
    'boolean'              => 'שדה התכונה: חייב להיות אמיתי או שגוי.',
    'confirmed'            => 'אישור התכונה אינו תואם.',
    'date'                 => 'התכונה: אינה תאריך חוקי.',
    'date_format'          => 'התכונה: אינה תואמת את הפורמט: format.',
    'different'            => 'התכונה: ו-: אחרים חייבים להיות שונים.',
    'digits'               => 'התכונה: חייבת להיות: ספרות ספרות.',
    'digits_between'       => 'התכונה: חייבת להיות בין: דקות ו-: ספרות מקסימליות.',
    'dimensions'           => 'לתכונה: יש ממדי תמונה לא חוקיים.',
    'distinct'             => 'שדה התכונה: יש ערך כפול.',
    'email'                => 'התכונה: חייבת להיות כתובת דוא"ל חוקית.',
    'exists'               => 'התכונה שנבחרה: אינה חוקית.',
    'file'                 => 'התכונה: חייבת להיות קובץ.',
    'filled'               => 'שדה המאפיין חייב להיות בעל ערך.',
    'image'                => 'התכונה: חייבת להיות תמונה.',
    'in'                   => 'התכונה שנבחרה: אינה חוקית.',
    'in_array'             => 'שדה התכונה: אינו קיים ב-: other.',
    'integer'              => 'התכונה: חייבת להיות מספר שלם.',
    'ip'                   => 'התכונה: חייבת להיות כתובת IP חוקית.',
    'ipv4'                 => 'התכונה: חייבת להיות כתובת IPv4 חוקית.',
    'ipv6'                 => 'התכונה: חייבת להיות כתובת IPv6 חוקית.',
    'json'                 => 'התכונה: חייבת להיות מחרוזת JSON חוקית.',
    'max'                  => [
        'numeric' => 'התכונה: לא יכולה להיות גדולה מ: מקסימום.',
        'file'    => 'התכונה: לא יכולה להיות גדולה מ: קילו-בתים מקסימליים.',
        'string'  => 'התכונה: לא יכולה להיות גדולה מ: תווים מקסימליים.',
        'array'   => 'לתכונה: אין יותר מ: פריטים מקסימליים.',
    ],
    'mimes'                => 'התכונה: חייבת להיות קובץ מסוג:: ערכים.',
    'mimetypes'            => 'התכונה: חייבת להיות קובץ מסוג:: ערכים.',
    'min'                  => [
        'numeric' => 'התכונה: חייבת להיות לפחות: דקות.',
        'file'    => 'התכונה: חייבת להיות לפחות: קילובייט מינימלי.',
        'string'  => 'התכונה: חייבת להיות לפחות: דקות תווים.',
        'array'   => 'התכונה: חייבת לכלול לפחות פריטים מינימליים.',
    ],
    'starts_with'          => 'השדה חייב להכיל לפחות אחד מהערכים הבאים.',
    'not_in'               => 'התכונה שנבחרה: אינה חוקית.',
    'numeric'              => 'התכונה: חייבת להיות מספר.',
    'present'              => 'שדה התכונה: חייב להיות נוכח.',
    'valid_regex'          => 'הקלט לא חוקי. ',
    'regex'                => 'תבנית התכונה: אינה חוקית.',
    'required'             => 'שדה התכונה: נדרש.',
    'required_if'          => 'שדה התכונה: נדרש כאשר: other is: value.',
    'required_unless'      => 'שדה התכונה: נדרש, אלא אם: אחרים נמצאים ב: ערכים.',
    'required_with'        => 'שדה התכונה: נדרש כאשר: ערכים קיימים.',
    'required_with_all'    => 'שדה התכונה: נדרש כאשר: ערכים קיימים.',
    'required_without'     => 'שדה התכונה: נדרש כאשר: ערכים לא קיימים.',
    'required_without_all' => 'שדה התכונה: נדרש כאשר אף אחד מערכים אלה אינו קיים.',
    'same'                 => 'התכונה: ו-: אחרים חייבים להתאים.',
    'size'                 => [
        'numeric' => 'התכונה: חייבת להיות: גודל.',
        'file'    => 'התכונה: חייבת להיות: גודל קילובייט.',
        'string'  => 'התכונה: חייבת להיות: גודל תווים.',
        'array'   => 'התכונה: חייבת להכיל: פריטי גודל.',
    ],
    'string'               => 'התכונה: חייבת להיות מחרוזת.',
    'timezone'             => 'התכונה: חייבת להיות אזור חוקי.',
    'unique'               => 'התכונה: כבר נלקחה.',
    'uploaded'             => 'התכונה: נכשלה.',
    'url'                  => 'תבנית התכונה: אינה חוקית.',
    'unique_undeleted'     => 'השדה חייב מזהה יחודי.',
    'non_circular'         => 'The :attribute must not create a circular reference.',
    'gte'                  => [
        'numeric'          => 'Value cannot be negative'
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
        'alpha_space' => 'השדה: מאפיין מכיל תו שאינו מותר.',
        'email_array'      => 'כתובת אימייל אחת או יותר אינה חוקית.',
        'hashed_pass'      => 'הסיסמה הנוכחית שלך שגויה',
        'dumbpwd'          => 'סיסמה זו נפוצה מדי.',
        'statuslabel_type' => 'עליך לבחור סוג תווית סטטוס חוקי',
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

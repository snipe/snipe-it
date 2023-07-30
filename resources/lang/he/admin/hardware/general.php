<?php

return [
    'about_assets_title'           => 'על נכסים',
    'about_assets_text'            => 'נכסים הם פריטים במעקב לפי מספר סידורי או תג נכס. הם נוטים להיות פריטים בעלי ערך גבוה יותר, כאשר מזהים פריטים ספציפיים.',
    'archived'  				=> 'בארכיון',
    'asset'  					=> 'נכס',
    'bulk_checkout'             => 'שייך נכס',
    'bulk_checkin'              => 'החזר נכסים לזמינות',
    'checkin'  					=> 'רכוש',
    'checkout'  				=> 'רכוש Checkout',
    'clone'  					=> 'נכס משוכפל',
    'deployable'  				=> 'ניתן לפריסה',
    'deleted'  					=> 'הנכס הזה נמחק.',
    'edit'  					=> 'ערוך נכס',
    'model_deleted'  			=> 'המודל של הנכס נמחק. יש לשחזר את המודל לפני שניתן לשחזר את הנכס.',
    'model_invalid'             => 'The Model of this Asset is invalid.',
    'model_invalid_fix'         => 'The Asset should be edited to correct this before attempting to check it in or out.',
    'requestable'               => 'ניתן לבקש',
    'requested'				    => 'מבוקש',
    'not_requestable'           => 'Not Requestable',
    'requestable_status_warning' => 'Do not change  requestable status',
    'restore'  					=> 'שחזור נכס',
    'pending'  					=> 'ממתין ל',
    'undeployable'  			=> 'לא ניתן לפריסה',
    'undeployable_tooltip'  	=> 'This asset has a status label that is undeployable and cannot be checked out at this time.',
    'view'  					=> 'הצג נכס',
    'csv_error' => 'קיימת שגיאה בקובץ ה-CSV שלך:',
    'import_text' => '
    <p>
    Upload a CSV that contains asset history. The assets and users MUST already exist in the system, or they will be skipped. Matching assets for history import happens against the asset tag. We will try to find a matching user based on the user\'s name you provide, and the criteria you select below. If you do not select any criteria below, it will simply try to match on the username format you configured in the Admin &gt; General Settings.
    </p>

    <p>Fields included in the CSV must match the headers: <strong>Asset Tag, Name, Checkout Date, Checkin Date</strong>. Any additional fields will be ignored. </p>

    <p>Checkin Date: blank or future checkin dates will checkout items to associated user.  Excluding the Checkin Date column will create a checkin date with todays date.</p>
    ',
    'csv_import_match_f-l' => 'Try to match users by firstname.lastname (jane.smith) format',
    'csv_import_match_initial_last' => 'Try to match users by first initial last name (jsmith) format',
    'csv_import_match_first' => 'Try to match users by first name (jane) format',
    'csv_import_match_email' => 'Try to match users by email as username',
    'csv_import_match_username' => 'Try to match users by username',
    'error_messages' => 'שגיאות:',
    'success_messages' => 'אישור:',
    'alert_details' => 'נא ראה הסבר בהמשך.',
    'custom_export' => 'יבוא מותאם',
    'mfg_warranty_lookup' => ':manufacturer Warranty Status Lookup',
];

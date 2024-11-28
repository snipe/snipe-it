<?php

return array(
    'about_licenses_title'      => 'Om licenser',
    'about_licenses'            => 'Licenser används för att spåra programvara. De har ett visst antal platser som kan checkas ut till individer',
    'checkin'  					=> 'Checkin License Seat',
    'checkout_history'  		=> 'Checkout historia',
    'checkout'  				=> 'Checkout License Seat',
    'edit'  					=> 'Redigera licens',
    'filetype_info'				=> 'Tillåtna filtyper är png, gif, jpg, jpeg, doc, docx, pdf, txt, zip och rar.',
    'clone'  					=> 'Kopiera licens',
    'history_for'  				=> 'Historia för',
    'in_out'  					=> 'In ut',
    'info'  					=> 'Licensinfo',
    'license_seats'  			=> 'Licenssäten',
    'seat'  					=> 'Sittplats',
    'seat_count'  				=> 'Plats :count',
    'seats'  					=> 'Säten',
    'software_licenses'  		=> 'Programvarulicenser',
    'user'  					=> 'Användare',
    'view'  					=> 'Visa licens',
    'delete_disabled'           => 'Licensen kan inte tas bort ännu eftersom vissa platser fortfarande är utcheckade.',
    'bulk'                      =>
        [
            'checkin_all'           => [
                'button'            => 'Checka in alla säten',
                'modal'             => 'Denna åtgärd checkar in en plats. | Denna åtgärd checkar in alla :checkedout_seats_count platser för denna licens.',
                'enabled_tooltip'   => 'Checka in ALLA platser för denna licens från både användare och tillgångar',
                'disabled_tooltip'  => 'Detta är inaktiverat eftersom det för närvarande inte finns några platser utcheckade',
                'disabled_tooltip_reassignable'  => 'Detta är inaktiverat eftersom licensen inte är omtilldelsningsbar',
                'success'           => 'Licensen har checkats in! | Alla licenser har checkats in!',
                'log_msg'           => 'Incheckad via massincheckning av licenser i licensgränssnittet',
            ],

            'checkout_all'              => [
                'button'                => 'Checka ut alla säten',
                'modal'                 => 'Denna åtgärd kommer att checka ut en plats till den första tillgängliga användaren. | Den här åtgärden kommer att checka ut alla :available_seats_count platser till de första tillgängliga användarna. En användare anses vara tillgänglig för denna plats om de inte redan har denna licens utcheckad till dem, och auto-tilldela licensegenskapen är aktiverad på deras användarkonto.',
                'enabled_tooltip'   => 'Checka ut alla säten (eller så många som finns tillgängliga) till ALLA användare',
                'disabled_tooltip'  => 'Detta är inaktiverat eftersom det för närvarande inte finns några säten tillgängliga',
                'success'           => 'Licensen har checkats ut! | :count licenser har checkats ut!',
                'error_no_seats'    => 'Det finns inga återstående säten kvar för denna licens.',
                'warn_not_enough_seats'    => ':count användare tilldelades denna licens, men vi fick slut på tillgängliga licenser.',
                'warn_no_avail_users'    => 'Inget att göra. Det finns inga användare som inte redan har denna licens tilldelad dem.',
                'log_msg'           => 'Utcheckad via massincheckning av licenser i licensgränssnittet',


            ],
    ],

    'below_threshold' => 'Det finns bara :remaining_count platser kvar för denna licens med en minsta mängd :min_amt. Du kanske vill överväga att köpa fler platser.',
    'below_threshold_short' => 'Detta objekt är under det minsta obligatoriska antalet.',
);

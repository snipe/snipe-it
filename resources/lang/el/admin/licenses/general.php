<?php

return array(
    'about_licenses_title'      => 'Σχετικά με τις άδειες',
    'about_licenses'            => 'Οι άδειες χρησιμοποιούνται για την παρακολούθηση του λογισμικού. Έχουν καθορισμένο αριθμό καθισμάτων που μπορούν να ελέγχονται σε άτομα',
    'checkin'  					=> 'Checkin άδεια',
    'checkout_history'  		=> 'Ιστορικό παραγγελίας',
    'checkout'  				=> 'Καθίσματα άδειας πληρωμής',
    'edit'  					=> 'Επεξεργασία άδειας',
    'filetype_info'				=> 'Επιτρεπόμενοι τύποι αρχείων είναι png, gif, jpg, jpeg, doc, docx, pdf, txt, zip και rar.',
    'clone'  					=> 'Κλόνος άδειας',
    'history_for'  				=> 'Ιστορικό για ',
    'in_out'  					=> 'Εισερχόμενα/Εξερχόμενα',
    'info'  					=> 'Πληροφορίες άδειας',
    'license_seats'  			=> 'Άδειες Θέσεις',
    'seat'  					=> 'Εδρα',
    'seats'  					=> 'Καθίσματα',
    'software_licenses'  		=> 'Άδειες λογισμικού',
    'user'  					=> 'Χρήστης',
    'view'  					=> 'Προβολή άδειας',
    'delete_disabled'           => 'This license cannot be deleted yet because some seats are still checked out.',
    'bulk'                      =>
        [
            'checkin_all'           => [
                'button'            => 'Checkin All Seats',
                'modal'             => 'This will action checkin one seat. | This action will checkin all :checkedout_seats_count seats for this license.',
                'enabled_tooltip'   => 'Checkin ALL seats for this license from both users and assets',
                'disabled_tooltip'  => 'This is disabled because there are no seats currently checked out',
                'success'           => 'License successfully checked in! | All licenses were successfully checked in!',
                'log_msg'           => 'Checked in via bulk license checkout in license GUI',
            ],

            'checkout_all'              => [
                'button'                => 'Checkout All Seats',
                'modal'                 => 'This action will checkout one seat to the first available user. | This action will checkout all :available_seats_count seats to the first available users. A user is considered available for this seat if they do not already have this license checked out to them, and the Auto-Assign License property is enabled on their user account.',
                'enabled_tooltip'   => 'Checkout ALL seats (or as many as are available) to ALL users',
                'disabled_tooltip'  => 'This is disabled because there are no seats currently available',
                'success'           => 'License successfully checked out! | :count licenses were successfully checked out!',
                'error_no_seats'    => 'There are no remaining seats left for this license.',
                'warn_not_enough_seats'    => ':count users were assigned this license, but we ran out of available license seats.',
                'warn_no_avail_users'    => 'Nothing to do. There are no users who do not already have this license assigned to them.',
                'log_msg'           => 'Checked out via bulk license checkout in license GUI',


            ],
    ],
);

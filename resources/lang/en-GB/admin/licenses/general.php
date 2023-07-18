<?php

return array(
    'about_licenses_title'      => 'About Licenses',
    'about_licenses'            => 'Licenses are used to track software.  They have a specified number of seats that can be checked out to individuals',
    'checkin'  					=> 'Checkin License Seat',
    'checkout_history'  		=> 'Checkout History',
    'checkout'  				=> 'Checkout License Seat',
    'edit'  					=> 'Edit License',
    'filetype_info'				=> 'Allowed filetypes are png, gif, jpg, jpeg, doc, docx, pdf, txt, zip, and rar.',
    'clone'  					=> 'Clone License',
    'history_for'  				=> 'History for ',
    'in_out'  					=> 'In/Out',
    'info'  					=> 'License Info',
    'license_seats'  			=> 'License Seats',
    'seat'  					=> 'Seat',
    'seats'  					=> 'Seats',
    'software_licenses'  		=> 'Software Licenses',
    'user'  					=> 'User',
    'view'  					=> 'View License',
    'delete_disabled'           => 'This licence cannot be deleted yet because some seats are still checked out.',
    'bulk'                      =>
        [
            'checkin_all'           => [
                'button'            => 'Check In All Seats',
                'modal'             => 'This will action check in one seat. | This action will check in all :checkedout_seats_count seats for this licence.',
                'enabled_tooltip'   => 'Check in ALL seats for this licence from both users and assets',
                'disabled_tooltip'  => 'This is disabled because there are no seats currently checked out',
                'success'           => 'Licence successfully checked in! | All licences were successfully checked in!',
                'log_msg'           => 'Checked in via bulk licence checkout in licence GUI',
            ],

            'checkout_all'              => [
                'button'                => 'Check Out All Seats',
                'modal'                 => 'This action will check out one seat to the first available user. | This action will check out all :available_seats_count seats to the first available users. A user is considered available for this seat if they do not already have this licence checked out to them, and the Auto-Assign Licence property is enabled on their user account.',
                'enabled_tooltip'   => 'Check out ALL seats (or as many as are available) to ALL users',
                'disabled_tooltip'  => 'This is disabled because there are no seats currently available',
                'success'           => 'Licence successfully checked out! | :count licences were successfully checked out!',
                'error_no_seats'    => 'There are no remaining seats left for this licence.',
                'warn_not_enough_seats'    => ':count users were assigned this licence, but we ran out of available licence seats.',
                'warn_no_avail_users'    => 'Nothing to do. There are no users who do not already have this licence assigned to them.',
                'log_msg'           => 'Checked out via bulk licence check out in licence GUI',


            ],
    ],
);

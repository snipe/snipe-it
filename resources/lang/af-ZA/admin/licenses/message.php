<?php

return [

    'does_not_exist' => 'License does not exist or you do not have permission to view it.',
    'user_does_not_exist' => 'User does not exist or you do not have permission to view them.',
    'asset_does_not_exist' => 'Die bate wat u met hierdie lisensie probeer assosieer, bestaan ​​nie.',
    'owner_doesnt_match_asset' => 'Die bate wat u met hierdie lisensie probeer assosieer, is in besit van ander as die persoon wat in die opdrag toegeken is.',
    'assoc_users' => 'Hierdie lisensie word tans na \'n gebruiker nagegaan en kan nie uitgevee word nie. Gaan asseblief die lisensie eers in, en probeer dan weer uitvee.',
    'select_asset_or_person' => 'Jy moet \'n bate of \'n gebruiker kies, maar nie albei nie.',
    'not_found' => 'License not found',
    'seats_available' => ':seat_count seats available',

    'create' => [
        'error' => 'Lisensie is nie geskep nie, probeer asseblief weer.',
        'success' => 'Lisensie geskep suksesvol.',
    ],

    'deletefile' => [
        'error' => 'Lêer nie verwyder nie. Probeer asseblief weer.',
        'success' => 'Lêer suksesvol uitgevee.',
    ],

    'upload' => [
        'error' => 'Lêer (s) nie opgelaai nie. Probeer asseblief weer.',
        'success' => 'Lêer (s) suksesvol opgelaai.',
        'nofiles' => 'Jy het nie enige lêers vir oplaai gekies nie, of die lêer wat jy probeer oplaai is te groot',
        'invalidfiles' => 'Een of meer van jou lêers is te groot of is \'n filetipe wat nie toegelaat word nie. Toegelate filetipes is png, gif, jpg, jpeg, doc, docx, pdf, txt, zip, rar, rtf, xml en lic.',
    ],

    'update' => [
        'error' => 'Lisensie is nie opgedateer nie, probeer asseblief weer',
        'success' => 'Lisensie suksesvol opgedateer.',
    ],

    'delete' => [
        'confirm' => 'Is jy seker jy wil hierdie lisensie uitvee?',
        'error' => 'Daar was \'n probleem met die verwydering van die lisensie. Probeer asseblief weer.',
        'success' => 'Die lisensie is suksesvol verwyder.',
        'bulk_success' => 'The selected licenses were deleted successfully.',
        'partial_success' => 'License deleted successfully. See additional information below. | :count licenses were deleted successfully. See additional information below.',
        'bulk_checkout_warning' => ':license_name has seats that are currently checked out and cannot be deleted. Please check in all seats before deleting.',
    ],

    'delete_with_checkin' => [
        'bulk_success' => ':count licenses were deleted successfully after checking in :seats seats.',
        'partial_success' => ':count licenses were deleted successfully after checking in :seats seats. See additional information below.',
    ],

    'checkout' => [
        'error' => 'Daar was \'n probleem om die lisensie te kontroleer. Probeer asseblief weer.',
        'success' => 'Die lisensie is suksesvol nagegaan',
        'not_enough_seats' => 'Not enough license seats available for checkout',
        'mismatch' => 'The license seat provided does not match the license',
        'unavailable' => 'This seat is not available for checkout.',
        'license_is_inactive' => 'This license is expired or terminated.',
    ],

    'checkin' => [
        'error' => 'Daar was \'n probleem om die lisensie te kontroleer. Probeer asseblief weer.',
        'not_reassignable' => 'Seat has been used',
        'success' => 'Die lisensie is suksesvol nagegaan',
    ],

    'import' => [
        'no_free_seats' => 'License ":license" has no free seats. ":target" was not assigned to a seat.',
    ],

];

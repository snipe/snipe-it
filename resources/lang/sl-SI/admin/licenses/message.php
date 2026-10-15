<?php

return [

    'does_not_exist' => 'Licenca ne obstaja ali pa nimate dovoljenja za njen ogled.',
    'user_does_not_exist' => 'Uporabnik ne obstaja ali pa nimate dovoljenja za njegov ogled.',
    'asset_does_not_exist' => 'Sredstev, katero poskušate povezati s to licenco, ne obstaja.',
    'owner_doesnt_match_asset' => 'Sredstev, ki ga poskušate povezati s to licenco, je v lasti nekoga drugega, in ne v lasti uporabnika ki je izbran v spustnem seznamu.',
    'assoc_users' => 'Ta licenca je trenutno izdana uporabniku in je ni mogoče izbrisati. Najprej preverite licenco in poskusite znova izbrisati. ',
    'select_asset_or_person' => 'Izbrati morate sredstvo ali uporabnika, vendar ne obojega.',
    'not_found' => 'Licenca ni najdena',
    'seats_available' => ':seat_count seats available',

    'create' => [
        'error' => 'Licenca ni bila ustvarjena, poskusite znova.',
        'success' => 'Licenca je bila ustvarjena uspešno.',
    ],

    'deletefile' => [
        'error' => 'Datoteka ni izbrisana. Prosim poskusite ponovno.',
        'success' => 'Datoteka je uspešno izbrisana.',
    ],

    'upload' => [
        'error' => 'Datoteka(e) niso naložene. Prosim poskusite ponovno.',
        'success' => 'Datoteka(e) so bile uspešno naložene.',
        'nofiles' => 'Niste izbrali nobenih datotek za nalaganje, ali je datoteka ki jo poskušate naložiti prevelika',
        'invalidfiles' => 'Ena ali več vaših datotek je prevelika ali pa je tip datoteke, ki ni dovoljen. Dovoljeni tipi datotek so png, gif, jpg, jpeg, doc, docx, pdf, txt, zip, rar, rtf, xml in lic.',
    ],

    'update' => [
        'error' => 'Licenca ni bila posodobljena, poskusite znova',
        'success' => 'Licenca je bila posodobljena uspešno.',
    ],

    'delete' => [
        'confirm' => 'Ali ste prepričani, da želite izbrisati to licenco?',
        'error' => 'Prišlo je do težave z brisanjem licence. Prosim poskusite ponovno.',
        'success' => 'Licenca je bila uspešno izbrisana.',
        'bulk_success' => 'The selected licenses were deleted successfully.',
        'partial_success' => 'License deleted successfully. See additional information below. | :count licenses were deleted successfully. See additional information below.',
        'bulk_checkout_warning' => ':license_name has seats that are currently checked out and cannot be deleted. Please check in all seats before deleting.',
    ],

    'delete_with_checkin' => [
        'bulk_success' => ':count licenses were deleted successfully after checking in :seats seats.',
        'partial_success' => ':count licenses were deleted successfully after checking in :seats seats. See additional information below.',
    ],

    'checkout' => [
        'error' => 'Prišlo je do težave pri izdji licence. Prosim poskusite ponovno.',
        'success' => 'Licenca je uspešno izdana',
        'not_enough_seats' => 'Not enough license seats available for checkout',
        'mismatch' => 'The license seat provided does not match the license',
        'unavailable' => 'This seat is not available for checkout.',
        'license_is_inactive' => 'This license is expired or terminated.',
    ],

    'checkin' => [
        'error' => 'Prišlo je do težave pri prevzemu licence. Prosim poskusite ponovno.',
        'not_reassignable' => 'Seat has been used',
        'success' => 'Licenca je uspešno prevzeta',
    ],

    'import' => [
        'no_free_seats' => 'License ":license" has no free seats. ":target" was not assigned to a seat.',
    ],

];

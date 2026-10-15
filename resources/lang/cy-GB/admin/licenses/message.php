<?php

return [

    'does_not_exist' => 'License does not exist or you do not have permission to view it.',
    'user_does_not_exist' => 'User does not exist or you do not have permission to view them.',
    'asset_does_not_exist' => 'Nid yw\'r ased rydych yn ceisio perthnasu i\'r trwydded yma yn bodoli.',
    'owner_doesnt_match_asset' => 'Nid y defnyddiwr sydd wedi nodi yw perchenog yr ased rydych yn ceisio perthnasu ir trwydded yma.',
    'assoc_users' => 'Ar hyn o bryd mae\'r trwydded yma allan gan ddefnyddiwr ac ni ellir ei ddileu. Cofnodwch yr trwyddedyn ol i fewn yn gyntaf, ac yna ceisiwch ei ddileu eto. ',
    'select_asset_or_person' => 'Rhaid i chi ddewis ased neu defnyddiwr ond nid y ddau.',
    'not_found' => 'License not found',
    'seats_available' => ':seat_count seats available',

    'create' => [
        'error' => 'Ni crewyd y trwydded, ceisiwch eto o. g. y. dd.',
        'success' => 'Trwydded wedi creu yn llwyddiannus.',
    ],

    'deletefile' => [
        'error' => 'Ffeil heb ei ddileu. Ceisiwch eto o. g. y. dd.',
        'success' => 'Ffeil wedi dileu yn llwyddiannus.',
    ],

    'upload' => [
        'error' => 'Ffeil(iau) heb ei uwchlwytho. Ceisiwch eto o. g. y. dd.',
        'success' => 'Ffeil(iau) wedi uwchlwytho yn llwyddiannus.',
        'nofiles' => 'Ni wnaethoch chi ddewis unrhyw ffeiliau i\'w uwchlwytho, neu mae\'r ffeil rydych chi\'n ceisio ei huwchlwytho yn rhy fawr',
        'invalidfiles' => 'Mae un neu mwy o\'r ffeiliau unai yn rhy fawr neu ddim y math cywir. Derbynir png, gif, fjp, doc, docx, pdf a txt.',
    ],

    'update' => [
        'error' => 'Ni diweddarwyd y trwydded, ceisiwch eto o. g. y. dd',
        'success' => 'Trwydded wedi diweddaru\'n llwyddiannus.',
    ],

    'delete' => [
        'confirm' => 'Ydych chi\'n siwr eich bod eisiau dileu\'r trwydded yma?',
        'error' => 'Nid oedd yn bosib dileu\'r trwydded. Ceisiwch eto o. g. y. dd.',
        'success' => 'Trwydded wedi dileu yn llwyddiannus.',
        'bulk_success' => 'The selected licenses were deleted successfully.',
        'partial_success' => 'License deleted successfully. See additional information below. | :count licenses were deleted successfully. See additional information below.',
        'bulk_checkout_warning' => ':license_name has seats that are currently checked out and cannot be deleted. Please check in all seats before deleting.',
    ],

    'delete_with_checkin' => [
        'bulk_success' => ':count licenses were deleted successfully after checking in :seats seats.',
        'partial_success' => ':count licenses were deleted successfully after checking in :seats seats. See additional information below.',
    ],

    'checkout' => [
        'error' => 'Nid oedd yn bosib nodi\'r trwydded allan. Ceisiwch eto o. g. y. dd.',
        'success' => 'Trwydded wedi nodi allan yn llwyddiannus',
        'not_enough_seats' => 'Not enough license seats available for checkout',
        'mismatch' => 'The license seat provided does not match the license',
        'unavailable' => 'This seat is not available for checkout.',
        'license_is_inactive' => 'This license is expired or terminated.',
    ],

    'checkin' => [
        'error' => 'Nid oedd yn bosib nodi\'r trwydded i mewn. Ceisiwch eto o. g. y. dd.',
        'not_reassignable' => 'Seat has been used',
        'success' => 'Trwydded wedi nodi i fewn yn llwyddiannus',
    ],

    'import' => [
        'no_free_seats' => 'License ":license" has no free seats. ":target" was not assigned to a seat.',
    ],

];

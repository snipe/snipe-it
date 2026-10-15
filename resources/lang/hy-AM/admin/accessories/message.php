<?php

return [

    'does_not_exist' => 'Աքսեսուար [:id] գոյություն չունի։',
    'not_found' => 'Այս աքսեսուարը չի գտնվել։',
    'assoc_users' => 'Այս աքսեսուարին առկա են :count տրամադրված իրեր. Վերադարձրեք դրանք և փորձեք կրկին։ ',

    'create' => [
        'error' => 'Աքսեսուարը չի ստեղծվել, խնդրում ենք փորձել կրկին։',
        'success' => 'Աքսեսուարը հաջողությամբ ստեղծվեց։',
    ],

    'update' => [
        'error' => 'Աքսեսուարը չի թարմացվել, խնդրում ենք փորձել կրկին',
        'success' => 'Աքսեսուարը հաջողությամբ թարմացվեց։',
    ],

    'delete' => [
        'confirm' => 'Հաստատե՞լ ջնջումը այս աքսեսուարի համար:',
        'error' => 'Աքսեսուարը ջնջել հնարավոր չեղավ. Փորձեք կրկին։',
        'success' => 'Աքսեսուարը հաջողությամբ ջնջվեց։',
        'bulk_success' => 'Accessory deleted successfully.|:count accessories were deleted successfully.',
        'partial_success' => ':count accessory was deleted successfully, but others could not be deleted. See below for details.|:count accessories were deleted successfully, but others could not be deleted. See below for details.',
    ],

    'checkout' => [
        'error' => 'Աքսեսուարը չի տրամադրվել, խնդրում ենք փորձել կրկին',
        'success' => 'Աքսեսուարը դուրս գրվեց։',
        'unavailable' => 'Աքսեսուարը դուրս գրելու համար բավարար չէ։ Խնդրում ենք ստուգել հասանելի քանակը',
        'user_does_not_exist' => 'Օգտատերը անվավեր է. Փորձեք կրկին։',
        'checkout_qty' => [
            'lte' => 'Ընդհանուր հասանելի է :number_currently_remaining աքսեսուար, իսկ դուք փորձում եք դուրս գրել :checkout_qty։ Խնդրում ենք փոփոխել դուրս գրվողների քանակը կամ այս աքսեսուարի ընդհանուր պահուստը և փորձել կրկին։',
        ],

    ],

    'checkin' => [
        'error' => 'Աքսեսուարը դուրս գրվեց',
        'success' => 'Աքսեսուարը դուրս գրվեց։',
        'user_does_not_exist' => 'Օգտատերը անվավեր է. Փորձեք կրկին։',
    ],

];

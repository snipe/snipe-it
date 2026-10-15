<?php

return [

    'does_not_exist' => 'Կատեգորիան բացակաում է ',
    'assoc_models' => 'Այս կատեգորիան ներկայում կապված է առնվազն մեկ մոդելի հետ և չի կարող ջնջվել։ Խնդրում ենք թարմացնել ձեր մոդելները, որպեսզի այլևս չհղվեն այս կատեգորիային, և փորձեք կրկին։',
    'assoc_items' => 'Այս կատեգորիան ներկայում կապված է առնվազն մեկ ակտիվի հետ և չի կարող ջնջվել։ Խնդրում ենք թարմացնել ձեր ակտիվները, որպեսզի այլևս չհղվեն այս կատեգորիային, և փորձեք կրկին։',

    'create' => [
        'error' => 'Կատեգորիան չի ստեղծվել, խնդրում ենք փորձեք կրկին:',
        'success' => 'Կատեգորիան հաջողությամբ ստեղծվել է։',
    ],

    'update' => [
        'error' => 'Կատեգորիան չի թարմացվել, խնդրում ենք փորձեք կրկին:',
        'success' => 'Կատեգորիան հաջողությամբ թարմացվելէ :',
        'cannot_change_category_type' => 'Չեք կարող փոխել կատեգորիայի տեսակը այն ստեղծելուց հետո։',
    ],

    'delete' => [
        'confirm' => 'Վստա՞հ եք, որ ցանկանում եք ջնջել այս կատեգորիան։',
        'error' => 'Կատեգորիան ջնջելիս խնդիր է առաջացել։ Խնդրում ենք փորձել կրկին։',
        'success' => 'Կատեգորիան հաջողությամբ ջնջվեց։',
        'bulk_success' => 'Category deleted successfully.|:count categories were deleted successfully.',
        'partial_success' => 'Կատեգորիան հաջողությամբ ջնջվեց։ Տես ստորև լրացուցիչ տեղեկությունը։ | :count կատեգորիաներ հաջողությամբ ջնջվեցին։ Տես ստորև լրացուցիչ տեղեկությունը։',
    ],

    'bulkedit' => [
        'warn' => 'You are about to edit the properties of the following category:|You are about to edit the properties of the following :count categories:',
        'no_selection' => 'You must select at least one category to edit.',
        'no_changes' => 'Դաշտեր չեն փոփոխվել, ուստի ոչինչ չի թարմացվել։',
        'success' => 'Category successfully updated.|:count categories successfully updated.',
    ],

];

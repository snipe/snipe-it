<?php

return [

    'deleted' => 'Ջնջված ակտիվի մոդել
',
    'does_not_exist' => 'Մոդելը գոյություն չունի։',
    'no_association' => 'ԶԳՈՒՇԱՑՈՒՄ։ Այս տարրի ակտիվի մոդելն անվավեր է կամ բացակայում է։
',
    'no_association_fix' => 'Սա կհանգեցնի տարօրինակ և լուրջ խնդիրների։ Խնդրում ենք հիմա խմբագրել այս ակտիվը՝ մոդել հանձնարարելու համար։
',
    'assoc_users' => 'Այս մոդելը ներկայումս կապված է մեկ կամ մի քանի ակտիվի հետ և հնարավոր չէ ջնջել։ Խնդրում ենք նախ ջնջել ակտիվները, ապա կրկին փորձել ջնջել։',
    'invalid_category_type' => 'Այս կատեգորիան պետք է լինի ակտիվի կատեգորիա։
',

    'create' => [
        'error' => 'Մոդելը չի ստեղծվել, խնդրում ենք կրկին փորձել։',
        'success' => 'Մոդելը հաջողությամբ ստեղծվել է։',
        'duplicate_set' => 'Նման անունով, արտադրողով և մոդելի համարով ակտիվի մոդելն արդեն գոյություն ունի։',
    ],

    'update' => [
        'error' => 'Մոդելը չի թարմացվել, խնդրում ենք կրկին փորձել։',
        'success' => 'Մոդելը հաջողությամբ թարմացվել է։',
    ],

    'delete' => [
        'confirm' => 'Վստա՞հ եք, որ ցանկանում եք ջնջել այս ակտիվի մոդելը։',
        'error' => 'Մոդելի ջնջման ժամանակ խնդիր է առաջացել։ Խնդրում ենք կրկին փորձել։',
        'success' => 'Մոդելը հաջողությամբ ջնջվել է։',
    ],

    'restore' => [
        'error' => 'Մոդելը չի վերականգնվել, խնդրում ենք կրկին փորձել։',
        'success' => 'Մոդելը հաջողությամբ վերականգնվել է։',
    ],

    'bulkedit' => [
        'error' => 'Դաշտեր չեն փոփոխվել, ուստի ոչինչ չի թարմացվել։',
        'success' => 'Մոդելը հաջողությամբ թարմացվել է։|:model_count մոդել հաջողությամբ թարմացվել է։',
        'warn' => 'Դուք պատրաստվում եք թարմացնել հետևյալ մոդելի հատկությունները։|Դուք պատրաստվում եք խմբագրել հետևյալ :model_count մոդելների հատկությունները։
',

    ],

    'bulkdelete' => [
        'error' => 'Մոդելներ չեն ընտրվել, ուստի ոչինչ չի ջնջվել։',
        'nothing_deletable' => 'None of the selected models can be deleted because they still have assets associated with them.',
        'success' => 'Մոդելը ջնջվել է։|:success_count մոդել ջնջվել է։
',
        'success_partial' => ':success_count մոդել(ներ) ջնջվել է(են), սակայն :fail_count մոդել հնարավոր չեղավ ջնջել, քանի որ դրանց հետ կապված ակտիվներ կան։',
    ],

    'merge' => [
        'min_two' => 'Select at least two models to merge.',
        'no_target' => 'Select which model to keep before merging.',
        'not_found' => 'One or more of the selected models could not be loaded. Refresh the models list and try again.',
        'information' => 'You are about to merge :count models. Pick the model you want to keep. Every asset attached to the other models will be reassigned to the model you pick, then the source models will be deleted.',
        'warning' => 'This cannot be undone. Reassigned assets will inherit the surviving model\'s category, fieldset, and depreciation settings.',
        'pick_target' => 'Which model do you want to keep?',
        'success' => 'Merged :source_count model(s) into ":target". :asset_count asset(s) were reassigned.',
    ],

];

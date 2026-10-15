<?php

return [

    'does_not_exist' => 'Տեղադիրքը գոյություն չունի։',
    'assoc_users' => 'Այս վայրը հնարավոր չէ ջնջել, քանի որ այն հանդիսանում է առնվազն մեկ իրի կամ օգտատիրոջ գրանցված վայրը, ունի իրեն կցված ակտիվներ, կամ հանդիսանում է այլ վայրի մայր վայր։ Խնդրում ենք թարմացնել ձեր գրառումները, որպեսզի դրանք այլևս չհղվեն այս վայրին, և կրկին փորձել։',
    'assoc_assets' => 'Այս վայրը կապված է առնվազն մեկ ակտիվի հետ և հնարավոր չէ ջնջել։ Խնդրում ենք թարմացնել ձեր ակտիվները, որպեսզի դրանք այլևս չհղվեն այս վայրին, և կրկին փորձել։',
    'assoc_child_loc' => 'Այս վայրը առնվազն մեկ ենթավայրի մայր վայրն է և հնարավոր չէ ջնջել։ Խնդրում ենք թարմացնել ձեր վայրերը, որպեսզի դրանք այլևս չհղվեն այս վայրին, և կրկին փորձել։',
    'assigned_assets' => 'Հատկացված ակտիվներ',
    'current_location' => 'Ընթացիկ վայր',
    'deleted_warning' => 'Այս վայրը ջնջվել է։ Խնդրում ենք վերականգնել այն նախքան փոփոխություններ կատարելը։',

    'create' => [
        'error' => 'Վայրը չի ստեղծվել, խնդրում ենք կրկին փորձել։',
        'success' => 'Վայրը հաջողությամբ ստեղծվեց։',
    ],

    'update' => [
        'error' => 'Վայրը չի թարմացվել, խնդրում ենք կրկին փորձել։',
        'success' => 'Վայրը հաջողությամբ թարմացվեց։',
    ],

    'restore' => [
        'error' => 'Վայրը չի վերականգնվել, խնդրում ենք կրկին փորձել։',
        'success' => 'Վայրը հաջողությամբ վերականգնվեց։',
    ],

    'delete' => [
        'confirm' => 'Վստա՞հ եք, որ ցանկանում եք ջնջել այս վայրը։',
        'error' => 'Վայրը ջնջելիս սխալ առաջացավ։ Խնդրում ենք կրկին փորձել։',
        'success' => 'Վայրը հաջողությամբ ջնջվեց։',
    ],

    'bulkedit' => [
        'error' => 'Դաշտեր չեն փոփոխվել, ուստի ոչինչ չի թարմացվել։',
        'success' => 'Location successfully updated.|:count locations successfully updated.',
        'warn' => 'Edit the fields below to update this location. Fields you leave blank will not change on the location.|Edit the fields below to update all :count selected locations. Fields you leave blank will not change on any of them.',
        'show_selected' => '1 selected location|:count selected locations',
        'company_scope_mismatch_partial' => 'The company was not changed on 1 location because items or users at that location belong to different companies. Update or move those first.|The company was not changed on :count locations because items or users at those locations belong to different companies. Update or move those first.',
        'company_scope_mismatch_all' => 'No locations were reassigned. The requested company does not match items or users at the selected location.|No locations were reassigned. The requested company does not match items or users at any of the :count selected locations.',
        'parent_company_mismatch_partial' => 'The parent or company was not changed on 1 location because it would leave the location in a different company than its parent.|The parent or company was not changed on :count locations because it would leave those locations in a different company than their parent.',
        'parent_company_mismatch_all' => 'No changes were saved. The requested parent or company would leave the location in a different company than its parent.|No changes were saved. The requested parent or company would leave every one of the :count selected locations in a different company than their parent.',
    ],

];

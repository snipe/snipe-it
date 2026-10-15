<?php

return [

    'does_not_exist' => 'Категоријата не постои.',
    'assoc_models' => 'Оваа категорија моментално е поврзана со барем еден модел и не може да се избрише. Ве молиме да ги ажурирате вашите модели за да не ја користите оваа категорија и обидете се повторно. ',
    'assoc_items' => 'Оваа категорија е моментално поврзана со најмалку еден :asset_type и не може да се избрише. Ажурирајте го вашиот :asset_type да не ја користи оваа категорија и обидете се повторно. ',

    'create' => [
        'error' => 'Категоријата не е креирана, обидете се повторно.',
        'success' => 'Категоријата е успешно креирана.',
    ],

    'update' => [
        'error' => 'Категоријата не беше ажурирана, обидете се повторно',
        'success' => 'Категоријата е успешно ажурирана.',
        'cannot_change_category_type' => 'Не можете да го смените типот на категорија откако е создадена',
    ],

    'delete' => [
        'confirm' => 'Дали сте сигурни дека сакате да ја избришете оваа категорија?',
        'error' => 'Имаше проблем со бришење на категоријата. Обидете се повторно.',
        'success' => 'Category was deleted successfully.',
        'bulk_success' => 'Category deleted successfully.|:count categories were deleted successfully.',
        'partial_success' => 'Category deleted successfully. See additional information below. | :count categories were deleted successfully. See additional information below.',
    ],

    'bulkedit' => [
        'warn' => 'You are about to edit the properties of the following category:|You are about to edit the properties of the following :count categories:',
        'no_selection' => 'You must select at least one category to edit.',
        'no_changes' => 'Не беа сменети полиња, затоа ништо не беше ажурирано.',
        'success' => 'Category successfully updated.|:count categories successfully updated.',
    ],

];

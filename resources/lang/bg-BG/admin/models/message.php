<?php

return [

    'deleted' => 'Изтрит модел',
    'does_not_exist' => 'Моделът не съществува.',
    'no_association' => 'ВНИМАНИЕ! Модела за този актив е неправилен или липсва!',
    'no_association_fix' => 'Това ще счупи нещата по много лош начин. Редактирайте артикула сега и го зачислете към модел.',
    'assoc_users' => 'Този модел е асоцииран с един или повече активи и не може да бъде изтрит. Моля изтрийте активите и опитайте отново.',
    'invalid_category_type' => 'Тази категоря трябва да бъде за модели.',

    'create' => [
        'error' => 'Моделът не беше създаден. Моля опитайте отново.',
        'success' => 'Моделът създаден успешно.',
        'duplicate_set' => 'Актив с това име, производител и номер на модел вече е въведен.',
    ],

    'update' => [
        'error' => 'Моделът не беше обновен. Моля опитайте отново.',
        'success' => 'Моделът обновен успешно.',
    ],

    'delete' => [
        'confirm' => 'Желаете ли изтриване на модела?',
        'error' => 'Проблем при изтриване на модела. Моля опитайте отново.',
        'success' => 'Моделът изтрит успешно.',
    ],

    'restore' => [
        'error' => 'Моделът не беше възстановен. Моля опитайте отново.',
        'success' => 'Моделът възстановен успешно.',
    ],

    'bulkedit' => [
        'error' => 'Няма полета, който да са се променили, така че нищо не е осъвременено.',
        'success' => 'Модела е обновен успешно. |:model_count модела са обновени успешно.',
        'warn' => 'Вие ще обновите характиристиките на следния модел: |Вие ще редактирате характеристиките на следните :model_count модела:',

    ],

    'bulkdelete' => [
        'error' => 'Няма избрани модели, така че нищо не бе изтрито.',
        'nothing_deletable' => 'None of the selected models can be deleted because they still have assets associated with them.',
        'success' => 'Модела е изтрит!|:success_count модела бяха изтрити!',
        'success_partial' => ':success_count модела бяха изтрити, но :fail_count не бяха, тъй като към тях има асоциирани активи.',
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

<?php

return [

    'deleted' => 'Избришан модел на средство',
    'does_not_exist' => 'Моделот не постои.',
    'no_association' => 'ПРЕДУПРЕДУВАЊЕ! Моделот на средство за овој предмет е невалиден или недостасува!',
    'no_association_fix' => 'Ова ќе ги сруши работите на чудни и ужасни начини. Ажурирајте го ова средство да му доделите модел.',
    'assoc_users' => 'Моделот во моментов е поврзан со едно или повеќе основни средства и не може да се избрише. Ве молиме избришете ги основните средствата, а потоа пробајте повторно да го избришете. ',
    'invalid_category_type' => 'Оваа категорија мора да биде категорија на средства.',

    'create' => [
        'error' => 'Моделот не е креиран, обидете се повторно.',
        'success' => 'Моделот е успешно креиран.',
        'duplicate_set' => 'Модел на основно средство со тоа име, производител и број на модел веќе постои.',
    ],

    'update' => [
        'error' => 'Моделот не е ажуриран, обидете се повторно',
        'success' => 'Моделот е ажуриран.',
    ],

    'delete' => [
        'confirm' => 'Дали сте сигурни дека сакате да го избришете моделот?',
        'error' => 'Имаше проблем со бришење на моделот. Обидете се повторно.',
        'success' => 'Моделот е избришан.',
    ],

    'restore' => [
        'error' => 'Моделот не е вратен, обидете се повторно',
        'success' => 'Моделот е вратен.',
    ],

    'bulkedit' => [
        'error' => 'Не беа сменети полиња, затоа ништо не беше ажурирано.',
        'success' => 'Моделот е успешно ажуриран. |:model_count модели се успешно ажурирани',
        'warn' => 'Ќе ги ажурирате каректеристиките на следниот модел:|Ќе ги ажурирате карактеристиките на следните :model_count модели:',

    ],

    'bulkdelete' => [
        'error' => 'Не беа избрани модели, затоа ништо не беше избришано.',
        'nothing_deletable' => 'None of the selected models can be deleted because they still have assets associated with them.',
        'success' => 'Моделот е избришан!|:success_count модели се избришани!',
        'success_partial' => ':success_count модел (и) се избришани, меѓутоа :fail_count не може да се избришат, бидејќи тие сè уште имаат средства поврзани со нив.',
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

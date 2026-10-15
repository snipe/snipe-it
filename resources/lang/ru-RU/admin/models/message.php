<?php

return [

    'deleted' => 'Модель удалена',
    'does_not_exist' => 'Модель не существует.',
    'no_association' => 'ПРЕДУПРЕЖДЕНИЕ! Модель активов для этого элемента неверна или отсутствует!',
    'no_association_fix' => 'Это странно и ужасно сломает вещи. Отредактируйте этот актив сейчас, чтобы назначить ему модель.',
    'assoc_users' => 'Данная модель связана с одним или несколькими активами, и не может быть удалена. Удалите либо измените связанные активы. ',
    'invalid_category_type' => 'Эта категория должна быть категорией активов.',

    'create' => [
        'error' => 'Модель не была создана, повторите еще раз.',
        'success' => 'Модель успешно создана.',
        'duplicate_set' => 'Модель с таким именем, производителем и номером уже существует.',
    ],

    'update' => [
        'error' => 'Невозможно обновить Модель, повторите еще раз',
        'success' => 'Модель успешно обновлена.',
    ],

    'delete' => [
        'confirm' => 'Вы уверены, что хотите удалить данную модель актива?',
        'error' => 'При удалении модели возникла ошибка. Повторите еще раз.',
        'success' => 'Модель успешно удалена.',
    ],

    'restore' => [
        'error' => 'Модель не была восстановлена, повторите попытку',
        'success' => 'Модель успешно восстановлена.',
    ],

    'bulkedit' => [
        'error' => 'Никаких изменений нет, поэтому ничего не обновлено.',
        'success' => 'Модель успешно обновлена. |:model_count моделей успешно обновлено.',
        'warn' => 'Вы собираетесь обновить свойства следующей модели:|Вы собираетесь изменить свойства следующих моделей :model_count:',

    ],

    'bulkdelete' => [
        'error' => 'Ни одна модель не выбрана, поэтому нечего удалить.',
        'nothing_deletable' => 'None of the selected models can be deleted because they still have assets associated with them.',
        'success' => 'Модель удалена!|:success_count моделей удалено!',
        'success_partial' => 'Удалено : success_count моделей(ль), однако: fail_count моделей не удалены, потому что они всё ещё имеют связанные с ними активы.',
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

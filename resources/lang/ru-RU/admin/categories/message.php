<?php

return [

    'does_not_exist' => 'Категория не существует.',
    'assoc_models' => 'Эта категория уже связана с одной или несколькими моделями и не может быть удалена. Измените модели, чтобы они не ссылались на эту категорию, и попробуйте снова. ',
    'assoc_items' => 'Эта категория связана с одним или несколькими :asset_type и не может быть удалена. Измените :asset_type, чтобы они не ссылались на эту категорию, и попробуйте снова. ',

    'create' => [
        'error' => 'Категория не создана, попробуйте снова.',
        'success' => 'Категория создана.',
    ],

    'update' => [
        'error' => 'Категория не изменена, попробуйте снова',
        'success' => 'Категория изменена.',
        'cannot_change_category_type' => 'Вы не можете изменить тип категории после ее создания',
    ],

    'delete' => [
        'confirm' => 'Вы уверены, что хотите удалить категорию?',
        'error' => 'При удалении категории возникла проблема. Попробуйте снова.',
        'success' => 'Аксессуар был успешно удалён.',
        'bulk_success' => 'Категория успешно удалена.|:count категорий удалена.',
        'partial_success' => 'Категория успешно удалена. Смотрите дополнительную информацию ниже. | :count категории были успешно удалены. Смотрите дополнительную информацию ниже.',
    ],

    'bulkedit' => [
        'warn' => 'You are about to edit the properties of the following category:|You are about to edit the properties of the following :count categories:',
        'no_selection' => 'You must select at least one category to edit.',
        'no_changes' => 'Никаких изменений нет, поэтому ничего не обновлено.',
        'success' => 'Category successfully updated.|:count categories successfully updated.',
    ],

];

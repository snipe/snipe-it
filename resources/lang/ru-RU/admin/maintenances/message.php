<?php

return [
    'not_found' => 'Актив не найден!',
    'delete' => [
        'confirm' => 'Вы уверены что хотите удалить?',
        'error' => 'При удалении возникла проблема. Пожалуйста попробуйте еще раз.',
        'success' => 'Удалено.',
    ],
    'create' => [
        'error' => 'Не выполнено, попробуйте еще раз.',
        'success' => 'Выполнено.',
    ],
    'edit' => [
        'error' => 'Обслуживание активов не было отредактировано, повторите попытку.',
        'success' => 'Управление активами отредактировано успешно.',
    ],
    'asset_maintenance_incomplete' => 'Ещё не готово',
    'warranty' => 'Гарантия',
    'not_warranty' => 'Гарантии нет/истекла',
    'complete' => [
        'confirm' => 'Вы уверены, что хотите завершить это обслуживание? Отменить его будет нельзя.',
        'success' => 'Обслуживание отмечено как завершенное.',
        'error' => 'Возникла проблема с пометкой этого обслуживания как завершенного. Пожалуйста, попробуйте снова.',
    ],
    'bulk_delete' => 'No maintenance records were deleted (:skipped skipped).|Deleted :count maintenance record. (:skipped skipped)|Deleted :count maintenance records. (:skipped skipped)',
    'bulk_complete' => 'No maintenance records were marked complete (:skipped skipped or already complete).|Marked :count maintenance record complete. (:skipped skipped or already complete)|Marked :count maintenance records complete. (:skipped skipped or already complete)',
];

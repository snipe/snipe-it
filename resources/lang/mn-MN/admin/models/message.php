<?php

return [

    'deleted' => 'Deleted asset model',
    'does_not_exist' => 'Загвар байхгүй байна.',
    'no_association' => 'WARNING! The asset model for this item is invalid or missing!',
    'no_association_fix' => 'This will break things in weird and horrible ways. Edit this asset now to assign it a model.',
    'assoc_users' => 'Энэ загвар одоогоор нэг буюу хэд хэдэн хөрөнгөтэй холбоотой бөгөөд устгаж болохгүй. Хөрөнгө устгаж, дараа нь устгахыг оролдоно уу.',
    'invalid_category_type' => 'This category must be an asset category.',

    'create' => [
        'error' => 'Загвар үүсгэгдсэнгүй, дахин оролдоно уу.',
        'success' => 'Загвар амжилттай болсон.',
        'duplicate_set' => 'Тухайн нэр, үйлдвэрлэгч болон загварын дугаар бүхий хөрөнгийн загвар аль хэдийн гарсан байна.',
    ],

    'update' => [
        'error' => 'Загвар шинэчлэгдсэнгүй, дахин оролдоно уу',
        'success' => 'Загвар амжилттай болсон.',
    ],

    'delete' => [
        'confirm' => 'Та энэ хөрөнгийн загварыг устгахыг хүсэж байна уу?',
        'error' => 'Загварыг устгахад асуудал гарлаа. Дахин оролдоно уу.',
        'success' => 'Загвар амжилттай устгагдсан байна.',
    ],

    'restore' => [
        'error' => 'Загвар сэргээгээгүй, дахин оролдоно уу',
        'success' => 'Загвар амжилттай болсон.',
    ],

    'bulkedit' => [
        'error' => 'Ямар ч талбар өөрчлөгдсөнгүй тул шинэчлэгдээгүй байна.',
        'success' => 'Model successfully updated. |:model_count models successfully updated.',
        'warn' => 'You are about to update the properties of the following model:|You are about to edit the properties of the following :model_count models:',

    ],

    'bulkdelete' => [
        'error' => 'Ямар ч загвар сонгогдоогүй тул юу ч устаагүй.',
        'nothing_deletable' => 'None of the selected models can be deleted because they still have assets associated with them.',
        'success' => 'Model deleted!|:success_count models deleted!',
        'success_partial' => ':success_count ширхэг загвар устсан ба :fail_count ширхэг загвар одоо хүртэл хөрөнгөтэй холбоотой байгаа тул устаагүй.',
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

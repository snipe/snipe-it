<?php

return [

    'deleted' => 'Deleted asset model',
    'does_not_exist' => 'مدل موجود نیست.',
    'no_association' => 'WARNING! The asset model for this item is invalid or missing!',
    'no_association_fix' => 'This will break things in weird and horrible ways. Edit this asset now to assign it a model.',
    'assoc_users' => 'این مدل در حال حاضر همراه یک یا بیشتر از یک دارایی است و نمی تواند حذف شود. لطفا دارایی ها را حذف کنید و سپس برای حذف کردن مجددا تلاش کنید. ',
    'invalid_category_type' => 'This category must be an asset category.',

    'create' => [
        'error' => 'مدل ساخته نشده است، لطفا دوباره تلاش کنید.',
        'success' => 'مدل با موفقیت ساخته شد.',
        'duplicate_set' => 'یک مدل دارایی با آن نام، سازنده و شماره ی مدل در حال حاضر موجود است.',
    ],

    'update' => [
        'error' => 'مدل به روزرسانی نشده است، لطفا دوباره تلاش کنید',
        'success' => 'مدل با موفقیت به روز رسانی شد.',
    ],

    'delete' => [
        'confirm' => 'آیا شما مطمئن هستید که می خواهید این مدل دارایی را حذف کنید؟',
        'error' => 'در زمان حذف کردن مدل، مشکلی وجود داشت. لطفا دوباره تلاش کنید.',
        'success' => 'مدل با موفقیت حذف شد.',
    ],

    'restore' => [
        'error' => 'مدل بازیابی نشد، لطفا دوباره تلاش کنید',
        'success' => 'مدل با موفقیت بازیابی شد.',
    ],

    'bulkedit' => [
        'error' => 'هیچ فیلدی تغییر نکرده بود، بنابراین چیزی به روز نشد.',
        'success' => 'Model successfully updated. |:model_count models successfully updated.',
        'warn' => 'You are about to update the properties of the following model:|You are about to edit the properties of the following :model_count models:',

    ],

    'bulkdelete' => [
        'error' => 'هیچ مدلی انتخاب نشده بود، بنابراین هیچ چیز حذف نشد.',
        'nothing_deletable' => 'None of the selected models can be deleted because they still have assets associated with them.',
        'success' => 'Model deleted!|:success_count models deleted!',
        'success_partial' => 'مدل(های) :success_count حذف شدند، اما :fail_count حذف نشدند زیرا هنوز دارایی های مرتبط با آنها هستند.
',
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

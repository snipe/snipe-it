<?php

return [

    'deleted' => 'نموذج الأصول المحذوفة',
    'does_not_exist' => 'الموديل غير موجود.',
    'no_association' => 'تحذير! نموذج الأصول لهذا العنصر غير صالح أو مفقود!',
    'no_association_fix' => 'سيؤدي هذا إلى كسر الأمور بطرق غريبة وفظيعة. قم بتعديل هذا الأصل الآن لربطه بنموذج.',
    'assoc_users' => 'هذا الموديل مرتبط حاليا بواحد أو أكثر من الأصول ولا يمكن حذفه. يرجى حذف الأصول، ثم محاولة الحذف مرة أخرى. ',
    'invalid_category_type' => 'This category must be an asset category.',

    'create' => [
        'error' => 'لم يتم انشاء الموديل، يرجى إعادة المحاولة.',
        'success' => 'تم إنشاء الموديل بنجاح.',
        'duplicate_set' => 'يوجد مسبقا موديل بهذا الاسم، الشركة المصنعة ورقم الموديل.',
    ],

    'update' => [
        'error' => 'لم يتم تحديث الموديل، يرجى إعادة المحاولة',
        'success' => 'تم تحديث الموديل بنجاح.',
    ],

    'delete' => [
        'confirm' => 'هل تريد بالتأكيد حذف موديل الأصل هذا؟',
        'error' => 'حدثت مشكلة أثناء حذف الموديل. حاول مرة اخرى.',
        'success' => 'تم حذف الموديل بنجاح.',
    ],

    'restore' => [
        'error' => 'لم تتم استعادة الموديل، يرجى إعادة المحاولة',
        'success' => 'تم إستعادة الموديل بنجاح.',
    ],

    'bulkedit' => [
        'error' => 'لم يتم تغيير أي حقول، لذلك لم يتم تحديث أي شيء.',
        'success' => 'تم تحديث النموذج بنجاح. |تم تحديث :model_count نموذج بنجاح.',
        'warn' => 'أنت على وشك تحديث خصائص النموذج التالي:<unk> أنت على وشك تعديل الخصائص التالية لـ :model_count models:',

    ],

    'bulkdelete' => [
        'error' => 'لم يتم اختيار أي موديلات، لذلك لم يتم حذف أي شيء.',
        'nothing_deletable' => 'None of the selected models can be deleted because they still have assets associated with them.',
        'success' => 'تم حذف النموذج!|تم حذف :success_count نموذج!',
        'success_partial' => 'تم حذف:success_count: من الموديلات، ومع ذلك تعذر حذف fail_count: نظرًا لأنها لا تزال تحتوي على أصول مقترنة بها.',
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

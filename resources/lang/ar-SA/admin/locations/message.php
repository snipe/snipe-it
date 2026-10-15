<?php

return [

    'does_not_exist' => 'الموقع غير موجود.',
    'assoc_users' => 'This location is not currently deletable because it is the location of record for at least one item or user, has assets assigned to it, or is the parent location of another location. Please update your records to no longer reference this location and try again ',
    'assoc_assets' => 'هذا الموقع مرتبط حاليا بمادة عرض واحدة على الأقل ولا يمكن حذفها. يرجى تحديث مواد العرض لم تعد تشير إلى هذا الموقع ثم أعد المحاولة. ',
    'assoc_child_loc' => 'هذا الموقع هو حاليا أحد الوالدين لموقع طفل واحد على الأقل ولا يمكن حذفه. يرجى تحديث مواقعك لم تعد تشير إلى هذا الموقع ثم أعد المحاولة.',
    'assigned_assets' => 'الأصول المعينة',
    'current_location' => 'الموقع الحالي',
    'deleted_warning' => 'This location has been deleted. Please restore it before attempting to make any changes.',

    'create' => [
        'error' => 'لم يتم إنشاء الموقع، الرجاء المحاولة مرة أخرى.',
        'success' => 'تم إنشاء الموقع بنجاح.',
    ],

    'update' => [
        'error' => 'لم يتم تحديث الموقع، الرجاء المحاولة مرة أخرى',
        'success' => 'تم تحديث الموقع بنجاح.',
    ],

    'restore' => [
        'error' => 'Location was not restored, please try again',
        'success' => 'Location restored successfully.',
    ],

    'delete' => [
        'confirm' => 'هل تريد بالتأكيد حذف هذا الموقع؟',
        'error' => 'حدثت مشكلة أثناء حذف الموقع. حاول مرة اخرى.',
        'success' => 'تم حذف الموقع بنجاح.',
    ],

    'bulkedit' => [
        'error' => 'لم يتم تغيير أي حقول، لذلك لم يتم تحديث أي شيء.',
        'success' => 'Location successfully updated.|:count locations successfully updated.',
        'warn' => 'Edit the fields below to update this location. Fields you leave blank will not change on the location.|Edit the fields below to update all :count selected locations. Fields you leave blank will not change on any of them.',
        'show_selected' => '1 selected location|:count selected locations',
        'company_scope_mismatch_partial' => 'The company was not changed on 1 location because items or users at that location belong to different companies. Update or move those first.|The company was not changed on :count locations because items or users at those locations belong to different companies. Update or move those first.',
        'company_scope_mismatch_all' => 'No locations were reassigned. The requested company does not match items or users at the selected location.|No locations were reassigned. The requested company does not match items or users at any of the :count selected locations.',
        'parent_company_mismatch_partial' => 'The parent or company was not changed on 1 location because it would leave the location in a different company than its parent.|The parent or company was not changed on :count locations because it would leave those locations in a different company than their parent.',
        'parent_company_mismatch_all' => 'No changes were saved. The requested parent or company would leave the location in a different company than its parent.|No changes were saved. The requested parent or company would leave every one of the :count selected locations in a different company than their parent.',
    ],

];

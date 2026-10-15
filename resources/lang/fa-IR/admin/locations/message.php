<?php

return [

    'does_not_exist' => 'مکان وجود ندارد.',
    'assoc_users' => 'This location is not currently deletable because it is the location of record for at least one item or user, has assets assigned to it, or is the parent location of another location. Please update your records to no longer reference this location and try again ',
    'assoc_assets' => 'این مکان در حال حاضر همراه با حداقل یک دارایی است و قادر به حذف نمی شود. لطفا بروز دارایی های خود را به دیگر این مکان مرجع و دوباره امتحان کنید. ',
    'assoc_child_loc' => 'این مکان در حال حاضر پدر و مادر کودک حداقل یک مکان است و قادر به حذف نمی شود. لطفا به روز رسانی مکان خود را به دیگر این مکان مرجع و دوباره امتحان کنید. ',
    'assigned_assets' => 'Assigned Assets',
    'current_location' => 'Current Location',
    'deleted_warning' => 'This location has been deleted. Please restore it before attempting to make any changes.',

    'create' => [
        'error' => 'مکان ایجاد نشد،دوباره سعی کنید.',
        'success' => 'مکان با موفقیت ایجاد شد.',
    ],

    'update' => [
        'error' => 'مکان بروزرسانی نشد،دوباره سعی کنید',
        'success' => 'مکان با موفقیت به روز رسانی شد.',
    ],

    'restore' => [
        'error' => 'Location was not restored, please try again',
        'success' => 'Location restored successfully.',
    ],

    'delete' => [
        'confirm' => 'آیا مطمئن هستید که می خواهید این مکان را حذف کنید؟',
        'error' => 'یک مشکل در حذف مکان وجود دارد،دوباره سعی کنید.',
        'success' => 'این مکان با موفقیت حذف شد.',
    ],

    'bulkedit' => [
        'error' => 'هیچ فیلدی تغییر نکرده بود، بنابراین چیزی به روز نشد.',
        'success' => 'Location successfully updated.|:count locations successfully updated.',
        'warn' => 'Edit the fields below to update this location. Fields you leave blank will not change on the location.|Edit the fields below to update all :count selected locations. Fields you leave blank will not change on any of them.',
        'show_selected' => '1 selected location|:count selected locations',
        'company_scope_mismatch_partial' => 'The company was not changed on 1 location because items or users at that location belong to different companies. Update or move those first.|The company was not changed on :count locations because items or users at those locations belong to different companies. Update or move those first.',
        'company_scope_mismatch_all' => 'No locations were reassigned. The requested company does not match items or users at the selected location.|No locations were reassigned. The requested company does not match items or users at any of the :count selected locations.',
        'parent_company_mismatch_partial' => 'The parent or company was not changed on 1 location because it would leave the location in a different company than its parent.|The parent or company was not changed on :count locations because it would leave those locations in a different company than their parent.',
        'parent_company_mismatch_all' => 'No changes were saved. The requested parent or company would leave the location in a different company than its parent.|No changes were saved. The requested parent or company would leave every one of the :count selected locations in a different company than their parent.',
    ],

];

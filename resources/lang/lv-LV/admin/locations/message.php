<?php

return [

    'does_not_exist' => 'Atrašanās vietas neeksistē.',
    'assoc_users' => 'This location is not currently deletable because it is the location of record for at least one item or user, has assets assigned to it, or is the parent location of another location. Please update your records to no longer reference this location and try again ',
    'assoc_assets' => 'Pašlaik šī atrašanās vieta ir saistīta ar vismaz vienu īpašumu un to nevar izdzēst. Lūdzu, atjauniniet savus aktīvus, lai vairs nerindotu šo atrašanās vietu, un mēģiniet vēlreiz.',
    'assoc_child_loc' => 'Pašlaik šī vieta ir vismaz viena bērna atrašanās vieta un to nevar izdzēst. Lūdzu, atjauniniet savas atrašanās vietas, lai vairs nerindotu šo atrašanās vietu, un mēģiniet vēlreiz.',
    'assigned_assets' => 'Assigned Assets',
    'current_location' => 'Current Location',
    'deleted_warning' => 'This location has been deleted. Please restore it before attempting to make any changes.',

    'create' => [
        'error' => 'Atrašanās vieta nav izveidota, lūdzu, mēģiniet vēlreiz.',
        'success' => 'Atrašanās vieta ir veiksmīgi izveidota.',
    ],

    'update' => [
        'error' => 'Atrašanās vieta nav atjaunināta, lūdzu, mēģiniet vēlreiz',
        'success' => 'Atrašanās vieta ir veiksmīgi atjaunināta.',
    ],

    'restore' => [
        'error' => 'Location was not restored, please try again',
        'success' => 'Location restored successfully.',
    ],

    'delete' => [
        'confirm' => 'Vai tiešām vēlaties dzēst šo atrašanās vietu?',
        'error' => 'Radās problēma, dzēšot atrašanās vietu. Lūdzu mēģiniet vēlreiz.',
        'success' => 'Atrašanās vieta tika veiksmīgi dzēsta.',
    ],

    'bulkedit' => [
        'error' => 'Neviens laukums netika mainīts, tāpēc nekas netika atjaunināts.',
        'success' => 'Location successfully updated.|:count locations successfully updated.',
        'warn' => 'Edit the fields below to update this location. Fields you leave blank will not change on the location.|Edit the fields below to update all :count selected locations. Fields you leave blank will not change on any of them.',
        'show_selected' => '1 selected location|:count selected locations',
        'company_scope_mismatch_partial' => 'The company was not changed on 1 location because items or users at that location belong to different companies. Update or move those first.|The company was not changed on :count locations because items or users at those locations belong to different companies. Update or move those first.',
        'company_scope_mismatch_all' => 'No locations were reassigned. The requested company does not match items or users at the selected location.|No locations were reassigned. The requested company does not match items or users at any of the :count selected locations.',
        'parent_company_mismatch_partial' => 'The parent or company was not changed on 1 location because it would leave the location in a different company than its parent.|The parent or company was not changed on :count locations because it would leave those locations in a different company than their parent.',
        'parent_company_mismatch_all' => 'No changes were saved. The requested parent or company would leave the location in a different company than its parent.|No changes were saved. The requested parent or company would leave every one of the :count selected locations in a different company than their parent.',
    ],

];

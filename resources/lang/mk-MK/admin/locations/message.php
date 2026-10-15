<?php

return [

    'does_not_exist' => 'Локацијата не постои.',
    'assoc_users' => 'This location is not currently deletable because it is the location of record for at least one item or user, has assets assigned to it, or is the parent location of another location. Please update your records to no longer reference this location and try again ',
    'assoc_assets' => 'Оваа локација моментално е поврзана со барем едно основно средство и не може да се избрише. Ве молиме да ги ажурирате вашите основни средства за да не ја користите оваа локација и обидете се повторно. ',
    'assoc_child_loc' => 'Оваа локација моментално е родител на најмалку една локација и не може да се избрише. Ве молиме да ги ажурирате вашите локации повеќе да не ја користат оваа локација како родител и обидете се повторно. ',
    'assigned_assets' => 'Доделени средства',
    'current_location' => 'Моментална локација',
    'deleted_warning' => 'This location has been deleted. Please restore it before attempting to make any changes.',

    'create' => [
        'error' => 'Локацијата не е креирана, обидете се повторно.',
        'success' => 'Локацијата е успешно креирана.',
    ],

    'update' => [
        'error' => 'Локацијата не беше ажурирана, обидете се повторно',
        'success' => 'Локацијата е успешно ажурирана.',
    ],

    'restore' => [
        'error' => 'Локацијата не е обновена, ве молиме пробајте повторно',
        'success' => 'Локацијата е обновена успешно.',
    ],

    'delete' => [
        'confirm' => 'Дали сте сигурни дека сакате да ја избришете оваа локација?',
        'error' => 'Имаше проблем со бришење на локацијата. Обидете се повторно.',
        'success' => 'Локацијата беше успешно избришана.',
    ],

    'bulkedit' => [
        'error' => 'Не беа сменети полиња, затоа ништо не беше ажурирано.',
        'success' => 'Location successfully updated.|:count locations successfully updated.',
        'warn' => 'Edit the fields below to update this location. Fields you leave blank will not change on the location.|Edit the fields below to update all :count selected locations. Fields you leave blank will not change on any of them.',
        'show_selected' => '1 selected location|:count selected locations',
        'company_scope_mismatch_partial' => 'The company was not changed on 1 location because items or users at that location belong to different companies. Update or move those first.|The company was not changed on :count locations because items or users at those locations belong to different companies. Update or move those first.',
        'company_scope_mismatch_all' => 'No locations were reassigned. The requested company does not match items or users at the selected location.|No locations were reassigned. The requested company does not match items or users at any of the :count selected locations.',
        'parent_company_mismatch_partial' => 'The parent or company was not changed on 1 location because it would leave the location in a different company than its parent.|The parent or company was not changed on :count locations because it would leave those locations in a different company than their parent.',
        'parent_company_mismatch_all' => 'No changes were saved. The requested parent or company would leave the location in a different company than its parent.|No changes were saved. The requested parent or company would leave every one of the :count selected locations in a different company than their parent.',
    ],

];

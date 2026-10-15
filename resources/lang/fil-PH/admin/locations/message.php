<?php

return [

    'does_not_exist' => 'Ang lokasyon ay hindi umiiral.',
    'assoc_users' => 'This location is not currently deletable because it is the location of record for at least one item or user, has assets assigned to it, or is the parent location of another location. Please update your records to no longer reference this location and try again ',
    'assoc_assets' => 'Ang lokasyong ito ay kasalukuyang naiugnay sa hindi bumaba sa isang asset at hindi maaaring mai-delete. Mangyaring i-update ang iyong mga asset upang hindi na magreperens sa lokasyong ito at paki-subok muli. ',
    'assoc_child_loc' => 'Ang lokasyong ito ay kasalukuyang pinagmumulan sa hindi bumaba sa lokasyon isang bata at hindi maaaring mai-delete. Mangyaring i-update ang iyong mga lokasyon upang hindi na magreperens sa lokasyong ito at paki-subok muli. ',
    'assigned_assets' => 'Assigned Assets',
    'current_location' => 'Current Location',
    'deleted_warning' => 'This location has been deleted. Please restore it before attempting to make any changes.',

    'create' => [
        'error' => 'Ang lokasyon ay hindi naisagawa, mangyaring subukang muli.',
        'success' => 'Ang lokasyon ay matagumpay na naisagawa.',
    ],

    'update' => [
        'error' => 'Ang lokasyon ay hindi nai-update, mangyaring subukang muli',
        'success' => 'Ang lokasyon ay matagumpay na nai-update.',
    ],

    'restore' => [
        'error' => 'Location was not restored, please try again',
        'success' => 'Location restored successfully.',
    ],

    'delete' => [
        'confirm' => 'Sigurado kaba na gusto mong i-delete ang lokasyong ito?',
        'error' => 'Mayroong isyu sa pag-delete ng lokasyon. Mangyaring subukang muli.',
        'success' => 'Matagumpay na nai-delete ang lokasyon.',
    ],

    'bulkedit' => [
        'error' => 'Walang nabagong mga field, kaya walang nai-update.',
        'success' => 'Location successfully updated.|:count locations successfully updated.',
        'warn' => 'Edit the fields below to update this location. Fields you leave blank will not change on the location.|Edit the fields below to update all :count selected locations. Fields you leave blank will not change on any of them.',
        'show_selected' => '1 selected location|:count selected locations',
        'company_scope_mismatch_partial' => 'The company was not changed on 1 location because items or users at that location belong to different companies. Update or move those first.|The company was not changed on :count locations because items or users at those locations belong to different companies. Update or move those first.',
        'company_scope_mismatch_all' => 'No locations were reassigned. The requested company does not match items or users at the selected location.|No locations were reassigned. The requested company does not match items or users at any of the :count selected locations.',
        'parent_company_mismatch_partial' => 'The parent or company was not changed on 1 location because it would leave the location in a different company than its parent.|The parent or company was not changed on :count locations because it would leave those locations in a different company than their parent.',
        'parent_company_mismatch_all' => 'No changes were saved. The requested parent or company would leave the location in a different company than its parent.|No changes were saved. The requested parent or company would leave every one of the :count selected locations in a different company than their parent.',
    ],

];

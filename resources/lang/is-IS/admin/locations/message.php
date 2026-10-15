<?php

return [

    'does_not_exist' => 'Staðsetningin er ekki til.',
    'assoc_users' => 'This location is not currently deletable because it is the location of record for at least one item or user, has assets assigned to it, or is the parent location of another location. Please update your records to no longer reference this location and try again ',
    'assoc_assets' => 'This location is currently associated with at least one asset and cannot be deleted. Please update your assets to no longer reference this location and try again. ',
    'assoc_child_loc' => 'This location is currently the parent of at least one child location and cannot be deleted. Please update your locations to no longer reference this location and try again. ',
    'assigned_assets' => 'Skráðar eignir',
    'current_location' => 'Núverandi staðsetning',
    'deleted_warning' => 'This location has been deleted. Please restore it before attempting to make any changes.',

    'create' => [
        'error' => 'Þessi birgi var ekki stofnaður. Vinsamlegast reyndu aftur.',
        'success' => 'Stofnun staðsetingar gekk.',
    ],

    'update' => [
        'error' => 'Staðsetning var ekki uppfærð, vinsamlega reyndu aftur',
        'success' => 'Stofnun staðsetningar gekk.',
    ],

    'restore' => [
        'error' => 'Location was not restored, please try again',
        'success' => 'Location restored successfully.',
    ],

    'delete' => [
        'confirm' => 'Ertu viss um að þú vilkjir eyða þessari staðsetningu?',
        'error' => 'Það er vandamál við að eyða þessari staðsetningu. Vinsamlega reyndu aftur.',
        'success' => 'Þessari staðsetningur var eytt.',
    ],

    'bulkedit' => [
        'error' => 'Engum reitum var breytt, svo ekkert var uppfært.',
        'success' => 'Location successfully updated.|:count locations successfully updated.',
        'warn' => 'Edit the fields below to update this location. Fields you leave blank will not change on the location.|Edit the fields below to update all :count selected locations. Fields you leave blank will not change on any of them.',
        'show_selected' => '1 selected location|:count selected locations',
        'company_scope_mismatch_partial' => 'The company was not changed on 1 location because items or users at that location belong to different companies. Update or move those first.|The company was not changed on :count locations because items or users at those locations belong to different companies. Update or move those first.',
        'company_scope_mismatch_all' => 'No locations were reassigned. The requested company does not match items or users at the selected location.|No locations were reassigned. The requested company does not match items or users at any of the :count selected locations.',
        'parent_company_mismatch_partial' => 'The parent or company was not changed on 1 location because it would leave the location in a different company than its parent.|The parent or company was not changed on :count locations because it would leave those locations in a different company than their parent.',
        'parent_company_mismatch_all' => 'No changes were saved. The requested parent or company would leave the location in a different company than its parent.|No changes were saved. The requested parent or company would leave every one of the :count selected locations in a different company than their parent.',
    ],

];

<?php

return [

    'does_not_exist' => 'Kāore i te tīariari te wāhi.',
    'assoc_users' => 'This location is not currently deletable because it is the location of record for at least one item or user, has assets assigned to it, or is the parent location of another location. Please update your records to no longer reference this location and try again ',
    'assoc_assets' => 'Kei te honohia tenei taapiri ki te iti rawa o te rawa me te kore e taea te muku. Whakaorangia nga taonga ki a koe kia kaua e tautuhi i tenei tauranga ka ngana ano.',
    'assoc_child_loc' => 'Kei tenei waahi te matua o te iti rawa o te mokopuna me te kore e taea te muku. Whakaorangia nga taangata ki a koe kia kaua e tautuhi i tenei tauranga ka ngana ano.',
    'assigned_assets' => 'Assigned Assets',
    'current_location' => 'Current Location',
    'deleted_warning' => 'This location has been deleted. Please restore it before attempting to make any changes.',

    'create' => [
        'error' => 'Kāore i tuhia te wāhi, tēnā whakamātau anō.',
        'success' => 'He pai te hanganga o te wahi.',
    ],

    'update' => [
        'error' => 'Kāore i whakahoutia te wāhi, tēnā whakamātau anō',
        'success' => 'Kua whakahoutia te tau.',
    ],

    'restore' => [
        'error' => 'Location was not restored, please try again',
        'success' => 'Location restored successfully.',
    ],

    'delete' => [
        'confirm' => 'Kei te hiahia koe ki te muku i tenei tauwāhi?',
        'error' => 'He raru kei te whakakore i te tauwāhi. Tena ngana ano.',
        'success' => 'I mukua te tauwāhi.',
    ],

    'bulkedit' => [
        'error' => 'Kaore i whakarereke nga mara, naore i whakahoutia.',
        'success' => 'Location successfully updated.|:count locations successfully updated.',
        'warn' => 'Edit the fields below to update this location. Fields you leave blank will not change on the location.|Edit the fields below to update all :count selected locations. Fields you leave blank will not change on any of them.',
        'show_selected' => '1 selected location|:count selected locations',
        'company_scope_mismatch_partial' => 'The company was not changed on 1 location because items or users at that location belong to different companies. Update or move those first.|The company was not changed on :count locations because items or users at those locations belong to different companies. Update or move those first.',
        'company_scope_mismatch_all' => 'No locations were reassigned. The requested company does not match items or users at the selected location.|No locations were reassigned. The requested company does not match items or users at any of the :count selected locations.',
        'parent_company_mismatch_partial' => 'The parent or company was not changed on 1 location because it would leave the location in a different company than its parent.|The parent or company was not changed on :count locations because it would leave those locations in a different company than their parent.',
        'parent_company_mismatch_all' => 'No changes were saved. The requested parent or company would leave the location in a different company than its parent.|No changes were saved. The requested parent or company would leave every one of the :count selected locations in a different company than their parent.',
    ],

];

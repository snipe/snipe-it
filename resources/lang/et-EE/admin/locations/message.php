<?php

return [

    'does_not_exist' => 'Asukohta ei eksisteeri.',
    'assoc_users' => 'This location is not currently deletable because it is the location of record for at least one item or user, has assets assigned to it, or is the parent location of another location. Please update your records to no longer reference this location and try again ',
    'assoc_assets' => 'Selle asukohaga on seotud vähemalt üks vahend ja seda ei saa kustutada. Palun uuenda oma vahendeid, et need ei kasutaks seda asukohta ning seejärel proovi uuesti. ',
    'assoc_child_loc' => 'Sel asukohal on hetkel all-asukohti ja seda ei saa kustutada. Palun uuenda oma asukohti nii, et need ei kasutaks seda asukohta ning seejärel proovi uuesti. ',
    'assigned_assets' => 'Määratud Varad',
    'current_location' => 'Praegune asukoht',
    'deleted_warning' => 'This location has been deleted. Please restore it before attempting to make any changes.',

    'create' => [
        'error' => 'Asukohta ei loodud, palun proovi uuesti.',
        'success' => 'Asukoha loomine õnnestus.',
    ],

    'update' => [
        'error' => 'Asukohta ei uuendatud, palun proovi uuesti',
        'success' => 'Asukoha uuendamine õnnestus.',
    ],

    'restore' => [
        'error' => 'Location was not restored, please try again',
        'success' => 'Location restored successfully.',
    ],

    'delete' => [
        'confirm' => 'Oled sa kindel, et soovid selle asukoha kustutada?',
        'error' => 'Asukoha kustutamisel tekkis probleem. Palun proovi uuesti.',
        'success' => 'Asukoha kustutamine õnnestus.',
    ],

    'bulkedit' => [
        'error' => 'Ühtegi välja ei muudetud, uuendusi ei tehtud',
        'success' => 'Location successfully updated.|:count locations successfully updated.',
        'warn' => 'Edit the fields below to update this location. Fields you leave blank will not change on the location.|Edit the fields below to update all :count selected locations. Fields you leave blank will not change on any of them.',
        'show_selected' => '1 selected location|:count selected locations',
        'company_scope_mismatch_partial' => 'The company was not changed on 1 location because items or users at that location belong to different companies. Update or move those first.|The company was not changed on :count locations because items or users at those locations belong to different companies. Update or move those first.',
        'company_scope_mismatch_all' => 'No locations were reassigned. The requested company does not match items or users at the selected location.|No locations were reassigned. The requested company does not match items or users at any of the :count selected locations.',
        'parent_company_mismatch_partial' => 'The parent or company was not changed on 1 location because it would leave the location in a different company than its parent.|The parent or company was not changed on :count locations because it would leave those locations in a different company than their parent.',
        'parent_company_mismatch_all' => 'No changes were saved. The requested parent or company would leave the location in a different company than its parent.|No changes were saved. The requested parent or company would leave every one of the :count selected locations in a different company than their parent.',
    ],

];

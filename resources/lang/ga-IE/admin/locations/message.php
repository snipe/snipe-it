<?php

return [

    'does_not_exist' => 'Níl an suíomh ann.',
    'assoc_users' => 'This location is not currently deletable because it is the location of record for at least one item or user, has assets assigned to it, or is the parent location of another location. Please update your records to no longer reference this location and try again ',
    'assoc_assets' => 'Tá an suíomh seo bainteach le sócmhainn amháin ar a laghad agus ní féidir é a scriosadh. Déan do sócmhainní a thabhairt cothrom le dáta gan tagairt a dhéanamh don áit seo agus déan iarracht arís.',
    'assoc_child_loc' => 'Faoi láthair tá an suíomh seo ina tuismitheoir ar a laghad ar shuíomh leanbh amháin ar a laghad agus ní féidir é a scriosadh. Nuashonraigh do láithreacha le do thoil gan tagairt a dhéanamh don suíomh seo agus déan iarracht arís.',
    'assigned_assets' => 'Assigned Assets',
    'current_location' => 'Current Location',
    'deleted_warning' => 'This location has been deleted. Please restore it before attempting to make any changes.',

    'create' => [
        'error' => 'Níor cruthaíodh an suíomh, déan iarracht arís.',
        'success' => 'Suíomh cruthaithe go rathúil.',
    ],

    'update' => [
        'error' => 'Níor nuashonraíodh an suíomh, déan iarracht arís',
        'success' => 'Suíomh curtha chun dáta go rathúil.',
    ],

    'restore' => [
        'error' => 'Location was not restored, please try again',
        'success' => 'Location restored successfully.',
    ],

    'delete' => [
        'confirm' => 'An bhfuil tú cinnte gur mian leat an suíomh seo a scriosadh?',
        'error' => 'Bhí ceist ann a scriosadh an suíomh. Arís, le d\'thoil.',
        'success' => 'Scriosadh an suíomh go rathúil.',
    ],

    'bulkedit' => [
        'error' => 'Níor athraíodh aon réimsí, mar sin níor nuashonraíodh aon rud.',
        'success' => 'Location successfully updated.|:count locations successfully updated.',
        'warn' => 'Edit the fields below to update this location. Fields you leave blank will not change on the location.|Edit the fields below to update all :count selected locations. Fields you leave blank will not change on any of them.',
        'show_selected' => '1 selected location|:count selected locations',
        'company_scope_mismatch_partial' => 'The company was not changed on 1 location because items or users at that location belong to different companies. Update or move those first.|The company was not changed on :count locations because items or users at those locations belong to different companies. Update or move those first.',
        'company_scope_mismatch_all' => 'No locations were reassigned. The requested company does not match items or users at the selected location.|No locations were reassigned. The requested company does not match items or users at any of the :count selected locations.',
        'parent_company_mismatch_partial' => 'The parent or company was not changed on 1 location because it would leave the location in a different company than its parent.|The parent or company was not changed on :count locations because it would leave those locations in a different company than their parent.',
        'parent_company_mismatch_all' => 'No changes were saved. The requested parent or company would leave the location in a different company than its parent.|No changes were saved. The requested parent or company would leave every one of the :count selected locations in a different company than their parent.',
    ],

];

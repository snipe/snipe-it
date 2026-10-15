<?php

return [
    'not_found' => 'Údržbu zařízení, kterou hledáte, se nepodařilo najít.',
    'delete' => [
        'confirm' => 'Opravdu si přejete smazat tuto údržbu?',
        'error' => 'Při odstraňování údržby nastala chyba. Zkuste to prosím znovu.',
        'success' => 'Údržba zařízení byla úspěšně odstraněna.',
    ],
    'create' => [
        'error' => 'Údržbu zařízení se nepodařilo vytvořit, zkuste to prosím znovu.',
        'success' => 'Údržba zařízení byla v pořádku vytvořena.',
    ],
    'edit' => [
        'error' => 'Údržba majetku nebyla upravena, zkuste to prosím znovu.',
        'success' => 'Údržba majetku byla úspěšně upravena.',
    ],
    'asset_maintenance_incomplete' => 'Prozatím nedokončeno',
    'warranty' => 'Záruka',
    'not_warranty' => 'Bez záruky',
    'complete' => [
        'confirm' => 'Are you sure you want to mark this maintenance as complete? This cannot be undone.',
        'success' => 'Maintenance marked as complete.',
        'error' => 'There was an issue marking this maintenance as complete. Please try again.',
    ],
    'bulk_delete' => 'No maintenance records were deleted (:skipped skipped).|Deleted :count maintenance record. (:skipped skipped)|Deleted :count maintenance records. (:skipped skipped)',
    'bulk_complete' => 'No maintenance records were marked complete (:skipped skipped or already complete).|Marked :count maintenance record complete. (:skipped skipped or already complete)|Marked :count maintenance records complete. (:skipped skipped or already complete)',
];

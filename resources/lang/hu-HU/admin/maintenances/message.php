<?php

return [
    'not_found' => 'Az eszköz karbantartás, amit keresel, az nem létezik!',
    'delete' => [
        'confirm' => 'Biztosan törli ezt a z eszköz karbantartást?',
        'error' => 'Volt egy kérés az eszköz karbantartás törlésére. Kérjük, próbálja meg újra.',
        'success' => 'Az eszköz karbantartás sikeresen törölve lett.',
    ],
    'create' => [
        'error' => 'Eszköz karbantartás nem jött létre, próbálja meg újra.',
        'success' => 'Eszköz karbantartás sikeresen létrejött.',
    ],
    'edit' => [
        'error' => 'Az Eszközkarbantartást nem szerkesztették, próbálkozzon újra.',
        'success' => 'Eszközkarbantartás sikeresen szerkesztve.',
    ],
    'asset_maintenance_incomplete' => 'Nincs kitöltve teljesen',
    'warranty' => 'Garancia',
    'not_warranty' => 'Nem garancia',
    'complete' => [
        'confirm' => 'Are you sure you want to mark this maintenance as complete? This cannot be undone.',
        'success' => 'Maintenance marked as complete.',
        'error' => 'There was an issue marking this maintenance as complete. Please try again.',
    ],
    'bulk_delete' => 'No maintenance records were deleted (:skipped skipped).|Deleted :count maintenance record. (:skipped skipped)|Deleted :count maintenance records. (:skipped skipped)',
    'bulk_complete' => 'No maintenance records were marked complete (:skipped skipped or already complete).|Marked :count maintenance record complete. (:skipped skipped or already complete)|Marked :count maintenance records complete. (:skipped skipped or already complete)',
];

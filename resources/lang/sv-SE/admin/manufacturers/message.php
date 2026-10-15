<?php

return [

    'support_url_help' => 'Variabler <code>{LOCALE}</code>, <code>{SERIAL}</code>, <code>{MODEL_NUMBER}</code>, och <code>{MODEL_NAME}</code> kan användas i din URL för att få dessa värden att automatiskt fyllas på när du visar tillgångar - till exempel https://checkcoverage.apple.com/{LOCALE}/{SERIAL}.',
    'does_not_exist' => 'Tillverkaren existerar inte.',
    'assoc_users' => 'Tillverkaren är för tillfället associerad med minst en modell och kan inte tas bort. Vänligen uppdatera dina modeller för att inte associeras med denna tillverkare och försök igen. ',

    'create' => [
        'error' => 'Tillverkaren kunde inte skapas. Vänligen försök igen.',
        'success' => 'Tillverkare skapad.',
    ],

    'update' => [
        'error' => 'Tillverkaren kunde inte uppdateras, vänligen försök igen',
        'success' => 'Tillverkare uppdaterad.',
    ],

    'restore' => [
        'error' => 'Tillverkaren kunde inte återskapas. Vänligen försök igen',
        'success' => 'Tillverkare återskapad.',
    ],

    'delete' => [
        'confirm' => 'Är du säker på att du vill ta bort denna tillverkare?',
        'error' => 'Det gick inte att ta bort tillverkaren. Vänligen försök igen.',
        'success' => 'Tillverkare raderad.',
        'bulk_success' => 'Tillverkaren har raderats.|:count tillverkare har raderats.',
        'partial_success' => 'Tillverkaren har raderats. Se ytterligare information nedan. |:count tillverkare har raderats. Se ytterligare information nedan.',
    ],

];

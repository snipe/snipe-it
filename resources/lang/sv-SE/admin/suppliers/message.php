<?php

return array(

    'deleted' => 'Raderad leverantör',
    'does_not_exist' => 'Leverantören existerar inte.',


    'create' => array(
        'error'   => 'Leverantören kunde inte skapas. Vänligen försök igen.',
        'success' => 'Leverantör skapad.'
    ),

    'update' => array(
        'error'   => 'Leverantören kunde inte uppdateras. Vänligen försök igen.',
        'success' => 'Leverantör uppdaterad.'
    ),

    'delete' => array(
        'confirm'   => 'Är du säker på att du vill radera denna leverantör?',
        'error'   => 'Det uppstod ett problem vid radering av leverantör. Var god försök igen.',
        'success' => 'Leverantör raderad.',
        'assoc_assets'	 => 'Denna leverantör är för närvarande associerad med :asset_count tillgång(ar) och kan inte tas bort. Vänligen uppdatera dina tillgångar för att inte längre referera till denna leverantör och försök igen. ',
        'assoc_licenses'	 => 'Denna leverantör är för närvarande är associerade med :licenses_count licens(er) och kan inte tas bort. Vänligen uppdatera din(a) licens(er) för att inte längre referera till denna leverantör och försök igen. ',
        'assoc_maintenances'	 => 'Denna leverantör är för närvarande associerad med :asset_maintenances_count underhållningsposter för tillgångar och kan inte raderas. Var vänlig uppdatera dina underhållningsposter för tillgångar för att inte längre referera till denna leverantör och försök igen. ',
    )

);

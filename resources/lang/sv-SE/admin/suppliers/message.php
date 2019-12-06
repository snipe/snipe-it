<?php

return array(

    'does_not_exist' => 'Leverantören finns inte.',


    'create' => array(
        'error'   => 'Leverantören skapades inte, var god försök igen.',
        'success' => 'Leverantören skapades framgångsrikt.'
    ),

    'update' => array(
        'error'   => 'Leverantören uppdaterades inte, var god försök igen',
        'success' => 'Leverantören uppdaterades framgångsrikt.'
    ),

    'delete' => array(
        'confirm'   => 'Är du säker på att du vill radera denna leverantör?',
        'error'   => 'Det uppstod ett problem med att ta bort leverantören. Var god försök igen.',
        'success' => 'Leverantören har tagits bort.',
        'assoc_assets'	 => 'Denna leverantör är för närvarande är associerad med: asset_count tillgång(ar) och kan inte tas bort. Vänligen uppdatera dina tillgångar för att inte längre referera denna leverantör och försök igen. ',
        'assoc_licenses'	 => 'Denna leverantör är för närvarande är associerade med: licenses_count licenser (s) och kan inte tas bort. Vänligen uppdatera dina licenser för att inte längre referera denna leverantör och försök igen. ',
        'assoc_maintenances'	 => 'Denna leverantör är för närvarande associerad med: asset_maintenances_count asset maintenances (s) och kan inte raderas. Var vänlig uppdatera dina tillgångsinrättningar för att inte längre referera till denna leverantör och försök igen. ',
    )

);

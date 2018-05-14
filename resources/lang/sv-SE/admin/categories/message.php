<?php

return array(

    'does_not_exist' => 'Kategorin existerar inte. ',
    'assoc_models'	 => 'Denna kategori är för närvarande associerad med åtminstone en modell och kan inte raderas. Uppdatera dina modeller så att inga associationer finns till denna kategori och försök igen. ',
    'assoc_items'	 => 'Denna kategori är för närvarande associerad med åtminstone en :asset_type och kan inte raderas. Uppdatera din :asset_type så att inga associationer finns till denna kategori och försök igen. ',

    'create' => array(
        'error'   => 'Kategorin blev inte skapad, försök igen.',
        'success' => 'Kategorin skapades.'
    ),

    'update' => array(
        'error'   => 'Kategorin uppdaterades inte, vänligen försök igen.',
        'success' => 'kategorin uppdaterad.'
    ),

    'delete' => array(
        'confirm'   => 'Är du säker på att du vill radera denna kategori?',
        'error'   => 'Ett problem uppstod vid kategoriraderingen. Försök igen.',
        'success' => 'Kategorin raderades.'
    )

);

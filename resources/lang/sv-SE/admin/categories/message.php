<?php

return [

    'does_not_exist' => 'Kategorin existerar inte.',
    'assoc_models' => 'Denna kategori är för närvarande associerad med åtminstone en modell och kan inte raderas. Uppdatera dina modeller så att inga associationer finns till denna kategori och försök igen. ',
    'assoc_items' => 'Denna kategori är för närvarande associerad med åtminstone en :asset_type och kan inte raderas. Uppdatera din :asset_type så att inga associationer finns till denna kategori och försök igen. ',

    'create' => [
        'error' => 'Kategorin kunde inte skapas, försök igen.',
        'success' => 'Kategorin skapades.',
    ],

    'update' => [
        'error' => 'Kategorin uppdaterades inte, vänligen försök igen.',
        'success' => 'Kategorin uppdaterades.',
        'cannot_change_category_type' => 'Du kan inte ändra kategoritypen när den har skapats',
    ],

    'delete' => [
        'confirm' => 'Är du säker på att du vill radera denna kategori?',
        'error' => 'Ett problem uppstod när kategorin skulle raderas. Försök igen.',
        'success' => 'Kategorin togs bort.',
        'bulk_success' => 'Kategorin togs bort.|:count kategorier togs bort.',
        'partial_success' => 'Kategorin togs bort. Se mer information nedan. | :count kategorier togs bort. Se mer information nedan.',
    ],

    'bulkedit' => [
        'warn' => 'You are about to edit the properties of the following category:|You are about to edit the properties of the following :count categories:',
        'no_selection' => 'You must select at least one category to edit.',
        'no_changes' => 'Inga fält ändrades, så ingenting uppdaterades.',
        'success' => 'Category successfully updated.|:count categories successfully updated.',
    ],

];

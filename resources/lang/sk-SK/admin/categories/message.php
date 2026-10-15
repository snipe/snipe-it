<?php

return [

    'does_not_exist' => 'Kategória neexistuje.',
    'assoc_models' => 'Táto kategória je priradená minimálne jednému modelu, preto nemôže byť odstránená. Prosím upravte príslušný model, aby neodkazoval na túto kategóriu a skúsne znovu. ',
    'assoc_items' => 'Táto kategória je priradená minimálne jednému :aset_tzpe, preto nemôže byť odstránená. Prosím upravte príslušný :asset_type, aby neodkazoval na túto kategóriu a skúsne znovu. ',

    'create' => [
        'error' => 'Kategória nebola vytvorená, skúste prosím znovu.',
        'success' => 'Kategória bola úspešne vytvorená.',
    ],

    'update' => [
        'error' => 'Kategóriu sa nepodarilo aktualizovať, skúste prosím znovu',
        'success' => 'Kategória bola úspešne aktualizovaná.',
        'cannot_change_category_type' => 'Nie je možné upraviť kategóriu potom čo bola vytvorená',
    ],

    'delete' => [
        'confirm' => 'Ste si istý, že chceete odstrániť túto kategóriu?',
        'error' => 'Pri odstraňovaní kategórie sa vyskytla chyba. Skúste prosím znovu.',
        'success' => 'Kategória bola úspešne odstránená.',
        'bulk_success' => 'Category deleted successfully.|:count categories were deleted successfully.',
        'partial_success' => 'Kategória bola úspešne odstránená. Podrobné informácie nižšie. | :count kategórií bolo úspešne odstránených. Podrobné informácie nižšie.',
    ],

    'bulkedit' => [
        'warn' => 'You are about to edit the properties of the following category:|You are about to edit the properties of the following :count categories:',
        'no_selection' => 'You must select at least one category to edit.',
        'no_changes' => 'Neboli zmenené žiadne polia, preto nebolo nič aktualizované.',
        'success' => 'Category successfully updated.|:count categories successfully updated.',
    ],

];

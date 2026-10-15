<?php

return [

    'does_not_exist' => 'Kategorie neexistuje.',
    'assoc_models' => 'Tato kategorie obsahuje nejméně jeden model majetku a nemůže být proto odstraněna. Změňte kategorii v dotyčných modelech majetku a zkuste to znovu. ',
    'assoc_items' => 'Tato kategorie obsahuje nejméně jeden :asset_type a nemůže být proto odstraněna. Změňte kategorii v dotyčných :asset_type a zkuste to znovu. ',

    'create' => [
        'error' => 'Kategorie nebyla vytvořena, zkuste to znovu prosím.',
        'success' => 'Kategorie byla úspěšně vytvořena.',
    ],

    'update' => [
        'error' => 'Kategorie nebyla aktualizována, zkuste to znovu prosím',
        'success' => 'Kategorie aktualizována úspěšně.',
        'cannot_change_category_type' => 'Jakmile byla kategorie vytvořena, nelze měnit její typ',
    ],

    'delete' => [
        'confirm' => 'Opravdu chcete smazat tuto kategorii na trvalo?',
        'error' => 'Vyskytl se problém při mazání kategorie. Zkuste to znovu prosím.',
        'success' => 'Kategorie byla úspěšně smazána.',
        'bulk_success' => 'Category deleted successfully.|:count categories were deleted successfully.',
        'partial_success' => 'Kategorie byla úspěšně smazána. Viz doplňující informace níže. | :count kategorií bylo úspěšně smazáno. Viz doplňující informace níže.',
    ],

    'bulkedit' => [
        'warn' => 'You are about to edit the properties of the following category:|You are about to edit the properties of the following :count categories:',
        'no_selection' => 'You must select at least one category to edit.',
        'no_changes' => 'Žádné pole nebyly změněny, takže nic nebylo aktualizováno.',
        'success' => 'Category successfully updated.|:count categories successfully updated.',
    ],

];

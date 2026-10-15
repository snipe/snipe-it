<?php

return [

    'does_not_exist' => 'Lokalita neexistuje.',
    'assoc_users' => 'Túto lokalitu momentálne nie je možné odstrániť, pretože je použitá pre aspoň jednu položku alebo používateľa, má priradené majetky alebo je nadradenou lokalitou inej lokality. Aktualizujte svoje záznamy tak, aby už neodkazovali na túto lokalitu a skúste to znova.',
    'assoc_assets' => 'Táto lokalita je priradená minimálne jednému majetku, preto nemôže byť odstránená. Prosím odstráňte referenciu na túto lokalitu z príslušného majetku a skúste znovu. ',
    'assoc_child_loc' => 'Táto lokalita je nadradenou minimálne jednej podradenej lokalite, preto nemôže byť odstránená. Prosím odstráňte referenciu s príslušnej lokality a skúste znovu. ',
    'assigned_assets' => 'Priradené položky majetku',
    'current_location' => 'Aktuálna lokalita',
    'deleted_warning' => 'Táto lokalita bolo odstránené. Pred vykonaním akýchkoľvek zmien ju obnovte.',

    'create' => [
        'error' => 'Lokalita nebola vytvorená, skúste prosím znovu.',
        'success' => 'Lokalita bola úspešne vytovrená.',
    ],

    'update' => [
        'error' => 'Lokalita nebola aktualizovaná, skúste prosím znovu',
        'success' => 'Lokalita bola úspešne upravená.',
    ],

    'restore' => [
        'error' => 'Lokalita nebola obnovená, prosím skúste znovu',
        'success' => 'Lokalita bola úspešne obnovená.',
    ],

    'delete' => [
        'confirm' => 'Ste si istý, že chcete odstrániť túto lokalitu?',
        'error' => 'Pri odstraňovaní lokality nastala chyba. Skúste prosím znovu.',
        'success' => 'Lokalita bola úspešne odstránená.',
    ],

    'bulkedit' => [
        'error' => 'Neboli zmenené žiadne polia, preto nebolo nič aktualizované.',
        'success' => 'Location successfully updated.|:count locations successfully updated.',
        'warn' => 'Edit the fields below to update this location. Fields you leave blank will not change on the location.|Edit the fields below to update all :count selected locations. Fields you leave blank will not change on any of them.',
        'show_selected' => '1 selected location|:count selected locations',
        'company_scope_mismatch_partial' => 'The company was not changed on 1 location because items or users at that location belong to different companies. Update or move those first.|The company was not changed on :count locations because items or users at those locations belong to different companies. Update or move those first.',
        'company_scope_mismatch_all' => 'No locations were reassigned. The requested company does not match items or users at the selected location.|No locations were reassigned. The requested company does not match items or users at any of the :count selected locations.',
        'parent_company_mismatch_partial' => 'The parent or company was not changed on 1 location because it would leave the location in a different company than its parent.|The parent or company was not changed on :count locations because it would leave those locations in a different company than their parent.',
        'parent_company_mismatch_all' => 'No changes were saved. The requested parent or company would leave the location in a different company than its parent.|No changes were saved. The requested parent or company would leave every one of the :count selected locations in a different company than their parent.',
    ],

];

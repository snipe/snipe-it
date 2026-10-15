<?php

return [

    'deleted' => 'Odstránený model majetku',
    'does_not_exist' => 'Model neexistuje.',
    'no_association' => 'VAROVANIE! Model majetku pre túto položku je neplatný alebo neexistuje!',
    'no_association_fix' => 'Tento stav môže spôsobiť nepredvídateľné problémy. Priraďte danému majetku správny model.',
    'assoc_users' => 'Tento model je použitý v jednom alebo viacerých majetkoch, preto nemôže byť odstránený. Prosím odstráňte príslušný majetok a skúste odstrániť znovu. ',
    'invalid_category_type' => 'Táto kategória musí byť kategóriou majetku.',

    'create' => [
        'error' => 'Model nebol vytovrený, prosím skúste znovu.',
        'success' => 'Model bol úspešne vytvorený.',
        'duplicate_set' => 'Model majetku s týmto názvom, výrobcom a číslom modelu už existuje.',
    ],

    'update' => [
        'error' => 'Model nebol upravený, prosím skúste znovu',
        'success' => 'Model bol úspešne upravený.',
    ],

    'delete' => [
        'confirm' => 'Ste si istý, že chcete odstrániť tento model majetku?',
        'error' => 'Pri odstraňovaní modelu sa vyskytla chyba. Skúste prosím znovu.',
        'success' => 'Model bol úspešne odstránený.',
    ],

    'restore' => [
        'error' => 'Model nebol obnovený, prosím skúste znovu',
        'success' => 'Model bol obnovený úspešne.',
    ],

    'bulkedit' => [
        'error' => 'Neboli zmenené žiadne polia, preto nebolo nič aktualizované.',
        'success' => 'Model bol úspešne upravený. |:model_count modelov bolo úspešne upravených.',
        'warn' => 'Chystáte sa upraviť nastavenia nasledovného modelu:|Chystáte sa upraviť nastavenia nasledovných :model_count modelov:',

    ],

    'bulkdelete' => [
        'error' => 'Neboli vybrané ziadne modely, preto nebolo nič odmazané.',
        'nothing_deletable' => 'None of the selected models can be deleted because they still have assets associated with them.',
        'success' => 'Model zmazaný!|:success_count_models modelov zmazaných!',
        'success_partial' => ':success_count model(y) odstránené, avšak :fail_count nebolo možné odstrániť pretože stále majú priradené majetky.',
    ],

    'merge' => [
        'min_two' => 'Select at least two models to merge.',
        'no_target' => 'Select which model to keep before merging.',
        'not_found' => 'One or more of the selected models could not be loaded. Refresh the models list and try again.',
        'information' => 'You are about to merge :count models. Pick the model you want to keep. Every asset attached to the other models will be reassigned to the model you pick, then the source models will be deleted.',
        'warning' => 'This cannot be undone. Reassigned assets will inherit the surviving model\'s category, fieldset, and depreciation settings.',
        'pick_target' => 'Which model do you want to keep?',
        'success' => 'Merged :source_count model(s) into ":target". :asset_count asset(s) were reassigned.',
    ],

];

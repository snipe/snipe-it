<?php

return array(

    'does_not_exist' => 'Model neexistuje.',
    'assoc_users'	 => 'Tento model je použítý v jednom alebo viacerých majetkoch, preto nemôže byť odstránený. Prosím odstráňte príslušný majetok a skúste odstrániť znovu. ',


    'create' => array(
        'error'   => 'Model nebol vytovrený, prosím skúste znovu.',
        'success' => 'Model bol úspešne vytvorený.',
        'duplicate_set' => 'Model majetku s týmto názvom, výrobcom a číslom modelu už existuje.',
    ),

    'update' => array(
        'error'   => 'Model nebol upravený, prosím skúste znovu',
        'success' => 'Model bol úspešne upravený.'
    ),

    'delete' => array(
        'confirm'   => 'Ste si istý, že chcete odstrániť tento model majetku?',
        'error'   => 'Pri odstraňovaní modelu sa vyskytla chyba. Skúste prosím znovu.',
        'success' => 'Model bol úspešne odstránený.'
    ),

    'restore' => array(
        'error'   		=> 'Model nebol obnovený, prosím skúste znovu',
        'success' 		=> 'Model bol obnovený úspešne.'
    ),

    'bulkedit' => array(
        'error'   		=> 'Neboli zmenené žiadne polia, preto nebolo nič aktualizované.',
        'success' 		=> 'Model bol upravený.'
    ),

    'bulkdelete' => array(
        'error'   		    => 'Neboli vybrané ziadne modely, preto nebolo nič odmazané.',
        'success' 		    => ':success_count model(y) vymazaný(é)!',
        'success_partial' 	=> ':success_count model(y) odstránené, avšak :fail_count nebolo možné odstrániť pretože stále majú priradené majetky.'
    ),

);

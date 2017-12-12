<?php

return array(

    'does_not_exist' => 'Modell nem létezik.',
    'assoc_users'	 => 'Ez a modell jelenleg társított egy vagy több eszközhöz, és nem törölhető. Legyen szíves törölje az eszközt, és próbálja meg ismét a modell törlését. ',


    'create' => array(
        'error'   => 'A model nem lett létrehozva. Próbálkozz újra.',
        'success' => 'A modell sikeresen létrehozva.',
        'duplicate_set' => 'Már létezik ilyen nevű eszközmodell, gyártó és modellszám.',
    ),

    'update' => array(
        'error'   => 'A modell nem frissült, próbálkozzon újra',
        'success' => 'A modell sikeresen frissült.'
    ),

    'delete' => array(
        'confirm'   => 'Biztos benne, hogy törli ezt az eszközmodellt?',
        'error'   => 'A modell törlését okozta. Kérlek próbáld újra.',
        'success' => 'A modell sikeresen törölve lett.'
    ),

    'restore' => array(
        'error'   		=> 'A modell nem állt helyre, próbálkozzon újra',
        'success' 		=> 'A modell sikeresen visszaállt.'
    ),

    'bulkedit' => array(
        'error'   		=> 'Nincsenek mezők megváltoztak, így semmi sem frissült.',
        'success' 		=> 'Modellek frissítve.'
    ),

    'bulkdelete' => array(
        'error'   		    => 'No models were selected, so nothing was deleted.',
        'success' 		    => ':success_count model(s) deleted!',
        'success_partial' 	=> ':success_count model(s) were deleted, however :fail_count were unable to be deleted because they still have assets associated with them.'
    ),

);

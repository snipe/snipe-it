<?php

return array(

    'does_not_exist' => 'Modell nem létezik.',
    'no_association' => 'Nincs modell hozzárendelve.',
    'no_association_fix' => 'Ez furcsa és szörnyű módokon fogja szétzúzni a dolgokat. Szerkeszd ezt az eszközt most, és rendeld hozzá egy modellhez.',
    'assoc_users'	 => 'Ez a modell jelenleg társított egy vagy több eszközhöz, és nem törölhető. Legyen szíves törölje az eszközt, és próbálja meg ismét a modell törlését. ',


    'create' => array(
        'error'   => 'A model nem lett létrehozva. Próbálkozz újra.',
        'success' => 'A modell sikeresen létrehozva.',
        'duplicate_set' => 'Már létezik ilyen nevű eszközmodell, gyártó és modellszám.',
    ),

    'update' => array(
        'error'   => 'A modell nem frissült, próbálkozzon újra',
        'success' => 'A modell sikeresen frissült.',
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
        'success' 		=> 'Eszköz modell sikeresen frissítve. Összesen |:model_count eszköz frissítve.',
        'warn'          => 'You are about to update the properies of the following model: |You are about to edit the properties of the following :model_count models:',

    ),

    'bulkdelete' => array(
        'error'   		    => 'Nem voltak eszközök kiválasztva, így semmi sem lett törölve.',
        'success' 		    => 'Eszköz modell törölve! Összesen |:success_count eszköz törölve!',
        'success_partial' 	=> ': success_count modell(ek) törlésre kerültek, azonban ennyit nem sikerült törölni: a fail_count , mert még hozzárendelt eszközökkel rendelkeznek.'
    ),

);

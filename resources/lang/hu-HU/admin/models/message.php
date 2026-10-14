<?php

return [

    'deleted' => 'Törölt eszköz modell',
    'does_not_exist' => 'Modell nem létezik.',
    'no_association' => 'FIGYELEM! Az eszköz modell hiányzik, vagy nem érvényes!',
    'no_association_fix' => 'Ez furcsa és szörnyű módokon fogja szétzúzni a dolgokat. Szerkeszd ezt az eszközt most, és rendeld hozzá egy modellhez.',
    'assoc_users' => 'Ez a modell jelenleg társított egy vagy több eszközhöz, és nem törölhető. Legyen szíves törölje az eszközt, és próbálja meg ismét a modell törlését. ',
    'invalid_category_type' => 'A kategóriának eszköz típusúnak kell lennie.',

    'create' => [
        'error' => 'A model nem lett létrehozva. Próbálkozz újra.',
        'success' => 'A modell sikeresen létrehozva.',
        'duplicate_set' => 'Már létezik egy eszközmodell ezzel a névvel, gyártóval és modellszámmal.',
    ],

    'update' => [
        'error' => 'A modell nem frissült, próbálkozzon újra',
        'success' => 'A modell sikeresen frissült.',
    ],

    'delete' => [
        'confirm' => 'Biztos benne, hogy törli ezt az eszközmodellt?',
        'error' => 'Hiba történt a modell törlése közben. Próbálja újra.',
        'success' => 'A modell sikeresen törölve lett.',
    ],

    'restore' => [
        'error' => 'A modell nem állt helyre, próbálkozzon újra',
        'success' => 'A modell sikeresen visszaállt.',
    ],

    'bulkedit' => [
        'error' => 'Nincsenek mezők megváltoztak, így semmi sem frissült.',
        'success' => 'Eszköz modell sikeresen frissítve. Összesen |:model_count eszköz frissítve.',
        'warn' => 'A következő modell tulajdonságait fogja frissíteni:|A következő modellek tulajdonságait fogja szerkeszteni :model_count :',

    ],

    'bulkdelete' => [
        'error' => 'Nem voltak eszközök kiválasztva, így semmi sem lett törölve.',
        'nothing_deletable' => 'A kiválasztott modellek egyike sem törölhető, mert még tartoznak hozzájuk eszközök.',
        'success' => 'Eszköz modell törölve! Összesen |:success_count eszköz törölve!',
        'success_partial' => ': success_count modell(ek) törlésre kerültek, azonban ennyit nem sikerült törölni: a fail_count , mert még hozzárendelt eszközökkel rendelkeznek.',
    ],

    'merge' => [
        'min_two' => 'Az egyesítéshez válasszon ki legalább két modellt.',
        'no_target' => 'Válassza ki a megtartani kívánt modellt az egyesítés előtt.',
        'not_found' => 'Az összevonás előtt válassza ki a megtartandó modellt.',
        'information' => ':count modell összevonására készül. Válassza ki a megtartandó modellt. A többi modellhez tartozó összes eszköz ehhez a modellhez lesz átrendelve, majd a forrásmodellek törlésre kerülnek.',
        'warning' => 'Ez a művelet nem vonható vissza. Az átrendelt eszközök a megtartott modell kategóriáját, mezőcsoportját és értékcsökkenési beállításait öröklik.',
        'pick_target' => 'Melyik modellt kívánja megtartani?',
        'success' => ':source_count modell összevonva a(z) „:target” modellbe. :asset_count eszköz átrendelve.',
    ],

];

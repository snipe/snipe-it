<?php

return [

    'deleted' => 'Raderad tillgångsmodell',
    'does_not_exist' => 'Modellen finns inte.',
    'no_association' => 'VARNING! Tillgångsmodellen för detta objekt är ogiltig eller saknas!',
    'no_association_fix' => 'Detta kommer att förstöra saker på märkliga sätt. Redigera denna tillgång nu för att tilldela det till en modell.',
    'assoc_users' => 'Denna modell är redan associerad med en eller flera tillgångar och kan inte tas bort. Ta bort tillgången och försök sedan igen. ',
    'invalid_category_type' => 'Denna kategori måste vara en tillgångskategori.',

    'create' => [
        'error' => 'Modellen skapades inte, försök igen.',
        'success' => 'Modellen skapad.',
        'duplicate_set' => 'En tillgångsmodell med det namnet, tillverkaren och modellnumret finns redan.',
    ],

    'update' => [
        'error' => 'Modellen uppdaterades inte, försök igen',
        'success' => 'Modellen uppdaterades.',
    ],

    'delete' => [
        'confirm' => 'Är du säker på att du vill ta bort denna modell?',
        'error' => 'Kunde inte ta bort modellen. Försök igen.',
        'success' => 'Modellen borttagen.',
    ],

    'restore' => [
        'error' => 'Modellen kunde inte återskapas, försök igen',
        'success' => 'Modellen återskapades.',
    ],

    'bulkedit' => [
        'error' => 'Inga fält ändrades, så ingenting uppdaterades.',
        'success' => 'Modellen har uppdaterats. |:model_count modeller har uppdaterats.',
        'warn' => 'Du är på väg att uppdatera egenskaperna för följande modell:|Du håller på att redigera egenskaperna för följande :model_count modeller:',

    ],

    'bulkdelete' => [
        'error' => 'Inga tillgångar valdes, så ingenting togs bort.',
        'nothing_deletable' => 'Ingen av de valda modellerna kan tas bort eftersom de fortfarande har tillgångar kopplade till dem.',
        'success' => 'Modell borttagen! |:success_count modeller borttagna!',
        'success_partial' => ':success_count modell(erna) raderades, men :fail_count kunde inte raderas eftersom de fortfarande har tillgångar kopplade till sig.',
    ],

    'merge' => [
        'min_two' => 'Välj minst två modeller att slå samman.',
        'no_target' => 'Välj vilken modell som ska behållas innan du slår samman.',
        'not_found' => 'Det gick inte att läsa in en eller flera av de valda modellerna. Uppdatera modellistan och försök igen.',
        'information' => 'Du är på väg att slå samman :count modeller. Välj den modell du vill behålla. Alla tillgångar som är kopplade till de andra modellerna flyttas till den valda modellen och sedan tas de ursprungliga modellerna bort.',
        'warning' => 'Detta kan inte ångras. Flyttade tillgångar ärver den kvarvarande modellens kategori, fältuppsättning och avskrivningsinställningar.',
        'pick_target' => 'Vilken modell vill du behålla?',
        'success' => ':source_count modell(er) har slagits samman med ”:target”. :asset_count tillgång(ar) har flyttats.',
    ],

];

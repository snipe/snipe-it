<?php

return array(

    'does_not_exist' => 'Šablons nepastāv.',
    'assoc_users'	 => 'Šobrīd šis šablons ir saistīts ar vienu vai vairākiem aktīviem, un to nevar izdzēst. Lūdzu, izdzēsiet aktīvus un pēc tam mēģiniet vēlreiz dzēst.',


    'create' => array(
        'error'   => 'Neizdevās izveidot šablonu, lūdzu, mēģiniet vēlreiz.',
        'success' => 'Šablons tika veiksmīgi izveidots.',
        'duplicate_set' => 'Aktīva šablons ar šo nosaukumu, ražotāju un modeļa numuru jau pastāv.',
    ),

    'update' => array(
        'error'   => 'Neizdevās atjaunināt šablonu, lūdzu, mēģiniet vēlreiz',
        'success' => 'Šablons tika veiksmīgi atjaunināts.'
    ),

    'delete' => array(
        'confirm'   => 'Vai tiešām vēlaties izdzēst šo aktīva šablonu?',
        'error'   => 'Radās problēma, izdzēšot šablonu. Lūdzu, mēģiniet vēlreiz.',
        'success' => 'Šablons tika veiksmīgi izdzēsts.'
    ),

    'restore' => array(
        'error'   		=> 'Neizdevās atjaunot šablonu, lūdzu, mēģiniet vēlreiz',
        'success' 		=> 'Šablons tika veiksmīgi atjaunots.'
    ),

    'bulkedit' => array(
        'error'   		=> 'Neviens laukums netika mainīts, tāpēc nekas netika atjaunināts.',
        'success' 		=> 'Šabloni tika atjaunināti.'
    ),

    'bulkdelete' => array(
        'error'   		    => 'Nav atlasītu šablonu, tāpēc nekas netika izdzēsts.',
        'success' 		    => '{1} :success_count šablons dzēsts!|[2,*] :success_count šabloni dzēsti!',
        'success_partial' 	=> ':success_count šablons(-i) dzēsts(-i), tomēr neizdevās idzēst :fail_count šablonus, jo tiem ir piesaistītas aparatūras.'
    ),

);

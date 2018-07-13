<?php

return array(

    'does_not_exist' => 'Mudelit pole olemas.',
    'assoc_users'	 => 'See mudel on seostus ühe või mitme vahendiga ja seda ei saa kustutada. Palun kustuta vahendid ja seejärel proovi uuesti kustutada. ',


    'create' => array(
        'error'   => 'Mudelit ei loodud, proovi uuesti.',
        'success' => 'Mudeli loomine õnnestus.',
        'duplicate_set' => 'Sellise nime, tootja ja mudeli numbriga mudel on juba olemas.',
    ),

    'update' => array(
        'error'   => 'Mudelit ei uuendatud, proovige uuesti',
        'success' => 'Mudeli uuendamine õnnestus.'
    ),

    'delete' => array(
        'confirm'   => 'Kas oled kindel, et soovid selle mudeli kustutada?',
        'error'   => 'Mudeli kustutamisel tekkis probleem. Palun proovi uuesti.',
        'success' => 'Mudeli kustutamine õnnestus.'
    ),

    'restore' => array(
        'error'   		=> 'Mudeli taastamine ei õnnestunud, proovi uuesti',
        'success' 		=> 'Mudeli taastamine õnnestus.'
    ),

    'bulkedit' => array(
        'error'   		=> 'Pole ühtegi välju muudetud, mistõttu ei uuendatud midagi.',
        'success' 		=> 'Mudelid on uuendatud.'
    ),

    'bulkdelete' => array(
        'error'   		    => 'No models were selected, so nothing was deleted.',
        'success' 		    => ':success_count model(s) deleted!',
        'success_partial' 	=> ':success_count model(s) were deleted, however :fail_count were unable to be deleted because they still have assets associated with them.'
    ),

);

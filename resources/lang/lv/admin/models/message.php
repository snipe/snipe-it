<?php

return array(

    'does_not_exist' => 'Modelis nepastāv.',
    'assoc_users'	 => 'Šobrīd šis modelis ir saistīts ar vienu vai vairākiem aktīviem, un tos nevar izdzēst. Lūdzu, izdzēsiet aktīvus un pēc tam mēģiniet vēlreiz dzēst.',


    'create' => array(
        'error'   => 'Modelis netika izveidots, lūdzu, mēģiniet vēlreiz.',
        'success' => 'Modelis veiksmīgi izveidots.',
        'duplicate_set' => 'Aktīvu modelis ar šo nosaukumu, ražotāju un modeļa numuru jau pastāv.',
    ),

    'update' => array(
        'error'   => 'Modelis nav atjaunināts, lūdzu, mēģiniet vēlreiz',
        'success' => 'Modelis tika veiksmīgi atjaunināts.'
    ),

    'delete' => array(
        'confirm'   => 'Vai tiešām vēlaties dzēst šo aktīvu modeli?',
        'error'   => 'Radās problēma, izdzēšot modeli. Lūdzu mēģiniet vēlreiz.',
        'success' => 'Modelis tika veiksmīgi dzēsts.'
    ),

    'restore' => array(
        'error'   		=> 'Modelis netika atjaunots, lūdzu, mēģiniet vēlreiz',
        'success' 		=> 'Veiksmīgi atjaunots modelis.'
    ),

    'bulkedit' => array(
        'error'   		=> 'Neviens laukums netika mainīts, tāpēc nekas netika atjaunināts.',
        'success' 		=> 'Modeļi ir atjaunināti.'
    ),

    'bulkdelete' => array(
        'error'   		    => 'No models were selected, so nothing was deleted.',
        'success' 		    => ':success_count model(s) deleted!',
        'success_partial' 	=> ':success_count model(s) were deleted, however :fail_count were unable to be deleted because they still have assets associated with them.'
    ),

);

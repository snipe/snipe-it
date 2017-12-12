<?php

return array(

    'does_not_exist' => 'Tokio modelio nėra.',
    'assoc_users'	 => 'Šis modelis šiuo metu susietas su daugiau nei vienu įrangos vientu ir negali būti ištrintas. Prašome ištrinkite įrangą ir tuomet bandykite trinti iš naujo. ',


    'create' => array(
        'error'   => 'Modelis nebuvo ištrintas, prašome bandykite iš naujo.',
        'success' => 'Modelis sėkmingai sukurtas.',
        'duplicate_set' => 'Įrangos modelis su šiuo pavadinimu, gamintoju ir modeliu numeriu jau yra.',
    ),

    'update' => array(
        'error'   => 'Modelis nebuvo atnaujintas, prašome bandykite iš naujo',
        'success' => 'Modelis sėkmingai atnaujintas.'
    ),

    'delete' => array(
        'confirm'   => 'Ar jūs tikrai norite ištrinti šios įrangos modelį?',
        'error'   => 'Nepavyko ištrinti modelio. Prašome bandykite dar kartą.',
        'success' => 'Modelis sėkmingai ištrintas.'
    ),

    'restore' => array(
        'error'   		=> 'Modelis nebuvo atkurtas, prašome bandykite dar kartą',
        'success' 		=> 'Modelis sėkmingai atkurtas.'
    ),

    'bulkedit' => array(
        'error'   		=> 'Nebuvo pakeista jokių laukų, todėl niekas nebuvo atnaujintas.',
        'success' 		=> 'Modeliai atnaujinti.'
    ),

    'bulkdelete' => array(
        'error'   		    => 'No models were selected, so nothing was deleted.',
        'success' 		    => ':success_count model(s) deleted!',
        'success_partial' 	=> ':success_count model(s) were deleted, however :fail_count were unable to be deleted because they still have assets associated with them.'
    ),

);

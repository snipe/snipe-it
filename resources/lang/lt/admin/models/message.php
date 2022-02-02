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
        'error'   		    => 'Nepasirinktas modelis, nėra ką ištrinti.',
        'success' 		    => ':success_count model(s) ištrinti!',
        'success_partial' 	=> ':success_count model(s) buvo ištrinti, bet :fail_count negalima ištrinti todėl, kad turtas vis dar susietas.'
    ),

);

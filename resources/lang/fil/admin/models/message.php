<?php

return array(

    'does_not_exist' => 'Ang modelo ay hindi umiiral.',
    'assoc_users'	 => 'Ang modelong ito ay kasalukuyang nai-ugnay sa isa o higit pang mga asset at hindi maaaring mai-delete. Paki-delete ng mga model na ito, at pagkatapos subukang i-delete muli. ',


    'create' => array(
        'error'   => 'Ang modelo ay hindi naisagawa, mangyaring subukang muli.',
        'success' => 'Ang modelo ay matagumpay na naisagawa.',
        'duplicate_set' => 'Ang modelo ng asset na may ganyang pangalan, ang tagapagsagawa at ang modelo ay umiiral na.',
    ),

    'update' => array(
        'error'   => 'Ang modelo ay hindi nai-update, mangyaring subukang muli',
        'success' => 'Ang modelo ay matagumpay na nai-update.'
    ),

    'delete' => array(
        'confirm'   => 'Sigurado kaba na gusto mong i-delete ang modelo ng asset?',
        'error'   => 'Mayroong isyu sa pag-delete ng modelo. Mangyaring subukang muli.',
        'success' => 'Matagumpay na nai-delete ang modelo.'
    ),

    'restore' => array(
        'error'   		=> 'Ang modelo ay hindi naibalik sa dati, mangyaring subukang muli',
        'success' 		=> 'Ang modelo ay matagumpay na naibalik.'
    ),

    'bulkedit' => array(
        'error'   		=> 'Walang nabagong mga field, kaya walang nai-update.',
        'success' 		=> 'Ang mga modelo ay naiupdate na.'
    ),

    'bulkdelete' => array(
        'error'   		    => 'Walang napiling mga model, kaya walang nai-delete.',
        'success' 		    => ':success_count model(s) na-delete na!',
        'success_partial' 	=> ':success_count ang mga modelo ay na-delete na, gayunpaman ::success_count ang mga modelo ay hindi mai-delete dahil sa mayron pa silang asset na naiuugnay sa kanila.'
    ),

);

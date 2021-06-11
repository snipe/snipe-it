<?php

return [

    'does_not_exist' => 'Model ne obstaja.',
    'assoc_users'	 => 'Ta model je trenutno povezan z enim ali več sredstvi in ​​ga ni mogoče izbrisati. Prosimo, izbrišite sredstva in poskusite zbrisati znova. ',

    'create' => [
        'error'   => 'Model ni bil ustvarjen, poskusite znova.',
        'success' => 'Model je bil uspešno ustvarjen.',
        'duplicate_set' => 'Model sredstva s tem imenom, proizvajalcem in številko modela že obstaja.',
    ],

    'update' => [
        'error'   => 'Model ni bil posodobljen, poskusite znova',
        'success' => 'Model je bil uspešno posodobljen.',
    ],

    'delete' => [
        'confirm'   => 'Ali ste prepričani, da želite izbrisati ta model sredstva?',
        'error'   => 'Prišlo je do težave pri brisanju modela. Prosim poskusite ponovno.',
        'success' => 'Model je bil uspešno izbrisan.',
    ],

    'restore' => [
        'error'   		=> 'Model ni bil obnovljen, poskusite znova',
        'success' 		=> 'Model je bil uspešno obnovljen.',
    ],

    'bulkedit' => [
        'error'   		=> 'Polja niso bila spremenjena, nič ni posodobljeno.',
        'success' 		=> 'Modeli so posodobljeni.',
    ],

    'bulkdelete' => [
        'error'   		    => 'Modeli niso bili izbrani, nič ni izbrisano.',
        'success' 		    => ': model (i) so izbrisani!',
        'success_partial' 	=> ': modeli so bili izbrisani, vendar: fail_count ni bilo mogoče izbrisati, ker so še vedno sredstva, povezana z njimi.',
    ],

];

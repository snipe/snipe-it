<?php

return array(

    'does_not_exist' => 'Model ne obstaja.',
    'no_association' => 'NO MODEL ASSOCIATED.',
    'no_association_fix' => 'This will break things in weird and horrible ways. Edit this asset now to assign it a model.',
    'assoc_users'	 => 'Ta model je trenutno povezan z enim ali več sredstvi in ​​ga ni mogoče izbrisati. Prosimo, izbrišite sredstva in poskusite zbrisati znova. ',


    'create' => array(
        'error'   => 'Model ni bil ustvarjen, poskusite znova.',
        'success' => 'Model je bil uspešno ustvarjen.',
        'duplicate_set' => 'Model sredstva s tem imenom, proizvajalcem in številko modela že obstaja.',
    ),

    'update' => array(
        'error'   => 'Model ni bil posodobljen, poskusite znova',
        'success' => 'Model je bil uspešno posodobljen.',
    ),

    'delete' => array(
        'confirm'   => 'Ali ste prepričani, da želite izbrisati ta model sredstva?',
        'error'   => 'Prišlo je do težave pri brisanju modela. Prosim poskusite ponovno.',
        'success' => 'Model je bil uspešno izbrisan.'
    ),

    'restore' => array(
        'error'   		=> 'Model ni bil obnovljen, poskusite znova',
        'success' 		=> 'Model je bil uspešno obnovljen.'
    ),

    'bulkedit' => array(
        'error'   		=> 'Polja niso bila spremenjena, nič ni posodobljeno.',
        'success' 		=> 'Model successfully updated. |:model_count models successfully updated.',
        'warn'          => 'You are about to update the properies of the following model: |You are about to edit the properties of the following :model_count models:',

    ),

    'bulkdelete' => array(
        'error'   		    => 'Modeli niso bili izbrani, nič ni izbrisano.',
        'success' 		    => 'Model deleted!|:success_count models deleted!',
        'success_partial' 	=> ': modeli so bili izbrisani, vendar: fail_count ni bilo mogoče izbrisati, ker so še vedno sredstva, povezana z njimi.'
    ),

);

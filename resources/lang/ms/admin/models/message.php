<?php

return array(

    'does_not_exist' => 'Model tidak wujud.',
    'no_association' => 'NO MODEL ASSOCIATED.',
    'no_association_fix' => 'This will break things in weird and horrible ways. Edit this asset now to assign it a model.',
    'assoc_users'	 => 'Model ini sekarang disekutukan dengan sekurang2nya satu atau lebih harta dan tidak boleh dihapuskan. Sila kemaskini harta, dan kemudian cuba lagi. ',


    'create' => array(
        'error'   => 'Model gagal dicipta, sila cuba lagi.',
        'success' => 'Model berjaya dicipta.',
        'duplicate_set' => 'Model aset dengan nama itu, pengeluar dan nombor model sudah ada.',
    ),

    'update' => array(
        'error'   => 'Model gagal dikemaskin, sila cuba lagi',
        'success' => 'Model berjaya dikemaskini.',
    ),

    'delete' => array(
        'confirm'   => 'Anda pasti anda ingin hapuskan model harta ini?',
        'error'   => 'Ada isu semasa menghapuskan model. Sila cuba lagi.',
        'success' => 'Model berjaya dihapuskan.'
    ),

    'restore' => array(
        'error'   		=> 'Model tidak dipulihkan, sila cuba lagi',
        'success' 		=> 'Model berjaya dipulihkan.'
    ),

    'bulkedit' => array(
        'error'   		=> 'Tiada medan berubah, jadi tiada apa yang dikemas kini.',
        'success' 		=> 'Model successfully updated. |:model_count models successfully updated.',
        'warn'          => 'You are about to update the properies of the following model: |You are about to edit the properties of the following :model_count models:',

    ),

    'bulkdelete' => array(
        'error'   		    => 'Tiada model dipilih, jadi tiada apa yang dipadamkan.',
        'success' 		    => 'Model deleted!|:success_count models deleted!',
        'success_partial' 	=> ':success_count model(s) telah dipadamkan, namun :fail_count tidak dapat dipadamkan kerana mereka masih mempunyai aset yang dikaitkan dengannya.'
    ),

);

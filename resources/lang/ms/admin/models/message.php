<?php

return array(

    'does_not_exist' => 'Model tidak wujud.',
    'assoc_users'	 => 'Model ini sekarang disekutukan dengan sekurang2nya satu atau lebih harta dan tidak boleh dihapuskan. Sila kemaskini harta, dan kemudian cuba lagi. ',


    'create' => array(
        'error'   => 'Model gagal dicipta, sila cuba lagi.',
        'success' => 'Model berjaya dicipta.',
        'duplicate_set' => 'Model aset dengan nama itu, pengeluar dan nombor model sudah ada.',
    ),

    'update' => array(
        'error'   => 'Model gagal dikemaskin, sila cuba lagi',
        'success' => 'Model berjaya dikemaskini.'
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
        'success' 		=> 'Model dikemas kini.'
    ),

    'bulkdelete' => array(
        'error'   		    => 'No models were selected, so nothing was deleted.',
        'success' 		    => ':success_count model(s) deleted!',
        'success_partial' 	=> ':success_count model(s) were deleted, however :fail_count were unable to be deleted because they still have assets associated with them.'
    ),

);

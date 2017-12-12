<?php

return array(

    'does_not_exist' => 'Model mevcut değil.',
    'assoc_users'	 => 'Model bir ya da daha çok demirbaş ile ilişkili ve silinemez. Lütfen demirbaşları silin ve tekrar deneyin. ',


    'create' => array(
        'error'   => 'Klasör oluşturulmadı, lütfen tekrar deneyin.',
        'success' => 'Model oluşturuldu.',
        'duplicate_set' => 'Bu üretici ve model numarası ile bir varlık ve model zaten var.',
    ),

    'update' => array(
        'error'   => 'Model güncellenemedi, lütfen tekrar deneyin',
        'success' => 'Model güncellendi.'
    ),

    'delete' => array(
        'confirm'   => 'Bu demirbaş modelini silmek istediğinize emin misiniz?',
        'error'   => 'Demirbaş silinirken bir problem oluştu. Lütfen tekrar deneyin.',
        'success' => 'Model silindi.'
    ),

    'restore' => array(
        'error'   		=> 'Model geri getirilemedi, lütfen tekrar deneyin',
        'success' 		=> 'Model geri getirildi.'
    ),

    'bulkedit' => array(
        'error'   		=> 'Hiçbir alan değiştirilmedi, dolayısıyla hiç bir alan güncellenmedi.',
        'success' 		=> 'Model güncellendi.'
    ),

    'bulkdelete' => array(
        'error'   		    => 'No models were selected, so nothing was deleted.',
        'success' 		    => ':success_count model(s) deleted!',
        'success_partial' 	=> ':success_count model(s) were deleted, however :fail_count were unable to be deleted because they still have assets associated with them.'
    ),

);

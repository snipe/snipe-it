<?php

return array(

    'undeployable' 		=> '<strong>Uyarı:</strong> Bu demirbaş dağıtılamaz olarak işlaretlenmiş.
                        Eğer durumu değişti ise, lütfen Demirbaş Durumu\'nu güncelleyiniz.',
    'does_not_exist' 	=> 'Demirbaş mevcut değil.',
    'does_not_exist_or_not_requestable' => 'Nice try. That asset does not exist or is not requestable.',
    'assoc_users'	 	=> 'Bu demirbaş kullanıcıya çıkış yapılmış olaran görülüyor ve silinemez. Lütfen önce demirbaş girişi yapınız, ardından tekrar siliniz. ',

    'create' => array(
        'error'   		=> 'Demirbaş oluşturulamadı, lütfen tekrar deneyin. ',
        'success' 		=> 'Demirbaş oluşturuldu.'
    ),

    'update' => array(
        'error'   			=> 'Demirbaş güncellenemedi, lütfen tekrar deneyin',
        'success' 			=> 'Demirbaş güncellendi.',
        'nothing_updated'	=>  'Hiçbir alan seçilmedi, dolayısıyla hiç bir alan güncellenmedi.',
    ),

    'restore' => array(
        'error'   		=> 'Demirbaş geri getirilemedi, lütfen tekrar deneyin',
        'success' 		=> 'Demirbaş geri getirildi.'
    ),

    'deletefile' => array(
        'error'   => 'Dosya silinemedi. Lütfen tekrar deneyin.',
        'success' => 'Dosya silindi.',
    ),

    'upload' => array(
        'error'   => 'Dosya(lar) yüklenemedi. Lütfen tekrar deneyin.',
        'success' => 'Dosya(lar) yüklendi.',
        'nofiles' => 'You did not select any files for upload, or the file you are trying to upload is too large',
        'invalidfiles' => 'Bir ya da daha fazla dosya izin verilen boyuttan daha büyük ya da izin verilmeyen bir dosya tipi seçtiniz. Lütfen dosya boyutu ve tipini kontrol ediniz.',
    ),

    'import' => array(
        'error'                 => 'Some items did not import correctly.',
        'errorDetail'           => 'The following Items were not imported because of errors.',
        'success'               => "Your file has been imported",
        'file_delete_success'   => "Your file has been been successfully deleted",
        'file_delete_error'      => "The file was unable to be deleted",
    ),


    'delete' => array(
        'confirm'   	=> 'Demirbaşı silmek istediğinize emin misiniz?',
        'error'   		=> 'Demirbaş silinirken bir problem oluştu. Lütfen tekrar deneyin.',
        'success' 		=> 'Demirbaş silindi.'
    ),

    'checkout' => array(
        'error'   		=> 'Demirbaş çıkışı yapılamadı. Lütfen tekrar deneyin',
        'success' 		=> 'Demirbaş çıkışı yapıldı.',
        'user_does_not_exist' => 'Bu kullanıcı geçersiz. Lütfen tekrar deneyin.',
        'not_available' => 'That asset is not available for checkout!'
    ),

    'checkin' => array(
        'error'   		=> 'Demirbaş girişi yapılamadı. Lütfen tekrar deneyin',
        'success' 		=> 'Demirbaş girişi yapıldı.',
        'user_does_not_exist' => 'Bu kullanıcı geçersiz. Lütfen tekrar deneyin.',
        'already_checked_in'  => 'That asset is already checked in.',

    ),

    'requests' => array(
        'error'   		=> 'Asset was not requested, please try again',
        'success' 		=> 'Asset requested successfully.',
        'canceled'      => 'Checkout request successfully canceled'
    )

);

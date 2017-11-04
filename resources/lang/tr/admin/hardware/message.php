<?php

return array(

    'undeployable' 		=> '<strong>Uyarı:</strong> Bu demirbaş dağıtılamaz olarak işlaretlenmiş.
                        Eğer durumu değişti ise, lütfen Demirbaş Durumu\'nu güncelleyiniz.',
    'does_not_exist' 	=> 'Demirbaş mevcut değil.',
    'does_not_exist_or_not_requestable' => 'İyi denemeydi. Bu varlık mevcut değil veya talep edilebilir değil.',
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

    'audit' => array(
        'error'   		=> 'Varlık denetimi başarısız oldu. Lütfen tekrar deneyin.',
        'success' 		=> 'Varlık denetimi başarıyla günlüğe kaydedildi.'
    ),


    'deletefile' => array(
        'error'   => 'Dosya silinemedi. Lütfen tekrar deneyin.',
        'success' => 'Dosya silindi.',
    ),

    'upload' => array(
        'error'   => 'Dosya(lar) yüklenemedi. Lütfen tekrar deneyin.',
        'success' => 'Dosya(lar) yüklendi.',
        'nofiles' => 'Yükleme için herhangi bir dosya seçmediniz veya karşıya yüklemeye çalıştığınız dosya çok büyük',
        'invalidfiles' => 'Bir ya da daha fazla dosya izin verilen boyuttan daha büyük ya da izin verilmeyen bir dosya tipi seçtiniz. Lütfen dosya boyutu ve tipini kontrol ediniz.',
    ),

    'import' => array(
        'error'                 => 'Bazı öğeler doğru şekilde içe aktarılamadı.',
        'errorDetail'           => 'Aşağıdaki öğeler hatalar nedeniyle alınamadı.',
        'success'               => "Dosyanızı içe aktarıldı",
        'file_delete_success'   => "Dosyanız başarıyla silindi",
        'file_delete_error'      => "Dosya silenemedi",
    ),


    'delete' => array(
        'confirm'   	=> 'Demirbaşı silmek istediğinize emin misiniz?',
        'error'   		=> 'Demirbaş silinirken bir problem oluştu. Lütfen tekrar deneyin.',
        'nothing_updated'   => 'Herhangi bir varlık seçilmediği için silinemedi.',
        'success' 		=> 'Demirbaş silindi.'
    ),

    'checkout' => array(
        'error'   		=> 'Demirbaş çıkışı yapılamadı. Lütfen tekrar deneyin',
        'success' 		=> 'Demirbaş çıkışı yapıldı.',
        'user_does_not_exist' => 'Bu kullanıcı geçersiz. Lütfen tekrar deneyin.',
        'not_available' => 'Bu varlık için atama yapılamaz!',
        'no_assets_selected' => 'You must select at least one asset from the list'
    ),

    'checkin' => array(
        'error'   		=> 'Demirbaş girişi yapılamadı. Lütfen tekrar deneyin',
        'success' 		=> 'Demirbaş girişi yapıldı.',
        'user_does_not_exist' => 'Bu kullanıcı geçersiz. Lütfen tekrar deneyin.',
        'already_checked_in'  => 'Bu varlık zaten atanmış.',

    ),

    'requests' => array(
        'error'   		=> 'Varlık talep edilmemiş, lütfen tekrar deneyin',
        'success' 		=> 'Varlık talep edildi.',
        'canceled'      => 'Varlık talebi reddedildi'
    )

);

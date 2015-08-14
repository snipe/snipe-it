<?php

return array(

    'does_not_exist' => 'Konum mevcut değil.',
    'assoc_users'	 => 'Konum en az 1 kullanıcı ile ilişkili durumda ve silinemez. Lütfen önce kullanıcıları güncelleyerek konumu boşaltın ve tekrar deneyin. ',
    'assoc_assets'	 => 'This location is currently associated with at least one asset and cannot be deleted. Please update your assets to no longer reference this location and try again. ',
    'assoc_child_loc'	 => 'This location is currently the parent of at least one child location and cannot be deleted. Please update your locations to no longer reference this location and try again. ',


    'create' => array(
        'error'   => 'Konum oluşturulamadı, lütfen tekrar deneyin.',
        'success' => 'Konum oluşturuldu.'
    ),

    'update' => array(
        'error'   => 'Konum güncellenemedi, lütfen tekrar deneyin',
        'success' => 'Konum güncellendi.'
    ),

    'delete' => array(
        'confirm'   	=> 'Konumu silmek istediğinize emin misiniz?',
        'error'   => 'Konum silinirken bir hata oluştu. Lütfen tekrar deneyin.',
        'success' => 'Konum silindi.'
    )

);

<?php

return [

    'does_not_exist' => 'Konum mevcut değil.',
    'assoc_users'     => 'Konum en az 1 kullanıcı ile ilişkili durumda ve silinemez. Lütfen önce kullanıcıları güncelleyerek konumu boşaltın ve tekrar deneyin. ',
    'assoc_assets'     => 'Bu konum şu anda en az bir varlık ile ilişkili ve silinemez. Lütfen artık bu konumu kullanabilmek için varlık konumlarını güncelleştirin.',
    'assoc_child_loc'     => 'Bu konum şu anda en az bir alt konum üstüdür ve silinemez. Lütfen artık bu konuma ait alt konumları güncelleyin. ',

    'create' => [
        'error'   => 'Konum oluşturulamadı, lütfen tekrar deneyin.',
        'success' => 'Konum oluşturuldu.',
    ],

    'update' => [
        'error'   => 'Konum güncellenemedi, lütfen tekrar deneyin',
        'success' => 'Konum güncellendi.',
    ],

    'delete' => [
        'confirm'    => 'Konumu silmek istediğinize emin misiniz?',
        'error'   => 'Konum silinirken bir hata oluştu. Lütfen tekrar deneyin.',
        'success' => 'Konum silindi.',
    ],

];

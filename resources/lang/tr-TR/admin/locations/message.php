<?php

return [

    'does_not_exist' => 'Konum mevcut değil.',
    'assoc_users' => 'Bu konum şu anda silinemez; çünkü en az bir varlık veya kullanıcı için kayıtlı konumdur, üzerine atanmış varlıklar bulunmaktadır veya başka bir konumun üst konumudur (parent location). Lütfen kayıtlarınızı bu konuma referans vermeyecek şekilde güncelleyin ve tekrar deneyin ',
    'assoc_assets' => 'Bu konum şu anda en az bir varlık ile ilişkili ve silinemez. Lütfen artık bu konumu kullanabilmek için varlık konumlarını güncelleştirin.',
    'assoc_child_loc' => 'Bu konum şu anda en az bir alt konum üstüdür ve silinemez. Lütfen artık bu konuma ait alt konumları güncelleyin. ',
    'assigned_assets' => 'Atanan Varlıklar',
    'current_location' => 'Mevcut konum',
    'deleted_warning' => 'Bu konum silindi. Lütfen herhangi bir değişiklik yapmadan önce konumu geri yükleyin.',

    'create' => [
        'error' => 'Konum oluşturulamadı, lütfen tekrar deneyin.',
        'success' => 'Konum oluşturuldu.',
    ],

    'update' => [
        'error' => 'Konum güncellenemedi, lütfen tekrar deneyin',
        'success' => 'Konum güncellendi.',
    ],

    'restore' => [
        'error' => 'Konum geri yüklenemedi, lütfen tekrar deneyin',
        'success' => 'Konum başarıyla geri yüklendi.',
    ],

    'delete' => [
        'confirm' => 'Konumu silmek istediğinize emin misiniz?',
        'error' => 'Konum silinirken bir hata oluştu. Lütfen tekrar deneyin.',
        'success' => 'Konum silindi.',
    ],

    'bulkedit' => [
        'error' => 'Hiçbir alan değiştirilmedi, dolayısıyla hiç bir alan güncellenmedi.',
        'success' => 'Model başarıyla güncellendi. |:model_count modelleri başarıyla güncellendi.',
        'warn' => 'Aşağıdaki alanları düzenleyerek bu konumu güncelleyin. Boş bıraktığınız alanlar konumda değiştirilmez.|Aşağıdaki alanları düzenleyerek seçili tüm :count konumu güncelleyin. Boş bıraktığınız alanlar hiçbirinde değiştirilmez.',
        'show_selected' => '1 konum seçildi|:count konum seçildi',
        'company_scope_mismatch_partial' => 'Öğeler veya kullanıcılar bu konumda farklı şirketlere ait olduğundan şirket 1 konumda değiştirilmedi.|Öğeler veya kullanıcılar bu konumlarda farklı şirketlere ait olduğundan şirket :count konumda değiştirilmedi. Önce bunları güncelleyin veya taşıyın.',
        'company_scope_mismatch_all' => 'Hiçbir konum yeniden atanmadı. İstenen şirket, seçilen konumdaki öğeler veya kullanıcılarla eşleşmiyor.|Hiçbir konum yeniden atanmadı. İstenen şirket, seçilen :count konumdan hiçbirindeki öğeler veya kullanıcılarla eşleşmiyor.',
        'parent_company_mismatch_partial' => 'Üst konumuyla farklı bir şirkette kalmasına neden olacağından üst konum veya şirket 1 konumda değiştirilmedi.|Üst konumlarıyla farklı bir şirkette kalmalarına neden olacağından üst konum veya şirket :count konumda değiştirilmedi.',
        'parent_company_mismatch_all' => 'Hiçbir değişiklik kaydedilmedi. İstenen üst konum veya şirket, konumun üst konumundan farklı bir şirkette kalmasına neden olurdu.|Hiçbir değişiklik kaydedilmedi. İstenen üst konum veya şirket, seçilen :count konumun her birinin kendi üst konumundan farklı bir şirkette kalmasına neden olurdu.',
    ],

];

<?php

return [

    'deleted' => 'Silinen varlık modeli',
    'does_not_exist' => 'Model mevcut değil.',
    'no_association' => 'UYARI! Bu öğeye ilişkin varlık modeli geçersiz veya eksik!',
    'no_association_fix' => 'Bu değişiklik bazı şeylerin garip ve tuhaf bir şekilde bozulmasına yol açabilir. Bu varlığı bir modelle ilişkilendirmek için düzeltin.',
    'assoc_users' => 'Model bir ya da daha çok demirbaş ile ilişkili ve silinemez. Lütfen demirbaşları silin ve tekrar deneyin. ',
    'invalid_category_type' => 'Kategori, bir varlık kategorisi olmak zorunda.',

    'create' => [
        'error' => 'Klasör oluşturulmadı, lütfen tekrar deneyin.',
        'success' => 'Model oluşturuldu.',
        'duplicate_set' => 'Bu üretici ve model numarası ile bir varlık ve model zaten var.',
    ],

    'update' => [
        'error' => 'Model güncellenemedi, lütfen tekrar deneyin',
        'success' => 'Model güncellendi.',
    ],

    'delete' => [
        'confirm' => 'Bu demirbaş modelini silmek istediğinize emin misiniz?',
        'error' => 'Demirbaş silinirken bir problem oluştu. Lütfen tekrar deneyin.',
        'success' => 'Model silindi.',
    ],

    'restore' => [
        'error' => 'Model geri getirilemedi, lütfen tekrar deneyin',
        'success' => 'Model geri getirildi.',
    ],

    'bulkedit' => [
        'error' => 'Hiçbir alan değiştirilmedi, dolayısıyla hiç bir alan güncellenmedi.',
        'success' => 'Model başarıyla güncellendi. |:model_count modelleri başarıyla güncellendi.',
        'warn' => 'Aşağıdaki modelin özelliklerini güncellemek üzeresiniz: |Aşağıdaki :model_count modellerinin özelliklerini düzenlemek üzeresiniz:',

    ],

    'bulkdelete' => [
        'error' => 'Hiçbir model seçilmedi, bu nedenle hiçbir şey silinmedi.',
        'nothing_deletable' => 'Seçilen modellerin hiçbiri silinemiyor; çünkü bu modellerle ilişkili varlıklar hâlâ mevcut.',
        'success' => 'Model silindi!|:success_count modelleri silindi!',
        'success_partial' => ':success_count adet model(ler) silindi, ancak :fail_count adet için silme işlemini tamamlayamadık, çünkü bunlar halâ varlıklarla ilişkilendirilmiş durumda.',
    ],

    'merge' => [
        'min_two' => 'Birleştirmek için en az iki model seçin.',
        'no_target' => 'Birleştirme işleminden önce tutulacak modeli seçin.',
        'not_found' => 'Seçilen modellerden biri veya birkaçı yüklenemedi. Model listesini yenileyip tekrar deneyin.',
        'information' => ':count modeli birleştirmek üzeresiniz. Tutmak istediğiniz modeli seçin. Diğer modellere bağlı tüm varlıklar seçtiğiniz modele aktarılacak, ardından kaynak modeller silinecektir.',
        'warning' => 'Bu işlem geri alınamaz. Yeniden atanan varlıklar, kalan modelin kategorisini, alan kümesini ve amortisman ayarlarını devralır.',
        'pick_target' => 'Hangi model tutulsun?',
        'success' => '":target" modelinde :source_count model birleştirildi. :asset_count varlık yeniden atandı.',
    ],

];

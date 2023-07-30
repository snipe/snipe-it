<?php

return [
    'about_assets_title'           => 'Varlıklar hakkında',
    'about_assets_text'            => 'Varlıklar Demirbaştır seri numarası veya varlık etiketi ile takibi yapılır. Bu nedenle değerli varlıklar benzersiz varlık kimliği ile ilişkilendirilirler.',
    'archived'  				=> 'Arşivlenmiş',
    'asset'  					=> 'Demirbaş',
    'bulk_checkout'             => 'Varlıkları Kullanıma Alma',
    'bulk_checkin'              => 'Demirbaş Girişi Yap',
    'checkin'  					=> 'Demirbaş Girişi Yap',
    'checkout'  				=> 'Ödenme Öğe',
    'clone'  					=> 'Demirbaşı Kopyala',
    'deployable'  				=> 'Dağıtılabilir',
    'deleted'  					=> 'Bu varlık silindi.',
    'edit'  					=> 'Demirbaşı Düzenle',
    'model_deleted'  			=> 'Bu varlık modeli silindi. Varlığı geri almak için modelini geri almalısınız.',
    'model_invalid'             => 'Bu varlığın model bilgisi hatalı.',
    'model_invalid_fix'         => 'Varlığı iade alma veya teslim etme işlemi öncesinde bunu düzeltmek için varlık bilgisi düzenlenmelidir.',
    'requestable'               => 'Talep edilebilir',
    'requested'				    => 'Talep edildi',
    'not_requestable'           => 'Talep Edilemez',
    'requestable_status_warning' => 'Talep edilebilirlik durumunu değiştirmeyin',
    'restore'  					=> 'Demirbaşı Geri Getir',
    'pending'  					=> 'Bekliyor',
    'undeployable'  			=> 'Dağtılamaz',
    'undeployable_tooltip'  	=> 'This asset has a status label that is undeployable and cannot be checked out at this time.',
    'view'  					=> 'Demirbaşı Görüntüle',
    'csv_error' => 'CSV dosyanızda bir hata var:',
    'import_text' => '
<p>
     Varlık geçmişini içeren bir CSV yükleyin. Varlıklar ve kullanıcılar sistemde zaten mevcut OLMALIDIR, aksi takdirde atlanırlar. Varlıkları geçmişteki içe aktarmalarla eşleştirmek, varlık etiketlerine rağmen gerçekleşir. Sağladığınız kullanıcı adına ve aşağıda seçtiğiniz kriterlere göre eşleşen bir kullanıcı bulmaya çalışacağız. Aşağıda herhangi bir ölçüt seçmezseniz, Yönetici &gt; Genel Ayarlar.
     </p>

     <p>CSV\'ye dahil edilen alanlar şu başlıklarla eşleşmelidir: <strong>Varlık Etiketi, İsim, Çıkış Tarihi, Giriş Tarihi</strong>. Bunların dışındaki alanlar yoksayılacaktır. </p>

     <p>Giriş Tarihi: boş bırakılan veya gelecek tarihli giriş tarihleri, o öğelerin ilgili kullanıcıya çıkışını yapacaktır. Giriş Tarihi sütununun bulunmaması halinde, bugünün tarihiyle bir giriş tarihi oluşturulacaktır.</p>    ',
    'csv_import_match_f-l' => 'Kullanıcıları ad.soyad (jane.smith) biçimiyle eşleştirmeye çalışın',
    'csv_import_match_initial_last' => 'Kullanıcıları adın ilk harfi ve soyad (jsmith) biçimiyle eşleştirmeye çalışın',
    'csv_import_match_first' => 'Kullanıcıları ad (jane) biçimiyle eşleştirmeye çalışın',
    'csv_import_match_email' => 'Kullanıcıları kullanıcı adı olarak e-postalarıyla eşleştirmeye çalışın',
    'csv_import_match_username' => 'Kullanıcıları kullanıcı adlarıyla eşleştirmeye çalışın',
    'error_messages' => 'Hata mesajı:',
    'success_messages' => 'Başarı mesajı:',
    'alert_details' => 'Detaylar için aşağıyı okuyun.',
    'custom_export' => 'Özel Dışarı Aktar',
    'mfg_warranty_lookup' => ':Üretici garantisinin durumuna bakma',
];

<?php

return array(

    'does_not_exist' => 'Tedarikçi mevcut değil.',


    'create' => array(
        'error'   => 'Tedarikçi oluşturulamadı, lütfen tekrar deneyin.',
        'success' => 'Tedarikçi oluşturuldu.'
    ),

    'update' => array(
        'error'   => 'Tedarikçi güncellenemedi, lütfen tekrar deneyin',
        'success' => 'Tedarikçi güncellendi.'
    ),

    'delete' => array(
        'confirm'   => 'Tedarikçiyi silmek istediğinize emin misiniz?',
        'error'   => 'Tedarikçi silinirken bir hata oluştu. Lütfen tekrar deneyin.',
        'success' => 'Tedarikçi silindi.',
        'assoc_assets'	 => 'This supplier is currently associated with :asset_count asset(s) and cannot be deleted. Please update your assets to no longer reference this supplier and try again. ',
        'assoc_licenses'	 => 'This supplier is currently associated with :licenses_count licences(s) and cannot be deleted. Please update your licenses to no longer reference this supplier and try again. ',
        'assoc_maintenances'	 => 'This supplier is currently associated with :asset_maintenances_count asset maintenances(s) and cannot be deleted. Please update your asset maintenances to no longer reference this supplier and try again. ',
    )

);

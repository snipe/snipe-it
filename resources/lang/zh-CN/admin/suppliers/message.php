<?php

return array(

    'deleted' => '已删除的供应商',
    'does_not_exist' => '供应商不存在。',


    'create' => array(
        'error'   => '供应商没有被创建，请重试。',
        'success' => '供应商创建成功。'
    ),

    'update' => array(
        'error'   => '供应商没有被更新，请重试。',
        'success' => '供应商更新成功。'
    ),

    'delete' => array(
        'confirm'   => '你确定要删除这个供应商吗？',
        'error'   => '删除供应商的过程中出现了一点儿问题，请重试。',
        'success' => '供应商成功被删除。',
        'assoc_assets'	 => '此供应商下至少还有 :asset_count 个相关模板，目前不能被删除，请你确定您的所有资 产不在此分类下，然后重试。 ',
        'assoc_licenses'	 => '此供应商目前与 :licenses_count 个许可证相关联，不能删除。请更新您的许可证，断开与此供应商的关联，然后重试。 ',
        'assoc_maintenances'	 => '此供应商下至少还有 :asset_count 个相关模板，目前不能被删除，请你确定您的所有资产不在此分类下，然后重试。 ',
    )

);

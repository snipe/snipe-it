<?php

return [

    'undeployable' 		 => '<strong>警告： </strong> 此资产已被标记为当前不可借出。如果此状态已经改变，请更新资产状态。',
    'does_not_exist' 	 => '资产不存在',
    'does_not_exist_var' => '找不到标签为 :asset_tag 的资产',
    'no_tag' 	         => '未提供资产标签。',
    'does_not_exist_or_not_requestable' => '该资产不存在或不可申领。',
    'assoc_users'	 	 => '这个资产目前已经借给某个用户，不能被删除，请检查资产信息，然后再尝试删除。',
    'warning_audit_date_mismatch' 	=> '此资产的下一个盘点日期 (:next_audit_date) 早于上一个盘点日期 (:last_audit_date)。请更新下一个盘点日期。',
    'labels_generated'   => '标签已成功生成。',
    'error_generating_labels' => '生成标签时出错。',
    'no_assets_selected' => '没有选择资产。',

    'create' => [
        'error'   		=> '资产创建失败，请重试。:(',
        'success' 		=> '资产创建成功。 :)',
        'success_linked' => '带有 :tag 标签的资产已成功创建。<strong><a href=":link" style="color: white;">点击此处查看</a></strong>。',
        'multi_success_linked' => '带有标签 :links 的资产已成功创建。| :count 个资产已成功创建。 :links。',
        'partial_failure' => '无法创建资产。原因：:failures|:count 个资产无法创建。原因：:failures',
    ],

    'update' => [
        'error'   			=> '资产更新失败，请重试。',
        'success' 			=> '资产更新成功。',
        'encrypted_warning' => '资产更新成功，但加密的自定义字段不是由于权限',
        'nothing_updated'	=>  '一个也没有选，所以什么也不会更新。',
        'no_assets_selected'  =>  '没有选择任何资产，因此没有更新任何内容。',
        'assets_do_not_exist_or_are_invalid' => '无法更新选定的资产。',
    ],

    'restore' => [
        'error'   		=> '资产未被恢复，请重试。',
        'success' 		=> '资产恢复成功。',
        'bulk_success' 		=> '资产已成功恢复。',
        'nothing_updated'   => '没有选择任何资产，所以没有恢复。', 
    ],

    'audit' => [
        'error'   		=> '资产盘点失败：:error ',
        'success' 		=> '资产审计已成功记录。',
    ],


    'deletefile' => [
        'error'   => '文件删除失败，请重试',
        'success' => '文件已成功删除。',
    ],

    'upload' => [
        'error'   => '文件上传失败，请重试。',
        'success' => '文件已上传成功。',
        'nofiles' => '尚未选择要上传的文件，或上传的文件过大。',
        'invalidfiles' => '一个或多个文件过大或者属于不被允许的文件类型。允许上传的文件类型有PNG，GIF，JPG，DOC，DOCX，PDF和TXT。',
    ],

    'import' => [
        'import_button'         => '流程导入',
        'error'                 => '某些字段没有正确导入',
        'errorDetail'           => '以下项由于错误未被导入',
        'success'               => '您的文件已被导入',
        'file_delete_success'   => '您的文件已成功删除',
        'file_delete_error'      => '该文件无法被删除',
        'file_missing' => '所选文件丢失',
        'file_already_deleted' => '选择的文件已被删除',
        'header_row_has_malformed_characters' => '标题行中的一个或多个属性包含格式错误的 UTF-8 字符',
        'content_row_has_malformed_characters' => '第一行内容中的一个或多个属性包含格式错误的 UTF-8 字符',
    ],


    'delete' => [
        'confirm'   	=> '你确定要删除这个资产吗？',
        'error'   		=> '删除资产的过程中出现了一点儿问题，请重试。',
        'assigned_to_error' => '{1}Asset Tag: :asset_tag 目前已借出。在删除此设备之前请先归还。 [2,*] Asset Tags: :asset_tag 目前已借出。在删除此设备之前请先归还。',
        'nothing_updated'   => '没有选择任何资产，所以没有删除任何资产。',
        'success' 		=> '资产成功被删除。',
    ],

    'checkout' => [
        'error'   		=> '资产未被借出，请重试',
        'success' 		=> '资产借出成功。',
        'user_does_not_exist' => '无效用户，请重试。',
        'not_available' => '此资产无法借出',
        'no_assets_selected' => '您必须在这个列表中选择至少一项资产',
    ],

    'multi-checkout' => [
        'error'   => '资产未借出，请重试 |资产未借出，请重试',
        'success' => '资产借出成功。 |资产借出成功。',
    ],

    'checkin' => [
        'error'   		=> '资产还没有借入，请重试。',
        'success' 		=> '资产借入成功。',
        'user_does_not_exist' => '无效用户，请重试。',
        'already_checked_in'  => '资产已经被申领',

    ],

    'requests' => [
        'error'   		=> '未能成功请求分配资产，请重试。',
        'success' 		=> '成功请求资产',
        'canceled'      => '借出申请已取消。',
    ],

];

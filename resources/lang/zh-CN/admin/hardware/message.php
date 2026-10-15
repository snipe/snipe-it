<?php

return [

    'undeployable' => '以下资源无法部署并且已经从签出中移除：:asset_tags',
    'does_not_exist' => '资产不存在',
    'does_not_exist_var' => '找不到标签为 :asset_tag 的资产',
    'no_tag' => '未提供资产标签。',
    'does_not_exist_or_not_requestable' => '该资产不存在或不可申领。',
    'assoc_users' => '这个资产目前已经签出给某个用户，不能被删除，请检查资产信息，然后再尝试删除。 ',
    'warning_audit_date_mismatch' => '此资产的下一个盘点日期 (:next_audit_date) 早于上一个盘点日期 (:last_audit_date)。请更新下一个盘点日期。',
    'labels_generated' => '标签已成功生成。',
    'error_generating_labels' => '生成标签时出错。',
    'no_assets_selected' => '没有选择资产。',

    'create' => [
        'error' => '资产创建失败，请重试。:(',
        'success' => '资产创建成功。 :)',
        'success_no_checkout' => 'Asset created successfully, but was not checked out because you do not have permission to check assets out.',
        'checkout_skipped_no_permission' => 'The asset was created, but was not checked out to the requested target because you do not have permission to check assets out.',
        'success_linked' => '带有 :tag 标签的资产已成功创建。<strong><a href=":link" style="color: white;">点击此处查看</a></strong>。',
        'multi_success_linked' => '带有标签 :links 的资产已成功创建。| :count 个资产已成功创建。 :links。',
        'partial_failure' => '无法创建资产。原因：:failures|:count 个资产无法创建。原因：:failures',
        'target_not_found' => [
            'user' => '找不到被分配的用户。',
            'asset' => '找不到被分配的资产。',
            'location' => '找不到被分配的位置。',
        ],
    ],

    'update' => [
        'error' => '资产更新失败，请重试。',
        'success' => '资产更新成功。',
        'encrypted_warning' => '资产更新成功，但加密的自定义字段不是由于权限',
        'nothing_updated' => '一个字段也没选，所以不会更新。',
        'no_assets_selected' => '没有选择资产，所以没有任何内容被更新。',
        'assets_do_not_exist_or_are_invalid' => '无法更新选定的资产。',
    ],

    'bulk_update' => [
        'success' => 'Asset updated successfully.|:count assets were updated successfully.',
        'partial' => ':success asset(s) updated successfully, :failed failed. See the results array for details.',
        'error' => 'No assets were updated. See the results array for details.',
    ],

    'restore' => [
        'error' => '资产未被恢复，请重试。',
        'success' => '资产恢复成功。',
        'bulk_success' => '资产已成功恢复。',
        'nothing_updated' => '没有选择任何资产，所以没有恢复。',
    ],

    'audit' => [
        'error' => '资产盘点失败：:error ',
        'success' => '资产审计已成功记录。',
    ],

    'deletefile' => [
        'error' => '文件删除失败，请重试',
        'success' => '文件已成功删除。',
    ],

    'upload' => [
        'error' => '文件上传失败，请重试。',
        'success' => '文件已上传成功。',
        'nofiles' => '尚未选择要上传的文件，或上传的文件过大。',
        'invalidfiles' => '一个或多个文件过大或者属于不被允许的文件类型。允许上传的文件类型有PNG，GIF，JPG，DOC，DOCX，PDF和TXT。',
    ],

    'import' => [
        'import_button' => '流程导入',
        'error' => '某些项目没有正确导入。',
        'errorDetail' => '以下项由于错误未被导入',
        'success' => '您的文件已被导入',
        'file_delete_success' => '您的文件已成功删除',
        'file_delete_error' => '该文件无法被删除',
        'file_missing' => '所选文件丢失',
        'file_already_deleted' => '选择的文件已被删除',
        'file_missing_on_disk' => 'The file for this import is no longer on disk. It may have been deleted outside of Snipe-IT. Delete this entry and re-upload the file to try again.',
        'file_empty' => 'This file has no data rows. Nothing can be imported from it.',
        'already_processing' => 'This import is currently being processed by another user. Please wait for it to finish before trying again.',
        'header_row_missing' => 'This file does not have a recognized header row. Delete this entry and re-upload the file to try again.',
        'header_row_has_malformed_characters' => '标题行中的一个或多个属性包含格式错误的 UTF-8 字符',
        'content_row_has_malformed_characters' => '第一行内容中的一个或多个属性包含格式错误的 UTF-8 字符',
        'transliterate_failure' => '从 :encoding 到 UTF-8 翻译失败，因为输入的字符无效',
        'bulk_delete' => [
            'button' => 'Delete Selected (:count)',
            'confirm_title' => 'Delete selected import files?',
            'confirm_body' => 'You are about to permanently delete :count import file(s). This cannot be undone.',
            'confirm_button' => '刪除',
            'success' => 'Import file deleted successfully.|:count import files were deleted successfully.',
            'skipped' => ':count file(s) were skipped because you do not have permission to delete them.',
            'select_all' => 'Select all files on this page',
            'select_row' => 'Select :file for bulk delete',
        ],
        'row_count' => '{0} No data rows in this file|{1} :count data row to import|[2,*] :count data rows to import',
        'summary' => [
            'created' => '创建',
            'updated' => '已更新',
            'skipped' => 'Skipped as duplicates',
            'errored' => 'Errored',
            'no_changes' => 'The import finished but nothing was created or updated. Every row was skipped, usually because the underlying records already existed. Check the counts below and adjust the CSV or import type if that is not what you expected.',
        ],
        'type_required' => 'Please select an import type before continuing.',
        'processing' => 'Processing your import. Please wait until this finishes before closing the page.',
        'backup_running' => 'Running backup before importing. This can take a while on larger files. Please wait.',
        'backup_label' => 'Pre-import backup',
        'backup_complete' => 'Backup complete',
        'import_label' => '导入',
        'required_fields_missing' => 'The following required fields are not mapped: :fields',
        'history' => [
            'missing_asset_tag_identity' => '(missing asset tag)',
            'missing_asset_tag_message' => 'Row skipped: no asset tag provided.',
            'asset_not_found_message' => 'Asset with this tag does not exist. Import assets first, then re-run the history import.',
            'target_not_matched_message' => 'No :target_type matched ":name". For users, toggle the match-by options in step 1 or create the user first. For locations, make sure the CSV location name matches an existing location exactly.',
            'invalid_target_type_message' => 'Target Type ":value" is not recognized. Use "user" or "location", or leave the column blank to default to user.',
        ],
        'wizard' => [
            'step_type' => 'Choose type',
            'step_map' => 'Map fields',
            'step_preview' => '预览',
            'back' => '后退',
            'next' => '下一页',
            'preview_button' => '预览',
            'process' => 'Process import',
            'preview_intro' => 'Previewing the first :count row(s) after applying your mapping. Use the Back button if you need to edit the mapped attributes before importing.',
        ],
    ],

    'delete' => [
        'confirm' => '你确定要删除这个资产吗？',
        'error' => '删除资产的过程中出现了一点儿问题，请重试。',
        'assigned_to_error' => '{1}Asset Tag: :asset_tag 目前已签出。在删除此设备之前请先归还。 [2,*] Asset Tags: :asset_tag 目前已签出。在删除此设备之前请先归还。',
        'nothing_updated' => '没有选择任何资产，所以没有删除任何资产。',
        'success' => '资产成功被删除。',
    ],

    'checkout' => [
        'error' => '资产未被签出，请重试',
        'success' => '资产签出成功。',
        'user_does_not_exist' => '无效用户，请重试。',
        'not_available' => '此资产无法签出！',
        'no_assets_selected' => '您必须在这个列表中选择至少一项资产',
    ],

    'multi-checkout' => [
        'error' => '资产未签出，请重试 |资产未签出，请重试',
        'success' => '资产签出成功。 |资产签出成功。',
    ],

    'multi-checkin' => [
        'error' => 'Asset was not checked in, please try again|Assets were not checked in, please try again',
        'success' => 'Asset checked in successfully.|Assets checked in successfully.',
        'no_assets_selected' => '您必须在这个列表中选择至少一项资产',
    ],

    'multi-audit' => [
        'success' => ':count asset audited successfully.|:count assets audited successfully.',
        'partial_error' => ':success asset audited, :failed failed. Check the errors below and try again.|:success assets audited, :failed failed. Check the errors below and try again.',
        'no_assets_selected' => '您必须在这个列表中选择至少一项资产',
    ],

    'checkin' => [
        'error' => '资产还没有归还，请重试。',
        'success' => '资产归还成功。',
        'user_does_not_exist' => '无效用户，请重试。',
        'already_checked_in' => '该资产已经归还。',
        'force_checkin_orphaned_success' => 'Invalid assignment cleared successfully.',
        'force_checkin_not_orphaned' => 'Item is not in an invalid assignment state.',
        'force_checkin_error' => 'Could not clear invalid assignment.',

    ],

    'requests' => [
        'error' => '申请失败，请重试。',
        'success' => '申请提交成功。',
        'canceled' => '申请已取消。',
        'cancel' => '取消申请此物品',
        'duplicate' => 'You already have an active request for this item.',
        'no_active' => 'You have no active request to cancel for this item.',
        'insufficient_stock' => 'Not enough on hand to fulfill this request. Replenish first.',
        'confirm_cancel_by_admin' => "Cancel :user's request for :item?",
        'no_selection' => 'No rows were selected to fulfill.',
        'row_stale' => 'Request #:id is no longer pending and was skipped.',
        'row_qty_invalid' => 'Request #:id has an invalid quantity and was skipped.',
        'row_user_missing' => 'Request #:id has no valid target user and was skipped.',
        'row_asset_missing' => 'Request #:id has no valid target asset and was skipped.',
        'row_asset_not_requesters' => 'Request #:id skipped: selected asset does not belong to the requester.',
        'row_asset_not_available' => 'Request #:id skipped: selected asset is not an available unit of this model.',
        'row_asset_taken' => 'Request #:id skipped: selected asset was assigned to someone else before submit.',
        'row_company_mismatch' => 'Request #:id skipped: :user cannot receive items from this company.',
        'row_over_allocated' => 'Request #:id skipped: not enough on hand at the moment of submit.',
        'no_target_assets_for_user' => ':user has no assets to install into.',
        'no_available_units' => 'No available units of this model to hand out.',
        'bulk_summary' => 'Fulfilled :fulfilled of :total requests.',
        'bulk_fulfill_notification_intro' => 'The following will apply to each ticked request when fulfilled:',
    ],

];

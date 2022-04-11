<?php

return [
    'about_assets_title'           => '关于资产',
    'about_assets_text'            => '资产是按照序列号或者资产标签跟踪的物品。可以标记特殊物品为高价值资产。',
    'archived'  				=> '已存档',
    'asset'  					=> '资产',
    'bulk_checkout'             => '分配资产',
    'bulk_checkin'              => '归还资产',
    'checkin'  					=> '借入资产',
    'checkout'  				=> '借出资产',
    'clone'  					=> '复制资产',
    'deployable'  				=> '可部署',
    'deleted'  					=> '此资产已被删除。',
    'edit'  					=> '编辑资产',
    'model_deleted'  			=> '这个资源模型已被删除。您必须先还原模型才能还原素材。',
    'requestable'               => '可申领',
    'requested'				    => '已申请',
    'not_requestable'           => '不可申领',
    'requestable_status_warning' => '不可更改申领状态',
    'restore'  					=> '还原资产',
    'pending'  					=> '待处理',
    'undeployable'  			=> '不可部署',
    'view'  					=> '查看资产',
    'csv_error' => '您的CSV文件中有一个错误：',
    'import_text' => '
<p>
    上传一个包含资产历史的CSV文件。“资产”和“用户”必须已存在于系统中，否则将被跳过。历史导入的匹配资产是针对资产标签进行的。我们将尝试根据您提供的用户名以及您在下面选择的条件找到匹配的用户。如果您未选择以下任何条件，它只会尝试匹配您在“管理”&gt; “常规设置”中配置的用户名格式。
    </p>

    <p>CSV 文件中包含的字段必须与以下标题匹配：<strong>资产标签、姓名、签出日期、签入日期</strong>。任何其他字段都将被忽略。 </p>

    <p>签入日期：空白或未来的签入日期会将物品签出给关联用户。排除“签入日期”列，将创建一个今天日期的签入日期</p>
    ',
    'csv_import_match_f-l' => '尝试按“名、姓 (jane.smith)” 格式匹配用户',
    'csv_import_match_initial_last' => '尝试按“名首字母、姓 (jsmith)” 格式匹配用户',
    'csv_import_match_first' => '尝试按“名 (jane)” 格式匹配用户',
    'csv_import_match_email' => '尝试按“电子邮件”匹配用户作为用户名',
    'csv_import_match_username' => '尝试按用户名匹配用户',
    'error_messages' => '错误信息：',
    'success_messages' => '成功信息：',
    'alert_details' => '请参阅下面的详细信息。',
    'custom_export' => '自定义导出'
];

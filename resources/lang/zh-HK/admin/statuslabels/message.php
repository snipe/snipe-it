<?php

return array(

    'does_not_exist' => '狀態標籤不存在',
    'assoc_assets'	 => '至少還有一個資產與此狀態標籤關聯，目前不能被删除，請確認後重試。 ',


    'create' => array(
        'error'   => '新增狀態標籤失敗，請重試。',
        'success' => '新增狀態標籤成功。'
    ),

    'update' => array(
        'error'   => '更新狀態標籤失敗，請重試。',
        'success' => '更新狀態標籤成功。'
    ),

    'delete' => array(
        'confirm'   => '您確定要刪除此狀態標籤嗎？',
        'error'   => '刪除狀態標籤失敗，請重試。',
        'success' => '刪除狀態標籤成功。'
    ),

    'help' => array(
        'undeployable'   => '這些資產不能分配給任何人。',
        'deployable'   => '這些資產可以檢出。一旦分配了它們，它們將承擔一個元狀態<i class="fa fa-circle text-blue"></i> <strong>Deployed</strong>。',
        'archived'   => '這些資產無法簽出，只會顯示在“存檔”視圖中。這有助於保留有關資產的預算/歷史目的信息，但將其保留在日常資產清單之外。',
        'pending'   => '這些資產不能分配給任何人，經常用於修理的物品，但預計將重新流通。',
    ),

);

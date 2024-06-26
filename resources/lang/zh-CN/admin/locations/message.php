<?php

return array(

    'does_not_exist' => '位置不存在',
    'assoc_users'    => '此位置目前不可删除，因为它是至少一个资产或用户的记录所在位置， 资产已分配给它，或者是另一个地点的上级位置。 请更新您的型号以不再关联此公司，然后重试。 ',
    'assoc_assets'	 => '删除失败，该位置已与其它资产关联。请先更新资产以取消关联，然后重试。 ',
    'assoc_child_loc'	 => '删除失败，该位置是一个或多个子位置的上层节点。请更新地理位置信息以取消关联，然后重试。 ',
    'assigned_assets' => '已分配的资产',
    'current_location' => '当前地理位置',


    'create' => array(
        'error'   => '位置没有被创建，请重试。',
        'success' => '位置创建成功。'
    ),

    'update' => array(
        'error'   => '位置没有被更新，请重试。',
        'success' => '位置更新成功。'
    ),

    'delete' => array(
        'confirm'   	=> '确定删除这个位置吗?',
        'error'   => '删除位置的过成中出现了一点儿问题，请重试。',
        'success' => '位置已经成功删除。'
    )

);

<?php

return array(

    'does_not_exist' => '位置不存在',
    'assoc_users'    => 'This location is not currently deletable because it is the location of record for at least one asset or user, has assets assigned to it, or is the parent location of another location. Please update your models to no longer reference this location and try again. ',
    'assoc_assets'	 => '删除失败，该位置已与其它资产关联。请先更新资产以取消关联，然后重试。 ',
    'assoc_child_loc'	 => '删除失败，该位置是一个或多个子位置的上层节点。请更新地理位置信息以取消关联，然后重试。 ',
    'assigned_assets' => '已分配的资产',
    'current_location' => '当前地理位置',
    'open_map' => 'Open in :map_provider_icon Maps',


    'create' => array(
        'error'   => '位置没有被创建，请重试。',
        'success' => '位置创建成功。'
    ),

    'update' => array(
        'error'   => '位置没有被更新，请重试。',
        'success' => '位置更新成功。'
    ),

    'restore' => array(
        'error'   => 'Location was not restored, please try again',
        'success' => 'Location restored successfully.'
    ),

    'delete' => array(
        'confirm'   	=> '确定删除这个位置吗?',
        'error'   => '删除位置的过成中出现了一点儿问题，请重试。',
        'success' => '位置已经成功删除。'
    )

);

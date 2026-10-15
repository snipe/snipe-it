<?php

return [

    'does_not_exist' => '位置不存在',
    'assoc_users' => '由于这个地点至少为一个资产或用户的记录位置，或有资产分配给它，或是其他地点的父级地点，因此目前无法删除。请更新您的记录，移除对此地点的引用，然后重试。 ',
    'assoc_assets' => '删除失败，该位置已与其它资产关联。请先更新资产以取消关联，然后重试。 ',
    'assoc_child_loc' => '删除失败，该位置是一个或多个子位置的上层节点。请更新地理位置信息以取消关联，然后重试。 ',
    'assigned_assets' => '已分配的资产',
    'current_location' => '当前位置',
    'deleted_warning' => '此位置已被删除。请在尝试做更改之前将其还原。',

    'create' => [
        'error' => '位置没有被创建，请重试。',
        'success' => '位置创建成功。',
    ],

    'update' => [
        'error' => '位置没有被更新，请重试。',
        'success' => '位置更新成功。',
    ],

    'restore' => [
        'error' => '位置未恢复，请重试',
        'success' => '位置恢复成功。',
    ],

    'delete' => [
        'confirm' => '确定删除这个位置吗?',
        'error' => '删除位置的过成中出现了一点儿问题，请重试。',
        'success' => '位置已经成功删除。',
    ],

    'bulkedit' => [
        'error' => '没有字段被更改，因此没有更新任何内容。',
        'success' => 'Location successfully updated.|:count locations successfully updated.',
        'warn' => 'Edit the fields below to update this location. Fields you leave blank will not change on the location.|Edit the fields below to update all :count selected locations. Fields you leave blank will not change on any of them.',
        'show_selected' => '1 selected location|:count selected locations',
        'company_scope_mismatch_partial' => 'The company was not changed on 1 location because items or users at that location belong to different companies. Update or move those first.|The company was not changed on :count locations because items or users at those locations belong to different companies. Update or move those first.',
        'company_scope_mismatch_all' => 'No locations were reassigned. The requested company does not match items or users at the selected location.|No locations were reassigned. The requested company does not match items or users at any of the :count selected locations.',
        'parent_company_mismatch_partial' => 'The parent or company was not changed on 1 location because it would leave the location in a different company than its parent.|The parent or company was not changed on :count locations because it would leave those locations in a different company than their parent.',
        'parent_company_mismatch_all' => 'No changes were saved. The requested parent or company would leave the location in a different company than its parent.|No changes were saved. The requested parent or company would leave every one of the :count selected locations in a different company than their parent.',
    ],

];

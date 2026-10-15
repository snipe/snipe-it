<?php

return [

    'does_not_exist' => '장소가 존재하지 않습니다.',
    'assoc_users' => '해당 위치에 자산 또는 사용자가 등록되어 있거나, 위치를 참조하는 상하관계 위치와 연결되어 있어서 아직 삭제할 수 없습니다. 해당 위치를 참조하지 않도록 정리하신 다음 다시 시도해주세요.⠀ ',
    'assoc_assets' => '이 장소는 현재 적어도 한명의 사용자와 연결되어 있어서 삭제할 수 없습니다. 사용자가 더 이상 이 장소를 참조하지 않게 갱신하고 다시 시도해주세요. ',
    'assoc_child_loc' => '이 장소는 현재 하나 이상의 하위 장소를 가지고 있기에 삭제 할 수 없습니다. 이 장소의 참조를 수정하고 다시 시도해 주세요. ',
    'assigned_assets' => '할당된 자산',
    'current_location' => '현재 위치',
    'deleted_warning' => '이 위치는 삭제 되었습니다. 변경하기 전에 이 위치를 복원해 주세요.',

    'create' => [
        'error' => '장소가 생성되지 않았습니다. 다시 시도해 주세요.',
        'success' => '장소가 생성되었습니다.',
    ],

    'update' => [
        'error' => '장소가 갱신되지 않았습니다. 다시 시도해 주세요.',
        'success' => '장소가 갱신되었습니다.',
    ],

    'restore' => [
        'error' => '위치를 복구할 수 없습니다. 다시 시도해 주세요.⠀',
        'success' => '위치가 복원되었습니다.',
    ],

    'delete' => [
        'confirm' => '이 장소를 삭제하시겠습니까?',
        'error' => '장소 삭제 중에 문제가 발생했습니다. 다시 시도해 주세요.',
        'success' => '장소가 삭제되었습니다.',
    ],

    'bulkedit' => [
        'error' => '변경된 항목이 없어서, 갱신되지 않습니다.',
        'success' => 'Location successfully updated.|:count locations successfully updated.',
        'warn' => 'Edit the fields below to update this location. Fields you leave blank will not change on the location.|Edit the fields below to update all :count selected locations. Fields you leave blank will not change on any of them.',
        'show_selected' => '1 selected location|:count selected locations',
        'company_scope_mismatch_partial' => 'The company was not changed on 1 location because items or users at that location belong to different companies. Update or move those first.|The company was not changed on :count locations because items or users at those locations belong to different companies. Update or move those first.',
        'company_scope_mismatch_all' => 'No locations were reassigned. The requested company does not match items or users at the selected location.|No locations were reassigned. The requested company does not match items or users at any of the :count selected locations.',
        'parent_company_mismatch_partial' => 'The parent or company was not changed on 1 location because it would leave the location in a different company than its parent.|The parent or company was not changed on :count locations because it would leave those locations in a different company than their parent.',
        'parent_company_mismatch_all' => 'No changes were saved. The requested parent or company would leave the location in a different company than its parent.|No changes were saved. The requested parent or company would leave every one of the :count selected locations in a different company than their parent.',
    ],

];

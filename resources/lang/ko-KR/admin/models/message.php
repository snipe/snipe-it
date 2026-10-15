<?php

return [

    'deleted' => '삭제된 자산 모델',
    'does_not_exist' => '모델이 존재하지 않습니다.',
    'no_association' => '경고! 이 항목의 자산 모델이 잘못되었거나 누락되었습니다!',
    'no_association_fix' => '이상하고 심각한 문제를 일으킬 수 있습니다. 지금 이 자산을 편집하여 모델을 지정하세요.',
    'assoc_users' => '이 모델은 현재 하나 이상의 자산들과 연결되어 있기에 삭제 할 수 없습니다. 자산들을 삭제하고 다시 삭제하길 시도하세요. ',
    'invalid_category_type' => '이 카테고리는 자산 카테고리여야 합니다.',

    'create' => [
        'error' => '모델이 생성되지 않았습니다. 다시 시도하세요.',
        'success' => '모델이 생성되었습니다.',
        'duplicate_set' => '이름, 제조사 그리고 모델 번호가 같은 자산 모델이 존재합니다.',
    ],

    'update' => [
        'error' => '모델이 갱신되지 않았습니다. 다시 시도하세요.',
        'success' => '모델이 갱신되었습니다.',
    ],

    'delete' => [
        'confirm' => '이 자산 모델을 삭제 하시겠습니까?',
        'error' => '모델을 삭제하는 중 문제가 발생했습니다. 다시 시도해 주세요.',
        'success' => '모델이 삭제되었습니다.',
    ],

    'restore' => [
        'error' => '모델이 복원되지 않았습니다. 다시 시도해 주세요.',
        'success' => '모델이 복원되었습니다.',
    ],

    'bulkedit' => [
        'error' => '변경된 항목이 없어서, 갱신되지 않습니다.',
        'success' => '모델이 업데이트되었습니다.|:model_count개의 모델이 업데이트되었습니다.',
        'warn' => '다음 모델의 속성을 업데이트하려고 합니다:|다음 :model_count개 모델의 속성을 편집하려고 합니다:',

    ],

    'bulkdelete' => [
        'error' => '선택된 모델이 없기에, 삭제되지 않습니다.',
        'nothing_deletable' => 'None of the selected models can be deleted because they still have assets associated with them.',
        'success' => '모델이 삭제되었습니다!|:success_count개의 모델이 삭제되었습니다!',
        'success_partial' => ': success_count개의 모델이 삭제되었지만, fail_count 개는 관련된 자산이 있기에 삭제할 수 없습니다.',
    ],

    'merge' => [
        'min_two' => 'Select at least two models to merge.',
        'no_target' => 'Select which model to keep before merging.',
        'not_found' => 'One or more of the selected models could not be loaded. Refresh the models list and try again.',
        'information' => 'You are about to merge :count models. Pick the model you want to keep. Every asset attached to the other models will be reassigned to the model you pick, then the source models will be deleted.',
        'warning' => 'This cannot be undone. Reassigned assets will inherit the surviving model\'s category, fieldset, and depreciation settings.',
        'pick_target' => 'Which model do you want to keep?',
        'success' => 'Merged :source_count model(s) into ":target". :asset_count asset(s) were reassigned.',
    ],

];

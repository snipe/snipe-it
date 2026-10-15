<?php

return [

    'deleted' => 'Deleted asset model',
    'does_not_exist' => 'ไม่มีโมเดลนี้',
    'no_association' => 'WARNING! The asset model for this item is invalid or missing!',
    'no_association_fix' => 'This will break things in weird and horrible ways. Edit this asset now to assign it a model.',
    'assoc_users' => 'โมเดลนี้มีความสัมพันธ์กับสินทรัพย์หนึ่ง หรือมากกว่าในปัจจุบัน และจะไม่สามารถลบได้ กรุณาลบสินทรัพย์และลองอีกครั้ง ',
    'invalid_category_type' => 'This category must be an asset category.',

    'create' => [
        'error' => 'ยังไม่ได้สร้างโมเดล กรุณาลองใหม่อีกครั้ง',
        'success' => 'สร้างโมเดียลเรียบร้อยแล้ว',
        'duplicate_set' => 'มีชื่อโมเดลสินทรัพย์ ผู้ผลิต และหมายเลขโมเดลแล้ว',
    ],

    'update' => [
        'error' => 'ยังไม่ได้ปรับปรุงโมเดล กรุณาลองใหม่อีกครั้ง',
        'success' => 'ปรับปรุงโมเดลเรียบร้อยแล้ว',
    ],

    'delete' => [
        'confirm' => 'คุณแน่ใจที่จะลบโมเดลนี้?',
        'error' => 'มีปัญหาระหว่างลบโมเดล กรุณาลองใหม่อีกครั้ง.',
        'success' => 'ลบโมเดลเรียบร้อยแล้ว',
    ],

    'restore' => [
        'error' => 'ยังไม่ได้กู้คืนโมเดล กรุณาลองใหม่อีกครั้ง',
        'success' => 'กู้คืนโมเดลเรียบร้อยแล้ว',
    ],

    'bulkedit' => [
        'error' => 'ไม่มีการเปลี่ยนแปลงเขตข้อมูลดังนั้นไม่มีอะไรที่ได้รับการปรับปรุง',
        'success' => 'Model successfully updated. |:model_count models successfully updated.',
        'warn' => 'You are about to update the properties of the following model:|You are about to edit the properties of the following :model_count models:',

    ],

    'bulkdelete' => [
        'error' => 'ไม่มีการเลือกรายการใด ๆ ดังนั้นจึงไม่มีสิ่งใดถูกลบ',
        'nothing_deletable' => 'None of the selected models can be deleted because they still have assets associated with them.',
        'success' => 'Model deleted!|:success_count models deleted!',
        'success_partial' => ': success_count โมเดลถูกลบแล้วอย่างไรก็ตาม: ไม่สามารถลบข้อมูล fail_count เนื่องจากยังมีเนื้อหาที่เชื่อมโยงอยู่',
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

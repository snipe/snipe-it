<?php

return array(

    'does_not_exist' => 'ไม่มีโมเดลนี้',
    'assoc_users'	 => 'โมเดลนี้มีความสัมพันธ์กับสินทรัพย์หนึ่ง หรือมากกว่าในปัจจุบัน และจะไม่สามารถลบได้ กรุณาลบสินทรัพย์และลองอีกครั้ง ',


    'create' => array(
        'error'   => 'ยังไม่ได้สร้างโมเดล กรุณาลองใหม่อีกครั้ง',
        'success' => 'สร้างโมเดียลเรียบร้อยแล้ว',
        'duplicate_set' => 'มีชื่อโมเดลสินทรัพย์ ผู้ผลิต และหมายเลขโมเดลแล้ว',
    ),

    'update' => array(
        'error'   => 'ยังไม่ได้ปรับปรุงโมเดล กรุณาลองใหม่อีกครั้ง',
        'success' => 'ปรับปรุงโมเดลเรียบร้อยแล้ว'
    ),

    'delete' => array(
        'confirm'   => 'คุณแน่ใจที่จะลบโมเดลนี้?',
        'error'   => 'มีปัญหาระหว่างลบโมเดล กรุณาลองใหม่อีกครั้ง.',
        'success' => 'ลบโมเดลเรียบร้อยแล้ว'
    ),

    'restore' => array(
        'error'   		=> 'ยังไม่ได้กู้คืนโมเดล กรุณาลองใหม่อีกครั้ง',
        'success' 		=> 'กู้คืนโมเดลเรียบร้อยแล้ว'
    ),

    'bulkedit' => array(
        'error'   		=> 'ไม่มีการเปลี่ยนแปลงเขตข้อมูลดังนั้นไม่มีอะไรที่ได้รับการปรับปรุง',
        'success' 		=> 'อัปเดตโมเดลแล้ว'
    ),

    'bulkdelete' => array(
        'error'   		    => 'No models were selected, so nothing was deleted.',
        'success' 		    => ':success_count model(s) deleted!',
        'success_partial' 	=> ':success_count model(s) were deleted, however :fail_count were unable to be deleted because they still have assets associated with them.'
    ),

);

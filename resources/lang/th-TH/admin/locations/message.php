<?php

return [

    'does_not_exist' => 'ไม่มีสถานที่นี้.',
    'assoc_users' => 'ขณะนี้ไม่สามารถลบสถานที่นี้ได้ เนื่องจากเป็นสถานที่บันทึกข้อมูลสำหรับสิ่งของหรือผู้ใช้อย่างน้อยหนึ่งรายการ, ยังมีสินทรัพย์ที่กำหนดไว้กับสถานที่นี้ หรือเป็นสถานที่หลักของสถานที่อื่น โปรดอัปเดตข้อมูลของคุณเพื่อไม่ให้มีการอ้างอิงถึงสถานที่นี้อีกต่อไป แล้วลองใหม่อีกครั้ง ',
    'assoc_assets' => 'สถานที่นี้ถูกใช้งานหรือเกี่ยวข้องอยู่กับผู้ใช้งานคนใดคนหนึ่ง และไม่สามารถลบได้ กรุณาปรับปรุงผู้ใช้งานของท่านไม่ให้มีส่วนเกี่ยวข้องกับสถานที่นี้ และลองอีกครั้ง. ',
    'assoc_child_loc' => 'สถานที่นี้ถูกใช้งานหรือเกี่ยวข้องอยู่กับหมวดสถานที่ใดที่หนึ่ง และไม่สามารถลบได้ กรุณาปรับปรุงสถานที่ของท่านไม่ให้มีส่วนเกี่ยวข้องกับหมวดสถานที่นี้ และลองอีกครั้ง. ',
    'assigned_assets' => 'สินทรัพย์ถูกมอบหมายแล้ว',
    'current_location' => 'ตำแหน่งปัจจุบัน',
    'deleted_warning' => 'สถานที่นี้ถูกลบแล้ว กรุณากู้คืนก่อนทำการเปลี่ยนแปลง',

    'create' => [
        'error' => 'สถานที่ยังไม่ถูกสร้าง กรุณาลองใหม่อีกครั้ง.',
        'success' => 'สร้างสถานที่เรียบร้อยแล้ว.',
    ],

    'update' => [
        'error' => 'สถานที่ยังไม่ถูกปรับปรุง กรุณาลองใหม่อีกครั้ง',
        'success' => 'ปรับปรุงสถานที่เรียบร้อยแล้ว.',
    ],

    'restore' => [
        'error' => 'ไม่สามารถกู้คืนสถานที่ได้ กรุณาลองอีกครั้ง',
        'success' => 'กู้คืนสถานที่แล้ว',
    ],

    'delete' => [
        'confirm' => 'คุณแน่ใจที่จะลบสถานที่นี้?',
        'error' => 'มีปัญหาระหว่างการลบสถานที่ กรุณาลองใหม่อีกครั้ง.',
        'success' => 'ลบสถานที่เรียบร้อยแล้ว.',
    ],

    'bulkedit' => [
        'error' => 'ไม่มีการเปลี่ยนแปลงเขตข้อมูลดังนั้นไม่มีอะไรที่ได้รับการปรับปรุง',
        'success' => 'Location successfully updated.|:count locations successfully updated.',
        'warn' => 'Edit the fields below to update this location. Fields you leave blank will not change on the location.|Edit the fields below to update all :count selected locations. Fields you leave blank will not change on any of them.',
        'show_selected' => '1 selected location|:count selected locations',
        'company_scope_mismatch_partial' => 'The company was not changed on 1 location because items or users at that location belong to different companies. Update or move those first.|The company was not changed on :count locations because items or users at those locations belong to different companies. Update or move those first.',
        'company_scope_mismatch_all' => 'No locations were reassigned. The requested company does not match items or users at the selected location.|No locations were reassigned. The requested company does not match items or users at any of the :count selected locations.',
        'parent_company_mismatch_partial' => 'The parent or company was not changed on 1 location because it would leave the location in a different company than its parent.|The parent or company was not changed on :count locations because it would leave those locations in a different company than their parent.',
        'parent_company_mismatch_all' => 'No changes were saved. The requested parent or company would leave the location in a different company than its parent.|No changes were saved. The requested parent or company would leave every one of the :count selected locations in a different company than their parent.',
    ],

];

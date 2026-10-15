<?php

return [

    'does_not_exist' => 'ยังไม่มีหมวดหมู่',
    'assoc_models' => 'หมวดหมู่นี้เชื่อมโยงกับโมเดลอย่างน้อยหนึ่งรายการและไม่สามารถลบออกได้ โปรดอัปเดตโมเดลของคุณเพื่อไม่ให้อ้างอิงหมวดหมู่นี้อีกแล้วลองอีกครั้ง',
    'assoc_items' => 'หมวดหมู่นี้มีการเชื่อมโยงกับ asset_type อย่างน้อยหนึ่งรายการและไม่สามารถลบได้ โปรดอัปเดต: asset_type เพื่อไม่ให้อ้างอิงหมวดหมู่นี้อีกแล้วลองอีกครั้ง',

    'create' => [
        'error' => 'ยังไม่ได้สร้างหมวดหมู่ กรุณาลองอีกครั้ง.',
        'success' => 'สร้างหมวดหมู่เรียบร้อยแล้ว.',
    ],

    'update' => [
        'error' => 'ยังไม่ได้ปรับปรุงหมวดหมู่ กรุณาลองอีกครั้ง',
        'success' => 'ปรับปรุงหมวดหมู่เรียบร้อยแล้ว.',
        'cannot_change_category_type' => 'คุณไม่สามารถเปลี่ยนประเภทหมวดหมู่ได้เมื่อสร้างแล้ว',
    ],

    'delete' => [
        'confirm' => 'คุณแน่ใจที่ต้องการจะลบหมวดหมู่นี้?',
        'error' => 'มีปัญหาขณะลบหมวดหมู่นี้ กรุณาลองอีกครั้ง.',
        'success' => 'หมวดหมู่ถูกลบแล้ว',
        'bulk_success' => 'Category deleted successfully.|:count categories were deleted successfully.',
        'partial_success' => 'หมวดหมู่ถูกลบแล้ว ดูข้อมูลเพิ่มเติมด้านล่าง | :count หมวดหมู่ได้ถูกลบแล้ว ดูข้อมูลเพิ่มเติมด้านล่าง',
    ],

    'bulkedit' => [
        'warn' => 'You are about to edit the properties of the following category:|You are about to edit the properties of the following :count categories:',
        'no_selection' => 'You must select at least one category to edit.',
        'no_changes' => 'ไม่มีการเปลี่ยนแปลงเขตข้อมูลดังนั้นไม่มีอะไรที่ได้รับการปรับปรุง',
        'success' => 'Category successfully updated.|:count categories successfully updated.',
    ],

];

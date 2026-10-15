<?php

return [

    'does_not_exist' => 'קטגוריה לא קיימת.',
    'assoc_models' => 'קטגוריה זו משויכת כרגע לדגם אחד לפחות ולא ניתן למחוק אותה. אנא עדכן את הדגמים שלך כדי לא להתייחס עוד לקטגוריה זו ונסה שוב.',
    'assoc_items' => 'קטגוריה זו משויכת כרגע עם לפחות אחד: type_type ולא ניתן למחוק אותה. עדכן את: הנכס_ typepe כדי לא להתייחס עוד לקטגוריה זו ונסה שוב.',

    'create' => [
        'error' => 'הקטגוריה לא נוצרה, נסה שוב.',
        'success' => 'קטגוריה נוצר בהצלחה.',
    ],

    'update' => [
        'error' => 'הקטגוריה לא עודכנה, נסה שוב',
        'success' => 'קטגוריה עודכנה בהצלחה.',
        'cannot_change_category_type' => 'אי אפשר לשנות את סוג הקטגוריה לאחר יצירתה',
    ],

    'delete' => [
        'confirm' => 'האם אתה בטוח שברצונך למחוק קטגוריה זו?',
        'error' => 'היתה בעיה במחיקת הקטגוריה. בבקשה נסה שוב.',
        'success' => 'Category was deleted successfully.',
        'bulk_success' => 'Category deleted successfully.|:count categories were deleted successfully.',
        'partial_success' => 'Category deleted successfully. See additional information below. | :count categories were deleted successfully. See additional information below.',
    ],

    'bulkedit' => [
        'warn' => 'You are about to edit the properties of the following category:|You are about to edit the properties of the following :count categories:',
        'no_selection' => 'You must select at least one category to edit.',
        'no_changes' => 'לא השתנו שדות, ולכן שום דבר לא עודכן.',
        'success' => 'Category successfully updated.|:count categories successfully updated.',
    ],

];

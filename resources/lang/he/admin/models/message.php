<?php

return array(

    'does_not_exist' => 'המודל אינו קיים.',
    'assoc_users'	 => 'מודל זה משויך כרגע לנכס אחד או יותר ולא ניתן למחוק אותו. מחק את הנכסים ולאחר מכן נסה למחוק שוב.',


    'create' => array(
        'error'   => 'המודל לא נוצר, נסה שוב.',
        'success' => 'המודל נוצר בהצלחה.',
        'duplicate_set' => 'כבר קיים מודל נכסים עם שם, יצרן ומספר דגם זה.',
    ),

    'update' => array(
        'error'   => 'המודל לא עודכן, נסה שוב',
        'success' => 'המודל עודכן בהצלחה.'
    ),

    'delete' => array(
        'confirm'   => 'האם אתה בטוח שברצונך למחוק מודל נכס זה?',
        'error'   => 'הייתה בעיה במחיקת המודל. בבקשה נסה שוב.',
        'success' => 'המודל נמחק בהצלחה.'
    ),

    'restore' => array(
        'error'   		=> 'המודל לא שוחזר, נסה שוב',
        'success' 		=> 'המודל שוחזר בהצלחה.'
    ),

    'bulkedit' => array(
        'error'   		=> 'לא השתנו שדות, ולכן שום דבר לא עודכן.',
        'success' 		=> 'המודלים עודכנו.'
    ),

    'bulkdelete' => array(
        'error'   		    => 'לא נבחרו מודלים, לכן לא נמחק שום דבר.',
        'success' 		    => ':success_count מודלים נמחקו!',
        'success_partial' 	=> ':success_count model(s) were deleted, however :fail_count were unable to be deleted because they still have assets associated with them.'
    ),

);

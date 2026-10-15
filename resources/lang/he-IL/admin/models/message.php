<?php

return [

    'deleted' => 'דגם פריט מחוק',
    'does_not_exist' => 'המודל אינו קיים.',
    'no_association' => 'אזהרה! דגם הפריט אינו תקין או חסר!',
    'no_association_fix' => 'זה ישבור דברים בדרכים שונות ומשונות. ערוך פריט זה עכשיו וקבע לו דגם.',
    'assoc_users' => 'מודל זה משויך כרגע לנכס אחד או יותר ולא ניתן למחוק אותו. מחק את הנכסים ולאחר מכן נסה למחוק שוב.',
    'invalid_category_type' => 'הקטגוריה הזאת חייב להיות קטגוריית משאבים.',

    'create' => [
        'error' => 'המודל לא נוצר, נסה שוב.',
        'success' => 'המודל נוצר בהצלחה.',
        'duplicate_set' => 'כבר קיים מודל נכסים עם שם, יצרן ומספר דגם זה.',
    ],

    'update' => [
        'error' => 'המודל לא עודכן, נסה שוב',
        'success' => 'המודל עודכן בהצלחה.',
    ],

    'delete' => [
        'confirm' => 'האם אתה בטוח שברצונך למחוק מודל נכס זה?',
        'error' => 'הייתה בעיה במחיקת המודל. בבקשה נסה שוב.',
        'success' => 'המודל נמחק בהצלחה.',
    ],

    'restore' => [
        'error' => 'המודל לא שוחזר, נסה שוב',
        'success' => 'המודל שוחזר בהצלחה.',
    ],

    'bulkedit' => [
        'error' => 'לא השתנו שדות, ולכן שום דבר לא עודכן.',
        'success' => 'דגם עודכן בהצלחה. |:model_count דגמים עודכנו בהצלחה.',
        'warn' => 'אתה עומד לעדכן את תכונותיו של הדגם הבא:|אתה עומד לערוך את תכונותיהם של |:model_count הדגמים הבאים:',

    ],

    'bulkdelete' => [
        'error' => 'לא נבחרו מודלים, לכן לא נמחק שום דבר.',
        'nothing_deletable' => 'None of the selected models can be deleted because they still have assets associated with them.',
        'success' => 'דגם נמחק!:|success_count דגמים נמחקו!',
        'success_partial' => ':success_count model(s) were deleted, however :fail_count were unable to be deleted because they still have assets associated with them.',
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

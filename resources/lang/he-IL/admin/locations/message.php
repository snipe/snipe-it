<?php

return [

    'does_not_exist' => 'המיקום אינו קיים.',
    'assoc_users' => 'This location is not currently deletable because it is the location of record for at least one item or user, has assets assigned to it, or is the parent location of another location. Please update your records to no longer reference this location and try again ',
    'assoc_assets' => 'המיקום משויך לפחות לפריט אחד ולכן לא ניתן למחוק אותו. אנא עדכן את הפריטים כך שלא יהיה אף פריט משויך למיקום זה ונסה שנית. ',
    'assoc_child_loc' => 'למיקום זה מוגדרים תתי-מיקומים ולכן לא ניתן למחוק אותו. אנא עדכן את המיקומים כך שלא שמיקום זה לא יכיל תתי מיקומים ונסה שנית. ',
    'assigned_assets' => 'פריטים מוקצים',
    'current_location' => 'מיקום נוכחי',
    'deleted_warning' => 'This location has been deleted. Please restore it before attempting to make any changes.',

    'create' => [
        'error' => 'המיקום לא נוצר, אנא נסה שנית.',
        'success' => 'המיקום נוצר בהצלחה.',
    ],

    'update' => [
        'error' => 'המיקום לא עודכן, אנא נסה שנית',
        'success' => 'המיקום עודכן בהצלחה.',
    ],

    'restore' => [
        'error' => 'מיקום לא שוחזר, אנא נסה שוב',
        'success' => 'המקום שוחזר בהצלחה.',
    ],

    'delete' => [
        'confirm' => 'האם אתה בטוח שברצונך למחוק את המיקום?',
        'error' => 'אירעה תקלה במחיקת המיקום. אנא נסה שנית.',
        'success' => 'המיקום נמחק בהצלחה.',
    ],

    'bulkedit' => [
        'error' => 'לא השתנו שדות, ולכן שום דבר לא עודכן.',
        'success' => 'Location successfully updated.|:count locations successfully updated.',
        'warn' => 'Edit the fields below to update this location. Fields you leave blank will not change on the location.|Edit the fields below to update all :count selected locations. Fields you leave blank will not change on any of them.',
        'show_selected' => '1 selected location|:count selected locations',
        'company_scope_mismatch_partial' => 'The company was not changed on 1 location because items or users at that location belong to different companies. Update or move those first.|The company was not changed on :count locations because items or users at those locations belong to different companies. Update or move those first.',
        'company_scope_mismatch_all' => 'No locations were reassigned. The requested company does not match items or users at the selected location.|No locations were reassigned. The requested company does not match items or users at any of the :count selected locations.',
        'parent_company_mismatch_partial' => 'The parent or company was not changed on 1 location because it would leave the location in a different company than its parent.|The parent or company was not changed on :count locations because it would leave those locations in a different company than their parent.',
        'parent_company_mismatch_all' => 'No changes were saved. The requested parent or company would leave the location in a different company than its parent.|No changes were saved. The requested parent or company would leave every one of the :count selected locations in a different company than their parent.',
    ],

];

<?php

return [

    'does_not_exist' => 'Platsen finns inte.',
    'assoc_users' => 'Denna plats kan inte tas bort för närvarande eftersom den är registrerad plats för minst en post eller användare, har tillgångar tilldelade till den, eller är moderplats för en annan plats. Uppdatera dina register så att de inte längre refererar till denna plats och försök igen ',
    'assoc_assets' => 'Platsen är associerad med minst en tillgång och kan inte tas bort. Vänligen uppdatera dina tillgångar så dom inte refererar till denna plats och försök igen. ',
    'assoc_child_loc' => 'Denna plats är för närvarande överliggande för minst en annan plats och kan inte tas bort. Vänligen uppdatera dina platser så dom inte längre refererar till denna och försök igen.',
    'assigned_assets' => 'Tilldelade tillgångar',
    'current_location' => 'Nuvarande plats',
    'deleted_warning' => 'Den här platsen har tagits bort. Återställ den innan du försöker göra några ändringar.',

    'create' => [
        'error' => 'Platsen kunde inte skapas. Vänligen försök igen.',
        'success' => 'Platsen skapades.',
    ],

    'update' => [
        'error' => 'Platsen kunde inte uppdateras. Vänligen försök igen',
        'success' => 'Platsen uppdaterades.',
    ],

    'restore' => [
        'error' => 'Platsen återställdes inte, försök igen',
        'success' => 'Platsen har återställts.',
    ],

    'delete' => [
        'confirm' => 'Är du säker du vill ta bort denna plats?',
        'error' => 'Ett fel inträffade när denna plats skulle tas bort. Vänligen försök igen.',
        'success' => 'Platsen har tagits bort.',
    ],

    'bulkedit' => [
        'error' => 'Inga fält ändrades, så ingenting uppdaterades.',
        'success' => 'Platsen har uppdaterats.|:count platser har uppdaterats.',
        'warn' => 'Redigera fälten nedan för att uppdatera platsen. Fält som du lämnar tomma ändras inte.|Redigera fälten nedan för att uppdatera alla :count markerade platser. Fält som du lämnar tomma ändras inte på någon av dem.',
        'show_selected' => '1 markerad plats|:count markerade platser',
        'company_scope_mismatch_partial' => 'Företaget ändrades inte för 1 plats eftersom objekt eller användare på platsen tillhör olika företag. Uppdatera eller flytta dem först.|Företaget ändrades inte för :count platser eftersom objekt eller användare på platserna tillhör olika företag. Uppdatera eller flytta dem först.',
        'company_scope_mismatch_all' => 'Inga platser tilldelades på nytt. Det valda företaget matchar inte objekten eller användarna på den markerade platsen.|Inga platser tilldelades på nytt. Det valda företaget matchar inte objekten eller användarna på någon av de :count markerade platserna.',
        'parent_company_mismatch_partial' => 'Den överordnade platsen eller företaget ändrades inte för 1 plats eftersom platsen då skulle tillhöra ett annat företag än sin överordnade plats.|Den överordnade platsen eller företaget ändrades inte för :count platser eftersom de då skulle tillhöra ett annat företag än sin överordnade plats.',
        'parent_company_mismatch_all' => 'Inga ändringar sparades. Den valda överordnade platsen eller det valda företaget skulle göra att platsen tillhörde ett annat företag än sin överordnade plats.|Inga ändringar sparades. Den valda överordnade platsen eller det valda företaget skulle göra att var och en av de :count markerade platserna tillhörde ett annat företag än sin överordnade plats.',
    ],

];

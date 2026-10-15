<?php

return [

    'does_not_exist' => 'Lokalizacja nie istnieje.',
    'assoc_users' => 'Tej lokalizacji nie można obecnie usunąć, ponieważ istnieje co najmniej jeden środek lub użytkownik przypisany do niej bądź jest to lokalizacja nadrzędna względem innej lokalizacji. Zaktualizuj problematyczne odwołania i spróbuj ponownie.',
    'assoc_assets' => 'Lokalizacja obecnie jest skojarzona z minimum jednym środkiem i nie może zostać usunięta. Uaktualnij właściwości środków tak, aby nie było relacji z tą lokalizacją i spróbuj ponownie. ',
    'assoc_child_loc' => 'Lokalizacja obecnie jest rodzicem minimum jeden innej lokalizacji i nie może zostać usunięta. Uaktualnij właściwości lokalizacji tak aby nie było relacji z tą lokalizacją i spróbuj ponownie. ',
    'assigned_assets' => 'Przypisane środki',
    'current_location' => 'Bieżąca lokalizacja',
    'deleted_warning' => 'Ta lokalizacja została usunięta. Przywróć lokalizację przed wprowadzeniem zmian.',

    'create' => [
        'error' => 'Lokalizacja nie została stworzona. Spróbuj ponownie.',
        'success' => 'Lokalizacja stworzona pomyślnie.',
    ],

    'update' => [
        'error' => 'Lokalizacja nie została zaktualizowana, spróbuj ponownie',
        'success' => 'Lokalizacja zaktualizowana pomyślnie.',
    ],

    'restore' => [
        'error' => 'Lokalizacja nie została przywrócona, spróbuj ponownie',
        'success' => 'Lokalizacja została przywrócona pomyślnie.',
    ],

    'delete' => [
        'confirm' => 'Czy na pewno usunąć wybraną lokalizację?',
        'error' => 'Podczas usuwania lokalizacji napotkano problem. Spróbuj ponownie.',
        'success' => 'Lokalizacja usunięta pomyślnie.',
    ],

    'bulkedit' => [
        'error' => 'Żadne pole nie zostało zmodyfikowane, więc nic nie zostało zaktualizowane.',
        'success' => 'Location successfully updated.|:count locations successfully updated.',
        'warn' => 'Edit the fields below to update this location. Fields you leave blank will not change on the location.|Edit the fields below to update all :count selected locations. Fields you leave blank will not change on any of them.',
        'show_selected' => '1 selected location|:count selected locations',
        'company_scope_mismatch_partial' => 'The company was not changed on 1 location because items or users at that location belong to different companies. Update or move those first.|The company was not changed on :count locations because items or users at those locations belong to different companies. Update or move those first.',
        'company_scope_mismatch_all' => 'No locations were reassigned. The requested company does not match items or users at the selected location.|No locations were reassigned. The requested company does not match items or users at any of the :count selected locations.',
        'parent_company_mismatch_partial' => 'The parent or company was not changed on 1 location because it would leave the location in a different company than its parent.|The parent or company was not changed on :count locations because it would leave those locations in a different company than their parent.',
        'parent_company_mismatch_all' => 'No changes were saved. The requested parent or company would leave the location in a different company than its parent.|No changes were saved. The requested parent or company would leave every one of the :count selected locations in a different company than their parent.',
    ],

];

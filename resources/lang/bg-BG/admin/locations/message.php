<?php

return [

    'does_not_exist' => 'Местоположението не съществува.',
    'assoc_users' => 'Това местоположение не може да бъде изтрито, защото има поне един актив или потребител, зачислен към него или съдържа под локаций. Моля обновете вашите записи, така че да не съдържат това местоположение и пробвайте отново ',
    'assoc_assets' => 'Местоположението е свързано с поне един актив и не може да бъде изтрито. Моля, актуализирайте активите, така че да не са свързани с това местоположение и опитайте отново. ',
    'assoc_child_loc' => 'В избраното местоположение е присъединено едно или повече местоположения. Моля преместете ги в друго и опитайте отново.',
    'assigned_assets' => 'Изписани Активи',
    'current_location' => 'Текущо местоположение',
    'deleted_warning' => 'Това местоположение е изтрито. Моля възстановете го преди да правите промени.',

    'create' => [
        'error' => 'Местоположението не е създадено. Моля, опитайте отново.',
        'success' => 'Местоположението е създадено.',
    ],

    'update' => [
        'error' => 'Местоположението не е обновено. Моля, опитайте отново',
        'success' => 'Местоположението е обновено.',
    ],

    'restore' => [
        'error' => 'Местоположението не беше възстановено, моля опитайте отново',
        'success' => 'Местоположението е възстановено.',
    ],

    'delete' => [
        'confirm' => 'Сигурни ли сте, че искате да изтриете това местоположение?',
        'error' => 'Възникна проблем при изтриване на местоположението. Моля, опитайте отново.',
        'success' => 'Местоположението е изтрито.',
    ],

    'bulkedit' => [
        'error' => 'Няма полета, който да са се променили, така че нищо не е осъвременено.',
        'success' => 'Location successfully updated.|:count locations successfully updated.',
        'warn' => 'Edit the fields below to update this location. Fields you leave blank will not change on the location.|Edit the fields below to update all :count selected locations. Fields you leave blank will not change on any of them.',
        'show_selected' => '1 selected location|:count selected locations',
        'company_scope_mismatch_partial' => 'The company was not changed on 1 location because items or users at that location belong to different companies. Update or move those first.|The company was not changed on :count locations because items or users at those locations belong to different companies. Update or move those first.',
        'company_scope_mismatch_all' => 'No locations were reassigned. The requested company does not match items or users at the selected location.|No locations were reassigned. The requested company does not match items or users at any of the :count selected locations.',
        'parent_company_mismatch_partial' => 'The parent or company was not changed on 1 location because it would leave the location in a different company than its parent.|The parent or company was not changed on :count locations because it would leave those locations in a different company than their parent.',
        'parent_company_mismatch_all' => 'No changes were saved. The requested parent or company would leave the location in a different company than its parent.|No changes were saved. The requested parent or company would leave every one of the :count selected locations in a different company than their parent.',
    ],

];

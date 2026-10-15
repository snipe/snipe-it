<?php

return [

    'does_not_exist' => 'Lokacija ne postoji.',
    'assoc_users' => 'This location is not currently deletable because it is the location of record for at least one item or user, has assets assigned to it, or is the parent location of another location. Please update your records to no longer reference this location and try again ',
    'assoc_assets' => 'Ta je lokacija trenutačno povezana s barem jednim resursom i ne može se izbrisati. Ažurirajte svoju imovinu da više ne referira na tu lokaciju i pokušajte ponovno.',
    'assoc_child_loc' => 'Ta je lokacija trenutačno roditelj najmanje jedne lokacije za djecu i ne može se izbrisati. Ažurirajte svoje lokacije da više ne referiraju ovu lokaciju i pokušajte ponovo.',
    'assigned_assets' => 'Assigned Assets',
    'current_location' => 'Current Location',
    'deleted_warning' => 'This location has been deleted. Please restore it before attempting to make any changes.',

    'create' => [
        'error' => 'Lokacija nije izrađena, pokušajte ponovo.',
        'success' => 'Lokacija je uspješno izrađena.',
    ],

    'update' => [
        'error' => 'Lokacija nije ažurirana, pokušajte ponovo',
        'success' => 'Lokacija je uspješno ažurirana.',
    ],

    'restore' => [
        'error' => 'Location was not restored, please try again',
        'success' => 'Location restored successfully.',
    ],

    'delete' => [
        'confirm' => 'Jeste li sigurni da želite izbrisati tu lokaciju?',
        'error' => 'Došlo je do problema s brisanjem lokacije. Molim te pokušaj ponovno.',
        'success' => 'Lokacija je uspješno obrisana.',
    ],

    'bulkedit' => [
        'error' => 'Nijedna polja nisu promijenjena, tako da ništa nije ažurirano.',
        'success' => 'Location successfully updated.|:count locations successfully updated.',
        'warn' => 'Edit the fields below to update this location. Fields you leave blank will not change on the location.|Edit the fields below to update all :count selected locations. Fields you leave blank will not change on any of them.',
        'show_selected' => '1 selected location|:count selected locations',
        'company_scope_mismatch_partial' => 'The company was not changed on 1 location because items or users at that location belong to different companies. Update or move those first.|The company was not changed on :count locations because items or users at those locations belong to different companies. Update or move those first.',
        'company_scope_mismatch_all' => 'No locations were reassigned. The requested company does not match items or users at the selected location.|No locations were reassigned. The requested company does not match items or users at any of the :count selected locations.',
        'parent_company_mismatch_partial' => 'The parent or company was not changed on 1 location because it would leave the location in a different company than its parent.|The parent or company was not changed on :count locations because it would leave those locations in a different company than their parent.',
        'parent_company_mismatch_all' => 'No changes were saved. The requested parent or company would leave the location in a different company than its parent.|No changes were saved. The requested parent or company would leave every one of the :count selected locations in a different company than their parent.',
    ],

];

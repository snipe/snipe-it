<?php

return [

    'does_not_exist' => 'Lokacija ne obstaja.',
    'assoc_users' => 'This location is not currently deletable because it is the location of record for at least one item or user, has assets assigned to it, or is the parent location of another location. Please update your records to no longer reference this location and try again ',
    'assoc_assets' => 'Ta lokacija je trenutno povezana z vsaj enim sredstvom in je ni mogoče izbrisati. Prosimo, posodobite svoja sredstva, da ne bodo več vsebovali te lokacije in poskusite znova. ',
    'assoc_child_loc' => 'Ta lokacija je trenutno starš vsaj ene lokacije otroka in je ni mogoče izbrisati. Posodobite svoje lokacije, da ne bodo več vsebovale te lokacije in poskusite znova. ',
    'assigned_assets' => 'Dodeljena sredstva',
    'current_location' => 'Trenutna lokacija',
    'deleted_warning' => 'This location has been deleted. Please restore it before attempting to make any changes.',

    'create' => [
        'error' => 'Lokacija ni bila ustvarjena, poskusite znova.',
        'success' => 'Lokacija je bila uspešno ustvarjena.',
    ],

    'update' => [
        'error' => 'Lokacija ni posodobljena, poskusite znova',
        'success' => 'Lokacija je bila posodobljena.',
    ],

    'restore' => [
        'error' => 'Lokacija ni bila obnovljena, poskusite znova',
        'success' => 'Lokacija je bila uspešno obnovljena.',
    ],

    'delete' => [
        'confirm' => 'Ali ste prepričani, da želite izbrisati to lokacijo?',
        'error' => 'Prišlo je do težave z brisanjem lokacije. Prosim poskusite ponovno.',
        'success' => 'Lokacija je bila uspešno izbrisana.',
    ],

    'bulkedit' => [
        'error' => 'Polja niso bila spremenjena, nič ni posodobljeno.',
        'success' => 'Location successfully updated.|:count locations successfully updated.',
        'warn' => 'Edit the fields below to update this location. Fields you leave blank will not change on the location.|Edit the fields below to update all :count selected locations. Fields you leave blank will not change on any of them.',
        'show_selected' => '1 selected location|:count selected locations',
        'company_scope_mismatch_partial' => 'The company was not changed on 1 location because items or users at that location belong to different companies. Update or move those first.|The company was not changed on :count locations because items or users at those locations belong to different companies. Update or move those first.',
        'company_scope_mismatch_all' => 'No locations were reassigned. The requested company does not match items or users at the selected location.|No locations were reassigned. The requested company does not match items or users at any of the :count selected locations.',
        'parent_company_mismatch_partial' => 'The parent or company was not changed on 1 location because it would leave the location in a different company than its parent.|The parent or company was not changed on :count locations because it would leave those locations in a different company than their parent.',
        'parent_company_mismatch_all' => 'No changes were saved. The requested parent or company would leave the location in a different company than its parent.|No changes were saved. The requested parent or company would leave every one of the :count selected locations in a different company than their parent.',
    ],

];

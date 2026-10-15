<?php

return [

    'does_not_exist' => 'Lokasi tidak wujud.',
    'assoc_users' => 'This location is not currently deletable because it is the location of record for at least one item or user, has assets assigned to it, or is the parent location of another location. Please update your records to no longer reference this location and try again ',
    'assoc_assets' => 'Lokasi ini kini dikaitkan dengan sekurang-kurangnya satu aset dan tidak boleh dihapuskan. Sila kemas kini aset anda untuk tidak merujuk lagi lokasi ini dan cuba lagi.',
    'assoc_child_loc' => 'Lokasi ini adalah ibu bapa sekurang-kurangnya satu lokasi kanak-kanak dan tidak boleh dipadamkan. Sila kemas kini lokasi anda untuk tidak merujuk lokasi ini lagi dan cuba lagi.',
    'assigned_assets' => 'Aset yang Ditetapkan',
    'current_location' => 'Lokasi Semasa',
    'deleted_warning' => 'This location has been deleted. Please restore it before attempting to make any changes.',

    'create' => [
        'error' => 'Lokasi gagal dicipta, sila cuba lagi.',
        'success' => 'Lokasi berjaya dicipta.',
    ],

    'update' => [
        'error' => 'Lokasi gagal dikemaskini, sila cuba lagi',
        'success' => 'Lokasi berjaya dikemaskini.',
    ],

    'restore' => [
        'error' => 'Lokasi tidak dipulihkan, sila cuba semula.',
        'success' => 'Lokasi berjaya dipulihkan.',
    ],

    'delete' => [
        'confirm' => 'Anda pasti and ingin menghapuskan lokasi ini?',
        'error' => 'Ada isu semasa menghapuskan lokasi. Sila cuba lagi.',
        'success' => 'Lokasi berjaya dihapuskan.',
    ],

    'bulkedit' => [
        'error' => 'Tiada medan berubah, jadi tiada apa yang dikemas kini.',
        'success' => 'Location successfully updated.|:count locations successfully updated.',
        'warn' => 'Edit the fields below to update this location. Fields you leave blank will not change on the location.|Edit the fields below to update all :count selected locations. Fields you leave blank will not change on any of them.',
        'show_selected' => '1 selected location|:count selected locations',
        'company_scope_mismatch_partial' => 'The company was not changed on 1 location because items or users at that location belong to different companies. Update or move those first.|The company was not changed on :count locations because items or users at those locations belong to different companies. Update or move those first.',
        'company_scope_mismatch_all' => 'No locations were reassigned. The requested company does not match items or users at the selected location.|No locations were reassigned. The requested company does not match items or users at any of the :count selected locations.',
        'parent_company_mismatch_partial' => 'The parent or company was not changed on 1 location because it would leave the location in a different company than its parent.|The parent or company was not changed on :count locations because it would leave those locations in a different company than their parent.',
        'parent_company_mismatch_all' => 'No changes were saved. The requested parent or company would leave the location in a different company than its parent.|No changes were saved. The requested parent or company would leave every one of the :count selected locations in a different company than their parent.',
    ],

];

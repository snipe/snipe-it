<?php

return [

    'deleted' => 'Model aset yang dipadam',
    'does_not_exist' => 'Model tidak wujud.',
    'no_association' => 'AMARAN! Model aset untuk item ini tidak sah atau tiada!',
    'no_association_fix' => 'Ini akan menyebabkan masalah yang pelik dan teruk. Sila sunting aset ini sekarang untuk menetapkan model kepadanya.',
    'assoc_users' => 'Model ini sekarang disekutukan dengan sekurang2nya satu atau lebih harta dan tidak boleh dihapuskan. Sila kemaskini harta, dan kemudian cuba lagi. ',
    'invalid_category_type' => 'Kategori ini mesti merupakan kategori aset.',

    'create' => [
        'error' => 'Model gagal dicipta, sila cuba lagi.',
        'success' => 'Model berjaya dicipta.',
        'duplicate_set' => 'Model aset dengan nama itu, pengeluar dan nombor model sudah ada.',
    ],

    'update' => [
        'error' => 'Model gagal dikemaskin, sila cuba lagi',
        'success' => 'Model berjaya dikemaskini.',
    ],

    'delete' => [
        'confirm' => 'Anda pasti anda ingin hapuskan model harta ini?',
        'error' => 'Ada isu semasa menghapuskan model. Sila cuba lagi.',
        'success' => 'Model berjaya dihapuskan.',
    ],

    'restore' => [
        'error' => 'Model tidak dipulihkan, sila cuba lagi',
        'success' => 'Model berjaya dipulihkan.',
    ],

    'bulkedit' => [
        'error' => 'Tiada medan berubah, jadi tiada apa yang dikemas kini.',
        'success' => 'Model berjaya dikemas kini. |:model_count model berjaya dikemas kini.',
        'warn' => 'Anda akan mengemas kini sifat model berikut: | Anda akan menyunting sifat :model_count model berikut:',

    ],

    'bulkdelete' => [
        'error' => 'Tiada model dipilih, jadi tiada apa yang dipadamkan.',
        'nothing_deletable' => 'None of the selected models can be deleted because they still have assets associated with them.',
        'success' => 'Model dipadam! | :success_count model dipadam!',
        'success_partial' => ':success_count model(s) telah dipadamkan, namun :fail_count tidak dapat dipadamkan kerana mereka masih mempunyai aset yang dikaitkan dengannya.',
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

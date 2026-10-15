<?php

return [

    'does_not_exist' => 'Lokasi tidak ada.',
    'assoc_users' => 'Lokasi ini saat ini tidak dapat dihapus karena merupakan lokasi digunakan setidaknya satu item atau pengguna, memiliki aset yang ditetapkan, atau merupakan lokasi induk dari lokasi lain. Harap ubah rekaman Anda agar tidak lagi merujuk ke lokasi ini dan coba lagi ',
    'assoc_assets' => 'Lokasi saat ini dikaitkan dengan setidaknya oleh satu aset dan tidak dapat dihapus. Perbarui aset Anda yang tidak ada referensi dari lokasi ini dan coba lagi. ',
    'assoc_child_loc' => 'Lokasi saat ini digunakan oleh induk salah satu dari turunan lokasi dan tidak dapat di hapus. Mohon perbarui lokasi Anda ke yang tidak ada referensi dengan lokasi ini dan coba kembali. ',
    'assigned_assets' => 'Aset yang Ditetapkan',
    'current_location' => 'Lokasi Saat Ini',
    'deleted_warning' => 'Lokasi ini telah dihapus. Harap pulihkan sebelum mencoba melakukan perubahan apa pun.',

    'create' => [
        'error' => 'Lokasi gagal di buat, mohon coba kebali.',
        'success' => 'Lokasi sukses di buat.',
    ],

    'update' => [
        'error' => 'Lokasi gagal di perbarui, mohon coba kembali',
        'success' => 'Lokasi sukses di perbarui.',
    ],

    'restore' => [
        'error' => 'Lokasi gagal dipulihkan, harap coba lagi',
        'success' => 'Lokasi berhasil dipulihkan.',
    ],

    'delete' => [
        'confirm' => 'Apakah Anda yakin untuk menghapus lokasi ini?',
        'error' => 'Terdapat kesalahan pada saat penghapusan lokasi ini. Silahkan coba kembali.',
        'success' => 'Lokasi telah berhasil dihapus.',
    ],

    'bulkedit' => [
        'error' => 'Tidak ada bidang yang berubah, jadi tidak ada yang diperbarui.',
        'success' => 'Location successfully updated.|:count locations successfully updated.',
        'warn' => 'Edit the fields below to update this location. Fields you leave blank will not change on the location.|Edit the fields below to update all :count selected locations. Fields you leave blank will not change on any of them.',
        'show_selected' => '1 selected location|:count selected locations',
        'company_scope_mismatch_partial' => 'The company was not changed on 1 location because items or users at that location belong to different companies. Update or move those first.|The company was not changed on :count locations because items or users at those locations belong to different companies. Update or move those first.',
        'company_scope_mismatch_all' => 'No locations were reassigned. The requested company does not match items or users at the selected location.|No locations were reassigned. The requested company does not match items or users at any of the :count selected locations.',
        'parent_company_mismatch_partial' => 'The parent or company was not changed on 1 location because it would leave the location in a different company than its parent.|The parent or company was not changed on :count locations because it would leave those locations in a different company than their parent.',
        'parent_company_mismatch_all' => 'No changes were saved. The requested parent or company would leave the location in a different company than its parent.|No changes were saved. The requested parent or company would leave every one of the :count selected locations in a different company than their parent.',
    ],

];

<?php

return array(

    'undeployable' 		=> '<strong>Peringatan: </strong> Aset ini telah di tandai sebagai aset yang tak dapat digunakan.
                        Jika status ini telah berubah, silahkan perbarui status aset.',
    'does_not_exist' 	=> 'Aset tidak ada.',
    'does_not_exist_or_not_requestable' => 'Aset tersebut tidak terdaftar atau tidak dapat di minta.',
    'assoc_users'	 	=> 'Aset ini sudah diberikan kepada pengguna dan tidak dapat di hapus. Silahkan cek aset terlebih dahulu kemudian coba hapus kembali. ',

    'create' => array(
        'error'   		=> 'Aset gagal di buat, silahkan coba kembali',
        'success' 		=> 'Sukses membuat aset'
    ),

    'update' => array(
        'error'   			=> 'Gagal perbarui aset, silahkan coba kembali',
        'success' 			=> 'Sukses perbarui aset.',
        'nothing_updated'	=>  'No fields were selected, so nothing was updated.',
    ),

    'restore' => array(
        'error'   		=> 'Asset was not restored, please try again',
        'success' 		=> 'Asset restored successfully.'
    ),

    'deletefile' => array(
        'error'   => 'File not deleted. Please try again.',
        'success' => 'File successfully deleted.',
    ),

    'upload' => array(
        'error'   => 'File(s) not uploaded. Please try again.',
        'success' => 'File(s) successfully uploaded.',
        'nofiles' => 'You did not select any files for upload, or the file you are trying to upload is too large',
        'invalidfiles' => 'One or more of your files is too large or is a filetype that is not allowed. Allowed filetypes are png, gif, jpg, doc, docx, pdf, and txt.',
    ),

    'import' => array(
        'error'         => 'Some items did not import correctly.',
        'errorDetail'   => 'The following Items were not imported because of errors.',
        'success'       => "Your file has been imported",
    ),


    'delete' => array(
        'confirm'   	=> 'Apakah Anda yakin untuk menghapus aset ini?',
        'error'   		=> 'Terdapat kesalahan pada saat penghapusan aset. Silahkan coba kembali.',
        'success' 		=> 'Aset sukses terhapus.'
    ),

    'checkout' => array(
        'error'   		=> 'Aset gagal di berikan, silahkan coba kembali',
        'success' 		=> 'Sukses memberikan aset.',
        'user_does_not_exist' => 'Pengguna tersebut tidak terdaftar. Silahkan coba kembali.',
        'not_available' => 'That asset is not available for checkout!'
    ),

    'checkin' => array(
        'error'   		=> 'Aset gagal di terima, silahkan coba kembali',
        'success' 		=> 'Sukses menerima aset.',
        'user_does_not_exist' => 'Pengguna tersebut tidak terdaftar. Silahkan coba kembali.',
        'already_checked_in'  => 'Aset tersebut telah di terima.',

    ),

    'requests' => array(
        'error'   		=> 'Aset gagal di minta, silahkan coba kembali',
        'success' 		=> 'Sukses meminta aset.',
    )

);

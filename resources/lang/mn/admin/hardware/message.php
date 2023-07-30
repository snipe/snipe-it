<?php

return [

    'undeployable' 		=> '<strong>Анхааруулга: </strong> Энэ хөрөнгө нь одоогоор хүчингүй болсон гэж тэмдэглэгдсэн байна. Хэрэв энэ байдал өөрчлөгдсөн бол хөрөнгийн статусыг шинэчлэнэ үү.',
    'does_not_exist' 	=> 'Хөрөнгө байхгүй байна.',
    'does_not_exist_or_not_requestable' => 'That asset does not exist or is not requestable.',
    'assoc_users'	 	=> 'Энэ хөрөнгийг одоогоор хэрэглэгчид шалгаж, устгах боломжгүй байна. Эхлээд хөрөнгийг шалгаж үзээд дараа нь устга.',

    'create' => [
        'error'   		=> 'Акт үүсгээгүй байна, дахин оролдоно уу. :(',
        'success' 		=> 'Хөрөнгө амжилттай болсон. :)',
    ],

    'update' => [
        'error'   			=> 'Хөрөнгийн шинэчлэлт хийгдээгүй тул дахин оролдоно уу',
        'success' 			=> 'Акт амжилттай шинэчлэгдсэн.',
        'nothing_updated'	=>  'Ямар ч талбар сонгогдоогүй тул шинэчлэгдээгүй байна.',
        'no_assets_selected'  =>  'No assets were selected, so nothing was updated.',
    ],

    'restore' => [
        'error'   		=> 'Хөрөнгө сэргээгээгүй байна, дахин оролдоно уу',
        'success' 		=> 'Хөрөнгийн амжилттай сэргээгдэв.',
        'bulk_success' 		=> 'Asset restored successfully.',
        'nothing_updated'   => 'No assets were selected, so nothing was restored.', 
    ],

    'audit' => [
        'error'   		=> 'Хөрөнгийн аудит амжилтгүй болсон. Дахин оролдоно уу.',
        'success' 		=> 'Хөрөнгийн аудит амжилттай нэвтэрсэн байна.',
    ],


    'deletefile' => [
        'error'   => 'Файлыг устгаагүй байна. Дахин оролдоно уу.',
        'success' => 'Файл амжилттай устгагдсан.',
    ],

    'upload' => [
        'error'   => 'Файлд байршуулаагүй файл. Дахин оролдоно уу.',
        'success' => 'Файлууд амжилттай байршуулсан.',
        'nofiles' => 'Та байршуулах ямар ч файл сонгоогүй, эсвэл байршуулах гэж буй файл хэт том байна',
        'invalidfiles' => 'Таны файлуудын нэг юмуу хэд нь хэтэрхий том юмуу эсвэл файлын төрлийг зөвшөөрдөггүй. Зөвшөөрөгдсөн filetypes нь png, gif, jpg, doc, docx, pdf, болон txt байна.',
    ],

    'import' => [
        'error'                 => 'Зарим зүйлс зөв импорт хийгдээгүй байна.',
        'errorDetail'           => 'Дараах зүйлсийг алдааны улмаас импортолсонгүй.',
        'success'               => 'Таны файл импортлогдсон байна',
        'file_delete_success'   => 'Таны файл амжилттай болсон байна',
        'file_delete_error'      => 'Файл устгагдах боломжгүй байна',
        'header_row_has_malformed_characters' => 'One or more attributes in the header row contain malformed UTF-8 characters',
        'content_row_has_malformed_characters' => 'One or more attributes in the first row of content contain malformed UTF-8 characters',
    ],


    'delete' => [
        'confirm'   	=> 'Та энэ хөрөнгийг устгахыг хүсч байна уу?',
        'error'   		=> 'Хөрөнгийг устгах асуудал гарлаа. Дахин оролдоно уу.',
        'nothing_updated'   => 'Ямар ч хөрөнгө сонгогдоогүй тул юу ч устгаагүй.',
        'success' 		=> 'Хөрөнгийг амжилттай устгасан байна.',
    ],

    'checkout' => [
        'error'   		=> 'Хөрөнгийг шалгаагүй байна, дахин оролдоно уу',
        'success' 		=> 'Акт амжилттай шалгасан.',
        'user_does_not_exist' => 'Энэ хэрэглэгч буруу байна. Дахин оролдоно уу.',
        'not_available' => 'Энэ хөрөнгийг татаж авахад бэлэн биш байна!',
        'no_assets_selected' => 'Жагсаалтаас доод тал нь нэг хөрөнгийг сонгоно уу',
    ],

    'checkin' => [
        'error'   		=> 'Хөрөнгө оруулаагүй байна, дахин оролдоно уу',
        'success' 		=> 'Хөрөнгө амжилттай шалгагдсан.',
        'user_does_not_exist' => 'Энэ хэрэглэгч буруу байна. Дахин оролдоно уу.',
        'already_checked_in'  => 'Энэ аккаунтыг аль хэдийн шалгасан байна.',

    ],

    'requests' => [
        'error'   		=> 'Акт хүсээгүй тул дахин оролдоно уу',
        'success' 		=> 'Хөрөнгө амжилттай ирэв.',
        'canceled'      => 'Тооцоо хийх хүсэлт амжилттай цуцлагдсан',
    ],

];

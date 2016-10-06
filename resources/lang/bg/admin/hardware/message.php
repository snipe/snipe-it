<?php

return array(

    'undeployable' 		=> '<strong>Внимание:</strong> Този актив е маркиран като невъзможен за предоставяне. Ако статусът е променен, моля обновете актива.',
    'does_not_exist' 	=> 'Активът не съществува.',
    'does_not_exist_or_not_requestable' => 'Добър опит. Активът не съществува или не може а бъде предоставян.',
    'assoc_users'	 	=> 'Активът е изписан на потребител и не може да бъде изтрит. Моля впишете го обратно и след това опитайте да го изтриете отново.',

    'create' => array(
        'error'   		=> 'Активът не беше създаден. Моля опитайте отново.',
        'success' 		=> 'Активът създаден успешно.'
    ),

    'update' => array(
        'error'   			=> 'Активът не беше обновен. Моля опитайте отново.',
        'success' 			=> 'Активът обновен успешно.',
        'nothing_updated'	=>  'Няма избрани полета, съответно нищо не беше обновено.',
    ),

    'restore' => array(
        'error'   		=> 'Активът не беше възстановен. Моля опитайте отново.',
        'success' 		=> 'Активът възстановен успешно.'
    ),

    'deletefile' => array(
        'error'   => 'Файлът не беше изтрит. Моля опитайте отново.',
        'success' => 'Файлът изтрит успешно.',
    ),

    'upload' => array(
        'error'   => 'Качването неуспешно. Моля опитайте отново.',
        'success' => 'Качването успешно.',
        'nofiles' => 'Не сте избрали файлове за качване или са твърде големи.',
        'invalidfiles' => 'Един или повече файлове са твърде големи или с непозволен тип. Разрешените файлови типове за качване са png, gif, jpg, doc, docx, pdf и txt.',
    ),

    'import' => array(
        'error'                 => 'Some items did not import correctly.',
        'errorDetail'           => 'The following Items were not imported because of errors.',
        'success'               => "Your file has been imported",
        'file_delete_success'   => "Your file has been been successfully deleted",
        'file_delete_error'      => "The file was unable to be deleted",
    ),


    'delete' => array(
        'confirm'   	=> 'Сигурни ли сте, че желаете изтриване на актива?',
        'error'   		=> 'Проблем при изтриване на актива. Моля опитайте отново.',
        'success' 		=> 'Активът е изтрит успешно.'
    ),

    'checkout' => array(
        'error'   		=> 'Активът не беше изписан. Моля опитайте отново.',
        'success' 		=> 'Активът изписан успешно.',
        'user_does_not_exist' => 'Невалиден потребител. Моля опитайте отново.',
        'not_available' => 'That asset is not available for checkout!'
    ),

    'checkin' => array(
        'error'   		=> 'Активът не беше вписан. Моля опитайте отново.',
        'success' 		=> 'Активът вписан успешно.',
        'user_does_not_exist' => 'Невалиден потребител. Моля опитайте отново.',
        'already_checked_in'  => 'That asset is already checked in.',

    ),

    'requests' => array(
        'error'   		=> 'Активът не беше изискан. Моля опитайте отново.',
        'success' 		=> 'Активът изискан успешно.',
        'canceled'      => 'Checkout request successfully canceled'
    )

);

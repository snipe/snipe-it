<?php

return array(

    'undeployable' 		=> '<strong>Warning: </strong> This asset has been marked as currently undeployable.
                        If this status has changed, please update the asset status.',
    'does_not_exist' 	=> 'Tài sản không tồn tại.',
    'does_not_exist_or_not_requestable' => 'Nice try. That asset does not exist or is not requestable.',
    'assoc_users'	 	=> 'This asset is currently checked out to a user and cannot be deleted. Please check the asset in first, and then try deleting again. ',

    'create' => array(
        'error'   		=> 'Asset was not created, please try again. :(',
        'success' 		=> 'Tài sản được tạo thành công. :)'
    ),

    'update' => array(
        'error'   			=> 'Tài sản chưa được cập nhật. Bạn hãy thử lại',
        'success' 			=> 'Tài sản được cập nhật thành công.',
        'nothing_updated'	=>  'Bạn đã không chọn trường nào vì thế đã không có gì được cập nhật.',
    ),

    'restore' => array(
        'error'   		=> 'Tài sản không được khôi phục, bạn hãy thử lại',
        'success' 		=> 'Tài sản được khôi phục thành công.'
    ),

    'deletefile' => array(
        'error'   => 'Tập tin đã không được xoá. Bạn hãy thử lại.',
        'success' => 'Tập tin đã được xoá thành công.',
    ),

    'upload' => array(
        'error'   => 'Tập tin đã không được tải lên. Bạn hãy thử lại.',
        'success' => 'Tập tin đã được tải lên thành công.',
        'nofiles' => 'You did not select any files for upload, or the file you are trying to upload is too large',
        'invalidfiles' => 'Một hoặc nhiều tập tin của bạn có dung lượng quá lớn hoặc có định dạng không được hỗ trợ. Những tập tin được hỗ trợ bao gồm: png, gif, jpg, doc, docx, pdf, và txt.',
    ),


    'delete' => array(
        'confirm'   	=> 'Bạn có chắc chắn muốn xoá bỏ tài sản này?',
        'error'   		=> 'Đã có vấn đề xảy ra khi xoá tài sản này. Bạn hãy thử lại xem.',
        'success' 		=> 'Tài sản này được xoá thành công.'
    ),

    'checkout' => array(
        'error'   		=> 'Asset was not checked out, please try again',
        'success' 		=> 'Asset checked out successfully.',
        'user_does_not_exist' => 'Người dùng này không tồn tại. Bạn hãy thử lại.'
    ),

    'checkin' => array(
        'error'   		=> 'Asset was not checked in, please try again',
        'success' 		=> 'Asset checked in successfully.',
        'user_does_not_exist' => 'Người dùng này không tồn tại. Bạn hãy thử lại.'
    )

);

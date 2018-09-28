<?php

return array(

    'does_not_exist' => 'Kiểu tài sản không tồn tại.',
    'assoc_users'	 => 'Tài sản này hiện tại đang liên kết với ít nhất một hoặc nhiều tài sản và không thể xóa. Xin vui lòng xóa tài sản, và cố gắng thử lại lần nữa. ',


    'create' => array(
        'error'   => 'Kiểu tài sản chưa được tạo, xin thử lại.',
        'success' => 'Kiểu tài sản đã tạo thành công.',
        'duplicate_set' => 'Kiểu tài sản này với tên, nhà sản xuất và mã tài sản thật sự đã tồn tại.',
    ),

    'update' => array(
        'error'   => 'Kiểu tài sản chưa cập nhật, xin thử lại',
        'success' => 'Kiểu tài sản đã cập nhật thành công.'
    ),

    'delete' => array(
        'confirm'   => 'Bạn có chắc muốn xóa kiểu tài sản này?',
        'error'   => 'Có vấn đề xảy ra khi xóa kiểu tài sản. Xin thử lại.',
        'success' => 'Kiểu tài sản đã xóa thành công.'
    ),

    'restore' => array(
        'error'   		=> 'Kiểu tài sản chưa được phục hồi, xin thử lại',
        'success' 		=> 'Kiểu tài sản đã được phục hồi thành công.'
    ),

    'bulkedit' => array(
        'error'   		=> 'Không có trường nào được thay đổi, vì vậy không có gì được cập nhật.',
        'success' 		=> 'Các mô hình được cập nhật.'
    ),

    'bulkdelete' => array(
        'error'   		    => 'Không có mục nào được chọn, nên không có gì bị xóa cả.',
        'success' 		    => ':succes_count model(s) đã được xóa!',
        'success_partial' 	=> ':success_count model(s) were deleted, however :fail_count were unable to be deleted because they still have assets associated with them.'
    ),

);

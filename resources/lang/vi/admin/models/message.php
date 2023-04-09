<?php

return array(

    'does_not_exist' => 'Kiểu tài sản không tồn tại.',
    'no_association' => 'NO MODEL ASSOCIATED.',
    'no_association_fix' => 'This will break things in weird and horrible ways. Edit this asset now to assign it a model.',
    'assoc_users'	 => 'Tài sản này hiện tại đang liên kết với ít nhất một hoặc nhiều tài sản và không thể xóa. Xin vui lòng xóa tài sản, và cố gắng thử lại lần nữa. ',


    'create' => array(
        'error'   => 'Kiểu tài sản chưa được tạo, xin thử lại.',
        'success' => 'Kiểu tài sản đã tạo thành công.',
        'duplicate_set' => 'Kiểu tài sản này với tên, nhà sản xuất và mã tài sản thật sự đã tồn tại.',
    ),

    'update' => array(
        'error'   => 'Kiểu tài sản chưa cập nhật, xin thử lại',
        'success' => 'Kiểu tài sản đã cập nhật thành công.',
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
        'success' 		=> 'Model successfully updated. |:model_count models successfully updated.',
        'warn'          => 'You are about to update the properies of the following model: |You are about to edit the properties of the following :model_count models:',

    ),

    'bulkdelete' => array(
        'error'   		    => 'Không có mục nào được chọn, nên không có gì bị xóa cả.',
        'success' 		    => 'Model deleted!|:success_count models deleted!',
        'success_partial' 	=> ':success_count model(s) kiểu tài sản đã được xóa, tuy nhiên có :fail_count loại không cho phép xóa vì chúng vẫn còn gắn liên kết đết tài sản.'
    ),

);

<?php

return [

    'deleted' => 'Model tài sản đã xóa',
    'does_not_exist' => 'Kiểu tài sản không tồn tại.',
    'no_association' => 'CẢNH BÁO! Model tài sản cho cho thiết bị này không hợp lệ hoặc bị thiếu!',
    'no_association_fix' => 'Điều này sẽ phá vỡ mọi thứ theo những cách kỳ lạ và khủng khiếp. Hãy chỉnh sửa tài sản này ngay bây giờ để gán cho nó một model.',
    'assoc_users' => 'Tài sản này hiện tại đang liên kết với ít nhất một hoặc nhiều tài sản và không thể xóa. Xin vui lòng xóa tài sản, và cố gắng thử lại lần nữa. ',
    'invalid_category_type' => 'This category must be an asset category.',

    'create' => [
        'error' => 'Kiểu tài sản chưa được tạo, xin thử lại.',
        'success' => 'Kiểu tài sản đã tạo thành công.',
        'duplicate_set' => 'Kiểu tài sản này với tên, nhà sản xuất và mã tài sản thật sự đã tồn tại.',
    ],

    'update' => [
        'error' => 'Kiểu tài sản chưa cập nhật, xin thử lại',
        'success' => 'Kiểu tài sản đã cập nhật thành công.',
    ],

    'delete' => [
        'confirm' => 'Bạn có chắc muốn xóa kiểu tài sản này?',
        'error' => 'Có vấn đề xảy ra khi xóa kiểu tài sản. Xin thử lại.',
        'success' => 'Kiểu tài sản đã xóa thành công.',
    ],

    'restore' => [
        'error' => 'Kiểu tài sản chưa được phục hồi, xin thử lại',
        'success' => 'Kiểu tài sản đã được phục hồi thành công.',
    ],

    'bulkedit' => [
        'error' => 'Không có trường nào được thay đổi, vì vậy không có gì được cập nhật.',
        'success' => 'Model đã được cập nhật thành công. |:model_count models đã được cập nhật thành công.',
        'warn' => 'You are about to update the properties of the following model:|You are about to edit the properties of the following :model_count models:',

    ],

    'bulkdelete' => [
        'error' => 'Không có mục nào được chọn, nên không có gì bị xóa cả.',
        'nothing_deletable' => 'None of the selected models can be deleted because they still have assets associated with them.',
        'success' => 'Model đã xóa!|:success_count model đã xóa!',
        'success_partial' => ':success_count model(s) kiểu tài sản đã được xóa, tuy nhiên có :fail_count loại không cho phép xóa vì chúng vẫn còn gắn liên kết đết tài sản.',
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

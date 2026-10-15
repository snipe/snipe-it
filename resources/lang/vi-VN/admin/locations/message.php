<?php

return [

    'does_not_exist' => 'Địa phương không tồn tại.',
    'assoc_users' => 'This location is not currently deletable because it is the location of record for at least one item or user, has assets assigned to it, or is the parent location of another location. Please update your records to no longer reference this location and try again ',
    'assoc_assets' => 'Địa phương này hiện tại đã được liên kết với ít nhất một tài sản và không thể xóa. Xin vui lòng cập nhật tài sản của bạn để không còn liên kết với địa phương này nữa và thử lại. ',
    'assoc_child_loc' => 'Địa phương này hiện tại là cấp parent của ít nhật một địa phương con và không thể xóa. Xin vui lòng cập nhật địa phương của bạn để không liên kết đến địa phương này và thử lại. ',
    'assigned_assets' => 'Tài sản được giao',
    'current_location' => 'Vị trí hiện tại',
    'deleted_warning' => 'This location has been deleted. Please restore it before attempting to make any changes.',

    'create' => [
        'error' => 'Địa phương chưa tạo, xin vui lòng thử lại.',
        'success' => 'Địa phương đã tạo thành công.',
    ],

    'update' => [
        'error' => 'Địa phương chưa cập nhật, xin vui lòng thử lại',
        'success' => 'Địa phương đã cập nhật thành công.',
    ],

    'restore' => [
        'error' => 'Location was not restored, please try again',
        'success' => 'Location restored successfully.',
    ],

    'delete' => [
        'confirm' => 'Bạn có chắc muốn xóa địa phương này?',
        'error' => 'Có vấn đề xảy ra khi xóa địa phương. Xin vui lòng thử lại.',
        'success' => 'Địa phương đã xóa thành công.',
    ],

    'bulkedit' => [
        'error' => 'Không có trường nào được thay đổi, vì vậy không có gì được cập nhật.',
        'success' => 'Location successfully updated.|:count locations successfully updated.',
        'warn' => 'Edit the fields below to update this location. Fields you leave blank will not change on the location.|Edit the fields below to update all :count selected locations. Fields you leave blank will not change on any of them.',
        'show_selected' => '1 selected location|:count selected locations',
        'company_scope_mismatch_partial' => 'The company was not changed on 1 location because items or users at that location belong to different companies. Update or move those first.|The company was not changed on :count locations because items or users at those locations belong to different companies. Update or move those first.',
        'company_scope_mismatch_all' => 'No locations were reassigned. The requested company does not match items or users at the selected location.|No locations were reassigned. The requested company does not match items or users at any of the :count selected locations.',
        'parent_company_mismatch_partial' => 'The parent or company was not changed on 1 location because it would leave the location in a different company than its parent.|The parent or company was not changed on :count locations because it would leave those locations in a different company than their parent.',
        'parent_company_mismatch_all' => 'No changes were saved. The requested parent or company would leave the location in a different company than its parent.|No changes were saved. The requested parent or company would leave every one of the :count selected locations in a different company than their parent.',
    ],

];

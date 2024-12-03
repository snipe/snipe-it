<?php

return [

    'undeployable' 		 => '<strong>Warning: </strong> This asset has been marked as currently undeployable. If this status has changed, please update the asset status.',
    'does_not_exist' 	 => 'ទ្រព្យសកម្មមិនមានទេ។',
    'does_not_exist_var' => 'Asset with tag :asset_tag not found.',
    'no_tag' 	         => 'No asset tag provided.',
    'does_not_exist_or_not_requestable' => 'ទ្រព្យសកម្មនោះមិនមានទេ ឬមិនអាចស្នើសុំបាន។',
    'assoc_users'	 	 => 'This asset is currently checked out to a user and cannot be deleted. Please check the asset in first, and then try deleting again. ',
    'warning_audit_date_mismatch' 	=> 'This asset\'s next audit date (:next_audit_date) is before the last audit date (:last_audit_date). Please update the next audit date.',
    'labels_generated'   => 'ស្លាកត្រូវបានបង្កើតដោយជោគជ័យ។',
    'error_generating_labels' => 'កំហុសខណៈពេលបង្កើតស្លាក។',
    'no_assets_selected' => 'មិនបានជ្រើសរើសទ្រព្យសម្បត្តិទេ។',

    'create' => [
        'error'   		=> 'ទ្រព្យសកម្មមិនត្រូវបានបង្កើតទេ សូមព្យាយាមម្តងទៀត។ :(',
        'success' 		=> 'ទ្រព្យសកម្មត្រូវបានបង្កើតដោយជោគជ័យ។ :)',
        'success_linked' => 'ទ្រព្យសកម្មជាមួយស្លាក៖ ស្លាកត្រូវបានបង្កើតដោយជោគជ័យ។ <strong><a href=":link" style="color: white;">ចុចទីនេះដើម្បីមើល</a></strong>។',
        'multi_success_linked' => 'Asset with tag :links was created successfully.|:count assets were created succesfully. :links.',
        'partial_failure' => 'An asset was unable to be created. Reason: :failures|:count assets were unable to be created. Reasons: :failures',
    ],

    'update' => [
        'error'   			=> 'ទ្រព្យសកម្មមិនត្រូវបានធ្វើបច្ចុប្បន្នភាពទេ សូមព្យាយាមម្តងទៀត',
        'success' 			=> 'ទ្រព្យសកម្មបានធ្វើបច្ចុប្បន្នភាពដោយជោគជ័យ។',
        'encrypted_warning' => 'Asset updated successfully, but encrypted custom fields were not due to permissions',
        'nothing_updated'	=>  'គ្មាន​វាល​ត្រូវ​បាន​ជ្រើស ដូច្នេះ​មិន​មាន​អ្វី​ត្រូវ​បាន​ធ្វើ​បច្ចុប្បន្នភាព​។',
        'no_assets_selected'  =>  'គ្មានទ្រព្យសម្បត្តិត្រូវបានជ្រើសរើស ដូច្នេះគ្មានអ្វីត្រូវបានធ្វើបច្ចុប្បន្នភាពទេ។',
        'assets_do_not_exist_or_are_invalid' => 'Selected assets cannot be updated.',
    ],

    'restore' => [
        'error'   		=> 'ទ្រព្យសកម្មមិនត្រូវបានស្ដារឡើងវិញទេ សូមព្យាយាមម្តងទៀត',
        'success' 		=> 'ទ្រព្យសកម្មត្រូវបានស្ដារឡើងវិញដោយជោគជ័យ។',
        'bulk_success' 		=> 'ទ្រព្យសកម្មត្រូវបានស្ដារឡើងវិញដោយជោគជ័យ។',
        'nothing_updated'   => 'គ្មានទ្រព្យសម្បត្តិត្រូវបានជ្រើសរើស ដូច្នេះគ្មានអ្វីត្រូវបានស្ដារឡើងវិញទេ។', 
    ],

    'audit' => [
        'error'   		=> 'Asset audit unsuccessful: :error ',
        'success' 		=> 'សវនកម្មទ្រព្យសកម្មត្រូវបានកត់ត្រាដោយជោគជ័យ។',
    ],


    'deletefile' => [
        'error'   => 'ឯកសារមិនត្រូវបានលុបទេ។ សូម​ព្យាយាម​ម្តង​ទៀត។',
        'success' => 'ឯកសារត្រូវបានលុបដោយជោគជ័យ។',
    ],

    'upload' => [
        'error'   => 'ឯកសារ(ច្រើន) មិនត្រូវបានផ្ទុកឡើងទេ។ សូម​ព្យាយាម​ម្តង​ទៀត។',
        'success' => 'ឯកសារ(ច្រើន) ដែលបានបង្ហោះដោយជោគជ័យ។',
        'nofiles' => 'អ្នកមិនបានជ្រើសរើសឯកសារណាមួយសម្រាប់ផ្ទុកឡើង ឬឯកសារដែលអ្នកកំពុងព្យាយាមផ្ទុកឡើងមានទំហំធំពេក',
        'invalidfiles' => 'ឯកសារមួយ ឬច្រើនរបស់អ្នកមានទំហំធំពេក ឬជាប្រភេទឯកសារដែលមិនត្រូវបានអនុញ្ញាត។ ប្រភេទឯកសារដែលបានអនុញ្ញាតគឺ png, gif, jpg, doc, docx, pdf, និង txt ។',
    ],

    'import' => [
        'import_button'         => 'Process Import',
        'error'                 => 'Some items did not import correctly.',
        'errorDetail'           => 'The following Items were not imported because of errors.',
        'success'               => 'ឯកសាររបស់អ្នកត្រូវបាននាំចូល',
        'file_delete_success'   => 'ឯកសាររបស់អ្នកត្រូវបានលុបដោយជោគជ័យ',
        'file_delete_error'      => 'ឯកសារមិនអាចលុបបានទេ។',
        'file_missing' => 'បាត់ឯកសារដែលបានជ្រើសរើស',
        'file_already_deleted' => 'The file selected was already deleted',
        'header_row_has_malformed_characters' => 'គុណលក្ខណៈមួយ ឬច្រើននៅក្នុងជួរបឋមកថាមានតួអក្សរ UTF-8 ខុសទម្រង់',
        'content_row_has_malformed_characters' => 'គុណលក្ខណៈមួយ ឬច្រើននៅក្នុងជួរទីមួយនៃមាតិកាមានតួអក្សរ UTF-8 ខុសទម្រង់',
    ],


    'delete' => [
        'confirm'   	=> 'តើអ្នកប្រាកដថាចង់លុបទ្រព្យសម្បត្តិនេះទេ?',
        'error'   		=> 'មានបញ្ហាក្នុងការលុបទ្រព្យសម្បត្តិ។ សូម​ព្យាយាម​ម្តង​ទៀត។',
        'nothing_updated'   => 'មិនមានទ្រព្យសម្បត្តិត្រូវបានជ្រើសរើស ដូច្នេះគ្មានអ្វីត្រូវបានលុបទេ។',
        'success' 		=> 'ទ្រព្យសកម្មត្រូវបានលុបដោយជោគជ័យ។',
    ],

    'checkout' => [
        'error'   		=> 'ទ្រព្យសកម្មមិនត្រូវបាន checked out ទេ សូមព្យាយាមម្តងទៀត',
        'success' 		=> 'ទ្រព្យសកម្មបាន checked out ដោយជោគជ័យ។',
        'user_does_not_exist' => 'អ្នកប្រើប្រាស់នោះមិនត្រឹមត្រូវទេ។ សូម​ព្យាយាម​ម្តង​ទៀត។',
        'not_available' => 'ទ្រព្យ​សកម្ម​នោះ​មិន​អាច​ checkout បាន​ទេ!',
        'no_assets_selected' => 'អ្នកត្រូវតែជ្រើសរើសយ៉ាងហោចណាស់ទ្រព្យសកម្មមួយពីបញ្ជី',
    ],

    'multi-checkout' => [
        'error'   => 'Asset was not checked out, please try again|Assets were not checked out, please try again',
        'success' => 'Asset checked out successfully.|Assets checked out successfully.',
    ],

    'checkin' => [
        'error'   		=> 'ទ្រព្យសកម្មមិនត្រូវ checked in ទេ, សូមព្យាយាមម្តងទៀត',
        'success' 		=> 'ទ្រព្យសកម្មបាន checked in ជោគជ័យ។',
        'user_does_not_exist' => 'អ្នកប្រើប្រាស់នោះមិនត្រឹមត្រូវទេ។ សូម​ព្យាយាម​ម្តង​ទៀត។',
        'already_checked_in'  => 'ទ្រព្យសកម្មនោះត្រូវ checked in រួចហើយ។',

    ],

    'requests' => [
        'error'   		=> 'ទ្រព្យសកម្មមិនត្រូវបានស្នើសុំទេ, សូមព្យាយាមម្តងទៀត',
        'success' 		=> 'ទ្រព្យសកម្មបានស្នើសុំដោយជោគជ័យ។',
        'canceled'      => 'សំណើ Checkout ត្រូវបានលុបចោលដោយជោគជ័យ',
    ],

];

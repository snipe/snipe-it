<?php

return [

    'does_not_exist' => 'ទីតាំងមិនមានទេ។',
    'assoc_users' => 'This location is not currently deletable because it is the location of record for at least one item or user, has assets assigned to it, or is the parent location of another location. Please update your records to no longer reference this location and try again ',
    'assoc_assets' => 'បច្ចុប្បន្នទីតាំងនេះត្រូវបានភ្ជាប់ជាមួយទ្រព្យសកម្មយ៉ាងហោចណាស់មួយ ហើយមិនអាចលុបបានទេ។ សូមអាប់ដេតទ្រព្យសកម្មរបស់អ្នក ដើម្បីកុំឱ្យយោងទីតាំងនេះតទៅទៀត ហើយព្យាយាមម្តងទៀត។ ',
    'assoc_child_loc' => 'បច្ចុប្បន្នទីតាំងនេះគឺជាមេនៃទីតាំងកូនយ៉ាងហោចណាស់មួយ ហើយមិនអាចលុបបានទេ។ សូម​ធ្វើ​បច្ចុប្បន្នភាព​ទីតាំង​របស់​អ្នក​ដើម្បី​លែង​យោង​ទីតាំង​នេះ​ទៀត​ហើយ​ព្យាយាម​ម្ដង​ទៀត។ ',
    'assigned_assets' => 'ទ្រព្យសកម្មដែលបានចាត់តាំង',
    'current_location' => 'ទីតាំង​បច្ចុប្បន្',
    'deleted_warning' => 'This location has been deleted. Please restore it before attempting to make any changes.',

    'create' => [
        'error' => 'ទីតាំងមិនត្រូវបានបង្កើតទេ សូមព្យាយាមម្តងទៀត។',
        'success' => 'ទីតាំងត្រូវបានបង្កើតដោយជោគជ័យ។',
    ],

    'update' => [
        'error' => 'ទីតាំងមិនត្រូវបានធ្វើបច្ចុប្បន្នភាពទេ សូមព្យាយាមម្តងទៀត',
        'success' => 'បានធ្វើបច្ចុប្បន្នភាពទីតាំងដោយជោគជ័យ។',
    ],

    'restore' => [
        'error' => 'ទីតាំងមិនត្រូវបានស្ដារឡើងវិញទេ សូមព្យាយាមម្តងទៀត',
        'success' => 'បានស្ដារទីតាំងឡើងវិញដោយជោគជ័យ។',
    ],

    'delete' => [
        'confirm' => 'តើអ្នកប្រាកដថាចង់លុបទីតាំងនេះទេ?',
        'error' => 'មានបញ្ហាក្នុងការលុបទីតាំង។ សូម​ព្យាយាម​ម្តង​ទៀត។',
        'success' => 'ទីតាំងត្រូវបានលុបដោយជោគជ័យ។',
    ],

    'bulkedit' => [
        'error' => 'គ្មាន fields ត្រូវបានផ្លាស់ប្តូរ ដូច្នេះគ្មានអ្វីត្រូវបានធ្វើបច្ចុប្បន្នភាពទេ។',
        'success' => 'Location successfully updated.|:count locations successfully updated.',
        'warn' => 'Edit the fields below to update this location. Fields you leave blank will not change on the location.|Edit the fields below to update all :count selected locations. Fields you leave blank will not change on any of them.',
        'show_selected' => '1 selected location|:count selected locations',
        'company_scope_mismatch_partial' => 'The company was not changed on 1 location because items or users at that location belong to different companies. Update or move those first.|The company was not changed on :count locations because items or users at those locations belong to different companies. Update or move those first.',
        'company_scope_mismatch_all' => 'No locations were reassigned. The requested company does not match items or users at the selected location.|No locations were reassigned. The requested company does not match items or users at any of the :count selected locations.',
        'parent_company_mismatch_partial' => 'The parent or company was not changed on 1 location because it would leave the location in a different company than its parent.|The parent or company was not changed on :count locations because it would leave those locations in a different company than their parent.',
        'parent_company_mismatch_all' => 'No changes were saved. The requested parent or company would leave the location in a different company than its parent.|No changes were saved. The requested parent or company would leave every one of the :count selected locations in a different company than their parent.',
    ],

];

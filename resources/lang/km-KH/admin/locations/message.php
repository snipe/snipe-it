<?php

return array(

    'does_not_exist' => 'ទីតាំងមិនមានទេ។',
    'assoc_users'    => 'This location is not currently deletable because it is the location of record for at least one asset or user, has assets assigned to it, or is the parent location of another location. Please update your models to no longer reference this location and try again. ',
    'assoc_assets'	 => 'បច្ចុប្បន្នទីតាំងនេះត្រូវបានភ្ជាប់ជាមួយទ្រព្យសកម្មយ៉ាងហោចណាស់មួយ ហើយមិនអាចលុបបានទេ។ សូមអាប់ដេតទ្រព្យសកម្មរបស់អ្នក ដើម្បីកុំឱ្យយោងទីតាំងនេះតទៅទៀត ហើយព្យាយាមម្តងទៀត។ ',
    'assoc_child_loc'	 => 'This location is currently the parent of at least one child location and cannot be deleted. Please update your locations to no longer reference this location and try again. ',
    'assigned_assets' => 'ទ្រព្យសកម្មដែលបានចាត់តាំង',
    'current_location' => 'ទីតាំង​បច្ចុប្បន្',
    'open_map' => 'Open in :map_provider_icon Maps',


    'create' => array(
        'error'   => 'ទីតាំងមិនត្រូវបានបង្កើតទេ សូមព្យាយាមម្តងទៀត។',
        'success' => 'ទីតាំងត្រូវបានបង្កើតដោយជោគជ័យ។'
    ),

    'update' => array(
        'error'   => 'ទីតាំងមិនត្រូវបានធ្វើបច្ចុប្បន្នភាពទេ សូមព្យាយាមម្តងទៀត',
        'success' => 'បានធ្វើបច្ចុប្បន្នភាពទីតាំងដោយជោគជ័យ។'
    ),

    'restore' => array(
        'error'   => 'Location was not restored, please try again',
        'success' => 'Location restored successfully.'
    ),

    'delete' => array(
        'confirm'   	=> 'តើអ្នកប្រាកដថាចង់លុបទីតាំងនេះទេ?',
        'error'   => 'មានបញ្ហាក្នុងការលុបទីតាំង។ សូម​ព្យាយាម​ម្តង​ទៀត។',
        'success' => 'ទីតាំងត្រូវបានលុបដោយជោគជ័យ។'
    )

);

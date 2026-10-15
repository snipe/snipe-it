<?php

return [

    'deleted' => 'គំរូទ្រព្យសកម្មដែលបានលុប',
    'does_not_exist' => 'ម៉ូដែលមិនមានទេ។',
    'no_association' => 'ព្រមាន! គំរូទ្រព្យសកម្មសម្រាប់ធាតុនេះមិនត្រឹមត្រូវ ឬបាត់!',
    'no_association_fix' => 'វា​នឹង​បំបែក​រឿង​ក្នុង​វិធី​ចម្លែក និង​គួរ​ឲ្យ​រន្ធត់។ កែសម្រួលទ្រព្យសកម្មនេះឥឡូវនេះ ដើម្បីចាត់ឱ្យវាជាគំរូមួយ។',
    'assoc_users' => 'បច្ចុប្បន្ន ម៉ូដែលនេះត្រូវបានភ្ជាប់ជាមួយទ្រព្យសកម្មមួយ ឬច្រើន ហើយមិនអាចលុបបានទេ។ សូមលុបទ្រព្យសម្បត្តិ ហើយបន្ទាប់មកព្យាយាមលុបម្តងទៀត។ ',
    'invalid_category_type' => 'ប្រភេទនេះត្រូវតែជាប្រភេទទ្រព្យសកម្ម។',

    'create' => [
        'error' => 'គំរូមិនត្រូវបានបង្កើតទេ សូមព្យាយាមម្តងទៀត។',
        'success' => 'គំរូត្រូវបានបង្កើតដោយជោគជ័យ។',
        'duplicate_set' => 'គំរូទ្រព្យសកម្មដែលមានឈ្មោះ ក្រុមហ៊ុនផលិត និងលេខម៉ូដែលនោះមានរួចហើយ។',
    ],

    'update' => [
        'error' => 'ម៉ូដែលមិនត្រូវបានអាប់ដេតទេ សូមព្យាយាមម្តងទៀត',
        'success' => 'ម៉ូដែលបានធ្វើបច្ចុប្បន្នភាពដោយជោគជ័យ។',
    ],

    'delete' => [
        'confirm' => 'តើអ្នកប្រាកដថាចង់លុបគំរូទ្រព្យសកម្មនេះទេ?',
        'error' => 'មាន​បញ្ហា​ក្នុង​ការ​លុប​ម៉ូដែល។ សូម​ព្យាយាម​ម្តង​ទៀត។',
        'success' => 'គំរូត្រូវបានលុបដោយជោគជ័យ។',
    ],

    'restore' => [
        'error' => 'ម៉ូដែលមិនត្រូវបានស្ដារឡើងវិញទេ សូមព្យាយាមម្តងទៀត',
        'success' => 'ម៉ូដែលត្រូវបានស្ដារឡើងវិញដោយជោគជ័យ។',
    ],

    'bulkedit' => [
        'error' => 'គ្មាន fields ត្រូវបានផ្លាស់ប្តូរ ដូច្នេះគ្មានអ្វីត្រូវបានធ្វើបច្ចុប្បន្នភាពទេ។',
        'success' => 'បានធ្វើបច្ចុប្បន្នភាពគំរូដោយជោគជ័យ។ |:model_count model បានធ្វើបច្ចុប្បន្នភាពដោយជោគជ័យ។',
        'warn' => 'អ្នកហៀបនឹងធ្វើបច្ចុប្បន្នភាពលក្ខណសម្បត្តិនៃគំរូខាងក្រោម៖|អ្នករៀបនឹងកែសម្រួលលក្ខណសម្បត្តិដូចខាងក្រោម៖ model_count models៖',

    ],

    'bulkdelete' => [
        'error' => 'គ្មាន​ម៉ូដែល​ត្រូវ​បាន​ជ្រើសរើស ដូច្នេះ​មិន​មាន​អ្វី​ត្រូវ​បាន​លុប។',
        'nothing_deletable' => 'None of the selected models can be deleted because they still have assets associated with them.',
        'success' => 'បានលុបម៉ូដែល!|:success_count model ត្រូវបានលុប!',
        'success_partial' => ':success_count model(s) ត្រូវបានលុប ទោះយ៉ាងណាក៏ដោយ :fail_count មិនអាចលុបបានទេ ដោយសារពួកគេនៅតែមានទ្រព្យសកម្មដែលពាក់ព័ន្ធជាមួយពួកគេ។',
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

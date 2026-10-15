<?php

return [

    'does_not_exist' => 'இருப்பிடம் இல்லை.',
    'assoc_users' => 'This location is not currently deletable because it is the location of record for at least one item or user, has assets assigned to it, or is the parent location of another location. Please update your records to no longer reference this location and try again ',
    'assoc_assets' => 'இந்த இடம் தற்போது குறைந்தது ஒரு சொத்துடன் தொடர்புடையது மற்றும் நீக்கப்பட முடியாது. இந்த இருப்பிடத்தை இனி குறிப்பிடாமல் உங்கள் சொத்துக்களை புதுப்பித்து மீண்டும் முயற்சிக்கவும்.',
    'assoc_child_loc' => 'இந்த இடம் தற்போது குறைந்தது ஒரு குழந்தையின் இருப்பிடத்தின் பெற்றோர் மற்றும் அதை நீக்க முடியாது. இந்த இருப்பிடத்தை இனி குறிப்பிடாமல் இருக்க உங்கள் இருப்பிடங்களை புதுப்பித்து மீண்டும் முயற்சிக்கவும்.',
    'assigned_assets' => 'Assigned Assets',
    'current_location' => 'Current Location',
    'deleted_warning' => 'This location has been deleted. Please restore it before attempting to make any changes.',

    'create' => [
        'error' => 'இருப்பிடம் உருவாக்கப்படவில்லை, மீண்டும் முயற்சிக்கவும்.',
        'success' => 'இடம் வெற்றிகரமாக உருவாக்கப்பட்டது.',
    ],

    'update' => [
        'error' => 'இருப்பிடம் புதுப்பிக்கப்படவில்லை, மீண்டும் முயற்சிக்கவும்',
        'success' => 'இருப்பிடம் வெற்றிகரமாக புதுப்பிக்கப்பட்டது.',
    ],

    'restore' => [
        'error' => 'Location was not restored, please try again',
        'success' => 'Location restored successfully.',
    ],

    'delete' => [
        'confirm' => 'இந்த இருப்பிடத்தை நிச்சயமாக நீக்க விரும்புகிறீர்களா?',
        'error' => 'இருப்பிடத்தை நீக்குவதில் ஒரு சிக்கல் இருந்தது. தயவு செய்து மீண்டும் முயற்சிக்கவும்.',
        'success' => 'இடம் வெற்றிகரமாக நீக்கப்பட்டது.',
    ],

    'bulkedit' => [
        'error' => 'எந்த துறைகளும் மாற்றப்படவில்லை, அதனால் எதுவும் புதுப்பிக்கப்படவில்லை.',
        'success' => 'Location successfully updated.|:count locations successfully updated.',
        'warn' => 'Edit the fields below to update this location. Fields you leave blank will not change on the location.|Edit the fields below to update all :count selected locations. Fields you leave blank will not change on any of them.',
        'show_selected' => '1 selected location|:count selected locations',
        'company_scope_mismatch_partial' => 'The company was not changed on 1 location because items or users at that location belong to different companies. Update or move those first.|The company was not changed on :count locations because items or users at those locations belong to different companies. Update or move those first.',
        'company_scope_mismatch_all' => 'No locations were reassigned. The requested company does not match items or users at the selected location.|No locations were reassigned. The requested company does not match items or users at any of the :count selected locations.',
        'parent_company_mismatch_partial' => 'The parent or company was not changed on 1 location because it would leave the location in a different company than its parent.|The parent or company was not changed on :count locations because it would leave those locations in a different company than their parent.',
        'parent_company_mismatch_all' => 'No changes were saved. The requested parent or company would leave the location in a different company than its parent.|No changes were saved. The requested parent or company would leave every one of the :count selected locations in a different company than their parent.',
    ],

];

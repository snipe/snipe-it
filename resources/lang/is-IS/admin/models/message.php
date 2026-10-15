<?php

return [

    'deleted' => 'Eyða tegund eigna',
    'does_not_exist' => 'Tegund ekki til.',
    'no_association' => 'VIÐVÖRUN! Eignategund fyrir þennan hlut er ógilt eða vantar!',
    'no_association_fix' => 'Þetta mun brjóta hlutina á undarlegan og hræðilegan hátt. Breyttu þessari eign núna til að úthluta henni fyrirmynd.',
    'assoc_users' => 'Þessi tegund er sem stendur tengt einni eða fleiri eignum og ekki er hægt að eyða því. Vinsamlegast eyddu eignunum og reyndu síðan að eyða aftur. ',
    'invalid_category_type' => 'This category must be an asset category.',

    'create' => [
        'error' => 'Tegundin var ekki búið til, vinsamlegast reyndu aftur.',
        'success' => 'Tegund búin til.',
        'duplicate_set' => 'Eignategund með þessu nafni, framleiðanda og tegundarnúmeri er þegar til.',
    ],

    'update' => [
        'error' => 'Tegund var ekki uppfærð, vinsamlegast reyndu aftur',
        'success' => 'Tegund uppfærð.',
    ],

    'delete' => [
        'confirm' => 'Ertu viss um að þú viljir eyða þessu eignategund?',
        'error' => 'Vandamál kom upp við að eyða tegundinni. Vinsamlegast reyndu aftur.',
        'success' => 'Tegund var eytt.',
    ],

    'restore' => [
        'error' => 'Tegund var ekki endurheimt, vinsamlegast reyndu aftur',
        'success' => 'Tegund endurheimt.',
    ],

    'bulkedit' => [
        'error' => 'Engum reitum var breytt, svo ekkert var uppfært.',
        'success' => 'Tegund uppfært. |:model_count Tegundir uppfærð.',
        'warn' => 'Þú ert að fara að uppfæra eiginleika eftirfarandi model:|Þú ert að fara að breyta eiginleikum eftirfarandi :model_count tegunda:',

    ],

    'bulkdelete' => [
        'error' => 'Engar tegundir voru valdar og því var engu eytt.',
        'nothing_deletable' => 'None of the selected models can be deleted because they still have assets associated with them.',
        'success' => 'Tegund eytt!|:success_count tegundum eytt!',
        'success_partial' => ':success_count tegund(um) var eytt, hins vegar var ekki hægt að eyða :fail_count vegna þess að þau hafa enn eignir tengdar þeim.',
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

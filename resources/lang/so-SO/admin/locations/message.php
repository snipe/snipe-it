<?php

return [

    'does_not_exist' => 'Goobtu ma jirto.',
    'assoc_users' => 'This location is not currently deletable because it is the location of record for at least one item or user, has assets assigned to it, or is the parent location of another location. Please update your records to no longer reference this location and try again ',
    'assoc_assets' => 'Goobtan waxaa hadda ku xiran hal isticmaale suurogalna maahan in latiro. Fadlan cusboonaysii hantidaada si aanay meeshan u tixraacin mar kalena isku day. ',
    'assoc_child_loc' => 'Goobtan waxay xarun rasmi ah u tahay farac kale ugu yaraan suuragalna maahan in la tir-tiro. Fadlan cusbooneysii goobtaada si aaney markale usoo tilmaamin mowqican iskuna day markale. ',
    'assigned_assets' => 'Hantida la qoondeeyay',
    'current_location' => 'Goobta xilligan',
    'deleted_warning' => 'This location has been deleted. Please restore it before attempting to make any changes.',

    'create' => [
        'error' => 'Goobta lama abuurin, fadlan isku day mar kale.',
        'success' => 'Goobta waa lagu guuleystay in la sameeyo.',
    ],

    'update' => [
        'error' => 'Goobta lama cusboonaysiin, fadlan isku day mar kale',
        'success' => 'Goobta waa lagu guuleystay in la cusbooneysiiyo.',
    ],

    'restore' => [
        'error' => 'Location was not restored, please try again',
        'success' => 'Location restored successfully.',
    ],

    'delete' => [
        'confirm' => 'Ma hubtaa inaad rabto inaad tirtirto goobtan?',
        'error' => 'Waxaa jirtay arrin meesha ka saareysa goobtan. Fadlan isku day mar kale.',
        'success' => 'Goobta si guul leh ayaa loo tirtiray.',
    ],

    'bulkedit' => [
        'error' => 'Wax feilds ah lama beddelin, markaa waxba lama cusboonaysiin.',
        'success' => 'Location successfully updated.|:count locations successfully updated.',
        'warn' => 'Edit the fields below to update this location. Fields you leave blank will not change on the location.|Edit the fields below to update all :count selected locations. Fields you leave blank will not change on any of them.',
        'show_selected' => '1 selected location|:count selected locations',
        'company_scope_mismatch_partial' => 'The company was not changed on 1 location because items or users at that location belong to different companies. Update or move those first.|The company was not changed on :count locations because items or users at those locations belong to different companies. Update or move those first.',
        'company_scope_mismatch_all' => 'No locations were reassigned. The requested company does not match items or users at the selected location.|No locations were reassigned. The requested company does not match items or users at any of the :count selected locations.',
        'parent_company_mismatch_partial' => 'The parent or company was not changed on 1 location because it would leave the location in a different company than its parent.|The parent or company was not changed on :count locations because it would leave those locations in a different company than their parent.',
        'parent_company_mismatch_all' => 'No changes were saved. The requested parent or company would leave the location in a different company than its parent.|No changes were saved. The requested parent or company would leave every one of the :count selected locations in a different company than their parent.',
    ],

];

<?php

return [

    'does_not_exist' => 'Locatie bestaat niet.',
    'assoc_users' => 'This location is not currently deletable because it is the location of record for at least one item or user, has assets assigned to it, or is the parent location of another location. Please update your records to no longer reference this location and try again ',
    'assoc_assets' => 'Deze locatie is momenteel gekoppeld met tenminste één asset en kan hierdoor niet worden verwijderd. Update je assets die niet meer bij deze locatie en probeer het opnieuw. ',
    'assoc_child_loc' => 'Deze locatie is momenteen de ouder van ten minste één kind locatie en kan hierdoor niet worden verwijderd. Update je locaties bij die niet meer naar deze locatie verwijzen en probeer het opnieuw. ',
    'assigned_assets' => 'Toegewezen activa',
    'current_location' => 'Huidige locatie',
    'deleted_warning' => 'This location has been deleted. Please restore it before attempting to make any changes.',

    'create' => [
        'error' => 'Locatie is niet aangemaakt, probeer het opnieuw.',
        'success' => 'Locatie is met succes aangemaakt.',
    ],

    'update' => [
        'error' => 'Locatie is niet gewijzigd, probeer het opnieuw',
        'success' => 'Locatie is met succes gewijzigd.',
    ],

    'restore' => [
        'error' => 'Locatie is niet hersteld, probeer het opnieuw',
        'success' => 'Locatie hersteld.',
    ],

    'delete' => [
        'confirm' => 'Weet je het zeker dat je deze locatie wilt verwijderen?',
        'error' => 'Er was een probleem met het verwijderen van deze locatie. Probeer het opnieuw.',
        'success' => 'De locatie is met succes verwijderd.',
    ],

    'bulkedit' => [
        'error' => 'Er was geen veld geselecteerd dus is er niks gewijzigd.',
        'success' => 'Location successfully updated.|:count locations successfully updated.',
        'warn' => 'Edit the fields below to update this location. Fields you leave blank will not change on the location.|Edit the fields below to update all :count selected locations. Fields you leave blank will not change on any of them.',
        'show_selected' => '1 selected location|:count selected locations',
        'company_scope_mismatch_partial' => 'The company was not changed on 1 location because items or users at that location belong to different companies. Update or move those first.|The company was not changed on :count locations because items or users at those locations belong to different companies. Update or move those first.',
        'company_scope_mismatch_all' => 'No locations were reassigned. The requested company does not match items or users at the selected location.|No locations were reassigned. The requested company does not match items or users at any of the :count selected locations.',
        'parent_company_mismatch_partial' => 'The parent or company was not changed on 1 location because it would leave the location in a different company than its parent.|The parent or company was not changed on :count locations because it would leave those locations in a different company than their parent.',
        'parent_company_mismatch_all' => 'No changes were saved. The requested parent or company would leave the location in a different company than its parent.|No changes were saved. The requested parent or company would leave every one of the :count selected locations in a different company than their parent.',
    ],

];

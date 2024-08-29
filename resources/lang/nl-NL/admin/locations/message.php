<?php

return array(

    'does_not_exist' => 'Locatie bestaat niet.',
    'assoc_users'    => 'This location is not currently deletable because it is the location of record for at least one asset or user, has assets assigned to it, or is the parent location of another location. Please update your models to no longer reference this location and try again. ',
    'assoc_assets'	 => 'Deze locatie is momenteel gekoppeld met tenminste één asset en kan hierdoor niet worden verwijderd. Update je assets die niet meer bij deze locatie en probeer het opnieuw. ',
    'assoc_child_loc'	 => 'Deze locatie is momenteen de ouder van ten minste één kind locatie en kan hierdoor niet worden verwijderd. Update je locaties bij die niet meer naar deze locatie verwijzen en probeer het opnieuw. ',
    'assigned_assets' => 'Toegewezen activa',
    'current_location' => 'Huidige locatie',
    'open_map' => 'Open in :map_provider_icon Maps',


    'create' => array(
        'error'   => 'Locatie is niet aangemaakt, probeer het opnieuw.',
        'success' => 'Locatie is met succes aangemaakt.'
    ),

    'update' => array(
        'error'   => 'Locatie is niet gewijzigd, probeer het opnieuw',
        'success' => 'Locatie is met succes gewijzigd.'
    ),

    'restore' => array(
        'error'   => 'Location was not restored, please try again',
        'success' => 'Location restored successfully.'
    ),

    'delete' => array(
        'confirm'   	=> 'Weet je het zeker dat je deze locatie wilt verwijderen?',
        'error'   => 'Er was een probleem met het verwijderen van deze locatie. Probeer het opnieuw.',
        'success' => 'De locatie is met succes verwijderd.'
    )

);

<?php

return array(

    'does_not_exist' => 'Status label bestaat niet.',
    'assoc_assets'	 => 'Dit status label is tenminste met één object gekoppeld en kan niet verwijderd worden. Zorg ervoor dat objecten geen gebruik maken van dit statuslabel en probeer het nogmaals.',


    'create' => array(
        'error'   => 'Status label is niet aangemaakt, probeer het nogmaals.',
        'success' => 'Status label succesvol aangemaakt.'
    ),

    'update' => array(
        'error'   => 'Status label is niet bijgewerkt, probeer het nogmaals',
        'success' => 'Status label succesvol bijgewerkt.'
    ),

    'delete' => array(
        'confirm'   => 'Weet je zeker dat je dit status label wil verwijderen?',
        'error'   => 'Er is iets mis gegaan tijdens het verwijderen van het status label, probeer het nogmaals.',
        'success' => 'Het status label is succesvol verwijderd.'
    ),

    'help' => array(
        'undeployable'   => 'Deze activa kunnen niet aan iemand worden toegewezen.',
        'deployable'   => 'Deze activa kunnen worden gecontroleerd. Zodra ze zijn toegewezen, nemen ze een meta-status van <i class="fa fa-circle text-blue"></i> <strong>Deployed</strong>.',
        'archived'   => 'Deze activa kunnen niet gecontroleerd worden en worden alleen weergegeven in de Archived view. Dit is handig om informatie over activa te behouden voor budgettering / historische doeleinden, maar deze uit de dagelijkse activa lijst te houden.',
        'pending'   => 'Deze activa kunnen nog niet worden toegewezen aan iemand die vaak gebruikt wordt voor items die niet voor reparatie kunnen worden uitgevoerd, maar naar verwachting terugzetten.',
    ),

);

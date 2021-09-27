<?php

return [

    'does_not_exist' => 'Status label bestaat niet.',
    'assoc_assets'	 => 'Dit status label is tenminste met één asset gekoppeld en kan niet verwijderd worden. Zorg ervoor dat assets geen gebruik maken van dit statuslabel en probeer het nogmaals. ',

    'create' => [
        'error'   => 'Status label is niet aangemaakt, probeer het nogmaals.',
        'success' => 'Status label succesvol aangemaakt.',
    ],

    'update' => [
        'error'   => 'Status label is niet bijgewerkt, probeer het nogmaals',
        'success' => 'Status label succesvol bijgewerkt.',
    ],

    'delete' => [
        'confirm'   => 'Weet je zeker dat je dit status label wil verwijderen?',
        'error'   => 'Er is iets mis gegaan tijdens het verwijderen van het status label, probeer het nogmaals.',
        'success' => 'Het status label is succesvol verwijderd.',
    ],

    'help' => [
        'undeployable'   => 'Deze assets kunnen niet aan iemand worden toegewezen.',
        'deployable'   => 'Deze assets kunnen worden uitgecheckt. Zodra ze zijn toegewezen, nemen ze een meta-status van <i class="fas fa-circle text-blue"></i> <strong>Ingezet</strong>.',
        'archived'   => 'Deze assets kunnen niet uitgecheckt worden en worden alleen weergegeven in de gearchiveerde weergave. Dit is nuttig om informatie te bewaren over assets voor budgetteren/historische doeleinden, maar om deze buiten de dagelijkse asset-lijst te houden.',
        'pending'   => 'Deze assets kunnen nog niet aan iemand worden toegewezen, vaak gebruikt voor items die in reparatie zijn, maar naar verwachting zullen ze weer in omloop komen.',
    ],

];

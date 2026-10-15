<?php

return [

    'deleted' => 'Verwijderd asset model',
    'does_not_exist' => 'Model bestaat niet.',
    'no_association' => 'WAARSCHUWING! Het asset model voor dit item is ongeldig of ontbreekt!',
    'no_association_fix' => 'Dit maakt dingen kapot op rare en gruwelijke manieren. Bewerk dit product nu om het een model toe te wijzen.',
    'assoc_users' => 'Dit model is momenteel gekoppeld met één of meer assets en kan niet worden verwijderd. Verwijder de assets en probeer het opnieuw. ',
    'invalid_category_type' => 'Deze categorie moet een asset categorie zijn.',

    'create' => [
        'error' => 'Model is niet aangemaakt, probeer het opnieuw.',
        'success' => 'Model is met succes aangemaakt.',
        'duplicate_set' => 'Een asset model met die naam, fabrikant en model nummer bestaat al.',
    ],

    'update' => [
        'error' => 'Model is niet gewijzigd, probeer het opnieuw',
        'success' => 'Model met succes gewijzigd.',
    ],

    'delete' => [
        'confirm' => 'Weet je het zeker dat je deze asset model wilt verwijderen?',
        'error' => 'Er was een probleem tijden het verwijderen van dit model. Probeer het opnieuw.',
        'success' => 'Het model is met succes verwijderd.',
    ],

    'restore' => [
        'error' => 'Model is niet hersteld. Probeer opnieuw',
        'success' => 'Model is met succes hersteld.',
    ],

    'bulkedit' => [
        'error' => 'Er was geen veld geselecteerd dus is er niks gewijzigd.',
        'success' => 'Model met succes geüpdatet |:model_count modellen succesvol bijgewerkt.',
        'warn' => 'U staat op het punt om de eigenschappen van het volgende model bij te werken: u staat op het punt de eigenschappen van de volgende :model_count modellen te bewerken:',

    ],

    'bulkdelete' => [
        'error' => 'Er waren geen modellen geselecteerd, er is dus niets verwijderd.',
        'nothing_deletable' => 'None of the selected models can be deleted because they still have assets associated with them.',
        'success' => 'Model verwijderd!|:success_count modellen zijn verwijderd!',
        'success_partial' => ':success_count model(len) werden verwijderd, maar : fail_count konden niet worden verwijderd omdat er nog steeds assets aan gekoppeld zijn.',
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

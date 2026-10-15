<?php

return [

    'deleted' => 'Slettet ressursmodell',
    'does_not_exist' => 'Modell eksisterer ikke.',
    'no_association' => 'ADVARSEL! Ressursmodellen for dette elementet er ugyldig eller mangler!',
    'no_association_fix' => 'Dette vil ødelegge ting på merkelige og forferdelige måte. Rediger denne ressursen nå for å tildele den en modell.',
    'assoc_users' => 'Denne modellen er tilknyttet en eller flere eiendeler og kan ikke slettes. Slett eiendelene, og prøv å slette modellen igjen. ',
    'invalid_category_type' => 'This category must be an asset category.',

    'create' => [
        'error' => 'Modellen ble ikke opprettet. Prøv igjen.',
        'success' => 'Opprettelse av modell var vellykket.',
        'duplicate_set' => 'En eiendel med dette navnet, produsenten og modelnummeret eksisterer allerede.',
    ],

    'update' => [
        'error' => 'Modell ble ikke oppdatert. Prøv igjen',
        'success' => 'Oppdatering av modell vellykket.',
    ],

    'delete' => [
        'confirm' => 'Er du sikker på at du vil slette denne modellen?',
        'error' => 'Det oppstod et problem under sletting av modellen. Prøv igjen.',
        'success' => 'Sletting av modell vellykket.',
    ],

    'restore' => [
        'error' => 'Modell ble ikke gjenopprettet. Prøv igjen',
        'success' => 'Vellykket gjenoppretting av modell.',
    ],

    'bulkedit' => [
        'error' => 'Ingen felt ble endret, så ingenting ble oppdatert.',
        'success' => 'Modelloppdatering vellyket.| :model_count modeller oppdatert.',
        'warn' => 'Du er i ferd med å oppdatere egenskapene til følgende modell: Du er i ferd med å redigere egenskapene for følgende modeller: model_count modeller:',

    ],

    'bulkdelete' => [
        'error' => 'Ingen modeller ble valgt, så ingenting ble slettet.',
        'nothing_deletable' => 'None of the selected models can be deleted because they still have assets associated with them.',
        'success' => 'Modellen ble slettet!g_:success_count modeller slettet!',
        'success_partial' => ':Success_count-modell(ene) ble slettet, men fail_count kunne ikke slettes fordi de fortsatt har eiendeler knyttet til dem.',
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

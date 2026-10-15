<?php

return [

    'deleted' => 'Model de activ șters',
    'does_not_exist' => 'Modelul nu exista.',
    'no_association' => 'AVERTISMENT! Modelul de activ pentru acest articol este invalid sau lipsește!',
    'no_association_fix' => 'Acest lucru va strica lucrurile în moduri ciudate și oribile. Editează acest bun acum pentru a-l atribui un model.',
    'assoc_users' => 'Acest model este momentan asociat cu cel putin unul sau mai multe active si nu poate fi sters. Va rugam sa stergeti activul si dupa incercati iar. ',
    'invalid_category_type' => 'This category must be an asset category.',

    'create' => [
        'error' => 'Modelul nu a fost creat, incercati iar.',
        'success' => 'Modelul a fost creat.',
        'duplicate_set' => 'Un model de activ cu numele, producătorul și numărul modelului există deja.',
    ],

    'update' => [
        'error' => 'Modelul nu a fost actualizat, va rugam incercati iar',
        'success' => 'Modelul a fost actualizat.',
    ],

    'delete' => [
        'confirm' => 'Sunteti sigur ca doriti sa stergeti acest model de activ?',
        'error' => 'A aparut o problema la stergerea modelului. Incercati iar.',
        'success' => 'Modelul a fost sters.',
    ],

    'restore' => [
        'error' => 'Modelul nu a fost restabilit, încercați din nou',
        'success' => 'Modelul a fost restaurat cu succes.',
    ],

    'bulkedit' => [
        'error' => 'Nu au fost modificate câmpuri, deci nimic nu a fost actualizat.',
        'success' => 'Modelul a fost actualizat cu succes. <unk> :model_count modele actualizate cu succes.',
        'warn' => 'Sunteți pe cale să actualizați proprietățile următorului model: Sunteți pe cale să editați proprietățile următoarelor modele :model_count:',

    ],

    'bulkdelete' => [
        'error' => 'Nu au fost selectate câmpuri, deci nimic nu a fost actualizat.',
        'nothing_deletable' => 'None of the selected models can be deleted because they still have assets associated with them.',
        'success' => 'Modelul a fost șters!<unk> :success_count modele șterse!',
        'success_partial' => 'Au fost șterse :success_count modele, cu toate acestea :fail_count nu au putut fi șterse deoarece au în continuare active asociate cu acestea.',
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

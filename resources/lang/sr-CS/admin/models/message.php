<?php

return [

    'deleted' => 'Obrisani model imovine',
    'does_not_exist' => 'Model ne postoji.',
    'no_association' => 'UPOZORENJE! Model za ovu stavku je ili pogrešan ili nedostaje!',
    'no_association_fix' => 'Ovo će polomiti stvari na čudne i užasne načine. Uredite odmah ovu imovinu da bi ste je povezali sa modelom.',
    'assoc_users' => 'Ovaj je model trenutno povezan s jednom ili više imovina i ne može se izbrisati. Izbrišite imovinu pa pokušajte ponovo. ',
    'invalid_category_type' => 'Ova kategorija mora biti kategorija imovine.',

    'create' => [
        'error' => 'Model nije kreiran, pokušajte ponovo.',
        'success' => 'Model je uspešno kreiran.',
        'duplicate_set' => 'Model imovine s tim nazivom, proizvođačem i brojem modela već postoji.',
    ],

    'update' => [
        'error' => 'Model nije ažuriran, pokušajte ponovo',
        'success' => 'Model je uspešno ažuriran.',
    ],

    'delete' => [
        'confirm' => 'Jeste li sigurni da želite izbrisati ovaj model imovine?',
        'error' => 'Došlo je do problema s brisanjem modela. Molim pokušajte ponovo.',
        'success' => 'Model je uspešno izbrisan.',
    ],

    'restore' => [
        'error' => 'Model nije obnovljen, pokušajte ponovo',
        'success' => 'Model je uspešno obnovljen.',
    ],

    'bulkedit' => [
        'error' => 'Polja nisu menjana, tako da ništa nije ažurirano.',
        'success' => 'Model je uspešno izmenjen. |:model_count modela je uspešno izmenjeno.',
        'warn' => 'Spremate se da izmenite svojstva sledećeg modela:|Spremate se da izmenite svojstva sledećih :model_count modela:',

    ],

    'bulkdelete' => [
        'error' => 'Nijedan model nije odabran, tako da ništa nije izbrisano.',
        'nothing_deletable' => 'Nijedan od izabranih modela može biti izbrisan jer još uvek imaju imovinu koja je povezana sa njima.',
        'success' => 'Model je obrisan!|:success_count modela je obrisano!',
        'success_partial' => ':success_count model(s) were deleted, however :fail_count were unable to be deleted because they still have assets associated with them.',
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

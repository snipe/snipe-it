<?php

return [

    'deleted' => 'Panaikintas turto modelis',
    'does_not_exist' => 'Tokio modelio nėra.',
    'no_association' => 'ĮSPĖJIMAS! Tokio turto modelio nėra arba jis neteisingas!',
    'no_association_fix' => 'Tai sugadins dalykus keistais ir siaubingais būdais. Nedelsdami redaguokite šį turtą ir priskirkite jam modelį.',
    'assoc_users' => 'Šis modelis šiuo metu susietas su bent vienu turto vienetu, todėl negali būti panaikintas. Panaikinkite šį turtą, tuomet vėl bandykite panaikinti modelį. ',
    'invalid_category_type' => 'Kategorija turi būti turto kategorija.',

    'create' => [
        'error' => 'Modelis nebuvo panaikintas, bandykite dar kartą.',
        'success' => 'Modelis sėkmingai sukurtas.',
        'duplicate_set' => 'Turto modelis su tokiu pavadinimu, gamintoju ir modelio numeriu jau yra.',
    ],

    'update' => [
        'error' => 'Modelis nebuvo atnaujintas, bandykite dar kartą',
        'success' => 'Modelis sėkmingai atnaujintas.',
    ],

    'delete' => [
        'confirm' => 'Ar tikrai norite panaikinti šį turto modelį?',
        'error' => 'Bandant panaikinti modelį įvyko klaida. Bandykite dar kartą.',
        'success' => 'Modelis sėkmingai panaikintas.',
    ],

    'restore' => [
        'error' => 'Modelis nebuvo atkurtas, bandykite dar kartą',
        'success' => 'Modelis sėkmingai atkurtas.',
    ],

    'bulkedit' => [
        'error' => 'Jokie laukai nebuvo pakeisti, todėl niekas nebuvo atnaujinta.',
        'success' => 'Modelis sėkmingai atnaujintas. |:model_count modeliai sėkmingai atnaujinti.',
        'warn' => 'Ketinate atnaujinti šio modelio ypatybes:|Ketinate redaguoti šių :model_count modelių ypatybes:',

    ],

    'bulkdelete' => [
        'error' => 'Nebuvo pasirinktas joks modelis, todėl niekas nebuvo panaikinta.',
        'nothing_deletable' => 'Nei vieno iš pasirinktų modelių negalima ištrinti, nes su jais vis dar yra susieto turto.',
        'success' => 'Modelis panaikintas! :success_count modeliai panaikinti!',
        'success_partial' => 'Panaikinti modeliai – :success_count, tačiau dar :fail_count nepavyko panaikinti, nes vis dar yra su jais susieto turto.',
    ],

    'merge' => [
        'min_two' => 'Pasirinkite bent du modelius, kuriuos norite sujungti.',
        'no_target' => 'Prieš sujungdami pasirinkite, kurį modelį palikti.',
        'not_found' => 'Nepavyko įkelti vieno ar kelių pasirinktų modelių. Atnaujinkite modelių sąrašą ir bandykite dar kartą.',
        'information' => 'Ketinate sujungti :count modelius. Pasirinkite modelį, kurį norite pasilikti. Visas kitiems modeliams priskirtas turtas bus priskirtas jūsų pasirinktam modeliui, o tada ankstesni modeliai bus ištrinti.',
        'warning' => 'Šio veiksmo atšaukti neįmanoma. Perleistam turtui bus priskirta išlikusio modelio kategorija, laukų rinkinys ir nusidėvėjimo nustatymai.',
        'pick_target' => 'Kokį modelį norėtumėte pasilikti?',
        'success' => 'Modeliai (:source_count) sujungti į ":target". Perkelta turto vienetų – :asset_count.',
    ],

];

<?php

return [

    'does_not_exist' => 'Sijaintia ei löydy.',
    'assoc_users' => 'This location is not currently deletable because it is the location of record for at least one item or user, has assets assigned to it, or is the parent location of another location. Please update your records to no longer reference this location and try again ',
    'assoc_assets' => 'Sijaintiin on tällä hetkellä liitettynä vähintään yksi laite, eikä sitä voi poistaa. Poista viittaus sijantiin ja yritä uudelleen. ',
    'assoc_child_loc' => 'Tämä sijainti on ylempi toiselle sijainnille eikä sitä voi poistaa. Päivitä sijainnit, jotta et enää viitata tähän sijaintiin ja yritä uudelleen. ',
    'assigned_assets' => 'Luovutetut laitteet',
    'current_location' => 'Nykyinen sijainti',
    'deleted_warning' => 'Tämä sijainti on poistettu. Palauta se, ennen kuin yrität tehdä muutoksia.',

    'create' => [
        'error' => 'Sijaintia ei luotu, yritä uudelleen.',
        'success' => 'Sijainti luotiin onnistuneesti.',
    ],

    'update' => [
        'error' => 'Sijaintia ei päivitetty, yritä uudelleen',
        'success' => 'Sijainti päivitettiin onnistuneesti.',
    ],

    'restore' => [
        'error' => 'Sijaintia ei palautettu, yritä uudelleen',
        'success' => 'Sijainti palautettu onnistuneesti.',
    ],

    'delete' => [
        'confirm' => 'Oletko varma että haluat poistaa tämän sijainnin?',
        'error' => 'Sijainnin poistossa tapahtui virhe. Yritä uudelleen.',
        'success' => 'Sijainti poistettiin onnistuneesti.',
    ],

    'bulkedit' => [
        'error' => 'Mitään kentistä ei ollut muutettu, joten mitään ei päivitetty.',
        'success' => 'Location successfully updated.|:count locations successfully updated.',
        'warn' => 'Edit the fields below to update this location. Fields you leave blank will not change on the location.|Edit the fields below to update all :count selected locations. Fields you leave blank will not change on any of them.',
        'show_selected' => '1 selected location|:count selected locations',
        'company_scope_mismatch_partial' => 'The company was not changed on 1 location because items or users at that location belong to different companies. Update or move those first.|The company was not changed on :count locations because items or users at those locations belong to different companies. Update or move those first.',
        'company_scope_mismatch_all' => 'No locations were reassigned. The requested company does not match items or users at the selected location.|No locations were reassigned. The requested company does not match items or users at any of the :count selected locations.',
        'parent_company_mismatch_partial' => 'The parent or company was not changed on 1 location because it would leave the location in a different company than its parent.|The parent or company was not changed on :count locations because it would leave those locations in a different company than their parent.',
        'parent_company_mismatch_all' => 'No changes were saved. The requested parent or company would leave the location in a different company than its parent.|No changes were saved. The requested parent or company would leave every one of the :count selected locations in a different company than their parent.',
    ],

];

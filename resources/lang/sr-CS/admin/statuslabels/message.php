<?php

return [

    'does_not_exist' => 'Oznaka statusa ne postoji.',
    'assoc_assets'	 => 'Oznaka statusa je trenutno povezana s barem jednim resursom i ne može se izbrisati. Ažurirajte resurs da se više ne referencira na tu oznaku statusa i pokušajte ponovno. ',

    'create' => [
        'error'   => 'Oznaka statusa nije kreirana, pokušajte ponovo.',
        'success' => 'Oznaka statusa je uspešno kreirana.',
    ],

    'update' => [
        'error'   => 'Oznaka statusa nije ažurirana, pokušajte ponovo',
        'success' => 'Oznaka statusa je uspešno ažurirana.',
    ],

    'delete' => [
        'confirm'   => 'Jeste li sigurni da želite da izbrišete ovu oznaku statusa?',
        'error'   => 'Došlo je do problema sa brisanjem oznake statusa. Molim pokušajte ponovo.',
        'success' => 'Oznaka statusa je uspešno izbrisana.',
    ],

    'help' => [
        'undeployable'   => 'Ova imovina ne može biti dodeljena nikome.',
        'deployable'   => 'These assets can be checked out. Once they are assigned, they will assume a meta status of <i class="fas fa-circle text-blue"></i> <strong>Deployed</strong>.',
        'archived'   => 'These assets cannot be checked out, and will only show up in the Archived view. This is useful for retaining information about assets for budgeting/historic purposes but keeping them out of the day-to-day asset list.',
        'pending'   => 'These assets can not yet be assigned to anyone, often used for items that are out for repair, but are expected to return to circulation.',
    ],

];

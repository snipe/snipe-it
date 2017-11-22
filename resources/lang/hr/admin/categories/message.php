<?php

return [

    'does_not_exist' => 'Kategorija ne postoji.',
    'assoc_models'     => 'Ova je kategorija trenutno povezana s barem jednim modelom i ne može se izbrisati. Ažurirajte svoje modele da više ne referiraju ovu kategoriju i pokušajte ponovno.',
    'assoc_items'     => 'Ova je kategorija trenutno povezana s najmanje jednim: asset_type i ne može se izbrisati. Ažurirajte svoj: asset_type da više ne referirate ovu kategoriju i pokušajte ponovo.',

    'create' => [
        'error'   => 'Kategorija nije izrađena, pokušajte ponovo.',
        'success' => 'Kategorija je uspješno izrađena.',
    ],

    'update' => [
        'error'   => 'Kategorija nije ažurirana, pokušajte ponovo',
        'success' => 'Kategorija je uspješno ažurirana.',
    ],

    'delete' => [
        'confirm'   => 'Jeste li sigurni da želite izbrisati ovu kategoriju?',
        'error'   => 'Došlo je do problema s brisanjem kategorije. Molim te pokušaj ponovno.',
        'success' => 'Kategorija je uspješno izbrisana.',
    ],

];

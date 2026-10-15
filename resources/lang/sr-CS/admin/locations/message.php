<?php

return [

    'does_not_exist' => 'Lokacija ne postoji.',
    'assoc_users' => 'Ova lokacija trenutno nije obrisiva jer je lokacija zapisa za barem jednu stavku ili korisnika, ima imovinu zaduženu njoj, ili je nadlokacija drugoj lokaciji. Molim vas ažurirajte vaše zapise da više ne budu povezani sa ovom lokacijom i pokušajte ponovo ',
    'assoc_assets' => 'Ta je lokacija trenutno povezana s barem jednim resursom i ne može se izbrisati. Ažurirajte resurs da se više ne referencira na tu lokaciju i pokušajte ponovno. ',
    'assoc_child_loc' => 'Ta je lokacija trenutno roditelj najmanje jednoj podredjenoj lokaciji i ne može se izbrisati. Ažurirajte svoje lokacije da se više ne referenciraju na ovu lokaciju i pokušajte ponovo. ',
    'assigned_assets' => 'Dodeljena imovina',
    'current_location' => 'Trenutna lokacija',
    'deleted_warning' => 'Lokacija je obrisana. Molim vas prvo je povratite pre pokušaja vršenja bilo kakvih izmena.',

    'create' => [
        'error' => 'Lokacija nije kreirana, pokušajte ponovo.',
        'success' => 'Lokacija je uspešno kreirana.',
    ],

    'update' => [
        'error' => 'Lokacija nije ažurirana, pokušajte ponovo',
        'success' => 'Lokacija je uspešno ažurirana.',
    ],

    'restore' => [
        'error' => 'Lokacija nije povraćena, molim vas pokušajte ponovo',
        'success' => 'Lokacija je uspešno povraćena.',
    ],

    'delete' => [
        'confirm' => 'Jeste li sigurni da želite izbrisati tu lokaciju?',
        'error' => 'Došlo je do problema s brisanjem lokacije. Molim pokušajte ponovo.',
        'success' => 'Lokacija je uspešno obrisana.',
    ],

    'bulkedit' => [
        'error' => 'Polja nisu menjana, tako da ništa nije ažurirano.',
        'success' => 'Lokacija je uspešno izmenjena.|:count lokacije su uspešno izmenjene.',
        'warn' => 'Izmenite polja ispod da bi ste izmenili lokaciju. Polja koja ostavite praznim neće se izmeniti za lokaciju.|Izmenite polja ispod da bi ste izmenili svih :count izabranih lokacija. Polja koja ostavite praznim neće se izmeniti ni za jednu od njih.',
        'show_selected' => '1 izabrana lokacija|:count izabrane lokacije',
        'company_scope_mismatch_partial' => 'Komapnija nije promenjena na 1 lokaciji zato što stavke ili korisnici na toj lokaciji pripadaju različitim kompanijama. Prvo ih izmenite ili premestite.|Kompanija nije izmenjena na :count lokacije zato što stavke ili korisnici na tim lokacijama pripadaju različitim kompanijama. Prvo ih izmenite ili premestite.',
        'company_scope_mismatch_all' => 'Nijednoj lokaciji nije promenjena dodela. Navedena kompanija se ne poklapa sa stavkama ili korisnicima na izabranoj lokaciji.|Nijednoj lokaciji nije promenjena dodela. Navedena kompanija se ne poklapa sa stavkama ili korisnicima ni na jednoj od :count izabranih lokacija.',
        'parent_company_mismatch_partial' => 'Roditelj ili kompanija nije promenjena na 1 lokaciji zato što bi ostavila lokaciju u različitoj kompaniji od svog roditelja.|Roditelj ili kompanija nije promenjena na :count lokacije zato što bi ostavila lokaciju u različitoj kompaniji od svojih roditelja.',
        'parent_company_mismatch_all' => 'Nijedna promena nije sačuvana. Navedeni roditelj ili kompanija bi ostavili lokaciju u različitoj kompaniji od svog roditelja.|Nijedna promena nije sačuvana. Navedeni roditelj ili kompanija bi ostavili svaku od :count izabranih lokacija u različitoj kompaniji od svog roditelja.',
    ],

];

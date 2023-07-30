<?php

return [

    'undeployable' 		=> '<strong>Upozorenje: </strong> Ova je snimka označena kao trenutno nedjeljiva. Ako se ovaj status promijenio, ažurirajte status aktive.',
    'does_not_exist' 	=> 'Imovina ne postoji.',
    'does_not_exist_or_not_requestable' => 'That asset does not exist or is not requestable.',
    'assoc_users'	 	=> 'Ovaj je entitet trenutno provjeren korisniku i ne može se izbrisati. Najprije provjerite snimljeni materijal, a zatim pokušajte ponovo ukloniti.',

    'create' => [
        'error'   		=> 'Imovina nije izrađena, pokušajte ponovo. :(',
        'success' 		=> 'Imovina je uspješno izrađena. :)',
    ],

    'update' => [
        'error'   			=> 'Imovina nije ažurirana, pokušajte ponovo',
        'success' 			=> 'Imovina je uspješno ažurirana.',
        'nothing_updated'	=>  'Nije odabrano nijedno polje, tako da ništa nije ažurirano.',
        'no_assets_selected'  =>  'No assets were selected, so nothing was updated.',
    ],

    'restore' => [
        'error'   		=> 'Imovina nije obnovljena, pokušajte ponovo',
        'success' 		=> 'Imovina je uspješno obnovljena.',
        'bulk_success' 		=> 'Asset restored successfully.',
        'nothing_updated'   => 'No assets were selected, so nothing was restored.', 
    ],

    'audit' => [
        'error'   		=> 'Revizija imovine nije uspjela. Molim te pokušaj ponovno.',
        'success' 		=> 'Uspjeh uspješno prijavljen.',
    ],


    'deletefile' => [
        'error'   => 'Datoteka nije izbrisana. Molim te pokušaj ponovno.',
        'success' => 'Datoteka je uspješno obrisana.',
    ],

    'upload' => [
        'error'   => 'Datoteke nisu prenesene. Molim te pokušaj ponovno.',
        'success' => 'Datoteke su uspješno učitane.',
        'nofiles' => 'Niste odabrali nijednu datoteku za prijenos ili je datoteka koju pokušavate prenijeti prevelika',
        'invalidfiles' => 'Jedna ili više datoteka je prevelika ili je vrsta datoteke koja nije dopuštena. Dopuštene vrste datoteka su png, gif, jpg, doc, docx, pdf i txt.',
    ],

    'import' => [
        'error'                 => 'Neke stavke nisu pravilno uvezene.',
        'errorDetail'           => 'Sljedeće stavke nisu uvezene zbog pogrešaka.',
        'success'               => 'Vaša je datoteka uvezena',
        'file_delete_success'   => 'Vaša je datoteka uspješno izbrisana',
        'file_delete_error'      => 'Datoteka nije mogla biti izbrisana',
        'header_row_has_malformed_characters' => 'One or more attributes in the header row contain malformed UTF-8 characters',
        'content_row_has_malformed_characters' => 'One or more attributes in the first row of content contain malformed UTF-8 characters',
    ],


    'delete' => [
        'confirm'   	=> 'Jeste li sigurni da želite izbrisati ovaj materijal?',
        'error'   		=> 'Došlo je do problema s brisanjem imovine. Molim te pokušaj ponovno.',
        'nothing_updated'   => 'Nijedna imovina nije odabrana, tako da ništa nije izbrisano.',
        'success' 		=> 'Imovina je uspješno obrisana.',
    ],

    'checkout' => [
        'error'   		=> 'Imovina nije odjavljena, pokušajte ponovo',
        'success' 		=> 'Asset je uspješno provjeren.',
        'user_does_not_exist' => 'Taj je korisnik nevažeći. Molim te pokušaj ponovno.',
        'not_available' => 'Taj materijal nije dostupan za naplatu!',
        'no_assets_selected' => 'Morate odabrati barem jednu imovinu s popisa',
    ],

    'checkin' => [
        'error'   		=> 'Prijava nije provjerena. Pokušajte ponovo',
        'success' 		=> 'Asset je uspješno prijavio.',
        'user_does_not_exist' => 'Taj je korisnik nevažeći. Molim te pokušaj ponovno.',
        'already_checked_in'  => 'Taj je entitet već prijavljen.',

    ],

    'requests' => [
        'error'   		=> 'Imovina nije zatražena, pokušajte ponovo',
        'success' 		=> 'Imovina je uspješno zatražena.',
        'canceled'      => 'Zahtjev za uplatu uspješno je otkazan',
    ],

];

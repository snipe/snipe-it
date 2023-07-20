<?php

return [

    'undeployable' 		=> '<strong>Warning: </strong> Acest activ a fost marcat ca fiind în prezent nedelimitat. Dacă această stare sa modificat, actualizați starea activelor.',
    'does_not_exist' 	=> 'Activul nu exista.',
    'does_not_exist_or_not_requestable' => 'Acest activ nu există sau nu poate fi solicitat.',
    'assoc_users'	 	=> 'Acest activ este predat catre un utilizator si nu se poate sterge. Va rugam verificati activul, dupa care incercati sa-l stergeti iar. ',

    'create' => [
        'error'   		=> 'Activul nu a fost creat, va rugam incercati iar. :(',
        'success' 		=> 'Activul a fost creat. :)',
    ],

    'update' => [
        'error'   			=> 'Activul nu a fost actualizat, va rugam incercati iar',
        'success' 			=> 'Activul a fost actualizat.',
        'nothing_updated'	=>  'Nu au fost selectate câmpuri, deci nimic nu a fost actualizat.',
        'no_assets_selected'  =>  'No assets were selected, so nothing was updated.',
    ],

    'restore' => [
        'error'   		=> 'Asset nu a fost restaurat, încercați din nou',
        'success' 		=> 'Activul a fost restaurat cu succes.',
        'bulk_success' 		=> 'Asset restored successfully.',
        'nothing_updated'   => 'No assets were selected, so nothing was restored.', 
    ],

    'audit' => [
        'error'   		=> 'Analiza activelor nu a avut succes. Vă rugăm să încercați din nou.',
        'success' 		=> 'Analiza activelor a fost înregistrată cu succes.',
    ],


    'deletefile' => [
        'error'   => 'Fișierul nu a fost șters. Vă rugăm să încercați din nou.',
        'success' => 'Fișierul a fost șters cu succes.',
    ],

    'upload' => [
        'error'   => 'Fișierul nu a fost încărcat. Vă rugăm să încercați din nou.',
        'success' => 'Fișierul a fost încărcat cu succes.',
        'nofiles' => 'Nu ați selectat niciun fișier pentru încărcare sau fișierul pe care încercați să îl încărcați este prea mare',
        'invalidfiles' => 'Unul sau mai multe fișiere este prea mare sau este un tip de fișier care nu este permis. Tipurile de fișiere permise sunt png, gif, jpg, doc, docx, pdf și txt.',
    ],

    'import' => [
        'error'                 => 'Unele elemente nu au importat corect.',
        'errorDetail'           => 'Următoarele elemente nu au fost importate din cauza erorilor.',
        'success'               => 'Fișierul dvs. a fost importat',
        'file_delete_success'   => 'Fișierul dvs. a fost șters cu succes',
        'file_delete_error'      => 'Fișierul nu a putut fi șters',
        'header_row_has_malformed_characters' => 'One or more attributes in the header row contain malformed UTF-8 characters',
        'content_row_has_malformed_characters' => 'One or more attributes in the first row of content contain malformed UTF-8 characters',
    ],


    'delete' => [
        'confirm'   	=> 'Sunteti sigur ca vreti sa stergeti acest activ?',
        'error'   		=> 'S-a intampinat o problema la stergerea activului. Va rugam incercati iar.',
        'nothing_updated'   => 'Nu au fost selectate active, deci nimic nu a fost șters.',
        'success' 		=> 'Activul a fost sters.',
    ],

    'checkout' => [
        'error'   		=> 'Activul nu a fost predat, va rugam incercati iar',
        'success' 		=> 'Activul a fost predat.',
        'user_does_not_exist' => 'Utilizatorul este invalid. Va rugam incercati iar.',
        'not_available' => 'Activul respectiv nu este disponibil pentru checkout!',
        'no_assets_selected' => 'Trebuie să selectați cel puțin un articol din lista',
    ],

    'checkin' => [
        'error'   		=> 'Activul nu a fost primit, va rugam incercati iar',
        'success' 		=> 'Activul a fost primit.',
        'user_does_not_exist' => 'Utilizatorul este invalid. Va rugam incercati iar.',
        'already_checked_in'  => 'Activul respectiv este deja înregistrat.',

    ],

    'requests' => [
        'error'   		=> 'Nu a fost solicitat un activ, încercați din nou',
        'success' 		=> 'Activele solicitate cu succes.',
        'canceled'      => 'Solicitarea de checkout a fost anulată cu succes',
    ],

];

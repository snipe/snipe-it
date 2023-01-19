<?php

return array(

    'does_not_exist' => 'Modelul nu exista.',
    'assoc_users'	 => 'Acest model este momentan asociat cu cel putin unul sau mai multe active si nu poate fi sters. Va rugam sa stergeti activul si dupa incercati iar. ',


    'create' => array(
        'error'   => 'Modelul nu a fost creat, incercati iar.',
        'success' => 'Modelul a fost creat.',
        'duplicate_set' => 'Un model de activ cu numele, producătorul și numărul modelului există deja.',
    ),

    'update' => array(
        'error'   => 'Modelul nu a fost actualizat, va rugam incercati iar',
        'success' => 'Modelul a fost actualizat.'
    ),

    'delete' => array(
        'confirm'   => 'Sunteti sigur ca doriti sa stergeti acest model de activ?',
        'error'   => 'A aparut o problema la stergerea modelului. Incercati iar.',
        'success' => 'Modelul a fost sters.'
    ),

    'restore' => array(
        'error'   		=> 'Modelul nu a fost restabilit, încercați din nou',
        'success' 		=> 'Modelul a fost restaurat cu succes.'
    ),

    'bulkedit' => array(
        'error'   		=> 'Nu au fost modificate câmpuri, deci nimic nu a fost actualizat.',
        'success' 		=> 'Modelele au fost actualizate.'
    ),

    'bulkdelete' => array(
        'error'   		    => 'Nu au fost selectate câmpuri, deci nimic nu a fost actualizat.',
        'success' 		    => 'Au fost șterse :success_count model(e)!',
        'success_partial' 	=> 'Au fost șterse :success_count modele, cu toate acestea :fail_count nu au putut fi șterse deoarece au în continuare active asociate cu acestea.'
    ),

);

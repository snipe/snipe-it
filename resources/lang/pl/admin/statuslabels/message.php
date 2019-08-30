<?php

return array(

    'does_not_exist' => 'Status etykiety nie istnieje.',
    'assoc_assets'	 => 'Status etykiety jest skojarzony z minimum jednym aktywem i nie może być usunięty. Uaktualnij aktywa tak aby nie było relacji z tym statusem i spróbuj ponownie. ',


    'create' => array(
        'error'   => 'Status etykiety nie został utworzony, spróbuj ponownie.',
        'success' => 'Status etykiety utworzony pomyślnie.'
    ),

    'update' => array(
        'error'   => 'Status etykiety nie został zaktualizowany, spróbuj ponownie',
        'success' => 'Status etykiety został zaktualizowany pomyślnie.'
    ),

    'delete' => array(
        'confirm'   => 'Czy na pewno chcesz usunąć ten status etykiety?',
        'error'   => 'Wystąpił błąd podczas usuwania statusu etykiety. Spróbuj ponownie.',
        'success' => 'Status etykiety został usunięty pomyślnie.'
    ),

    'help' => array(
        'undeployable'   => 'Te aktywa nie mogą być przypisane do nikogo.',
        'deployable'   => 'Te aktywa można sprawdzić. Gdy zostaną przypisane, przyjmą stan meta w postaci <i class="fa fa-circle text-blue"></i> <strong>Deployed</strong>.',
        'archived'   => 'Te zasoby nie mogą zostać sprawdzone i będą wyświetlane tylko w Archiwizowanym widoku. Jest to użyteczne przy przechowywaniu informacji o zasobach w celach budżetowych / historycznych, ale nie na bieżąco z listy aktywów.',
        'pending'   => 'Te aktywa nie mogą być jeszcze przydzielone nikomu, często używane do przedmiotów przeznaczonych do naprawy, ale oczekują, że powrócą do obiegu.',
    ),

);

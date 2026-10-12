<?php

return [

    'does_not_exist' => 'Nie ma takiej kategorii.',
    'assoc_models' => 'Wybrana kategoria jest obecnie powiązana z co najmniej jednym typem urządzenia i nie może zostać usunięta. Uaktualnij swoją listę modeli urządzeń by nie zwierała tej kategorii, a następnie spróbuj ponownie. ',
    'assoc_items' => 'Ta kategoria jest obecnie powiązana z co najmniej jednym :asset_type i nie można jej usunąć. Uaktualnij swój :asset_type tak, aby nie odnosiła się do tej kategorii, a następnie spróbuj ponownie. ',

    'create' => [
        'error' => 'Kategoria nie została utworzona, spróbuj ponownie.',
        'success' => 'Kategoria utworzona.',
    ],

    'update' => [
        'error' => 'Kategoria nie została zaktualizowana, spróbuj ponownie',
        'success' => 'Kategoria zaktualizowana.',
        'cannot_change_category_type' => 'Nie można zmienić typu kategorii po jej utworzeniu',
    ],

    'delete' => [
        'confirm' => 'Czy jesteś pewien że chcesz usunąć tą kategorię ?',
        'error' => 'Wystąpił błąd podczas usuwania kategorii. Spróbuj ponownie.',
        'success' => 'Pomyślnie usunięto kategorię.',
        'bulk_success' => 'Category deleted successfully.|:count categories were deleted successfully.',
        'partial_success' => 'Kategoria usunięta z powodzeniem. Sprawdź szczegółowe informacje poniżej. | :count kategorie zostały usunięte z powodzeniem. Sprawdź szczegółowe informacje poniżej.',
    ],

    'bulkedit' => [
        'warn' => 'You are about to edit the properties of the following category:|You are about to edit the properties of the following :count categories:',
        'no_selection' => 'Wybierz co najmniej jedną kategorię do edycji.',
        'no_changes' => 'Żadne pole nie zostało zmodyfikowane, więc nic nie zostało zaktualizowane.',
        'success' => 'Category successfully updated.|:count categories successfully updated.',
    ],

];

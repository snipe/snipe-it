<?php

return [

    'does_not_exist' => 'Categorie bestaat niet.',
    'assoc_models' => 'Deze categorie is momenteel gekoppeld met ten minste 1 model en kan niet verwijderd worden. Pas uw modellen aan zodat deze categorie niet langer gebruikt wordt en probeer opnieuw. ',
    'assoc_items' => 'Deze categorie is momenteel gekoppeld aan ten minste één: asset_type en kan niet worden verwijderd. Zorg dat uw: asset_type niet langer verwijst naar deze categorie en probeer het opnieuw. ',

    'create' => [
        'error' => 'Categorie is niet aangemaakt. Probeer het opnieuw.',
        'success' => 'Categorie is aangemaakt.',
    ],

    'update' => [
        'error' => 'Categorie is niet aangepast. Probeer het opnieuw.',
        'success' => 'Categorie is aangepast.',
        'cannot_change_category_type' => 'U kunt het categorietype niet meer wijzigen nadat het is aangemaakt',
    ],

    'delete' => [
        'confirm' => 'Weet u zeker dat u deze categorie wilt verwijderen?',
        'error' => 'Er is een probleem opgetreden bij het verwijderen van deze categorie. Probeer het opnieuw.',
        'success' => 'De categorie is succesvol verwijderd.',
        'bulk_success' => 'Category deleted successfully.|:count categories were deleted successfully.',
        'partial_success' => 'Categorie succesvol verwijderd. Zie additionele informatie hieronder. | :count categorieën succesvol verwijderd. Zie additionele informatie hieronder.',
    ],

    'bulkedit' => [
        'warn' => 'You are about to edit the properties of the following category:|You are about to edit the properties of the following :count categories:',
        'no_selection' => 'You must select at least one category to edit.',
        'no_changes' => 'Er was geen veld geselecteerd dus is er niks gewijzigd.',
        'success' => 'Category successfully updated.|:count categories successfully updated.',
    ],

];

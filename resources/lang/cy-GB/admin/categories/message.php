<?php

return [

    'does_not_exist' => 'Categori ddim yn bodoli.',
    'assoc_models' => 'Mae\'r categori yma wedi perthnasu i oleiaf un model a nid yw\'n bosib dileu. Diweddarwch eich modelau i beidio cyfeirio at y categori yma ac yna ceisiwch eto. ',
    'assoc_items' => 'Mae\'r categori yma wedi perthnasu i :asset_type a nid yw\'n bosib dileu. Diweddarwch eich :asset_type i beidio cyfeirio at y categori yma ac yna ceisiwch eto. ',

    'create' => [
        'error' => 'Ni crewyd y categori, ceisiwch eto o. g. y. dd.',
        'success' => 'Categori wedi creu\'n llwyddiannus.',
    ],

    'update' => [
        'error' => 'Ni diweddarwyd y categori, ceisiwch eto o. g. y. dd',
        'success' => 'Categori wedi diweddaru\'n llwyddiannus.',
        'cannot_change_category_type' => 'You cannot change the category type once it has been created',
    ],

    'delete' => [
        'confirm' => 'Ydych chi\'n siwr eich bod eisiau dileu\'r categori yma?',
        'error' => 'Nid oedd yn bosib dileu\'r categori. Ceisiwch eto o.g.y.dd.',
        'success' => 'Category was deleted successfully.',
        'bulk_success' => 'Category deleted successfully.|:count categories were deleted successfully.',
        'partial_success' => 'Category deleted successfully. See additional information below. | :count categories were deleted successfully. See additional information below.',
    ],

    'bulkedit' => [
        'warn' => 'You are about to edit the properties of the following category:|You are about to edit the properties of the following :count categories:',
        'no_selection' => 'You must select at least one category to edit.',
        'no_changes' => 'Dim newid mewn manylder, felly dim byd i diweddaru.',
        'success' => 'Category successfully updated.|:count categories successfully updated.',
    ],

];

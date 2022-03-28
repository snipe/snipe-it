<?php

return [

    'does_not_exist' => 'Status Label does not exist.',
    'assoc_assets'	 => 'This Status Label is currently associated with at least one Asset and cannot be deleted. Please update your assets to no longer reference this status and try again. ',

    'create' => [
        'error'   => 'Status Label was not created, please try again.',
        'success' => 'Status Label created successfully.',
    ],

    'update' => [
        'error'   => 'Status Label was not updated, please try again',
        'success' => 'Status Label updated successfully.',
    ],

    'delete' => [
        'confirm'   => 'Are you sure you wish to delete this Status Label?',
        'error'   => 'There was an issue deleting the Status Label. Please try again.',
        'success' => 'The Status Label was deleted successfully.',
    ],

    'help' => [
        'undeployable'   => 'Þessum eignum er ekki hægt að úthluta til notenda.',
        'deployable'   => 'These assets can be checked out. Once they are assigned, they will assume a meta status of <i class="fas fa-circle text-blue"></i> <strong>Deployed</strong>.',
        'archived'   => 'Þessum eignum er ekki hægt að ráðstafa og þær sjást eingöngu í þar til gerðum lista. Þetta er gagnlegt til að varðveita upplýsingar um eignir sem nýta má við gerð fjárhagsáætlana eða til að halda utan um sögu eigna á sama tíma og þeim er haldið utan við þann eignalista sem unnið er með daglega.',
        'pending'   => 'Þessum eignum er ekki hægt að úthluta til notenda að svo stöddu. Oft notað fyrir hluti sem eru í viðgerð en er viðbúið að verði teknir aftur í notkun.',
    ],

];

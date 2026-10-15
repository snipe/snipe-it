<?php

return [
    'does_not_exist' => 'Empresa não existe.',
    'deleted' => 'Empresa excluída',
    'assoc_users' => 'Esta empresa está associada a pelo menos um modelo e não pode ser eliminada. Actualize os seus modelos para que não referenciem esta empresa e tente novamente. ',
    'create' => [
        'error' => 'Empresa não criada, por favor tente de novo.',
        'success' => 'Empresa criada com sucesso.',
    ],
    'update' => [
        'error' => 'Empresa não foi atualizada, tente novamente',
        'success' => 'Empresa atualizada com sucesso.',
    ],
    'delete' => [
        'confirm' => 'Tem a certeza que deseja eliminar está empresa?',
        'error' => 'Existe um problema ao eliminar a empresa. Por favor tente de novo.',
        'success' => 'A empresa foi eliminada com sucesso.',
        'bulk_success' => 'Company deleted successfully.|:count companies were deleted successfully.',
        'partial_success' => 'Company deleted successfully. See additional information below. | :count companies were deleted successfully. See additional information below.',
    ],
];

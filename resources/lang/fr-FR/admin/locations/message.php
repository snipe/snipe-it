<?php

return array(

    'does_not_exist' => 'Le lieu n\'existe pas.',
    'assoc_users'    => 'Cet emplacement n\'est pas actuellement supprimable car il s\'agit de l\'emplacement de l\'enregistrement pour au moins un actif ou un utilisateur, a des actifs qui lui sont assignés, ou est l\'emplacement parent d\'un autre emplacement. Veuillez mettre à jour vos modèles pour ne plus référencer cette entreprise et réessayez. ',
    'assoc_assets'	 => 'Cet emplacement est actuellement associé à au moins un actif et ne peut pas être supprimé. Veuillez mettre à jour vos actifs pour ne plus faire référence à cet emplacement et réessayez. ',
    'assoc_child_loc'	 => 'Cet emplacement est actuellement le parent d\'au moins un sous emplacement et ne peut pas être supprimé . S\'il vous plaît mettre à jour vos emplacement pour ne plus le référencer et réessayez. ',
    'assigned_assets' => 'Actifs assignés',
    'current_location' => 'Emplacement actuel',


    'create' => array(
        'error'   => 'Le lieu n\'a pas été créé, veuillez essayer à nouveau.',
        'success' => 'Le lieu a été créé avec succès.'
    ),

    'update' => array(
        'error'   => 'Le lieu n\'a pas été mis à jour, veuillez essayer à nouveau',
        'success' => 'Le lieu a été mis à jour avec succès.'
    ),

    'delete' => array(
        'confirm'   	=> 'Êtes-vous sûr de vouloir supprimer ce lieu ?',
        'error'   => 'Un problème a eu lieu pendant la suppression du lieu. Veuillez essayer à nouveau.',
        'success' => 'Le lieu a été supprimé avec succès.'
    )

);

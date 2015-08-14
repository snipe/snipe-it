<?php

return array(

    'does_not_exist' => 'Le lieu n\'existe pas.',
    'assoc_users'	 => 'Ce lieu est actuellement associé avec au moins un utilisateur et ne peut pas être supprimé. Veuillez mettre à jour vos utilisateurs pour ne plus faire référence à ce lieu et essayez à nouveau. ',
    'assoc_assets'	 => 'This location is currently associated with at least one asset and cannot be deleted. Please update your assets to no longer reference this location and try again. ',
    'assoc_child_loc'	 => 'This location is currently the parent of at least one child location and cannot be deleted. Please update your locations to no longer reference this location and try again. ',


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

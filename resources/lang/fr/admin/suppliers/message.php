<?php

return array(

    'does_not_exist' => 'Le fournisseur n\'existe pas.',


    'create' => array(
        'error'   => 'Le fournisseur n\'a pas été créé, veuillez essayer à nouveau.',
        'success' => 'Le fournisseur a été créé avec succès.'
    ),

    'update' => array(
        'error'   => 'Le fournisseur n\'a pas été mis à jour, veuillez essayer à nouveau',
        'success' => 'Le fournisseur a été mis à jour avec succès.'
    ),

    'delete' => array(
        'confirm'   => 'Êtes-vous sûr de vouloir supprimer ce fournisseur ?',
        'error'   => 'Un problème a eu lieu pendant la suppression du fournisseur. Veuillez essayer à nouveau.',
        'success' => 'Le fournisseur a été supprimé avec succès.',
        'assoc_assets'	 => 'This supplier is currently associated with :asset_count asset(s) and cannot be deleted. Please update your assets to no longer reference this supplier and try again. ',
        'assoc_licenses'	 => 'This supplier is currently associated with :licenses_count licences(s) and cannot be deleted. Please update your licenses to no longer reference this supplier and try again. ',
        'assoc_maintenances'	 => 'This supplier is currently associated with :asset_maintenances_count asset maintenances(s) and cannot be deleted. Please update your asset maintenances to no longer reference this supplier and try again. ',
    )

);

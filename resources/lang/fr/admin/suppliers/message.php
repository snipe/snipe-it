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
        'assoc_assets'	 => 'Ce fournisseur est actuellement associé au matériel :asset_count et ne peut être supprimé. Veuillez actualiser votre matériel pour ne plus référencer ce fournisseur et réessayer. ',
        'assoc_licenses'	 => 'Ce fournisseur est actuellement associé aux licences :licence_count et ne peut être supprimé. Veuillez actualiser vos licences pour ne plus référencer ce fournisseur et réessayer. ',
        'assoc_maintenances'	 => 'Ce fournisseur est actuellement associé à la maintenance de matériel :asset_maintenance_count et ne peut être supprimé. Veuillez actualiser votre maintenance de matériel pour ne plus référencer ce fournisseur et réessayer. ',
    )

);

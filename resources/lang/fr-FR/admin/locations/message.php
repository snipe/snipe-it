<?php

return [

    'does_not_exist' => 'Le lieu n\'existe pas.',
    'assoc_users' => 'Cet emplacement n\'est pas actuellement supprimable car il s\'agit de l\'emplacement de l\'enregistrement pour au moins un actif ou un utilisateur, a des actifs qui lui sont assignés, ou est l\'emplacement parent d\'un autre emplacement. Veuillez mettre à jour vos modèles pour ne plus référencer cette entreprise et réessayez. ',
    'assoc_assets' => 'Cet emplacement est actuellement associé à au moins un actif et ne peut pas être supprimé. Veuillez mettre à jour vos actifs pour ne plus faire référence à cet emplacement et réessayez. ',
    'assoc_child_loc' => 'Cet emplacement est actuellement le parent d\'au moins un sous emplacement et ne peut pas être supprimé . S\'il vous plaît mettre à jour vos emplacement pour ne plus le référencer et réessayez. ',
    'assigned_assets' => 'Actifs assignés',
    'current_location' => 'Emplacement actuel',
    'deleted_warning' => 'Cet emplacement a été supprimé. Veuillez le restaurer avant de tenter d\'apporter des modifications.',

    'create' => [
        'error' => 'Le lieu n\'a pas été créé, veuillez essayer à nouveau.',
        'success' => 'Le lieu a été créé avec succès.',
    ],

    'update' => [
        'error' => 'Le lieu n\'a pas été mis à jour, veuillez essayer à nouveau',
        'success' => 'Le lieu a été mis à jour avec succès.',
    ],

    'restore' => [
        'error' => 'L\'emplacement n\'a pas été restauré, veuillez réessayer',
        'success' => 'Emplacement restauré avec succès.',
    ],

    'delete' => [
        'confirm' => 'Êtes-vous sûr de vouloir supprimer ce lieu ?',
        'error' => 'Un problème a eu lieu pendant la suppression du lieu. Veuillez essayer à nouveau.',
        'success' => 'Le lieu a été supprimé avec succès.',
    ],

    'bulkedit' => [
        'error' => 'Aucun champ n\'a été changé, donc rien n\'a été mis à jour.',
        'success' => 'Emplacement mis à jour avec succès. |:count emplacements mis à jour avec succès.',
        'warn' => 'Modifiez les champs ci-dessous pour mettre à jour cet emplacement. Les champs que vous laissez vide ne changeront pas à l\'emplacement. Modifier les champs ci-dessous pour mettre à jour tous les :count emplacements sélectionnés. Les champs que vous laissez vide ne changeront sur aucun d\'entre eux.',
        'show_selected' => ':count emplacements sélectionnés|:count emplacements sélectionnés',
        'company_scope_mismatch_partial' => 'L\'entreprise n\'a pas été modifiée sur 1 emplacement parce que les éléments ou les utilisateurs de cet emplacement appartiennent à différentes sociétés. Mettez à jour ou déplacez ceux-ci en premier. L\'entreprise n\'a pas été modifiée sur :count emplacements parce que les éléments ou les utilisateurs de ces emplacements appartiennent à différentes sociétés. Mettez à jour ou déplacez-les en premier.',
        'company_scope_mismatch_all' => 'Aucun emplacement n\'a été réaffecté. La société demandée ne correspond pas aux articles ou aux utilisateurs à l\'emplacement sélectionné. Aucun emplacement n\'a été réaffecté. La société demandée ne correspond pas aux articles ou aux utilisateurs dans l\'un des :count emplacements sélectionnés.',
        'parent_company_mismatch_partial' => 'La société mère ou la société n\'a pas été changée sur 1 emplacement car elle laisserait l\'emplacement dans une entreprise différente de son père. Le parent ou la société n\'a pas été changé sur :count emplacements car cela laisserait ces emplacements dans une société différente de leur parent.',
        'parent_company_mismatch_all' => 'Aucune modification n\'a été enregistrée. La société mère ou la société demandée laisserait l\'emplacement dans une entreprise différente de son parent.|Aucune modification n\'a été enregistrée. La mère ou la société demandée quitterait chacun des emplacements sélectionnés :count dans une entreprise différente de leur parent.',
    ],

];

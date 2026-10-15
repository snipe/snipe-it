<?php

return [

    'deleted' => 'Modèle d\'actif supprimé',
    'does_not_exist' => 'Le modèle n\'existe pas.',
    'no_association' => 'ATTENTION ! Le modèle d\'actif pour cet objet est invalide ou manquant !',
    'no_association_fix' => 'Cela va casser les choses de manière bizarre et horrible. Modifiez cette ressource maintenant pour lui assigner un modèle.',
    'assoc_users' => 'Ce modèle est actuellement associé à au moins un actif et ne peut pas être supprimé. Veuillez supprimer les actifs associés et essayer à nouveau. ',
    'invalid_category_type' => 'La catégorie doit être une catégorie d\'actifs.',

    'create' => [
        'error' => 'Le modèle n\'a pas été créé, veuillez essayer à nouveau.',
        'success' => 'Le modèle a été créé avec succès.',
        'duplicate_set' => 'Un modèle d\'actif avec ce nom, fabricant et modèle existe déjà.',
    ],

    'update' => [
        'error' => 'Le modèle n\'a pas été mis à jour, veuillez essayer à nouveau',
        'success' => 'Le modèle a été mis à jour avec succès.',
    ],

    'delete' => [
        'confirm' => 'Êtes-vous sûr de vouloir supprimer ce modèle d\'actif ?',
        'error' => 'Un problème a eu lieu pendant la suppression du modèle. Veuillez essayer à nouveau.',
        'success' => 'Le modèle a été supprimé avec succès.',
    ],

    'restore' => [
        'error' => 'Le modèle d\'actif n\'a pas été restauré, veuillez réessayer',
        'success' => 'Modèle d\'actif restauré correctement.',
    ],

    'bulkedit' => [
        'error' => 'Aucun champ n\'a été changé, donc rien n\'a été mis à jour.',
        'success' => 'Modèle mis à jour avec succès. |:model_count modèles mis à jour avec succès.',
        'warn' => 'Vous êtes sur le point de mettre à jour les propriétés du modèle suivant :|Vous êtes sur le point de modifier les propriétés des modèles :model_count suivants :',

    ],

    'bulkdelete' => [
        'error' => 'Aucun modèle n\'a été sélectionné, donc rien n\'a été supprimé.',
        'nothing_deletable' => 'Aucun des modèles sélectionnés ne peut être supprimé car ils ont encore des actifs associés.',
        'success' => 'Modèle supprimé !|:success_count modèles supprimés !',
        'success_partial' => ': les modèles success_count ont été supprimés, cependant : fail_count n\'a pas pu être supprimé car ils ont toujours des ressources associées.',
    ],

    'merge' => [
        'min_two' => 'Sélectionnez au moins deux modèles à fusionner.',
        'no_target' => 'Sélectionnez le modèle à conserver avant de fusionner.',
        'not_found' => 'Un ou plusieurs modèles sélectionnés n\'ont pas pu être chargés. Rafraîchissez la liste des modèles et réessayez.',
        'information' => 'Vous êtes sur le point de fusionner les modèles :count. Choisissez le modèle que vous voulez garder. Chaque ressource attachée aux autres modèles sera réaffectée au modèle que vous choisissez, puis les modèles source seront supprimés.',
        'warning' => 'Cette opération ne peut pas être annulée. Les actifs réassignés hériteront de la catégorie, du jeu de champs et des paramètres d\'amortissements du modèle survivant.',
        'pick_target' => 'Quel modèle voulez-vous conserver ?',
        'success' => 'Fusionné :source_count modèle(s) dans ":target". :asset_count asset(s) ont été réaffectés.',
    ],

];

<?php

return [

    'deleted' => 'Deleted asset model',
    'does_not_exist' => 'Nid yw\'r model yn bodoli.',
    'no_association' => 'WARNING! The asset model for this item is invalid or missing!',
    'no_association_fix' => 'This will break things in weird and horrible ways. Edit this asset now to assign it a model.',
    'assoc_users' => 'Mae\'r model yma wedi perthnasu hefo un neu mwy o asedau. Fydd rhaid dileu\'r asedau ac yna trio eto. ',
    'invalid_category_type' => 'This category must be an asset category.',

    'create' => [
        'error' => 'Ni crewyd y model, ceisiwch eto o.g.y.dd.',
        'success' => 'Model wedi creu yn llwyddiannus.',
        'duplicate_set' => 'Mae model ased hefo\'r enw, gwneuthyrwr a rhif model yn bodoli yn barod.',
    ],

    'update' => [
        'error' => 'Ni diweddarwyd y model, ceisiwch eto o.g.y.dd',
        'success' => 'Model wedi diweddaru\'n llwyddiannus.',
    ],

    'delete' => [
        'confirm' => 'Ydych chi\'n sicr eich bod eisiau dileu\'r model ased yma?',
        'error' => 'Nid oedd yn bosib dileu\'r model. Ceisiwch eto o.g.y.dd.',
        'success' => 'Model wedi dileu\'n llwyddiannus.',
    ],

    'restore' => [
        'error' => 'Nid oedd yn bosib adfer y model, ceisiwch eto o.g.y.dd',
        'success' => 'Model wedi adfer yn llwyddiannus.',
    ],

    'bulkedit' => [
        'error' => 'Dim newid mewn manylder, felly dim byd i diweddaru.',
        'success' => 'Model successfully updated. |:model_count models successfully updated.',
        'warn' => 'You are about to update the properties of the following model:|You are about to edit the properties of the following :model_count models:',

    ],

    'bulkdelete' => [
        'error' => 'Dim modelau wedi dewis, felly dim byd i\'w ddileu.',
        'nothing_deletable' => 'None of the selected models can be deleted because they still have assets associated with them.',
        'success' => 'Model deleted!|:success_count models deleted!',
        'success_partial' => ':success_count model(au) wedi\'i dileu, :fail_count heb eu ddileu gan bod asedau wedi perthnasu iddo.',
    ],

    'merge' => [
        'min_two' => 'Select at least two models to merge.',
        'no_target' => 'Select which model to keep before merging.',
        'not_found' => 'One or more of the selected models could not be loaded. Refresh the models list and try again.',
        'information' => 'You are about to merge :count models. Pick the model you want to keep. Every asset attached to the other models will be reassigned to the model you pick, then the source models will be deleted.',
        'warning' => 'This cannot be undone. Reassigned assets will inherit the surviving model\'s category, fieldset, and depreciation settings.',
        'pick_target' => 'Which model do you want to keep?',
        'success' => 'Merged :source_count model(s) into ":target". :asset_count asset(s) were reassigned.',
    ],

];

<?php

return array(

    'does_not_exist' => 'Nid yw\'r lleoliad yn bodoli.',
    'assoc_users'    => 'This location is not currently deletable because it is the location of record for at least one asset or user, has assets assigned to it, or is the parent location of another location. Please update your models to no longer reference this company and try again. ',
    'assoc_assets'	 => 'Mae\'r lleoliad yma wedi perthnasu i oleiaf un ased a nid yw\'n bosib dileu. Diweddarwch eich asedau i beidio cyfeirio at y lleoliad yma ac yna ceisiwch eto. ',
    'assoc_child_loc'	 => 'Mae\'r lleoliad yma yn rhiant i oleiaf un lleoliad a nid yw\'n bosib dileu. Diweddarwch eich lleoliadau i beidio cyfeirio at y lleoliad yma ac yna ceisiwch eto. ',
    'assigned_assets' => 'Assigned Assets',
    'current_location' => 'Current Location',


    'create' => array(
        'error'   => 'Ni crewyd y lleoliad, ceisiwch eto o.g.y.dd.',
        'success' => 'Lleoliad wedi creu yn llwyddiannus.'
    ),

    'update' => array(
        'error'   => 'Ni diweddarwyd y lleoliad, ceisiwch eto o.g.y.dd',
        'success' => 'Lleoliad wedi diweddaru\'n llwyddiannus.'
    ),

    'delete' => array(
        'confirm'   	=> 'Ydych chi\'n siwr eich bod eisiau dileu\'r lleoliad yma?',
        'error'   => 'Nid oedd yn bosib dileu\'r lleoliad. Ceisiwch eto o.g.y.dd.',
        'success' => 'Lleoliad wedi dileu\'n llwyddiannus.'
    )

);

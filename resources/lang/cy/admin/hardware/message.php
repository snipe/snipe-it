<?php

return [

    'undeployable' 		=> '<strong> Rhybudd: </strong> Mae\'r ased hwn wedi\'i nodi fel un na ellir ei ddefnyddio ar hyn o bryd.
                        Os yw\'r statws hwn wedi newid, diweddarwch statws yr ased.',
    'does_not_exist' 	=> 'Nid yw\'r ased yn bodoli.',
    'does_not_exist_or_not_requestable' => 'That asset does not exist or is not requestable.',
    'assoc_users'	 	=> 'Ar hyn o bryd mae\'r ased yma allan gan ddefnyddiwr ac ni ellir ei ddileu. Cofnodwch yr ased yn ol i fewn yn gyntaf, ac yna ceisiwch ei ddileu eto. ',

    'create' => [
        'error'   		=> 'Ni crewyd yr ased, ceisiwch eto o. g. y. dd. :(',
        'success' 		=> 'Ased wedi creu yn llwyddiannus. :)',
    ],

    'update' => [
        'error'   			=> 'Ni diweddarwyd yr assed, ceisiwch eto o. g. y. dd',
        'success' 			=> 'Ased wedi diweddaru\'n llwyddiannus.',
        'nothing_updated'	=>  'Dim newid mewn manylder, felly dim byd wedi\'i diweddaru.',
        'no_assets_selected'  =>  'No assets were selected, so nothing was updated.',
    ],

    'restore' => [
        'error'   		=> 'Nid oedd yn bosib adfer yr ased, ceisiwch eto o. g. y. dd',
        'success' 		=> 'Ased wedi adfer yn llwyddiannus.',
        'bulk_success' 		=> 'Asset restored successfully.',
        'nothing_updated'   => 'No assets were selected, so nothing was restored.', 
    ],

    'audit' => [
        'error'   		=> 'Roedd archwiliad asedau yn aflwyddiannus. Ceisiwch eto o. g. y. dd.',
        'success' 		=> 'Cofnodwyd archwiliad asedau yn llwyddiannus.',
    ],


    'deletefile' => [
        'error'   => 'Ffeil heb ei ddileu. Ceisiwch eto o.g.y.dd.',
        'success' => 'Ffeil wedi dileu yn llwyddiannus.',
    ],

    'upload' => [
        'error'   => 'Ffeil(iau) heb ei uwchlwytho. Ceisiwch eto o. g. y. dd.',
        'success' => 'Ffeil(iau) wedi uwchlwytho yn llwyddiannus.',
        'nofiles' => 'Ni wnaethoch chi ddewis unrhyw ffeiliau i\'w uwchlwytho, neu mae\'r ffeil rydych chi\'n ceisio ei huwchlwytho yn rhy fawr',
        'invalidfiles' => 'Mae un neu mwy o\'r ffeiliau unai yn rhy fawr neu ddim y math cywir. Derbynir png, gif, fjp, doc, docx, pdf a txt.',
    ],

    'import' => [
        'error'                 => 'Rhai eitemau heb ei mewnforio\'n gywir.',
        'errorDetail'           => 'Ni fewnforiwyd yr eitemau canlynol oherwydd gwallau.',
        'success'               => 'Mae\'ch ffeil wedi\'i mewnforio',
        'file_delete_success'   => 'Mae eich ffeil wedi\'i dileu yn llwyddiannus',
        'file_delete_error'      => 'Nid oedd yn bosib dileu\'r ffeil',
        'header_row_has_malformed_characters' => 'One or more attributes in the header row contain malformed UTF-8 characters',
        'content_row_has_malformed_characters' => 'One or more attributes in the first row of content contain malformed UTF-8 characters',
    ],


    'delete' => [
        'confirm'   	=> 'Ydych chi\'n sicr eich bod eisiau dileu\'r ased yma?',
        'error'   		=> 'Roedd problem wrth ceisio dileu\'r ased. Ceisiwch eto o. g. y. dd.',
        'nothing_updated'   => 'Dim asedau wedi dewis, felly dim byd wedi\'i dileu.',
        'success' 		=> 'Ased wedi dileu\'n llwyddiannus.',
    ],

    'checkout' => [
        'error'   		=> 'Ased heb ei nodi fel allan, ceisiwch eto o. g. y. dd',
        'success' 		=> 'Ased wedi nodi fel allan yn llwyddiannus.',
        'user_does_not_exist' => 'Nid yw\'r defnyddiwr yna yn ddilys. Ceisiwch eto o.g.y.dd.',
        'not_available' => 'Nid yw\'r ased yma ar gael i\'w defnyddio!',
        'no_assets_selected' => 'Rhaid i chi ddewis o leiaf un ased o\'r rhestr',
    ],

    'checkin' => [
        'error'   		=> 'Ased heb ei nodi i mewn, ceisiwch eto o. g. y. dd',
        'success' 		=> 'Ased wedi nodi i mewn yn llwyddiannus.',
        'user_does_not_exist' => 'Nid yw\'r defnyddiwr yna yn ddilys. Ceisiwch eto o. g. y. dd.',
        'already_checked_in'  => 'Ased wedi nodi i mewn yn gywir.',

    ],

    'requests' => [
        'error'   		=> 'Nid oedd cais am yr ased, ceisiwch eto o. g. y. dd',
        'success' 		=> 'Cais am ased yn llwyddiannus.',
        'canceled'      => 'Wedi llwydo i canslo cais am ased',
    ],

];

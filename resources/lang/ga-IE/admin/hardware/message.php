<?php

return [

    'undeployable' 		=> '<strong>Marradh: </strong> Tá an tsócmhainn seo marcáilte mar atá inghníomhaithe faoi láthair. Má d\'athraigh an stádas seo, déan an stádas sócmhainne a nuashonrú.',
    'does_not_exist' 	=> 'Níl sócmhainn ann.',
    'does_not_exist_or_not_requestable' => 'That asset does not exist or is not requestable.',
    'assoc_users'	 	=> 'Faoi láthair déanfar an tsócmhainn seo a sheiceáil chuig úsáideoir agus ní féidir é a scriosadh. Déan seiceáil ar an tsócmhainn sa chéad uair, agus déan iarracht ansin scriosadh arís.',

    'create' => [
        'error'   		=> 'Níor cruthaíodh sócmhainn, déan iarracht arís. :(',
        'success' 		=> 'Cruthaíodh sócmhainn go rathúil. :)',
    ],

    'update' => [
        'error'   			=> 'Níor tugadh nuashonrú ar an tsócmhainn, déan iarracht arís',
        'success' 			=> 'Nuashonraíodh sócmhainn go rathúil',
        'nothing_updated'	=>  'Níor roghnaíodh réimsí ar bith, mar sin níor nuashonraíodh aon rud.',
        'no_assets_selected'  =>  'No assets were selected, so nothing was updated.',
    ],

    'restore' => [
        'error'   		=> 'Níor cuireadh an tsócmhainn ar ais, déan iarracht arís',
        'success' 		=> 'Aisghabháil sócmhainne go rathúil.',
    ],

    'audit' => [
        'error'   		=> 'Níor éirigh leis an iniúchadh sócmhainne. Arís, le d\'thoil.',
        'success' 		=> 'Iniúchadh sócmhainne logáilte go rathúil.',
    ],


    'deletefile' => [
        'error'   => 'Ní scriosadh an comhad. Arís, le d\'thoil.',
        'success' => 'Comhad a scriosadh go rathúil',
    ],

    'upload' => [
        'error'   => 'Comhad (í) nach bhfuil uaslódáil. Arís, le d\'thoil.',
        'success' => 'Comhad (í) uaslódáil go rathúil.',
        'nofiles' => 'Níor roghnaigh tú comhaid ar bith le híoslódáil, nó tá an comhad a bhfuil tú ag iarraidh uaslódáil ró-mhór',
        'invalidfiles' => 'Tá ceann amháin nó níos mó de do chuid comhad ró-mhór nó is comhad í nach bhfuil ceadaithe. Tá píopaí comhaid a cheadaítear png, gif, jpg, doc, docx, pdf, and txt.',
    ],

    'import' => [
        'error'                 => 'Níor iompórtáil roinnt míreanna i gceart.',
        'errorDetail'           => 'Níor allmhairíodh na Míreanna seo a leanas mar gheall ar earráidí.',
        'success'               => 'Tá do chomhad iompórtáilte',
        'file_delete_success'   => 'Tá do chomhad scriosta go rathúil',
        'file_delete_error'      => 'Níorbh fhéidir an comhad a scriosadh',
    ],


    'delete' => [
        'confirm'   	=> 'An bhfuil tú cinnte gur mian leat an tsócmhainn seo a scriosadh?',
        'error'   		=> 'Bhí ceist ann a scriosadh an tsócmhainn. Arís, le d\'thoil.',
        'nothing_updated'   => 'Níor roghnaíodh aon sócmhainní, mar sin níor scriosadh aon rud.',
        'success' 		=> 'Scriosadh an tsócmhainn go rathúil.',
    ],

    'checkout' => [
        'error'   		=> 'Níor sheiceáil amach an tsócmhainn, déan iarracht arís',
        'success' 		=> 'Seiceáil sheiceáil amach go rathúil.',
        'user_does_not_exist' => 'Tá an úsáideoir neamhbhailí. Arís, le d\'thoil.',
        'not_available' => 'Níl an tsócmhainn sin ar fáil le haghaidh seiceáil!',
        'no_assets_selected' => 'You must select at least one asset from the list',
    ],

    'checkin' => [
        'error'   		=> 'Níor seiceáladh an tsócmhainn, déan iarracht arís',
        'success' 		=> 'Seiceáil seiceáil go rathúil.',
        'user_does_not_exist' => 'Tá an úsáideoir neamhbhailí. Arís, le d\'thoil.',
        'already_checked_in'  => 'Déantar an sócmhainn sin a sheiceáil cheana féin.',

    ],

    'requests' => [
        'error'   		=> 'Níor iarradh sócmhainn, déan iarracht arís',
        'success' 		=> 'D\'iarr sócmhainn go rathúil.',
        'canceled'      => 'Iarrtar ar iarraidh seiceáil go rathúil',
    ],

];

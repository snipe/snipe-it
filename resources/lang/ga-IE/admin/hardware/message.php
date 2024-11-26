<?php

return [

    'undeployable' 		 => '<strong>Warning: </strong> This asset has been marked as currently undeployable. If this status has changed, please update the asset status.',
    'does_not_exist' 	 => 'Níl sócmhainn ann.',
    'does_not_exist_var' => 'Asset with tag :asset_tag not found.',
    'no_tag' 	         => 'No asset tag provided.',
    'does_not_exist_or_not_requestable' => 'That asset does not exist or is not requestable.',
    'assoc_users'	 	 => 'Faoi láthair déanfar an tsócmhainn seo a sheiceáil chuig úsáideoir agus ní féidir é a scriosadh. Déan seiceáil ar an tsócmhainn sa chéad uair, agus déan iarracht ansin scriosadh arís.',
    'warning_audit_date_mismatch' 	=> 'This asset\'s next audit date (:next_audit_date) is before the last audit date (:last_audit_date). Please update the next audit date.',
    'labels_generated'   => 'Labels were successfully generated.',
    'error_generating_labels' => 'Error while generating labels.',
    'no_assets_selected' => 'No assets selected.',

    'create' => [
        'error'   		=> 'Níor cruthaíodh sócmhainn, déan iarracht arís. :(',
        'success' 		=> 'Cruthaíodh sócmhainn go rathúil. :)',
        'success_linked' => 'Asset with tag :tag was created successfully. <strong><a href=":link" style="color: white;">Click here to view</a></strong>.',
        'multi_success_linked' => 'Asset with tag :links was created successfully.|:count assets were created succesfully. :links.',
        'partial_failure' => 'An asset was unable to be created. Reason: :failures|:count assets were unable to be created. Reasons: :failures',
    ],

    'update' => [
        'error'   			=> 'Níor tugadh nuashonrú ar an tsócmhainn, déan iarracht arís',
        'success' 			=> 'Nuashonraíodh sócmhainn go rathúil',
        'encrypted_warning' => 'Asset updated successfully, but encrypted custom fields were not due to permissions',
        'nothing_updated'	=>  'Níor roghnaíodh réimsí ar bith, mar sin níor nuashonraíodh aon rud.',
        'no_assets_selected'  =>  'No assets were selected, so nothing was updated.',
        'assets_do_not_exist_or_are_invalid' => 'Selected assets cannot be updated.',
    ],

    'restore' => [
        'error'   		=> 'Níor cuireadh an tsócmhainn ar ais, déan iarracht arís',
        'success' 		=> 'Aisghabháil sócmhainne go rathúil.',
        'bulk_success' 		=> 'Aisghabháil sócmhainne go rathúil.',
        'nothing_updated'   => 'No assets were selected, so nothing was restored.', 
    ],

    'audit' => [
        'error'   		=> 'Asset audit unsuccessful: :error ',
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
        'import_button'         => 'Process Import',
        'error'                 => 'Níor iompórtáil roinnt míreanna i gceart.',
        'errorDetail'           => 'Níor allmhairíodh na Míreanna seo a leanas mar gheall ar earráidí.',
        'success'               => 'Tá do chomhad iompórtáilte',
        'file_delete_success'   => 'Tá do chomhad scriosta go rathúil',
        'file_delete_error'      => 'Níorbh fhéidir an comhad a scriosadh',
        'file_missing' => 'The file selected is missing',
        'file_already_deleted' => 'The file selected was already deleted',
        'header_row_has_malformed_characters' => 'One or more attributes in the header row contain malformed UTF-8 characters',
        'content_row_has_malformed_characters' => 'One or more attributes in the first row of content contain malformed UTF-8 characters',
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

    'multi-checkout' => [
        'error'   => 'Asset was not checked out, please try again|Assets were not checked out, please try again',
        'success' => 'Asset checked out successfully.|Assets checked out successfully.',
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

<?php

return [

    'undeployable' 		=> '<strong>Warning: </strong> Kua tohua tenei taonga i te mea kaore i te rongonui. Mena kua hurihia tenei mana, whakahouhia te mana o te taonga.',
    'does_not_exist' 	=> 'Kaore he tahua.',
    'does_not_exist_or_not_requestable' => 'That asset does not exist or is not requestable.',
    'assoc_users'	 	=> 'Kei te tirohia tenei taonga i tetahi kaiwhakamahi me te kore e taea te muku. Tirohia koa te taonga i te tuatahi, a ka ngana ki te muku ano.',

    'create' => [
        'error'   		=> 'Kaore i hangaia te tahua, tēnā whakamātau anō. :(',
        'success' 		=> 'Kua waihangatia te tahua. :)',
    ],

    'update' => [
        'error'   			=> 'Kāore i te whakahouhia te tahua, tēnā whakamātau anō',
        'success' 			=> 'Kua whakahoutia te tahua.',
        'nothing_updated'	=>  'Kaore i whiriwhiria he mahinga, na reira kaore i whakahoutia.',
        'no_assets_selected'  =>  'No assets were selected, so nothing was updated.',
    ],

    'restore' => [
        'error'   		=> 'Kaore i whakahokia mai te tahua, tena koa ngana ano',
        'success' 		=> 'Kua hokihia te tahua.',
        'bulk_success' 		=> 'Asset restored successfully.',
        'nothing_updated'   => 'No assets were selected, so nothing was restored.', 
    ],

    'audit' => [
        'error'   		=> 'Kaore i te angitu te arotake o te tahua. Tena ngana ano.',
        'success' 		=> 'Kua pai te takiuru o te kaute.',
    ],


    'deletefile' => [
        'error'   => 'Kāore te kōnae i mukua. Tena ngana ano.',
        'success' => 'Kua mukua te kōnae.',
    ],

    'upload' => [
        'error'   => 'Ko nga kōnae kāore i tukuna. Tena ngana ano.',
        'success' => 'Ko te (ngā) kōnae i tukuna paihia.',
        'nofiles' => 'Kaore i whiriwhiria e koe tetahi kōnae mo te tukuna, ko te kōnae e ngana ana koe ki te tuku he nui rawa',
        'invalidfiles' => 'Kotahi, nui atu ranei o ou kōnae he nui rawa atu, he waaahi ranei e kore e whakaaetia. Ko nga kōnae e whakaaetia ana he png, gif, jpg, doc, docx, pdf, me te txt.',
    ],

    'import' => [
        'error'                 => 'Kāore i tika te kawemai o etahi o nga mea.',
        'errorDetail'           => 'Ko nga mea e whai ake nei kihai i kawemai no te mea he hapa.',
        'success'               => 'I kawemai to kōnae',
        'file_delete_success'   => 'Kua mukua pai to kōnae',
        'file_delete_error'      => 'Kāore i taea te mukua te kōnae',
        'header_row_has_malformed_characters' => 'One or more attributes in the header row contain malformed UTF-8 characters',
        'content_row_has_malformed_characters' => 'One or more attributes in the first row of content contain malformed UTF-8 characters',
    ],


    'delete' => [
        'confirm'   	=> 'Kei te hiahia koe ki te muku i tenei taonga?',
        'error'   		=> 'He raru kei te whakakore i te taonga. Tena ngana ano.',
        'nothing_updated'   => 'Kaore he rawa i tohua, na reira kaore i whakakorehia.',
        'success' 		=> 'Kua mukua te taonga.',
    ],

    'checkout' => [
        'error'   		=> 'Kaore i teahia te taketake, me ngana ano',
        'success' 		=> 'Kua tohua te tahua.',
        'user_does_not_exist' => 'He muhu te kaiwhakamahi. Tena ngana ano.',
        'not_available' => 'Kaore i te wātea te taonga mo te takitaki!',
        'no_assets_selected' => 'You must select at least one asset from the list',
    ],

    'checkin' => [
        'error'   		=> 'Kaore i whakauruhia te taketake, me ngana ano',
        'success' 		=> 'Kua tohua te tahua.',
        'user_does_not_exist' => 'He muhu te kaiwhakamahi. Tena ngana ano.',
        'already_checked_in'  => 'Kua tohua taua taonga i roto i.',

    ],

    'requests' => [
        'error'   		=> 'Kāore i te tono te tahua, tēnā whakamātau anō',
        'success' 		=> 'I tono angitu te tahua.',
        'canceled'      => 'Kua whakakorea te manaakitia o te tono riihi',
    ],

];

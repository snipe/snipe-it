<?php

return [

    'undeployable' 		=> '<strong>Babala: </strong> Ang asset na ito ay kasalukuyang namarkahan bilang hindi pwedeng mai-deploy..
                        Kung nabago na ang katayuang ito, paki-update ng katayuan ng asset.',
    'does_not_exist' 	=> 'Hindi umiiral ang asset.',
    'does_not_exist_or_not_requestable' => 'That asset does not exist or is not requestable.',
    'assoc_users'	 	=> 'Ang asset na ito ay kasalukuyang nai-check out sa isang user at hindi na maaaring mai-delete. Mangyaring suriin muna ang asset, at pagkatapos subukang i-delete muli. ',

    'create' => [
        'error'   		=> 'Ang asset ay hindi naisagawa, mangyaring subukang muli. :(',
        'success' 		=> 'Ang asset ay matagumpay na naisagawa. :)',
    ],

    'update' => [
        'error'   			=> 'Ang asset ay hindi nai-update, mangyaring subukang muli',
        'success' 			=> 'Ang asset ay matagumpay na nai-update.',
        'nothing_updated'	=>  'Walang napiling mga fields, kaya walang nai-update.',
        'no_assets_selected'  =>  'No assets were selected, so nothing was updated.',
    ],

    'restore' => [
        'error'   		=> 'Ang asset ay hindi naibalik sa dati, mangyaring subukang muli',
        'success' 		=> 'Ang asset ay matagumpay nang naibalik sa dati.',
    ],

    'audit' => [
        'error'   		=> 'Ang audit ng asset ay hindi nagtagumpay. Mangyaring subukang muli.',
        'success' 		=> 'Matagumpay na nai-log ang audit ng asset.',
    ],


    'deletefile' => [
        'error'   => 'Ang file ay hindi nai-delete. Mangyaring subukang muli.',
        'success' => 'Ang file ay matagumpay nang nai-delete.',
    ],

    'upload' => [
        'error'   => 'Ang file(s) ay hindi nai-upload. Mangyaring subukang muli.',
        'success' => 'Ang file(s) ay matagumpay na nai-upload.',
        'nofiles' => 'Hindi ka pumili ng maga files para sa i-upload, o ang file na gusto mong i-upload ay masyadong malaki',
        'invalidfiles' => 'Ang isa o higit sa iyong mga file ay masyadong malaki o isang uri ng file na hindi pinapayagan. Ang mga pinapayagang mga file ay ang png, gif, jpg, doc, docx, pdf, at txt.',
    ],

    'import' => [
        'error'                 => 'Ang iilang mga aytem ay hindi nai-import ng tama.',
        'errorDetail'           => 'Ang mga sumusunod na mga Aytem ay hindi na-import dahil sa mga error.',
        'success'               => 'Ang iyong file ay na-import na',
        'file_delete_success'   => 'Ang iyong file ay matagumpay nang nai-upload',
        'file_delete_error'      => 'Ang file ay hindi mai-delete',
    ],


    'delete' => [
        'confirm'   	=> 'Sigurado kaba na gusto mong i-delete ang asset na ito?',
        'error'   		=> 'Mayroong isyu sa pag-delete ng asset. Mangyaring subukang muli.',
        'nothing_updated'   => 'Walang napiling mga asset, kaya walang nai-delete.',
        'success' 		=> 'Matagumpay na nai-delete ang asset.',
    ],

    'checkout' => [
        'error'   		=> 'Ang asset ay hindi nai-check out, mangyaring subukang muli',
        'success' 		=> 'Matagumpay na nai-check out ang asset.',
        'user_does_not_exist' => 'Ang user na iyon ay hindi balido. Mangyaring subukang muli.',
        'not_available' => 'Ang asset ay hindi pwedeng mai-checkout!',
        'no_assets_selected' => 'Dapat kang pumili ng kahit isang asset mula sa listahan',
    ],

    'checkin' => [
        'error'   		=> 'Ang asset ay hindi nai-check in, mangyaring subukang muli',
        'success' 		=> 'Ang asset ay matagumpay na nai-check in.',
        'user_does_not_exist' => 'Ang user na iyon ay hindi balido. Mangyaring subukang muli.',
        'already_checked_in'  => 'Ang asset ay nai-check in na.',

    ],

    'requests' => [
        'error'   		=> 'Ang asset ay hindi nai-rekwest, mangyaring subukang muli',
        'success' 		=> 'Matagumpay na nai-rekwest ang asset.',
        'canceled'      => 'Ang rekwest sa pag-checkout ay matagumpay na nakansela',
    ],

];

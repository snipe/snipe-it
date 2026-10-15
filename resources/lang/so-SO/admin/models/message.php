<?php

return [

    'deleted' => 'Waa la tiray qaabka hantida',
    'does_not_exist' => 'Qaabku ma jiro.',
    'no_association' => 'DIGNIIN! Qaabka hantida shaygan waa mid aan sax ahayn ama maqan!',
    'no_association_fix' => 'Tani waxay keeni doontaa in ashya\'du u jabaan si argagax badan oo la yaab leh. Wax ka bedel hantidan si aad Model uga dhigto.',
    'assoc_users' => 'Noocani wuxuu ku xiranyahay hal ra\'samaal ama wax kabadan suurgalna maahan in latiro. Fadlan tirtir hantida iskuna day markale inaad tirtirto. ',
    'invalid_category_type' => 'This category must be an asset category.',

    'create' => [
        'error' => 'Qaabka lama abuurin, fadlan isku day mar kale.',
        'success' => 'Qaabka si guul leh ayaa loo sameeyay.',
        'duplicate_set' => 'Nashqada hantida leh magacaas, soo saaraha iyo nambarka moodeelka ayaa horay u jirtay.',
    ],

    'update' => [
        'error' => 'Qaabka lama cusboonaysiin, fadlan isku day mar kale',
        'success' => 'Qaabka si guul leh ayaa loo cusboonaysiiyay.',
    ],

    'delete' => [
        'confirm' => 'Ma hubtaa inaad rabto inaad tirtirto qaabkan hantida?',
        'error' => 'Waxaa jirtay arrin tir-tireysay qaabka. Fadlan isku day mar kale.',
        'success' => 'Qaabka si guul leh ayaa loo tirtiray.',
    ],

    'restore' => [
        'error' => 'Qaabka lama soo celin, fadlan isku day mar kale',
        'success' => 'Qaabka si guul leh ayaa loo soo celiyay.',
    ],

    'bulkedit' => [
        'error' => 'Wax feilds ah lama beddelin, markaa waxba lama cusboonaysiin.',
        'success' => 'Qaabka si guul leh ayaa loo cusboonaysiiyay |:model_count moodaladana si guul leh ayaa loo cusboonaysiiyay.',
        'warn' => 'Waxaad ku dhowdahay inaad cusboonaysiiso sifooyinka qaabkan soo socda:|Waxaad ku dhowdahay inaad wax ka beddesho sifooyinka soo socda: model_count models:',

    ],

    'bulkdelete' => [
        'error' => 'Noocyo lama dooran, marka waxba lama tirtirin.',
        'nothing_deletable' => 'None of the selected models can be deleted because they still have assets associated with them.',
        'success' => 'Model waa la tirtiray!|:success_count moodallada ah waa la tirtiray!',
        'success_partial' => ':success_count moodeel(yaasha) waa la tirtiray, si kastaba ha ahaatee :fail_count waa la tirtiri waayay sababtoo ah wali waxay haystaan ​​hanti iyaga la xriirta.',
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

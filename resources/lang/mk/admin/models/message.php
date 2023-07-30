<?php

return array(

    'does_not_exist' => 'Моделот не постои.',
    'no_association' => 'NO MODEL ASSOCIATED.',
    'no_association_fix' => 'This will break things in weird and horrible ways. Edit this asset now to assign it a model.',
    'assoc_users'	 => 'Моделот во моментов е поврзан со едно или повеќе основни средства и не може да се избрише. Ве молиме избришете ги основните средствата, а потоа пробајте повторно да го избришете. ',


    'create' => array(
        'error'   => 'Моделот не е креиран, обидете се повторно.',
        'success' => 'Моделот е успешно креиран.',
        'duplicate_set' => 'Модел на основно средство со тоа име, производител и број на модел веќе постои.',
    ),

    'update' => array(
        'error'   => 'Моделот не е ажуриран, обидете се повторно',
        'success' => 'Моделот е ажуриран.',
    ),

    'delete' => array(
        'confirm'   => 'Дали сте сигурни дека сакате да го избришете моделот?',
        'error'   => 'Имаше проблем со бришење на моделот. Обидете се повторно.',
        'success' => 'Моделот е избришан.'
    ),

    'restore' => array(
        'error'   		=> 'Моделот не е вратен, обидете се повторно',
        'success' 		=> 'Моделот е вратен.'
    ),

    'bulkedit' => array(
        'error'   		=> 'Не беа сменети полиња, затоа ништо не беше ажурирано.',
        'success' 		=> 'Model successfully updated. |:model_count models successfully updated.',
        'warn'          => 'You are about to update the properies of the following model: |You are about to edit the properties of the following :model_count models:',

    ),

    'bulkdelete' => array(
        'error'   		    => 'Не беа избрани модели, затоа ништо не беше избришано.',
        'success' 		    => 'Model deleted!|:success_count models deleted!',
        'success_partial' 	=> ':success_count модел (и) се избришани, меѓутоа :fail_count не може да се избришат, бидејќи тие сè уште имаат средства поврзани со нив.'
    ),

);

<?php

return array(

    'does_not_exist' => 'Категорія не існує.',
    'assoc_models'	 => 'Наразі ця категорія пов\'язана хоча б з однією моделлю і не може бути видалена. Будь ласка, оновіть вашу модель, щоб більше не посилатись на цю категорію та повторіть спробу. ',
    'assoc_items'	 => 'Ця категорія пов\'язана хоча б з одним :asset_type і не може бути видалена. Будь ласка, оновіть ваш :asset_type щоб більше не посилатися на цю категорію і спробуйте ще раз. ',

    'create' => array(
        'error'   => 'Категорія не була створена, будь ласка, спробуйте ще раз.',
        'success' => 'Category created successfully.'
    ),

    'update' => array(
        'error'   => 'Category was not updated, please try again',
        'success' => 'Категорія успішно оновлена.',
        'cannot_change_category_type'   => 'You cannot change the category type once it has been created',
    ),

    'delete' => array(
        'confirm'   => 'Ви впевнені що бажаєте видалити цю категорію?',
        'error'   => 'There was an issue deleting the category. Please try again.',
        'success' => 'Категорія успішно видалена.'
    )

);

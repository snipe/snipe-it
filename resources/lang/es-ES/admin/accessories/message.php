<?php

return array(

    'does_not_exist' => 'El accesorio [:id] no existe.',
    'not_found' => 'Ese accesorio no fue encontrado.',
    'assoc_users'	 => 'Este accesorio actualmente tiene :count elemento(s) asignado(s) a usuarios. Por favor realice el ingreso de los accesorios y vuelva a intentar. ',

    'create' => array(
        'error'   => 'El accesorio no fue creado, por favor inténtelo de nuevo.',
        'success' => 'Accesorio creado correctamente.'
    ),

    'update' => array(
        'error'   => 'El accesorio no fue actualizado, por favor, inténtelo de nuevo',
        'success' => 'Accesorio actualizado correctamente.'
    ),

    'delete' => array(
        'confirm'   => '¿Está seguro de que desea eliminar este accesorio?',
        'error'   => 'Hubo un problema eliminando el accesorio. Por favor, inténtelo de nuevo.',
        'success' => 'El accesorio fue borrado con éxito.'
    ),

     'checkout' => array(
        'error'   		=> 'El accesorio no fue asignado, por favor vuelva a intentarlo',
        'success' 		=> 'Accesorio asignado correctamente.',
        'unavailable'   => 'El accesorio no está disponible para ser asignado. Compruebe la cantidad disponible',
        'user_does_not_exist' => 'Este usuario no es válido. Por favor, inténtelo de nuevo.',
         'checkout_qty' => array(
            'lte'  => 'There is currently only one available accessory of this type, and you are trying to check out :checkout_qty. Please adjust the checkout quantity or the total stock of this accessory and try again.|There are :number_currently_remaining total available accessories, and you are trying to check out :checkout_qty. Please adjust the checkout quantity or the total stock of this accessory and try again.',
            ),
           
    ),

    'checkin' => array(
        'error'   		=> 'El accesorio no fue recibido, por favor vuelva a intentarlo',
        'success' 		=> 'El accesorio ha sido ingresado correctamente.',
        'user_does_not_exist' => 'Ese usuario no es válido. Por favor, inténtelo de nuevo.'
    )


);

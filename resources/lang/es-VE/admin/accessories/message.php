<?php

return array(

    'does_not_exist' => 'El accesorio [:id] no existe.',
<<<<<<< HEAD
    'not_found' => 'Ese accesorio no fue encontrado.',
    'assoc_users'	 => 'Este accesorio actualmente tiene :count elemento(s) asignado(s) a usuarios. Por favor realice el ingreso de los accesorios y vuelva a intentar. ',

    'create' => array(
        'error'   => 'El accesorio no fue creado, por favor inténtelo de nuevo.',
=======
    'assoc_users'	 => 'El accesorio actual tiene :count elementos entregados a usuarios. Por favor ingresa los accesorios e intenta de nuevo. ',

    'create' => array(
        'error'   => 'El accesorio no se creó, inténtalo de nuevo.',
>>>>>>> 64747d0fb (updates based on review)
        'success' => 'El accesorio se ha creado con éxito.'
    ),

    'update' => array(
<<<<<<< HEAD
        'error'   => 'El accesorio no fue actualizado, por favor, inténtelo de nuevo',
=======
        'error'   => 'El accesorio no se actualizó, inténtalo de nuevo',
>>>>>>> 64747d0fb (updates based on review)
        'success' => 'El accesorio se ha actualizado con éxito.'
    ),

    'delete' => array(
<<<<<<< HEAD
        'confirm'   => '¿Está seguro de que desea eliminar este accesorio?',
        'error'   => 'Hubo un problema eliminando el accesorio. Por favor, inténtelo de nuevo.',
=======
        'confirm'   => '¿Estás seguro que deseas borrar este accesorio?',
        'error'   => 'Hubo un problema borrando este accesorio. Por favor inténtalo nuevamente.',
>>>>>>> 64747d0fb (updates based on review)
        'success' => 'El accesorio se ha borrado con éxito.'
    ),

     'checkout' => array(
<<<<<<< HEAD
        'error'   		=> 'El accesorio no fue asignado, por favor vuelva a intentarlo',
        'success' 		=> 'Accesorio asignado correctamente.',
        'unavailable'   => 'El accesorio no está disponible para ser asignado. Compruebe la cantidad disponible',
        'user_does_not_exist' => 'Este usuario no es válido. Por favor, inténtelo de nuevo.',
         'checkout_qty' => array(
            'lte'  => 'En este momento solo existe un accesorio disponible de este tipo y está tratando de asignar :checkout_qty. Por favor, ajuste la cantidad asignada o el total de existencias de este accesorio e intente nuevamente.|Existen en total :number_currently_remaining accesorios disponibles y está tratando de asignar :checkout_qty. Por favor, ajuste la cantidad asignada o el total de existencias de este accesorio e intente nuevamente.',
            ),
           
    ),

    'checkin' => array(
        'error'   		=> 'El accesorio no fue recibido, por favor vuelva a intentarlo',
        'success' 		=> 'El accesorio ha sido ingresado correctamente.',
        'user_does_not_exist' => 'Ese usuario no es válido. Por favor, inténtelo de nuevo.'
=======
        'error'   		=> 'Equipo no ha sido retirado, inténtalo de nuevo',
        'success' 		=> 'El accesorio se ha retirado exitosamente.',
        'user_does_not_exist' => 'Este usuario es inválido. Por favor, inténtalo de nuevo.'
    ),

    'checkin' => array(
        'error'   		=> 'El accesorio no fue ingresado, por favor inténtalo de nuevo',
        'success' 		=> 'El accesorio se ha ingresado con éxito.',
        'user_does_not_exist' => 'Este usuario es inválido. Por favor, inténtalo de nuevo.'
>>>>>>> 64747d0fb (updates based on review)
    )


);

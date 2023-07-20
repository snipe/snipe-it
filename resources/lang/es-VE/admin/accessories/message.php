<?php

return array(

    'does_not_exist' => 'El accesorio [:id] no existe.',
    'assoc_users'	 => 'El accesorio actual tiene :count elementos entregados a usuarios. Por favor ingresa los accesorios e intenta de nuevo. ',

    'create' => array(
        'error'   => 'El accesorio no se creó, inténtalo de nuevo.',
        'success' => 'El accesorio se ha creado con éxito.'
    ),

    'update' => array(
        'error'   => 'El accesorio no se actualizó, inténtalo de nuevo',
        'success' => 'El accesorio se ha actualizado con éxito.'
    ),

    'delete' => array(
        'confirm'   => '¿Estás seguro que deseas borrar este accesorio?',
        'error'   => 'Hubo un problema borrando este accesorio. Por favor inténtalo nuevamente.',
        'success' => 'El accesorio se ha borrado con éxito.'
    ),

     'checkout' => array(
        'error'   		=> 'Equipo no ha sido retirado, inténtalo de nuevo',
        'success' 		=> 'El accesorio se ha retirado exitosamente.',
        'unavailable'   => 'Accessory is not available for checkout. Check quantity available',
        'user_does_not_exist' => 'Este usuario es inválido. Por favor, inténtalo de nuevo.'
    ),

    'checkin' => array(
        'error'   		=> 'El accesorio no fue ingresado, por favor inténtalo de nuevo',
        'success' 		=> 'El accesorio se ha ingresado con éxito.',
        'user_does_not_exist' => 'Este usuario es inválido. Por favor, inténtalo de nuevo.'
    )


);

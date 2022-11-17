<?php

return array(

    'does_not_exist' => 'El consumible no existe.',

    'create' => array(
        'error'   => 'El consumible no fue creado, por favor, inténtalo de nuevo.',
        'success' => 'Consumible creado con éxito.'
    ),

    'update' => array(
        'error'   => 'Consumible no fue actualizado, por favor, inténtalo de nuevo',
        'success' => 'Consumible actualizado con éxito.'
    ),

    'delete' => array(
        'confirm'   => '¿Estás seguro de que quieres eliminar este consumible?',
        'error'   => 'Hubo un problema al eliminar este consumible. Por favor inténtalo de nuevo.',
        'success' => 'El consumible fue eliminado con éxito.'
    ),

     'checkout' => array(
        'error'   		=> 'El consumible no fue retirado, por favor, inténtalo de nuevo',
        'success' 		=> 'Consumible retirado con éxito.',
        'user_does_not_exist' => 'Este usuario es inválido. Por favor, inténtalo de nuevo.'
    ),

    'checkin' => array(
        'error'   		=> 'Consumible no fue registrado, por favor, inténtelo de nuevo',
        'success' 		=> 'Consumible fue registrado con éxito.',
        'user_does_not_exist' => 'El usuario no es válido. Por favor inténtalo de nuevo.'
    ),    

    'numeric'  => 'El número total debe ser numérico' ,
    'required' => 'El número total no puede estar vacío' ,
    'over'     => 'El número total prestado es mayor que el stock disponible',    
    'under' => 'Número total por debajo de la cantidad mínima aceptable',
    'not_in' => 'El número total prestado no puede ser cero',


);

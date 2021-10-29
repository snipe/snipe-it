<?php

return [

    'account_already_exists' => 'Ya existe un usuario con este e-mail.',
    'account_not_found'      => 'El nombre de usuario o contraseña es incorrecta.',
    'account_not_activated'  => 'Este usuario no está activado.',
    'account_suspended'      => 'Este usuario está desactivado.',
    'account_banned'         => 'Este usuario ha sido expulsado.',
    'throttle'               => 'Demasiados intentos fallidos de inicio de sesión. Por favor, inténtalo de nuevo en :minutes minutos.',

    'two_factor' => [
        'already_enrolled'      => 'Su dispositivo ya está inscrito.',
        'success'               => '¡Hola! Haz iniciado sesión correctamente.',
        'code_required'         => 'El código de dos factores es necesario.',
        'invalid_code'          => 'El código de dos factores no es válido.',
    ],

    'signin' => [
        'error'   => 'Ha habido un problema al iniciar sesión. Por favor, vuelve a intentarlo.',
        'success' => 'has iniciado sesión correctamente.',
    ],

    'logout' => [
        'error'   => 'Hubo un problema al intentar cerrar la sesión, por favor inténtelo de nuevo.',
        'success' => 'Se ha cerrado sesión correctamente.',
    ],

    'signup' => [
        'error'   => 'Ha habido un problema al crear la cuenta. Por favor, vuelve a intentarlo.',
        'success' => 'Cuenta creada correctamente.',
    ],

    'forgot-password' => [
        'error'   => 'Ha habido un problema al intentar resetear el password. Por favor, vuelve a intentarlo.',
        'success' => 'Si esa dirección de correo electrónico existe en nuestro sistema, se ha enviado un correo electrónico de recuperación de contraseña.',
    ],

    'forgot-password-confirm' => [
        'error'   => 'Ha habido un problema al intentar resetear el password. Por favor, vuelve a intentarlo.',
        'success' => 'El password ha sido reseteado correctamente.',
    ],

];

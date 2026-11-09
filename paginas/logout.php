<?php

// Cierre de sesión. No muestra nada: borra la sesión y vuelve al inicio con un aviso.

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/sesion.php';

// Si alguien entra acá sin estar logueado, simplemente lo mando al inicio.
if (usuarioLogueado() === null) {
    redirigir('/index.php');
}

// Vacío los datos y destruyo la sesión en el servidor.
$_SESSION = [];
session_destroy();

// Abro una sesión nueva (con otro ID) solamente para poder mostrar el mensaje flash.
// La cookie de "Recordarme" no se toca: es una preferencia del navegador, no de la sesión.
session_start();
session_regenerate_id(true);

guardarFlash('exito', 'Cerraste sesión. ¡Buen viaje, nos vemos en la próxima isla!');
redirigir('/index.php');

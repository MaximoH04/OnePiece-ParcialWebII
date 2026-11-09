<?php

// Configuración general del sitio.
//
// En la PC uso los datos de XAMPP que están acá abajo. En el hosting (InfinityFree)
// subo además un config.produccion.php con la URL y los datos de la base de allá.
// Ese archivo no va a GitHub porque tiene la contraseña de la base de datos
// (hay un modelo en config.produccion.ejemplo.php).
//
// Aunque el archivo esté en la PC, en localhost siempre uso XAMPP: la base de
// InfinityFree no acepta conexiones desde afuera del hosting.

$enLocalhost = in_array($_SERVER['SERVER_NAME'] ?? 'localhost', ['localhost', '127.0.0.1', '::1'], true);

if (!$enLocalhost && is_file(__DIR__ . '/config.produccion.php')) {
    require __DIR__ . '/config.produccion.php';
} else {
    define('BASE_URL', '/parcial-webII');

    define('DB_HOST', 'localhost');
    define('DB_USUARIO', 'root');
    define('DB_CLAVE', '');
    define('DB_NOMBRE', 'bitacora_pirata');
}

define('NOMBRE_SITIO', 'Bitácora Pirata');

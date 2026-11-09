<?php

// Modelo de configuración para el hosting.
// En InfinityFree: copiar este archivo como config.produccion.php (en la misma carpeta
// que config.php) y completar con los datos que da el panel en "MySQL Databases".

// Si el sitio se sube directo a htdocs queda en la raíz del dominio, entonces va vacío.
// Si se sube dentro de una carpeta, por ejemplo htdocs/parcial-webII, va '/parcial-webII'.
define('BASE_URL', '');

define('DB_HOST', 'sqlXXX.infinityfree.com');
define('DB_USUARIO', 'if0_XXXXXXXX');
define('DB_CLAVE', 'contraseña-de-la-cuenta-de-hosting');
define('DB_NOMBRE', 'if0_XXXXXXXX_bitacora');

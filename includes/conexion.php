<?php

// Conexión a MySQL con MySQLi. Es el único lugar del sitio donde me conecto:
// las páginas que necesitan la base hacen require_once de este archivo y usan $conexion.

require_once __DIR__ . '/../config.php';

// Con esto MySQLi tira una excepción ante cualquier error (conexión, consulta mal armada,
// clave duplicada...) en vez de devolver false en silencio.
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conexion = mysqli_connect(DB_HOST, DB_USUARIO, DB_CLAVE, DB_NOMBRE);

    // utf8mb4 para que las tildes y la ñ se guarden y se lean bien.
    mysqli_set_charset($conexion, 'utf8mb4');
} catch (mysqli_sql_exception $e) {
    // El detalle técnico va al log del servidor; al visitante no le muestro
    // datos de la base, solamente un aviso.
    error_log('Error de conexión a MySQL: ' . $e->getMessage());
    http_response_code(500);
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Sin conexión | <?= NOMBRE_SITIO ?></title>
        <link rel="stylesheet" href="<?= BASE_URL ?>/css/estilos.css">
    </head>
    <body>
    <main>
        <div class="caja error">
            <h1>No hay conexión con la base de datos</h1>
            <p>El barco está en reparación. Probá de nuevo en unos minutos.</p>
            <a class="boton" href="<?= BASE_URL ?>/index.php">Volver al inicio</a>
        </div>
    </main>
    </body>
    </html>
    <?php
    exit;
}

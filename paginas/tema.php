<?php

// Recibe el botón de tema claro/oscuro del menú, guarda la elección en una cookie
// por un año y vuelve a la página donde estaba el visitante.

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/sesion.php';
require_once __DIR__ . '/../includes/cookies.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirigir('/index.php');
}

$tema = trim($_POST['tema'] ?? '');

// Solo guardo valores conocidos; cualquier otra cosa se ignora.
if (in_array($tema, TEMAS_VALIDOS, true)) {
    guardarCookie(COOKIE_TEMA, $tema, 365);
}

// "volver" trae la dirección de la página donde se tocó el botón.
// Solamente acepto direcciones de este mismo sitio, para que nadie pueda usar
// esta página para mandar a un visitante a otro dominio.
$volver = $_POST['volver'] ?? '';
$esDireccionInterna = is_string($volver)
    && str_starts_with($volver, BASE_URL . '/')
    && !str_starts_with($volver, '//')
    && !str_contains($volver, '\\');

if (!$esDireccionInterna) {
    $volver = BASE_URL . '/index.php';
}

header('Location: ' . $volver);
exit;

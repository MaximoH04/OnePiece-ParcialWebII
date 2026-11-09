<?php

// Encabezado del sitio: <head>, logo, menú y mensajes flash. Se incluye en todas las páginas.
// Cada página define su $titulo antes de incluir esto.

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/sesion.php';
require_once __DIR__ . '/../includes/cookies.php';

if (!isset($titulo)) {
    $titulo = NOMBRE_SITIO;
}

// El tema sale de la cookie y se aplica como clase del <body>.
$tema = temaActual();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($titulo) ?></title>
    <link rel="icon" href="<?= BASE_URL ?>/img/bandera-piratas.jpg">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/estilos.css">
</head>
<body class="tema-<?= $tema ?>">

<header class="encabezado">
    <a class="marca" href="<?= BASE_URL ?>/index.php">
        <img src="<?= BASE_URL ?>/img/bandera-piratas.jpg" alt="Bandera de los Sombrero de Paja">
        <span>
            <strong><?= NOMBRE_SITIO ?></strong>
            <small>Sitio de fans de One Piece</small>
        </span>
    </a>

    <?php require_once __DIR__ . '/nav.php'; ?>
</header>

<main>

<?php foreach (tomarFlash() as $flash): ?>
    <?php
    // El tipo lo uso como clase del CSS, así que solo acepto los que existen.
    $tipoFlash = in_array($flash['tipo'], ['exito', 'error', 'atencion'], true) ? $flash['tipo'] : 'atencion';
    ?>
    <div class="flash <?= $tipoFlash ?>" role="status">
        <?= htmlspecialchars($flash['texto']) ?>
    </div>
<?php endforeach; ?>

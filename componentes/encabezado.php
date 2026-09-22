<?php

// Encabezado y menú. Se incluye en todas las páginas.
require_once __DIR__ . '/../config.php';

// Cada página define su $titulo antes de incluir esto.
if (!isset($titulo)) {
    $titulo = NOMBRE_SITIO;
}

// Lo uso para pintar el link de la página en la que estoy parado.
$paginaActual = basename($_SERVER['PHP_SELF']);

$menu = [
    'index.php'       => 'Inicio',
    'tripulacion.php' => 'Tripulación',
    'sagas.php'       => 'Sagas',
    'contacto.php'    => 'Contacto',
];

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
<body>

<header class="encabezado">
    <a class="marca" href="<?= BASE_URL ?>/index.php">
        <img src="<?= BASE_URL ?>/img/bandera-piratas.jpg" alt="Bandera de los Sombrero de Paja">
        <span>
            <strong><?= NOMBRE_SITIO ?></strong>
            <small>Sitio de fans de One Piece</small>
        </span>
    </a>

    <nav class="menu">
        <ul>
            <?php foreach ($menu as $archivo => $texto): ?>
                <?php
                // index.php está en la raíz, las demás páginas cuelgan de /paginas
                $enlace = ($archivo === 'index.php')
                    ? BASE_URL . '/index.php'
                    : BASE_URL . '/paginas/' . $archivo;
                ?>
                <li>
                    <a href="<?= $enlace ?>"<?php if ($archivo === $paginaActual) echo ' class="activo"'; ?>>
                        <?= htmlspecialchars($texto) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
</header>

<main>

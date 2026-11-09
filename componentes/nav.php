<?php

// Menú principal. Cambia según haya o no una sesión iniciada:
// - visitante: links para ingresar y registrarse
// - usuario logueado: saludo, "Mi camarote" y "Salir"
// Además tiene el botón para cambiar entre tema claro y oscuro (se guarda en una cookie).

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/sesion.php';
require_once __DIR__ . '/../includes/cookies.php';

// Lo uso para pintar el link de la página en la que estoy parado.
$paginaActual = basename($_SERVER['PHP_SELF']);
$usuarioNav   = usuarioLogueado();

$menu = [
    'index.php'       => 'Inicio',
    'tripulacion.php' => 'Tripulación',
    'sagas.php'       => 'Sagas',
    'contacto.php'    => 'Contacto',
];

if ($usuarioNav === null) {
    $menuCuenta = [
        'login.php'    => 'Ingresar',
        'registro.php' => 'Registrarse',
    ];
} else {
    $menuCuenta = [
        'perfil.php' => 'Mi camarote',
        'logout.php' => 'Salir',
    ];
}

// El botón ofrece siempre el tema contrario al que está puesto.
$temaContrario = (temaActual() === 'oscuro') ? 'claro' : 'oscuro';
$textoTema     = ($temaContrario === 'oscuro') ? 'Modo oscuro' : 'Modo claro';

/**
 * index.php está en la raíz, las demás páginas cuelgan de /paginas.
 */
function enlaceMenu(string $archivo): string
{
    return ($archivo === 'index.php')
        ? BASE_URL . '/index.php'
        : BASE_URL . '/paginas/' . $archivo;
}

?>
<nav class="menu">
    <ul>
        <?php foreach ($menu as $archivo => $texto): ?>
            <li>
                <a href="<?= enlaceMenu($archivo) ?>"<?php if ($archivo === $paginaActual) echo ' class="activo"'; ?>>
                    <?= htmlspecialchars($texto) ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

    <ul class="menu-cuenta">
        <?php if ($usuarioNav !== null): ?>
            <li class="saludo">Hola, <?= htmlspecialchars($usuarioNav['usuario']) ?></li>
        <?php endif; ?>

        <?php foreach ($menuCuenta as $archivo => $texto): ?>
            <li>
                <a href="<?= enlaceMenu($archivo) ?>"<?php if ($archivo === $paginaActual) echo ' class="activo"'; ?>>
                    <?= htmlspecialchars($texto) ?>
                </a>
            </li>
        <?php endforeach; ?>

        <li>
            <form method="POST" action="<?= BASE_URL ?>/paginas/tema.php">
                <input type="hidden" name="tema" value="<?= $temaContrario ?>">
                <input type="hidden" name="volver" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
                <button class="boton-tema" type="submit"><?= $textoTema ?></button>
            </form>
        </li>
    </ul>
</nav>

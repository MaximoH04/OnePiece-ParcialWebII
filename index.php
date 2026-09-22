<?php

// Portada. El tablero de recompensas lo armo recorriendo el array de datos/piratas.php.

require_once __DIR__ . '/config.php';

$titulo = 'Inicio | ' . NOMBRE_SITIO;
$piratas = require __DIR__ . '/datos/piratas.php';

require_once __DIR__ . '/componentes/encabezado.php';
?>

<section class="portada">
    <img class="portada-imagen" src="<?= BASE_URL ?>/img/portada-one-piece.jpg"
         alt="Los Sombrero de Paja navegando en el Thousand Sunny">

    <div class="portada-texto">
        <img class="portada-logo" src="<?= BASE_URL ?>/img/logo-one-piece.svg" alt="Logo de One Piece">
        <h1>Rumbo a la Grand Line</h1>
        <p>
            Seguimos el viaje de los Sombrero de Paja desde que Luffy salió de Foosha.
            Fichas de la tripulación, las sagas más importantes y el tablero de recompensas
            siempre actualizado.
        </p>
        <a class="boton" href="<?= BASE_URL ?>/paginas/tripulacion.php">Ver la tripulación</a>
    </div>
</section>

<section class="seccion">
    <h2>Tablero de recompensas</h2>
    <p class="bajada">
        Últimos carteles emitidos por el Gobierno Mundial. Los que están marcados como destacados
        son los que la Marina persigue con prioridad.
    </p>

    <div class="tarjetas">
        <?php foreach ($piratas as $pirata): ?>
            <?php
            // Si el pirata está destacado le sumo una clase más a la tarjeta.
            $clases = 'tarjeta';
            if ($pirata['destacado']) {
                $clases .= ' destacada';
            }

            // Y el cartelito de arriba cambia según si la recompensa sigue activa o no.
            $textoEtiqueta = ($pirata['estado'] === 'activa') ? 'Recompensa activa' : 'Capturado';
            $claseEtiqueta = ($pirata['estado'] === 'activa') ? 'etiqueta' : 'etiqueta gris';
            ?>
            <article class="<?= $clases ?>">
                <img src="<?= BASE_URL ?>/img/<?= htmlspecialchars($pirata['imagen']) ?>"
                     alt="<?= htmlspecialchars($pirata['titulo']) ?>">

                <div class="tarjeta-datos">
                    <span class="<?= $claseEtiqueta ?>"><?= $textoEtiqueta ?></span>
                    <h3><?= htmlspecialchars($pirata['titulo']) ?></h3>
                    <p class="puesto"><?= htmlspecialchars($pirata['puesto']) ?></p>
                    <p class="descripcion"><?= htmlspecialchars($pirata['descripcion']) ?></p>
                    <p class="recompensa"><?= htmlspecialchars($pirata['recompensa']) ?> berries</p>

                    <?php if ($pirata['destacado']): ?>
                        <p class="prioridad">Prioridad máxima de la Marina</p>
                    <?php endif; ?>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<section class="seccion invitacion">
    <h2>¿Tenés algo para aportar?</h2>
    <p>
        Si encontraste un dato nuevo, se nos escapó un error o querés sugerir una ficha,
        escribinos desde el formulario.
    </p>
    <a class="boton azul" href="<?= BASE_URL ?>/paginas/contacto.php">Ir al formulario</a>
</section>

<?php require_once __DIR__ . '/componentes/pie.php'; ?>

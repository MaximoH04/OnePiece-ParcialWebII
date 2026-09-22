<?php

require_once __DIR__ . '/../config.php';

$titulo = 'Tripulación | ' . NOMBRE_SITIO;

// Reutilizo el mismo array que la portada, pero lo muestro en fichas grandes.
$tripulacion = require __DIR__ . '/../datos/piratas.php';

require_once __DIR__ . '/../componentes/encabezado.php';
?>

<section class="seccion">
    <h1>Los Sombrero de Paja</h1>
    <p class="bajada">
        Cada uno se subió al barco por un sueño propio. Estas son las fichas de los que hoy
        tienen cartel de recompensa publicado.
    </p>

    <?php foreach ($tripulacion as $tripulante): ?>
        <article class="ficha">
            <figure>
                <img src="<?= BASE_URL ?>/img/<?= htmlspecialchars($tripulante['imagen']) ?>"
                     alt="<?= htmlspecialchars($tripulante['titulo']) ?>">
                <figcaption><?= htmlspecialchars($tripulante['recompensa']) ?> berries</figcaption>
            </figure>

            <div>
                <h2><?= htmlspecialchars($tripulante['titulo']) ?></h2>
                <p class="puesto"><?= htmlspecialchars($tripulante['puesto']) ?></p>
                <p><?= htmlspecialchars($tripulante['descripcion']) ?></p>
                <p class="dato">
                    Cartel:
                    <?= ($tripulante['estado'] === 'activa') ? 'búsqueda vigente' : 'estuvo capturado alguna vez' ?>
                </p>
            </div>
        </article>
    <?php endforeach; ?>
</section>

<section class="seccion">
    <h2>Por qué se arma así una tripulación</h2>
    <div class="texto">
        <p>
            En One Piece ningún capitán navega solo, y no es un detalle: la serie va sumando gente
            por rol. Primero un espadachín, después una navegante, y así hasta completar todo lo que
            un barco necesita para cruzar la Grand Line.
        </p>
        <p>
            Por eso cada personaje entra con un problema propio que resolver. El cocinero se ocupa de
            que no falte comida en meses de viaje, el médico mantiene en pie a la tripulación y la
            arqueóloga es la única que puede leer la historia que el Gobierno Mundial quiere tapar.
        </p>
    </div>
</section>

<?php require_once __DIR__ . '/../componentes/pie.php'; ?>

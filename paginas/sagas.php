<?php

require_once __DIR__ . '/../config.php';

$titulo = 'Sagas | ' . NOMBRE_SITIO;
$sagas = require __DIR__ . '/../datos/sagas.php';

require_once __DIR__ . '/../componentes/encabezado.php';
?>

<section class="seccion">
    <h1>Sagas imperdibles</h1>
    <p class="bajada">
        Cuatro etapas que marcaron el rumbo de la historia, desde que Luffy zarpa de Foosha
        hasta la pelea por el país de Wano.
    </p>

    <div class="sagas">
        <?php foreach ($sagas as $saga): ?>
            <article class="saga">
                <img src="<?= BASE_URL ?>/img/<?= htmlspecialchars($saga['imagen']) ?>"
                     alt="Saga de <?= htmlspecialchars($saga['nombre']) ?>">
                <div class="saga-texto">
                    <h2><?= htmlspecialchars($saga['nombre']) ?></h2>
                    <p class="episodios"><?= htmlspecialchars($saga['episodios']) ?></p>
                    <p><?= htmlspecialchars($saga['descripcion']) ?></p>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<?php require_once __DIR__ . '/../componentes/pie.php'; ?>

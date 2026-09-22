<?php

// Pie de página. Acá cierro el <main> que abrí en el encabezado.
require_once __DIR__ . '/../config.php';

?>
</main>

<footer class="pie">
    <div class="pie-columnas">
        <div>
            <h3><?= NOMBRE_SITIO ?></h3>
            <p>
                Sitio de fans de One Piece. Acá junto los carteles de recompensa,
                las fichas de la tripulación y un repaso de las sagas que más me gustaron.
            </p>
        </div>

        <div>
            <h3>Secciones</h3>
            <ul>
                <li><a href="<?= BASE_URL ?>/index.php">Inicio</a></li>
                <li><a href="<?= BASE_URL ?>/paginas/tripulacion.php">Tripulación</a></li>
                <li><a href="<?= BASE_URL ?>/paginas/sagas.php">Sagas</a></li>
                <li><a href="<?= BASE_URL ?>/paginas/contacto.php">Contacto</a></li>
            </ul>
        </div>
    </div>
</footer>

</body>
</html>

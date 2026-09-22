<?php

// Formulario de contacto. Manda todo por POST a confirmacion.php, que es la página
// que valida. Los required y el type="email" son la primera barrera, pero se pueden
// saltear desde el navegador, así que del otro lado vuelvo a revisar todo.

require_once __DIR__ . '/../config.php';

$titulo = 'Contacto | ' . NOMBRE_SITIO;
$motivos = require __DIR__ . '/../datos/motivos.php';

// Cuando confirmacion.php encuentra errores manda de vuelta acá con los datos en la URL.
// Los leo para volver a cargar el formulario y que no haya que escribir todo de nuevo.
$nombre        = htmlspecialchars($_GET['nombre'] ?? '');
$apellido      = htmlspecialchars($_GET['apellido'] ?? '');
$email         = htmlspecialchars($_GET['email'] ?? '');
$mensaje       = htmlspecialchars($_GET['mensaje'] ?? '');
$motivoElegido = $_GET['motivo'] ?? '';

require_once __DIR__ . '/../componentes/encabezado.php';
?>

<section class="seccion">
    <h1>Contacto</h1>
    <p class="bajada">Completá el formulario y te respondemos por mail. Son todos campos obligatorios.</p>

    <form class="formulario" method="POST" action="<?= BASE_URL ?>/paginas/confirmacion.php">

        <div class="fila">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" value="<?= $nombre ?>"
                       minlength="2" maxlength="40" placeholder="Monkey" required>
            </div>

            <div class="campo">
                <label for="apellido">Apellido</label>
                <input type="text" id="apellido" name="apellido" value="<?= $apellido ?>"
                       minlength="2" maxlength="40" placeholder="D. Luffy" required>
            </div>
        </div>

        <div class="campo">
            <label for="email">Mail</label>
            <input type="email" id="email" name="email" value="<?= $email ?>"
                   placeholder="nombre@ejemplo.com" required>
        </div>

        <div class="campo">
            <label for="motivo">Motivo</label>
            <select id="motivo" name="motivo" required>
                <option value="" disabled <?= ($motivoElegido === '') ? 'selected' : '' ?>>Seleccioná un motivo</option>
                <?php foreach ($motivos as $valor => $motivo): ?>
                    <option value="<?= $valor ?>" <?= ($motivoElegido === $valor) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($motivo['etiqueta']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="campo">
            <label for="mensaje">Mensaje</label>
            <textarea id="mensaje" name="mensaje" rows="6" maxlength="600"
                      placeholder="Contanos en qué podemos ayudarte" required><?= $mensaje ?></textarea>
        </div>

        <button class="boton" type="submit">Enviar consulta</button>
    </form>
</section>

<?php require_once __DIR__ . '/../componentes/pie.php'; ?>

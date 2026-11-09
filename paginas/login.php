<?php

// Inicio de sesión. Se puede entrar con el nombre de usuario o con el mail.
// Si se marca "Recordarme" guardo en una cookie lo que escribió en ese campo,
// para que la próxima vez el formulario ya aparezca completo.

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/sesion.php';
require_once __DIR__ . '/../includes/cookies.php';

requerirInvitado();

$titulo = 'Iniciar sesión | ' . NOMBRE_SITIO;

// Si hay cookie de "Recordarme" arranco el formulario con ese usuario cargado.
$acceso    = usuarioRecordado();
$recordar  = ($acceso !== '');
$errores   = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $acceso   = trim($_POST['acceso'] ?? '');
    $clave    = $_POST['clave'] ?? '';
    $recordar = isset($_POST['recordarme']);

    if (empty($acceso)) {
        $errores[] = 'Escribí tu usuario o tu mail.';
    }
    if (empty(trim($clave))) {
        $errores[] = 'Escribí tu contraseña.';
    }

    if (empty($errores)) {
        require_once __DIR__ . '/../includes/conexion.php';

        // Busco por usuario o por mail con una consulta preparada.
        $sql = 'SELECT id, nombre, usuario, email, password, rol
                FROM usuarios
                WHERE usuario = ? OR email = ?
                LIMIT 1';
        $consulta = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($consulta, 'ss', $acceso, $acceso);
        mysqli_stmt_execute($consulta);
        $resultado = mysqli_stmt_get_result($consulta);
        $fila = mysqli_fetch_assoc($resultado);
        mysqli_stmt_close($consulta);

        // password_verify compara lo que escribió con el hash guardado en la base.
        if ($fila && password_verify($clave, $fila['password'])) {

            // Nuevo ID de sesión al loguearse, para que nadie pueda reutilizar
            // un ID viejo (fijación de sesión).
            session_regenerate_id(true);

            // En la sesión guardo lo mínimo para la navegación. La contraseña nunca.
            $_SESSION['usuario'] = [
                'id'      => (int) $fila['id'],
                'nombre'  => $fila['nombre'],
                'usuario' => $fila['usuario'],
                'rol'     => $fila['rol'],
            ];

            // Cookie de "Recordarme": 30 días. Si no la marcó, borro la que hubiera.
            if ($recordar) {
                guardarCookie(COOKIE_RECORDAR, $acceso, 30);
            } else {
                borrarCookie(COOKIE_RECORDAR);
            }

            guardarFlash('exito', '¡Bienvenido a bordo, ' . $fila['nombre'] . '!');
            redirigir('/paginas/perfil.php');
        }

        // Mismo mensaje si no existe el usuario o si la clave está mal:
        // así no se puede averiguar qué usuarios están registrados.
        $errores[] = 'El usuario o la contraseña no son correctos.';
    }
}

require_once __DIR__ . '/../componentes/encabezado.php';
?>

<section class="seccion">
    <h1>Iniciar sesión</h1>
    <p class="bajada">Entrá con tu usuario o con el mail con el que te registraste.</p>

    <?php if (!empty($errores)): ?>
        <div class="caja error">
            <h2>No pudimos iniciar sesión</h2>
            <ul>
                <?php foreach ($errores as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form class="formulario formulario-chico" method="POST" action="<?= BASE_URL ?>/paginas/login.php" novalidate>

        <div class="campo">
            <label for="acceso">Usuario o mail</label>
            <input type="text" id="acceso" name="acceso" value="<?= htmlspecialchars($acceso) ?>"
                   maxlength="120" placeholder="luffy" autocomplete="username" required>
        </div>

        <div class="campo">
            <label for="clave">Contraseña</label>
            <input type="password" id="clave" name="clave" autocomplete="current-password" required>
        </div>

        <label class="casilla">
            <input type="checkbox" name="recordarme" value="1" <?= $recordar ? 'checked' : '' ?>>
            Recordarme en este navegador
        </label>

        <button class="boton" type="submit">Ingresar</button>

        <p class="pie-formulario">
            ¿Todavía no tenés cuenta? <a href="<?= BASE_URL ?>/paginas/registro.php">Registrate</a>
        </p>
    </form>
</section>

<?php require_once __DIR__ . '/../componentes/pie.php'; ?>

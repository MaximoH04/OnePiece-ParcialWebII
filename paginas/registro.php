<?php

// Registro de usuarios. El formulario se manda a esta misma página:
// si hay errores se vuelve a mostrar con lo que ya estaba escrito,
// y si está todo bien se inserta el usuario y se redirige al login.

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/sesion.php';

// Si ya inició sesión no tiene sentido registrarse de nuevo.
requerirInvitado();

$titulo = 'Registro | ' . NOMBRE_SITIO;

// Arranco todo vacío para que las variables existan aunque no haya POST.
$nombre  = '';
$usuario = '';
$email   = '';
$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Guardo los datos "limpios" (sin espacios de más) pero sin escapar:
    // a la base van tal cual, y htmlspecialchars() lo aplico recién al mostrarlos.
    $nombre  = trim($_POST['nombre'] ?? '');
    $usuario = trim($_POST['usuario'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $clave   = $_POST['clave'] ?? '';
    $clave2  = $_POST['clave2'] ?? '';

    // ---------- validaciones en el servidor ----------

    if (empty($nombre)) {
        $errores[] = 'Te falta completar el nombre.';
    } elseif (mb_strlen($nombre) < 3 || mb_strlen($nombre) > 60) {
        $errores[] = 'El nombre tiene que tener entre 3 y 60 caracteres.';
    }

    // Solo letras sin tilde, números y guion bajo, para que el usuario sea fácil de tipear.
    if (empty($usuario)) {
        $errores[] = 'Te falta elegir un nombre de usuario.';
    } elseif (!preg_match('/^[a-zA-Z0-9_]{3,30}$/', $usuario)) {
        $errores[] = 'El usuario tiene que tener entre 3 y 30 caracteres: letras, números o guion bajo.';
    }

    if (empty($email)) {
        $errores[] = 'Te falta completar el mail.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 120) {
        $errores[] = 'Ese mail no tiene un formato válido (tiene que ser algo como nombre@ejemplo.com).';
    }

    // La contraseña no la recorto con trim(): un espacio puede ser parte de la clave.
    // Lo que sí controlo es que no sea puro espacio en blanco.
    if (empty(trim($clave))) {
        $errores[] = 'Te falta elegir una contraseña.';
    } elseif (mb_strlen($clave) < 8) {
        $errores[] = 'La contraseña tiene que tener al menos 8 caracteres.';
    } elseif (!preg_match('/[A-Za-z]/', $clave) || !preg_match('/[0-9]/', $clave)) {
        $errores[] = 'La contraseña tiene que tener al menos una letra y un número.';
    } elseif ($clave !== $clave2) {
        $errores[] = 'Las dos contraseñas no coinciden.';
    }

    // ---------- usuario o mail repetidos ----------

    // Recién consulto la base si los datos tienen buena forma.
    // Consulta preparada: los ? se completan con bind_param, nunca concateno lo que escribió el usuario.
    if (empty($errores)) {
        require_once __DIR__ . '/../includes/conexion.php';

        $sql = 'SELECT usuario, email FROM usuarios WHERE usuario = ? OR email = ?';
        $consulta = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($consulta, 'ss', $usuario, $email);
        mysqli_stmt_execute($consulta);
        $resultado = mysqli_stmt_get_result($consulta);

        // Puede venir más de una fila (uno con el mismo usuario y otro con el mismo mail).
        // Comparo en minúsculas porque MySQL tampoco distingue mayúsculas en estas columnas.
        while ($fila = mysqli_fetch_assoc($resultado)) {
            if (mb_strtolower($fila['usuario']) === mb_strtolower($usuario)) {
                $errores[] = 'El usuario "' . $usuario . '" ya está tomado. Probá con otro.';
            }
            if (mb_strtolower($fila['email']) === mb_strtolower($email)) {
                $errores[] = 'Ya hay una cuenta registrada con ese mail.';
            }
        }

        mysqli_stmt_close($consulta);
    }

    // ---------- alta ----------

    if (empty($errores)) {
        // Nunca guardo la contraseña tal cual: password_hash() la convierte en un hash
        // que después se compara con password_verify() en el login.
        $hash = password_hash($clave, PASSWORD_DEFAULT);

        $sql = 'INSERT INTO usuarios (nombre, usuario, email, password) VALUES (?, ?, ?, ?)';
        $consulta = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($consulta, 'ssss', $nombre, $usuario, $email, $hash);

        try {
            mysqli_stmt_execute($consulta);
            mysqli_stmt_close($consulta);

            guardarFlash('exito', '¡Bienvenido a la tripulación, ' . $nombre . '! Tu cuenta quedó creada, ya podés iniciar sesión.');
            redirigir('/paginas/login.php');
        } catch (mysqli_sql_exception $e) {
            // 1062 = clave única duplicada. Pasa si dos personas se registran
            // con el mismo usuario o mail casi al mismo tiempo.
            if ($e->getCode() === 1062) {
                $errores[] = 'Ese usuario o mail se acaba de registrar. Probá con otro.';
            } else {
                error_log('Error al registrar usuario: ' . $e->getMessage());
                $errores[] = 'No pudimos crear la cuenta por un problema del servidor. Probá de nuevo más tarde.';
            }
        }
    }
}

require_once __DIR__ . '/../componentes/encabezado.php';
?>

<section class="seccion">
    <h1>Sumate a la tripulación</h1>
    <p class="bajada">
        Creá tu cuenta para tener tu propio camarote en la Bitácora. Todos los campos son obligatorios.
    </p>

    <?php if (!empty($errores)): ?>
        <div class="caja error">
            <h2>No pudimos crear la cuenta</h2>
            <p>Revisá esto y probá de nuevo:</p>
            <ul>
                <?php foreach ($errores as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form class="formulario formulario-chico" method="POST" action="<?= BASE_URL ?>/paginas/registro.php" novalidate>

        <div class="campo">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($nombre) ?>"
                   minlength="3" maxlength="60" placeholder="Monkey D. Luffy" autocomplete="name" required>
        </div>

        <div class="campo">
            <label for="usuario">Usuario</label>
            <input type="text" id="usuario" name="usuario" value="<?= htmlspecialchars($usuario) ?>"
                   minlength="3" maxlength="30" pattern="[A-Za-z0-9_]{3,30}" placeholder="luffy"
                   autocomplete="username" required>
            <small class="ayuda">Entre 3 y 30 caracteres: letras, números o guion bajo.</small>
        </div>

        <div class="campo">
            <label for="email">Mail</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>"
                   maxlength="120" placeholder="nombre@ejemplo.com" autocomplete="email" required>
        </div>

        <div class="fila">
            <div class="campo">
                <label for="clave">Contraseña</label>
                <input type="password" id="clave" name="clave" minlength="8"
                       autocomplete="new-password" required>
            </div>

            <div class="campo">
                <label for="clave2">Repetir contraseña</label>
                <input type="password" id="clave2" name="clave2" minlength="8"
                       autocomplete="new-password" required>
            </div>
        </div>
        <small class="ayuda">Mínimo 8 caracteres, con al menos una letra y un número.</small>

        <button class="boton" type="submit">Crear cuenta</button>

        <p class="pie-formulario">
            ¿Ya tenés cuenta? <a href="<?= BASE_URL ?>/paginas/login.php">Iniciá sesión</a>
        </p>
    </form>
</section>

<?php require_once __DIR__ . '/../componentes/pie.php'; ?>

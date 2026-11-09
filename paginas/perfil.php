<?php

// "Mi camarote": página privada, solo para usuarios logueados.
// Los datos los vuelvo a leer de la base por el id guardado en la sesión.

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/sesion.php';
require_once __DIR__ . '/../includes/cookies.php';

requerirLogin();

require_once __DIR__ . '/../includes/conexion.php';

$idUsuario = usuarioLogueado()['id'];

$sql = 'SELECT nombre, usuario, email, rol, fecha_alta FROM usuarios WHERE id = ?';
$consulta = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($consulta, 'i', $idUsuario);
mysqli_stmt_execute($consulta);
$resultado = mysqli_stmt_get_result($consulta);
$perfil = mysqli_fetch_assoc($resultado);
mysqli_stmt_close($consulta);

// Si la cuenta ya no existe en la base (la borraron), la sesión no sirve más.
if (!$perfil) {
    $_SESSION = [];
    session_regenerate_id(true);
    guardarFlash('error', 'Tu cuenta ya no existe. Si querés, podés registrarte de nuevo.');
    redirigir('/paginas/login.php');
}

$fechaAlta = date('d/m/Y', strtotime($perfil['fecha_alta']));
$rolTexto  = ($perfil['rol'] === 'admin') ? 'Capitán (administrador)' : 'Tripulante';
$recordado = usuarioRecordado();

$titulo = 'Mi camarote | ' . NOMBRE_SITIO;

require_once __DIR__ . '/../componentes/encabezado.php';
?>

<section class="seccion">
    <h1>Mi camarote</h1>
    <p class="bajada">
        Hola, <?= htmlspecialchars($perfil['nombre']) ?>. Estos son los datos de tu cuenta
        y las preferencias que guardó este navegador.
    </p>

    <h2>Datos de la cuenta</h2>
    <dl class="resumen">
        <dt>Nombre</dt>
        <dd><?= htmlspecialchars($perfil['nombre']) ?></dd>

        <dt>Usuario</dt>
        <dd><?= htmlspecialchars($perfil['usuario']) ?></dd>

        <dt>Mail</dt>
        <dd><?= htmlspecialchars($perfil['email']) ?></dd>

        <dt>Rango</dt>
        <dd><?= htmlspecialchars($rolTexto) ?></dd>

        <dt>A bordo desde</dt>
        <dd><?= htmlspecialchars($fechaAlta) ?></dd>
    </dl>

    <h2>Preferencias guardadas en cookies</h2>
    <dl class="resumen">
        <dt>Tema visual</dt>
        <dd><?= temaActual() === 'oscuro' ? 'Oscuro' : 'Claro' ?> (se cambia con el botón del menú)</dd>

        <dt>Recordarme</dt>
        <dd>
            <?php if ($recordado !== ''): ?>
                Activado: el login se completa solo con "<?= htmlspecialchars($recordado) ?>".
            <?php else: ?>
                Desactivado.
            <?php endif; ?>
        </dd>
    </dl>

    <a class="boton" href="<?= BASE_URL ?>/paginas/logout.php">Cerrar sesión</a>
</section>

<?php require_once __DIR__ . '/../componentes/pie.php'; ?>

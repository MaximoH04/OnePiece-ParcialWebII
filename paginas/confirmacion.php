<?php

// Acá llega lo que se mandó desde contacto.php.
// Primero me fijo si realmente vino un POST, después limpio los datos, después
// valido, y recién al final muestro algo en pantalla.

require_once __DIR__ . '/../config.php';

$titulo = 'Confirmación | ' . NOMBRE_SITIO;

// Mismo archivo que usa el formulario, así la lista de motivos no se desincroniza.
$motivos = require __DIR__ . '/../datos/motivos.php';

// Si alguien entra pegando la URL en el navegador esto es GET y no hay nada que procesar.
$vinoPorPost = ($_SERVER['REQUEST_METHOD'] === 'POST');

// Link de vuelta al formulario. Si hay errores le engancho lo que ya venía escrito
// para que contacto.php lo vuelva a cargar y no haya que tipear todo otra vez.
$volverAlFormulario = BASE_URL . '/paginas/contacto.php';

// Arranco todo vacío para que las variables existan aunque no haya POST.
$nombre = '';
$apellido = '';
$email = '';
$motivo = '';
$mensaje = '';
$errores = [];

if ($vinoPorPost) {

    // Limpio cada campo antes de tocarlo. El ?? '' evita el "Undefined array key"
    // si falta alguno, trim() saca los espacios de más y htmlspecialchars() convierte
    // el HTML en texto para que nadie me inyecte etiquetas.
    $nombre   = htmlspecialchars(trim($_POST['nombre'] ?? ''), ENT_QUOTES, 'UTF-8');
    $apellido = htmlspecialchars(trim($_POST['apellido'] ?? ''), ENT_QUOTES, 'UTF-8');
    $email    = htmlspecialchars(trim($_POST['email'] ?? ''), ENT_QUOTES, 'UTF-8');
    $motivo   = htmlspecialchars(trim($_POST['motivo'] ?? ''), ENT_QUOTES, 'UTF-8');
    $mensaje  = htmlspecialchars(trim($_POST['mensaje'] ?? ''), ENT_QUOTES, 'UTF-8');

    // Voy validando campo por campo y guardo los problemas en $errores.
    // Uso mb_strlen y no strlen porque con las tildes strlen cuenta de más.
    if (empty($nombre)) {
        $errores[] = 'Te falta completar el nombre.';
    } elseif (mb_strlen($nombre) < 3) {
        $errores[] = 'El nombre tiene que tener al menos 3 caracteres.';
    }

    if (empty($apellido)) {
        $errores[] = 'Te falta completar el apellido.';
    } elseif (mb_strlen($apellido) < 3) {
        $errores[] = 'El apellido tiene que tener al menos 3 caracteres.';
    }

    if (empty($email)) {
        $errores[] = 'Te falta completar el mail.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = 'Ese mail no tiene un formato válido (tiene que ser algo como nombre@ejemplo.com).';
    }

    // El motivo tiene que ser una de las claves de datos/motivos.php.
    // Si alguien edita el select desde el navegador, acá lo frena.
    if (empty($motivo)) {
        $errores[] = 'Elegí un motivo de contacto.';
    } elseif (!in_array($motivo, array_keys($motivos), true)) {
        $errores[] = 'El motivo que elegiste no está en la lista.';
    }

    if (empty($mensaje)) {
        $errores[] = 'El mensaje no puede quedar vacío.';
    } elseif (mb_strlen($mensaje) < 10) {
        $errores[] = 'Contanos un poco más: el mensaje necesita al menos 10 caracteres.';
    }

    // http_build_query arma el ?nombre=...&apellido=... con lo que mandó el formulario.
    if (!empty($errores)) {
        $volverAlFormulario .= '?' . http_build_query($_POST);
    }
}

require_once __DIR__ . '/../componentes/encabezado.php';
?>

<section class="seccion">

<?php if (!$vinoPorPost): ?>

    <!-- Entró por la URL, sin pasar por el formulario -->
    <div class="caja atencion">
        <h1>Acceso indebido</h1>
        <p>
            Esta página solamente muestra el resultado de un formulario enviado.
        </p>
        <a class="boton" href="<?= BASE_URL ?>/paginas/contacto.php">Ir al formulario</a>
    </div>

<?php elseif (!empty($errores)): ?>

    <!-- Vino por POST pero algo no pasó la validación -->
    <div class="caja error">
        <h1>No pudimos enviar tu consulta</h1>
        <p>Revisá esto y probá de nuevo:</p>

        <ul>
            <?php foreach ($errores as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>

        <a class="boton" href="<?= $volverAlFormulario ?>">Volver al formulario</a>
    </div>

<?php else: ?>

    <!-- Todo bien. Los datos ya vienen escapados de arriba, por eso los imprimo directo -->
    <div class="caja exito">
        <h1>¡Gracias, <?= $nombre ?> <?= $apellido ?>!</h1>
        <p>
            Tu consulta quedó registrada. Te vamos a responder a <strong><?= $email ?></strong>.
        </p>
        <p class="contexto"><?= $motivos[$motivo]['respuesta'] ?></p>
    </div>

    <h2>Resumen de lo que mandaste</h2>

    <dl class="resumen">
        <dt>Nombre y apellido</dt>
        <dd><?= $nombre ?> <?= $apellido ?></dd>

        <dt>Mail</dt>
        <dd><?= $email ?></dd>

        <dt>Motivo</dt>
        <dd><?= $motivos[$motivo]['etiqueta'] ?></dd>

        <dt>Mensaje</dt>
        <dd><?= nl2br($mensaje) ?></dd>
    </dl>

    <a class="boton azul" href="<?= BASE_URL ?>/index.php">Volver al inicio</a>

<?php endif; ?>

</section>

<?php require_once __DIR__ . '/../componentes/pie.php'; ?>

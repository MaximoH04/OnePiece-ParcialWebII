<?php

// Todo lo que tiene que ver con la sesión: arrancarla, los mensajes flash
// y el control de acceso a las páginas.

require_once __DIR__ . '/../config.php';

// session_start() tiene que ir antes de imprimir cualquier cosa, y una sola vez.
// Por eso cada página incluye este archivo arriba de todo, antes del encabezado.
if (session_status() === PHP_SESSION_NONE) {
    // httponly: JavaScript no puede leer la cookie de sesión.
    // samesite Lax: otro sitio no puede mandar formularios usando mi sesión.
    session_set_cookie_params([
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

/**
 * Guarda un mensaje para mostrarlo en la próxima página que se cargue.
 * $tipo puede ser 'exito', 'error' o 'atencion' (son las clases de la caja en el CSS).
 */
function guardarFlash(string $tipo, string $texto): void
{
    $_SESSION['flash'][] = ['tipo' => $tipo, 'texto' => $texto];
}

/**
 * Devuelve los mensajes pendientes y los borra de la sesión,
 * así cada mensaje se ve una sola vez.
 */
function tomarFlash(): array
{
    $mensajes = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);

    return $mensajes;
}

/**
 * Datos del usuario logueado, o null si no hay nadie.
 */
function usuarioLogueado(): ?array
{
    return $_SESSION['usuario'] ?? null;
}

/**
 * Manda a otra página del sitio y corta la ejecución.
 * $ruta es relativa a la raíz del sitio, por ejemplo '/paginas/login.php'.
 */
function redirigir(string $ruta): void
{
    header('Location: ' . BASE_URL . $ruta);
    exit;
}

/**
 * Para páginas privadas: si no hay sesión iniciada, manda al login.
 */
function requerirLogin(): void
{
    if (usuarioLogueado() === null) {
        guardarFlash('atencion', 'Tenés que iniciar sesión para entrar a esa sección.');
        redirigir('/paginas/login.php');
    }
}

/**
 * Para login y registro: si ya hay sesión iniciada no tiene sentido mostrarlos.
 */
function requerirInvitado(): void
{
    if (usuarioLogueado() !== null) {
        guardarFlash('atencion', 'Ya tenés la sesión iniciada.');
        redirigir('/paginas/perfil.php');
    }
}

<?php

// Preferencias del visitante que guardo en cookies, del lado del navegador:
// el tema visual (claro u oscuro) y el usuario del "Recordarme" del login.

require_once __DIR__ . '/../config.php';

const COOKIE_TEMA     = 'tema';
const COOKIE_RECORDAR = 'recordar_usuario';
const TEMAS_VALIDOS   = ['claro', 'oscuro'];

/**
 * Crea (o pisa) una cookie del sitio que dura $dias días.
 */
function guardarCookie(string $nombre, string $valor, int $dias): void
{
    setcookie($nombre, $valor, [
        'expires'  => time() + $dias * 24 * 60 * 60,
        'path'     => BASE_URL === '' ? '/' : BASE_URL,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);

    // setcookie() recién llega al navegador con la respuesta; la cargo también en
    // $_COOKIE por si en este mismo pedido se vuelve a leer.
    $_COOKIE[$nombre] = $valor;
}

/**
 * Para borrar una cookie se la vuelve a mandar con una fecha que ya pasó.
 */
function borrarCookie(string $nombre): void
{
    setcookie($nombre, '', [
        'expires'  => time() - 3600,
        'path'     => BASE_URL === '' ? '/' : BASE_URL,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);

    unset($_COOKIE[$nombre]);
}

/**
 * Tema elegido. La cookie la puede editar cualquiera desde el navegador,
 * así que solamente acepto los valores de la lista.
 */
function temaActual(): string
{
    $tema = $_COOKIE[COOKIE_TEMA] ?? 'claro';

    return in_array($tema, TEMAS_VALIDOS, true) ? $tema : 'claro';
}

/**
 * Usuario (o mail) recordado en el login, o '' si no marcó "Recordarme".
 */
function usuarioRecordado(): string
{
    $valor = $_COOKIE[COOKIE_RECORDAR] ?? '';

    return is_string($valor) ? trim($valor) : '';
}

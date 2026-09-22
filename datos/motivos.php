<?php

// Motivos del formulario. Los uso en dos lados: contacto.php arma el select con esto
// y confirmacion.php valida contra estas mismas claves.

return [
    'consulta' => [
        'etiqueta'  => 'Consulta general',
        'respuesta' => 'Te vamos a contestar por mail dentro de las próximas 48 horas.',
    ],
    'sugerencia' => [
        'etiqueta'  => 'Sugerencia de contenido',
        'respuesta' => 'Anotamos tu sugerencia en la lista de próximas fichas para publicar. ¡Gracias por el aporte!',
    ],
    'error' => [
        'etiqueta'  => 'Reportar un error del sitio',
        'respuesta' => 'Ya quedó registrado el error para revisarlo. Si podés, contanos después qué navegador estabas usando.',
    ],
    'colaboracion' => [
        'etiqueta'  => 'Quiero colaborar',
        'respuesta' => 'Siempre hace falta tripulación: te escribimos para contarte qué tareas hay abiertas.',
    ],
];

<?php

// Los 6 carteles de recompensa. El archivo devuelve el array para cargarlo con un require.
// Con "destacado" y "estado" cambio cómo se ve cada tarjeta.

return [
    [
        'titulo'      => 'Monkey D. Luffy',
        'puesto'      => 'Capitán',
        'descripcion' => 'Comió la fruta Gomu Gomu y quedó hecho de goma. Su sueño es encontrar el One Piece y ser el Rey de los Piratas.',
        'imagen'      => 'luffy.jpg',
        'recompensa'  => '3.000.000.000',
        'destacado'   => true,
        'estado'      => 'activa',
    ],
    [
        'titulo'      => 'Roronoa Zoro',
        'puesto'      => 'Espadachín',
        'descripcion' => 'Pelea con tres espadas, una de ellas en la boca. Quiere ser el mejor espadachín del mundo.',
        'imagen'      => 'zoro.jpg',
        'recompensa'  => '1.111.000.000',
        'destacado'   => false,
        'estado'      => 'activa',
    ],
    [
        'titulo'      => 'Nami',
        'puesto'      => 'Navegante',
        'descripcion' => 'Lee el clima como nadie y maneja el timón del Sunny. Sueña con dibujar el mapa completo del mundo.',
        'imagen'      => 'nami.jpg',
        'recompensa'  => '366.000.000',
        'destacado'   => false,
        'estado'      => 'activa',
    ],
    [
        'titulo'      => 'Sanji',
        'puesto'      => 'Cocinero',
        'descripcion' => 'Cocina para toda la tripulación y pelea solamente con las piernas. Busca el mar legendario All Blue.',
        'imagen'      => 'sanji.jpg',
        'recompensa'  => '1.032.000.000',
        'destacado'   => false,
        'estado'      => 'activa',
    ],
    [
        'titulo'      => 'Tony Tony Chopper',
        'puesto'      => 'Médico',
        'descripcion' => 'Es un reno que comió la fruta Hito Hito. La Marina todavía cree que es la mascota del barco.',
        'imagen'      => 'chopper.jpg',
        'recompensa'  => '1.000',
        'destacado'   => false,
        'estado'      => 'capturado',
    ],
    [
        'titulo'      => 'Nico Robin',
        'puesto'      => 'Arqueóloga',
        'descripcion' => 'La única persona viva capaz de leer los Poneglyphs. Tiene cartel desde los ocho años.',
        'imagen'      => 'robin.jpg',
        'recompensa'  => '930.000.000',
        'destacado'   => true,
        'estado'      => 'capturado',
    ],
];

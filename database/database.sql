-- ------------------------------------------------------------
-- Bitácora Pirata - Segundo Parcial de Programación Web II
-- Base de datos del módulo de usuarios (registro y login).
--
-- Usuarios de prueba: todos tienen la contraseña  Pirata123
-- Se puede entrar con el nombre de usuario o con el mail.
-- ------------------------------------------------------------

-- En XAMPP estas dos líneas crean la base y la seleccionan.
-- En InfinityFree la base ya viene creada desde el panel y no deja crear otra:
-- para el hosting usar database-infinityfree.sql, que no las tiene.
CREATE DATABASE IF NOT EXISTS bitacora_pirata
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;
USE bitacora_pirata;

DROP TABLE IF EXISTS usuarios;

CREATE TABLE usuarios (
    id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    nombre      VARCHAR(60)  NOT NULL,
    usuario     VARCHAR(30)  NOT NULL,
    email       VARCHAR(120) NOT NULL,
    -- acá se guarda el hash de password_hash(), nunca la contraseña en texto plano
    password    VARCHAR(255) NOT NULL,
    -- el rol queda preparado para el panel de administración de la entrega final
    rol         ENUM('usuario', 'admin') NOT NULL DEFAULT 'usuario',
    fecha_alta  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_usuarios_usuario (usuario),
    UNIQUE KEY uq_usuarios_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO usuarios (nombre, usuario, email, password, rol, fecha_alta) VALUES
('Monkey D. Luffy',   'luffy',   'luffy@bitacorapirata.test',   '$2y$12$9eZWCPt6cxSkeADIaOyXKOGXalU13NHFrdr/adjnnBGFZY5eUHzfq', 'admin',   '2026-09-01 10:00:00'),
('Roronoa Zoro',      'zoro',    'zoro@bitacorapirata.test',    '$2y$12$/jfzejwHNr.RqLfyMPiJB.Npv6mpgkTM68.iapAkMO/qu9FWDIARO', 'usuario', '2026-09-03 18:25:00'),
('Nami',              'nami',    'nami@bitacorapirata.test',    '$2y$12$OXvHqjdzU8wKdXXjnjmdge8xPzQIF2EVdxDJiyJqD8wi6jS1fGPP2', 'usuario', '2026-09-07 09:40:00'),
('Usopp',             'usopp',   'usopp@bitacorapirata.test',   '$2y$12$AMHD2uDcJFtw/VXfB6nLk.oWprWqWSuyclN4y60OLOR5gzUMVoV8y', 'usuario', '2026-09-12 21:05:00'),
('Sanji',             'sanji',   'sanji@bitacorapirata.test',   '$2y$12$tZQF3tYk65g.4WypUASoTeMrrTrsaVbjLFVc.V0x9wwoozo6ERJyS', 'usuario', '2026-09-20 13:15:00'),
('Tony Tony Chopper', 'chopper', 'chopper@bitacorapirata.test', '$2y$12$zvUw57JTgxoa3JYIKkZv2OdpR3/HrqhDxV.LP2gDj0eYevfuDDgJe', 'usuario', '2026-10-02 16:30:00'),
('Nico Robin',        'robin',   'robin@bitacorapirata.test',   '$2y$12$Lw9BxBc1VTSTT/HQQqK5WuJlRZADQLk9N8WCwGyTTr1KN2ESPdpqa', 'usuario', '2026-10-15 11:50:00'),
('Franky',            'franky',  'franky@bitacorapirata.test',  '$2y$12$xGsxbMQxygKxb8eExDbn6uDYdxxvSYx1NkTDoZubV4rdGo4nvXjyW', 'usuario', '2026-10-28 20:10:00');

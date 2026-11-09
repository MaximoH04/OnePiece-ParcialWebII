Segundo Parcial de Programacion Web II
Escuela Da Vinci

Alumno: Maximo Hidalgo
Tematica: Anime One Piece
Rama elegida: Opcion A - Modulo de usuarios (registro y login con MySQL y sesiones)


Repositorio
-----------
https://github.com/MaximoH04/OnePiece-ParcialWebII
(el estado de la entrega del Primer Parcial quedo marcado con el tag "parcial-1")


Como probarlo en XAMPP
----------------------
1. Copiar la carpeta parcial-webII dentro de htdocs.
2. Prender Apache y MySQL desde el panel de XAMPP.
3. En phpMyAdmin, importar database/database.sql (crea la base bitacora_pirata
   con la tabla usuarios y 8 usuarios de prueba).
4. Entrar a http://localhost/parcial-webII/

Usuarios de prueba: luffy, zoro, nami, usopp, sanji, chopper, robin, franky.
Todos tienen la contrasena Pirata123. Se puede entrar con el usuario o con el mail
(por ejemplo nami@bitacorapirata.test).


Que se agrego en este parcial
-----------------------------
- Base de datos MySQL con la tabla usuarios (database/database.sql).
- Conexion centralizada con MySQLi y control de errores (includes/conexion.php).
- Registro con validacion en el servidor y control de usuario o mail repetido.
- Login con password_verify, session_regenerate_id y datos en $_SESSION.
- Logout que destruye la sesion.
- Pagina privada "Mi camarote" (perfil) que solo se ve con la sesion iniciada.
- Mensajes flash guardados en la sesion (se muestran una sola vez).
- Cookies: tema claro/oscuro (boton del menu) y "Recordarme" en el login.
- Menu que cambia segun haya o no sesion iniciada.
- Todas las consultas con parametros usan sentencias preparadas
  (mysqli_prepare + mysqli_stmt_bind_param + mysqli_stmt_execute).
- Toda salida dinamica pasa por htmlspecialchars().


Archivos
--------
index.php                    portada + tablero de recompensas
config.php                   BASE_URL, nombre del sitio y datos de la base
config.produccion.ejemplo.php  modelo de config para el hosting (InfinityFree)
componentes/encabezado.php   head, logo, menu y mensajes flash
componentes/nav.php          menu principal (cambia segun la sesion) y boton de tema
componentes/pie.php          pie de pagina y cierre del html
includes/conexion.php        conexion a MySQL con MySQLi
includes/sesion.php          session_start, mensajes flash y control de acceso
includes/cookies.php         cookies de preferencias (tema y Recordarme)
paginas/registro.php         alta de usuarios
paginas/login.php            inicio de sesion
paginas/logout.php           cierre de sesion
paginas/perfil.php           "Mi camarote", solo con sesion iniciada
paginas/tema.php             guarda el tema elegido en una cookie
paginas/tripulacion.php      seccion de contenido
paginas/sagas.php            seccion de contenido
paginas/contacto.php         formulario que manda por POST
paginas/confirmacion.php     valida lo que llega del formulario y muestra el resultado
datos/piratas.php            array con los 6 piratas
datos/motivos.php            motivos validos del formulario
datos/sagas.php              datos de la seccion sagas
database/database.sql        estructura de la base y registros de prueba
css/estilos.css              unica hoja de estilos (flexbox + variables para el tema)
img/                         imagenes


Despliegue en InfinityFree
--------------------------
1. Crear la base desde el panel (MySQL Databases) y anotar host, usuario,
   contrasena y nombre de la base.
2. En phpMyAdmin del hosting, elegir esa base, borrar las lineas CREATE DATABASE
   y USE del database.sql e importarlo.
3. Copiar config.produccion.ejemplo.php como config.produccion.php y completar los datos.
   (config.produccion.php no se sube a GitHub porque tiene la contrasena.)
4. Subir los archivos a htdocs por el File Manager o FTP.


Fuente de las imagenes
---------------------------
- Fotos de los personajes: MyAnimeList (cdn.myanimelist.net)
- Logo de One Piece y bandera: Wikimedia Commons
- Imagenes de las sagas: One Piece Wiki
- Banner de la portada: AniList

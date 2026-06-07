 ÁRBOL DE ARCHIVOS
    • index.php // HTML de la página principal
    • agenda-------index.php
    • ajustes--------index.php
    • armario-------index.php
    • notas----------index.php
    • img
    • uploads // carpeta de guardado de imágenes
    - multiversopersonaldb.sql (IMPORTANTE PARA LA IMPORTACIÓN DE LA BASE DE DATOS)
    • css-----------styles.css
    • js---------------script.js
    • php--------------actualizarDatos.php
                      -actualizarEvento.php
                      -borrarEvento.php
                      -borrarImagen.php
                      -borrarNota.php
                      -cerrarSesion.php
                      -comprobarSesion.php
                      -conexionMySQL.php
                      -crearEvento.php
                      -crearNota.php
                      -actualizarNota.php
                      -devolverEventos.php
                      -devolverMarcadores.php
                      -devuelveEvento.php
                      -devuelveNota.php
                      -guardarImagen.php
                      -iniciarSesion.php
                      -registrarUsuario.php


INSTALACIÓN DE MULTIVERSO PERSONAL
    1. Descarga del proyecto.
Acceder al enlace de Google Drive facilitado, descargar la carpeta comprimida .zip y descomprimirla, dando como resultado una carpeta con todos los archivos.

    2. Instalación en servidor local.
Para que la aplicación pueda ejecutarse debe colocarse dentro del directorio del servidor local. En caso de XAMPP (C:\xampp\htdocs\www.multiversopersonal.com) En caso de WAMP (C:\wamp64\www\www.multiversopersonal.com), una vez la aplicación esté en el directorio del servidor local, habrá que iniciarlo, abrir el panel de control del servidor local y encenderlo.

    3. Importación de la base de datos. (IMPORTANTE)
La aplicación necesita de una base de datos para el almacenamiento trato de datos, abrir el navegador y escribir http://localhost/phpmyadmin, crear una base de datos nueva e importar la del proyecto. Comprobar que aparecen todas las tablas necesarias (usuarios, eventos, notas e imágenes) y configurar el nombre de usurario como “root” y la contraseña vacia (“”) o en caso de tener otro nombre de usuario y contraseña acceder al archivo “conexionMySQL.php” linea 14 y modificar los parámetros pertinentes de la clase mysqli, teniendo como primer parámetro el host, como segundo el nombre de usuario de la base de datos, como tercero la contraseña y como cuarto el nombre de la base de datos. Archivo necesario para la importación de datos "multiversopersonaldb.sql".

    4. Puesta en marcha de la aplicación.
Una vez esté todo instalado, hay que abrir el navegador y escribir en la barra http://localhost/www.multiversopersonal.com/ y pulsar enter, de este modo la aplicación cargará la página principal a partir de donde habrá que mirar el “manual de usuario”.

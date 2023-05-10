<?php

$host = "http://localhost"; // Cambiar por el nombre del host de tu servidor de base de datos
$user = "root"; // Cambiar por el nombre de usuario de la base de datos
$password = ""; // Cambiar por la contraseña de la base de datos
$dbname = "prueba"; // Cambiar por el nombre de la base de datos

// Crear la conexión
$conn = mysqli_connect($host, $user, $password, $dbname);

// Verificar si la conexión fue exitosa
if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}
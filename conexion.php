<?php
// Configura los detalles de la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "b_signup";

// Crear conexión
$conexion = mysqli_connect($servername, $username, $password, $database);

// Verificar la conexión
if (!$conexion) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

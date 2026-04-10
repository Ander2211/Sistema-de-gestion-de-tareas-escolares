<?php
$host = "localhost";
$user = "root"; // Tu usuario de MySQL
$pass = "";     // Tu contraseña de MySQL
$db   = "tareas";// base de datos 

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
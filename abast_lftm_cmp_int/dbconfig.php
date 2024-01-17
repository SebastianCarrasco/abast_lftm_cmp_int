<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "electrans_dsrrllo";

// Intenta conectar con la base de datos
$mysqli = new mysqli($host, $username, $password, $database);

// Verifica la conexión
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>
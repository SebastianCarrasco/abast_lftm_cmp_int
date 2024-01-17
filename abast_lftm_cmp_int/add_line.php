<?php
// add_line.php

$num_oc_po = $_POST['num_oc_po'];
$nueva_descripcion = $_POST['nueva_descripcion'];
$nueva_cantidad = $_POST['nueva_cantidad'];
$nuevo_precio = $_POST['nuevo_precio'];

// Conexión a la base de datos (reemplaza los valores con los tuyos)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "electrans_dsrrllo";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
  die("Error de conexión: " . $conn->connect_error);
}

// Consulta a la base de datos para agregar la línea
$sql = "INSERT INTO abast_lftm_cmp_int (num_oc_po, dscrpc_mat, cant_po, vlr_usd) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isii", $num_oc_po, $nueva_descripcion, $nueva_cantidad, $nuevo_precio);
$stmt->execute();

// Cerrar conexión
$conn->close();
?>
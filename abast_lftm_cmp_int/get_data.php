<?php
if (!isset($_GET['num_oc_po']) || !is_numeric($_GET['num_oc_po'])) {
  echo "El parámetro num_oc_po no está definido o no es válido";
  exit;
}

$num_oc_po = $_GET['num_oc_po'];

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

// Consulta a la base de datos con el filtro
$sql = "SELECT num_oc_po, dscrpc_mat, cant_po, vlr_usd FROM abast_lftm_cmp_int WHERE num_oc_po = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $num_oc_po);
$stmt->execute();
$result = $stmt->get_result();

// Generar filas de la tabla con los datos obtenidos de la base de datos
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row["dscrpc_mat"] . "</td>";
    echo "<td>" . $row["cant_po"] . "</td>";
    echo "<td>" . $row["vlr_usd"] . "</td>";
    echo "</tr>";
  }
} else {
  echo "<tr><td colspan='3'>No se encontraron registros</td></tr>";
}

// Cerrar conexión
$conn->close();
?>

<style>
  table {
    width: 100%;
  }

  table th,
  table td {
    max-width: 100px;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .rectangle {
    width: 100%;
    height: 200px;
    /* Ajusta la altura según lo que necesites */
    overflow-y: auto;
    background-color: #DEDEDE;
    margin-top: 20px;
    /* Para darle espacio en la parte superior */
    padding: 10px;
    /* Espacio interno para el texto o contenido dentro del rectángulo */
    text-align: center;
    /* Centra el texto dentro del rectángulo */
  }

  .card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .center-content {
    flex: 1;
    text-align: center;
  }
</style>
<?php
//session_start();
//if (!isset($_SESSION['tipo']) && $_SESSION['tipo'] !== 'ABSTADM') {
//  header('Location: ../index.php');
//die();
//}
?>
<?php
include_once 'dbconfig.php';

if (isset($_GET['delete_id'])) {
  $sql_query = "DELETE FROM abast_lftm_cmp_int WHERE id=" . $_GET['delete_id'];
  $mysqli->query($sql_query);
  header("Location: $_SERVER[PHP_SELF]");
}

if (isset($_GET['changestatus_id'])) {
  $sql_query = "UPDATE abast_lftm_cmp_int SET `status`='" . $_GET['status'] . "' WHERE id=" . $_GET['changestatus_id'];
  $mysqli->query($sql_query);
  header("Location: $_SERVER[PHP_SELF]");
}

$query = "SELECT estd_comp_int AS ESTADOS, count(*) AS CANTIDAD from abast_lftm_cmp_int group by estd_comp_int";
$res = $mysqli->query($query);
?>
<!---- Código indicadores economicos ---->
<?php
$apiUrl = 'https://mindicador.cl/api';
//Es necesario tener habilitada la directiva allow_url_fopen para usar file_get_contents
if (ini_get('allow_url_fopen')) {
  $json = file_get_contents($apiUrl);
} else {
  //De otra forma utilizamos cURL
  $curl = curl_init($apiUrl);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  $json = curl_exec($curl);
  curl_close($curl);
}
$dailyIndicators = json_decode($json);
/*echo 'El valor actual de la UF es $' .*/
$dailyIndicators->uf->valor;
/*echo 'El valor actual del Dólar observado es $' . */
$dailyIndicators->dolar->valor;
/*echo 'El valor actual del Dólar acuerdo es $' . */
$dailyIndicators->dolar_intercambio->valor;
/*echo 'El valor actual del Euro es $' . */
$dailyIndicators->euro->valor;
/*echo 'El valor actual del IPC es ' . */
$dailyIndicators->ipc->valor;
?>
<!---- Fin Código indicadores economicos ---->
<!---- Codigo Agregar Nueva Compra Internacional ---->
<?php
include_once 'dbconfig.php';

$proveedoresYPaises = array(
  "HEBEI" => "China",
  "WORLDWIDE SERVICE" => "EEUU",
  "SHANGHAI SHAWN INDUSTRIAL CO. LTD" => "China",
  "SHANGHAI CONTROLAND ENGINEERING COMPANY" => "China",
  "FULMER/PERMA CAST" => "EEUU",
  "ZHEJIANG GOODSENSE FORKLIFT CO. LTD" => "China",
  "WEST INSTRUMENTS DE MÉXICO S.A" => "MEXICO",
  "CHANGZHOU BOGARD SEALS TECHNICAL" => "China",
  "MORGANITE BRASIL LTDA" => "BRASIL",
  "ALIER (HONG KONG) BEARING CO. LTD" => "Hong Kong",
  "DLL INC" => "CANADA",
  "MEGATONE" => "ARGENTINA",
  "DIGIKEY" => "EEUU",
  "PEI-GENESIS" => "EEUU",
  "ALLIED" => "EEUU",
  "VERICAL" => "EEUU",
  "MICROFRAME" => "EEUU",
  "MOUSER" => "EEUU",
  "ONLINE COMPONENTS" => "EEUU",
  "MARTINDALE" => "REINO UNIDO",
  "SKYGEEK" => "EEUU",
  "CONTROLAND INTERNATIONAL LTD" => "EEUU",
  "BENGBU DOUBLECIRCLE ELECTRONICS" => "China"
);

if (isset($_POST['btn-save'])) {
  // variables for input data
  $fch_inicio_solctd = $_POST['fch_inicio_solctd'];
  $prveedrs_webs = $_POST['prveedrs_webs'];

  if (isset($proveedoresYPaises[$prveedrs_webs])) {
    $pais_prveedr = $proveedoresYPaises[$prveedrs_webs];
  } else {
    $pais_prveedr = "Desconocido";
  }

  $tip_mtrl = $_POST['dscrpc_tip_mat'];
  $num_oc_po = $_POST['num_oc_po'];

  $sql_query = "INSERT INTO abast_lftm_cmp_int (
      `fch_inicio_solctd`,
      `prveedrs_webs`,
      `pais_prveedr`,
      `dscrpc_tip_mat`,
      `num_oc_po`) VALUES('" . $fch_inicio_solctd . "','" . $prveedrs_webs . "','" . $pais_prveedr . "','" . $tip_mtrl . "','" . $num_oc_po . "')";

  // sql query execution function
  if ($mysqli->query($sql_query)) {
?>
    <script type="text/javascript">
      alert('Orden de Compra Agregada con éxito!');
      window.location.href = 'indexabast_lftm_cmp_int.php';
    </script>
  <?php
  } else {
  ?>
    <script type="text/javascript">
      alert('Ocurrió un error al insertar tus datos.');
    </script>
<?php
  }
}
?>
<!---- FIn Codigo Agregar Nueva Compra Internacional ---->
<!DOCTYPE html>
<html lang="es">

<head>
  <title>Electrans - Intranet</title>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
  <link rel="icon" href="img/favicon.ico" type="image/x-icon">
  <?php require_once "scripts.php"; ?>
  <!-------- Inicio Codigo Edicion de registros  -------------------->
  <script type="text/javascript">
    function edt_id(id) {
      window.location.href = 'edit_abast_lftm_cmp_int.php?edit_id=' + id;
    }

    function edt_upload_id(id) {
      window.location.href = 'upload_abast_lftm_cmp_int.php?edit_id=' + id;
    }

    function view_id(id) {
      window.location.href = 'view_abast_lftm_cmp_int.php?view_id=' + id;
    }

    function delete_id(id) {
      if (confirm('¿ESTA SEGURO QUE DESEA BORRAR ESTE REGISTRO?')) {
        window.location.href = 'indexabast_lftm_cmp_int.php?delete_id=' + id;
      }
    }

    function changestatus_id(id, status) {
      window.location.href = 'indexabast_lftm_cmp_int.php?changestatus_id=' + id + '&status=' + status;
    }
  </script>
  <!-------- Fin Codigo Edicion de registros  ---------------------->
  <!-------- Inicio Codigo Grafico Stats Compras  ------------------>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load("current", {
      packages: ["corechart"]
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ['BANDA', 'CANTIDAD'],
        <?php
        while ($row = $res->fetch_assoc()) {
          echo "['" . $row['ESTADOS'] . "'," . $row['CANTIDAD'] . "],";
        }
        ?>
      ]);
      var options = {
        title: '',
        is3D: true,
      };
      var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
      chart.draw(data, options);
    }
  </script>
  <!-------- Fin Codigo Grafico Stats Compras  ------------------>
  <script>
    // Script Buscar en tabla
    /*
    $(document).ready(function(){
    $("#search").keyup(function(){
    _this = this;
    // Buscando en tabla
    $.each($("#table_id tbody tr"), function() {
    if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
    $(this).hide();
    else
    $(this).show();
    });
    });
    });
    */
  </script>
  <!-------- Inicio Codigo CSS Tfoot   ------------------>
  <style>
    tfoot {
      display: table-header-group;
    }

    #contenidoTabla {
      font-size: 12px;
    }

    td {
      font-size: 12px;
    }

    th {
      font-size: 12px;
    }
  </style>
  <!-------- Combobox Anidados  -------->
  <script language="javascript">
    $(document).ready(function() {
      $("#category").on('change', function() {
        $("#category option:selected").each(function() {
          category = $(this).val();
          $.post("datos.php", {
            category: category
          }, function(data) {
            $("#subCategory").html(data);
          });
        });
      });
    });
  </script>
</head>

<body>
  <!-------- Inicio Boostrap  -------->
  <div class="card text-center">
    <div class="card-header">
      <img src="img/logo_1.png" width="150" height="47">
      <div class="center-content">
        <h5 class="quote">Sistema de Compras Internacionales</h5>
      </div>
      <div>
        <h6 class="quote">
          <?php echo "Usuario: " . $_SESSION['usuario']; ?>&nbsp|&nbsp<a href="../logout.php">Cerrar Sesión</a>
        </h6>
      </div>
    </div>
  </div>
  <div class="card-body">
    <!-------- Inicio header informativo  -------->
    <div class="row">
      <div class="col-sm-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Estado de las Compras</h5>
            <div id="piechart_3d" style="width: 450px; height: 200px;"></div>
          </div>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="card">
          <div class="card-body">
            <h6>DETALLE NUMERO DE COMPRAS</h6>
            <div class="card-group">
              <div class="card text-white bg-primary mb-3" style="max-width: 9rem;max-height: 7rem">
                <div class="card-header">TOTAL</div>
                <div class="card-body">
                  <h6 class="card-title">
                    <?php
                    $query1 = $mysqli->query("SELECT count(*) AS PO FROM abast_lftm_cmp_int  GROUP BY num_oc_po");
                    $num1 = mysqli_num_rows($query1);
                    echo $num1;
                    ?>
                  </h6>
                </div>
              </div>
              <div class="card text-white bg-success mb-3" style="max-width: 9rem;max-height: 7rem">
                <div class="card-header">PAGADAS</div>
                <div class="card-body">
                  <h6 class="card-title">
                    <?php
                    $query2 = $mysqli->query("select count(*) as PO from abast_lftm_cmp_int where fch_pago !='' group by num_oc_po");
                    $num2 = mysqli_num_rows($query2);
                    echo $num2;
                    ?>
                  </h6>
                </div>
              </div>
              <div class="card text-white bg-warning mb-3" style="max-width: 9rem;max-height: 7rem">
                <div class="card-header">POR PAGAR</div>
                <div class="card-body">
                  <h6 class="card-title">
                    <?php
                    $query3 = $mysqli->query("select count(*) as PO from abast_lftm_cmp_int where fch_pago ='' group by num_oc_po");
                    $num3 = mysqli_num_rows($query3);
                    echo $num3;
                    ?>
                  </h6>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-2">
        <div class="card">
          <div class="card-body">
            <h6>TOTAL OC'S PAGADAS</h6>
            <div class="card-group">
              <div class="card text-white bg-primary mb-2" style="max-width: 15rem;max-height: 14rem">
                <div class="card-body">
                  <h6 class="card-title">USD</h6>
                  <p class="card-text">
                    <?php
                    $query4 = $mysqli->query("SELECT SUM(total_en_po) AS Total FROM	abast_lftm_cmp_int WHERE fch_pago != ''");
                    $num4 = mysqli_fetch_array($query4);
                    $total_usd = $num4['Total'];
                    echo "$" . number_format($total_usd, 2, '.', '.');
                    ?>
                  </p>
                  <h6 class="card-title">PESOS</h6>
                  <p class="card-text">
                    <?php
                    $total_usd = $num4['Total'] * $dailyIndicators->dolar_intercambio->valor;
                    echo "$" . number_format($total_usd, 2, '.', '.');
                    ?>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-2">
        <div class="card">
          <div class="card-body">
            <h6>TOTAL OC'S POR PAGAR</h6>
            <div class="card-group">
              <div class="card text-white bg-primary mb-2" style="max-width: 15rem;max-height: 14rem">
                <div class="card-body">
                  <h6 class="card-title">USD</h6>
                  <p class="card-text">
                    <?php
                    $query5 = $mysqli->query("SELECT SUM(total_en_po) AS Total FROM	abast_lftm_cmp_int WHERE fch_pago = ''");
                    $num5 = mysqli_fetch_array($query5);
                    $total_usd_x_pag = $num5['Total'];
                    echo "$" . number_format($total_usd_x_pag, 2, '.', '.');
                    ?>
                  </p>
                  <h6 class="card-title">PESOS</h6>
                  <p class="card-text">
                    <?php
                    $total_usd_x_pag = $num5['Total'] * $dailyIndicators->dolar_intercambio->valor;
                    echo "$" . number_format($total_usd_x_pag, 2, '.', '.');
                    ?>
                  </p>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-------- Fin header informativo  -------->
    <div>
    </div>
    <div>
      <!-- Barra de busqueda script buscar en tabla-----
        <input type="text" class="form-control pull-right" style="width:30%" id="search" placeholder="Escriba aqui lo que desea buscar..." >-->
    </div>
    </br>
    <div class="card">
      <div class="card-body display">
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a class="nav-link active" id="tab1" data-toggle="tab" href="#tabla1">SEG. OC PENDIENTES</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="tab2" data-toggle="tab" href="#tabla2">SEG. OC CERRADAS</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="tab3" data-toggle="tab" href="#tabla3">PACKING EN TRANSITO</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="tab4" data-toggle="tab" href="#tabla4">PACKING PEND. PAGO EN BOD.</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="tab4" data-toggle="tab" href="#tabla5">PACKING CERRADA</a>
          </li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane fade show active" id="tabla1">
            <div class="table-responsive">
              <!--<a href="#" class="openBtn_agreg_nueva_comp_int btn btn-primary">AGREGAR NUEVA COMPRA INTERNACIONAL</a>-->
              <table class="table" id="iddatatable">
                <thead style="background-color: #4c6176;color: white;">
                  <tr>
                    <th>Fecha</th>
                    <th>Proveedor</th>
                    <th>N° OC/PO</th>
                    <th>Detalle</th>
                    <th>Estado OC</th>
                    <th>Fecha Pago</th>
                    <th>N° Packing</th>
                    <th>Transporte</th>
                    <!--<th>Ver</th>
                    <th>Editar</th>
                    <th>Subir</th>
                    <th>Eliminar</th>-->
                  </tr>
                </thead>
                <tfoot style="background-color: #4c6176;color: white;">
                  <tr>
                    <th>Inicio</th>
                    <th>País</th>
                    <th>N° OC/PO</th>
                    <th>Materiales</th>
                    <th>Estado OC</th>
                    <th>Fecha Pago</th>
                    <th>N° Packing</th>
                    <th></th>
                    <!--<th></th>
                    <th></th>
                    <th></th>
                    <th></th>-->
                  </tr>
                </tfoot>
                <tbody>
                  <?php
                  $sql_query = "SELECT Id, fch_inicio_solctd, prveedrs_webs, pais_prveedr, num_oc_po, dscrpc_tip_mat, estd_comp_int, fch_pago, num_invoic, num_pack_lst, tip_trnsp 
                        FROM abast_lftm_cmp_int 
                        WHERE fch_pago = '' 
                        ORDER BY fch_inicio_solctd DESC";
                  $result_set = $mysqli->query($sql_query);
                  $i = 1;
                  while ($row = mysqli_fetch_row($result_set)) {
                  ?>
                    <tr>
                      <td align="center">
                        <?php
                        $originalDate = $row[1];
                        $newDate = date("d/M/y", strtotime($originalDate));
                        echo $newDate;
                        ?>
                      </td>
                      <td align="center">
                        <?php echo $row[2] . "/" . $row[3]; ?>
                      </td>
                      <td align="center">
                        <?php echo $row[4]; ?>
                      </td>
                      <td align="center">
                        <?php echo $row[5]; ?>
                      </td>
                      <td align="center">
                        <?php echo $row[6]; ?>
                      </td>
                      <td align="center">
                        <?php
                        if ($row[7] !== '') {
                          $pagoDate = $row[7];
                          $newPagoDate = date("d/M/y", strtotime($pagoDate));
                          echo $newPagoDate;
                        }
                        ?>
                      </td>
                      <td align="center">
                        <?php echo $row[9]; ?>
                      </td>
                      <td align="center">
                        <?php echo $row[10]; ?>
                      </td>
                      <!--<td align="center">
                        <a href="javascript:void(0);" onclick="openModal(this)" class="btn btn-outline-success btn-sm" data-num_oc_po="<?php echo $row[4]; ?>"><img src="img/eye.svg"></a>
                      </td>
                      <td align="center">
                        <a href="javascript:edt_id('<?php echo $row[4]; ?>')" class="btn btn-outline-warning btn-sm">
                          <img src="img/pencil-square.svg">
                        </a>
                      </td>
                      <td align="center">
                        <a href="javascript:edt_upload_id('<?php echo $row[0]; ?>')" class="btn btn-outline-info btn-sm">
                          <img src="img/upload.svg">
                        </a>
                      </td>
                      <td align="center">
                        <a href="javascript:delete_id('<?php echo $row[0]; ?>')" class="btn btn-outline-danger btn-sm">
                          <img src="img/trash3.svg">
                        </a>
                      </td>-->
                    </tr>
                  <?php
                    $i++;
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="tab-pane fade" id="tabla2">
            <div class="table-responsive">
              <table class="table" id="iddatatable2">
                <thead style="background-color: #4c6176;color: white;">
                  <tr>
                    <th>Fecha</th>
                    <th>Proveedor</th>
                    <th>N° OC/PO</th>
                    <th>Detalle</th>
                    <th>Estado OC</th>
                    <th>Fecha Pago</th>
                    <th>N° Packing</th>
                    <th>Transporte</th>
                    <!--<th>Ver</th>
                    <th>Editar</th>
                    <th>Subir</th>
                    <th>Eliminar</th>-->
                  </tr>
                </thead>
                <tfoot style="background-color: #4c6176;color: white;">
                  <tr>
                    <th>Inicio</th>
                    <th>País</th>
                    <th>N° OC/PO</th>
                    <th>Materiales</th>
                    <th>Estado OC</th>
                    <th>Fecha Pago</th>
                    <th>N° Packing</th>
                    <th></th>
                    <!--<th></th>
                    <th></th>
                    <th></th>
                    <th></th>-->
                  </tr>
                </tfoot>
                <tbody>
                  <?php
                  $sql_query = "SELECT Id, fch_inicio_solctd, prveedrs_webs, pais_prveedr, num_oc_po, dscrpc_mat, estd_comp_int, fch_pago, num_invoic, num_pack_lst, tip_trnsp 
                        FROM abast_lftm_cmp_int 
                        WHERE fch_pago <> '' 
                        ORDER BY fch_inicio_solctd DESC";
                  $result_set = $mysqli->query($sql_query);
                  $i = 1;
                  while ($row = mysqli_fetch_row($result_set)) {
                  ?>
                    <tr>
                      <td align="center">
                        <?php
                        $originalDate = $row[1];
                        $newDate = date("d/M/y", strtotime($originalDate));
                        echo $newDate;
                        ?>
                      </td>
                      <td align="center">
                        <?php echo $row[2] . "/" . $row[3]; ?>
                      </td>
                      <td align="center">
                        <?php echo $row[4]; ?>
                      </td>
                      <td align="center">
                        <?php echo $row[5]; ?>
                      </td>
                      <td align="center">
                        <?php echo $row[6]; ?>
                      </td>
                      <td align="center">
                        <?php
                        if ($row[7] !== '') {
                          $pagoDate = $row[7];
                          $newPagoDate = date("d/M/y", strtotime($pagoDate));
                          echo $newPagoDate;
                        }
                        ?>
                      </td>
                      <td align="center">
                        <?php echo $row[9]; ?>
                      </td>
                      <td align="center">
                        <?php echo $row[10]; ?>
                      </td>
                      <!--<td align="center">
                        <a href="javascript:void(0);" onclick="openModal(this)" class="btn btn-outline-success btn-sm" data-num_oc_po="<?php echo $row[4]; ?>"><img src="img/eye.svg"></a>
                      </td>
                      <td align="center">
                        <a href="javascript:edt_id('<?php echo $row[4]; ?>')" class="btn btn-outline-warning btn-sm">
                          <img src="img/pencil-square.svg">
                        </a>
                      </td>
                      <td align="center">
                        <a href="javascript:edt_upload_id('<?php echo $row[0]; ?>')" class="btn btn-outline-info btn-sm">
                          <img src="img/upload.svg">
                        </a>
                      </td>
                      <td align="center">
                        <a href="javascript:delete_id('<?php echo $row[0]; ?>')" class="btn btn-outline-danger btn-sm">
                          <img src="img/trash3.svg">
                        </a>
                      </td>-->
                    </tr>
                  <?php
                    $i++;
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="tab-pane fade" id="tabla3">
            <div class="table-responsive">
              <!--<a href="#" class="openBtn_agreg_nueva_pl btn btn-primary">AGREGAR NUEVO PACKING LIST</a>-->
              <table class="table" id="iddatatable3">
                <thead style="background-color: #4c6176;color: white;">
                  <tr>
                    <th>N° Packing</th>
                    <th>Proveedor</th>
                    <th>N° OC/PO</th>
                    <th>Tipo Material</th>
                    <th>N° TRK/AWB</th>
                    <th>N° PDQ</th>
                    <th>Estado PL</th>
                    <th>Estado Pago</th>
                    <!--<th>Ver</th>
                    <th>Editar</th>
                    <th>Subir</th>
                    <th>Eliminar</th>-->
                  </tr>
                </thead>
                <tfoot style="background-color: #4c6176;color: white;">
                  <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <!--<th></th>
                    <th></th>
                    <th></th>
                    <th></th>-->
                  </tr>
                </tfoot>
                <tbody>
                  <?php
                  $sql_query = "SELECT * 
                    FROM abast_lftm_cmp_int
                    WHERE estd_comp_int = 'EN TRANS. INTERNAC.'
                    OR estd_comp_int = 'EN TRANS. PROVEEDOR.'
                    OR estd_comp_int = 'EN TRANS. STGO AFTA.'
                    OR estd_comp_int = 'EN TRANS. MEJILL. AFTA.'
                    ORDER BY 'num_oc_po'";
                  $result_set = $mysqli->query($sql_query);
                  $i = 1;
                  while ($row = mysqli_fetch_row($result_set)) {
                  ?>
                    <tr>
                      <td align="center">
                        <?php echo $row[18]; ?>
                      </td>
                      <td align="center">
                        <?php echo $row[2] . "/" . $row[3]; ?>
                      </td>
                      <td align="center">
                        <?php echo $row[4]; ?>
                      </td>
                      <td align="center">
                        <?php echo $row[13]; ?>
                      </td>
                      <td align="center">
                        <?php echo $row[21]; ?>
                      </td>
                      <td align="center">
                        <?php echo $row[30]; ?>
                      </td>
                      <td align="center">
                        <?php echo $row[14]; ?>
                      </td>
                      <td align="center">
                        <?php
                        if ($row[15] !== '') {
                          echo 'Pagado';
                        } else {
                          echo 'Sin pago';
                        }
                        ?>
                      </td>
                      <!--<td align="center">
                          <a href="javascript:view_id('<?php echo $row[0]; ?>')" class="btn btn-outline-info btn-sm">
                            <img src="img/eye.svg">
                          </a>
                      </td>
                      <td align="center">
                        <a href="javascript:edt_id('<?php echo $row[4]; ?>')" class="btn btn-outline-warning btn-sm">
                          <img src="img/pencil-square.svg">
                        </a>
                      </td>
                      <td align="center">
                        <a href="javascript:edt_upload_id('<?php echo $row[0]; ?>')" class="btn btn-outline-info btn-sm">
                          <img src="img/upload.svg">
                        </a>
                      </td>
                      <td align="center">
                        <a href="javascript:delete_id('<?php echo $row[0]; ?>')" class="btn btn-outline-danger btn-sm">
                          <img src="img/trash3.svg">
                        </a>
                      </td>-->
                    </tr>
                  <?php
                    $i++;
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="tab-pane fade" id="tabla4">
            <div class="table-responsive">
              <table class="table" id="iddatatable4">
                <thead style="background-color: #4c6176;color: white;">
                  <tr>
                    <th>N° Packing</th>
                    <th>Proveedor</th>
                    <th>N° OC/PO</th>
                    <th>Tipo Material</th>
                    <th>N° TRK/AWB</th>
                    <th>N° PDQ</th>
                    <th>Estado PL</th>
                    <th>Estado Pago</th>
                    <!--<th>Ver</th>
                    <th>Editar</th>
                    <th>Subir</th>
                    <th>Eliminar</th>-->
                  </tr>
                </thead>
                <tfoot style="background-color: #4c6176;color: white;">
                  <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <!--<th></th>
                    <th></th>
                    <th></th>
                    <th></th>-->
                  </tr>
                </tfoot>
                <tbody>
                  <?php
                  $sql_query = "SELECT * 
                    FROM abast_lftm_cmp_int 
                    WHERE fch_pago = ''
                    AND estd_comp_int = 'EN BODEGA'
                    ORDER BY num_oc_po DESC";
                  $result_set = $mysqli->query($sql_query);
                  $i = 1;
                  while ($row = mysqli_fetch_row($result_set)) {
                  ?>
                    <tr>
                      <td align="center">
                        <?php echo $row[18]; ?>
                      </td>
                      <td align="center">
                        <?php echo $row[2] . "/" . $row[3]; ?>
                      </td>
                      <td align="center">
                        <?php echo $row[4]; ?>
                      </td>
                      <td align="center">
                        <?php echo $row[13]; ?>
                      </td>
                      <td align="center">
                        <?php echo $row[21]; ?>
                      </td>
                      <td align="center">
                        <?php echo $row[30]; ?>
                      </td>
                      <td align="center">
                        <?php echo $row[14]; ?>
                      </td>
                      <td align="center">
                        <?php
                        if ($row[15] !== '') {
                          echo 'Pagado';
                        } else {
                          echo 'Sin pago';
                        }
                        ?>
                      </td>
                      <!--<td align="center">
                          <a href="javascript:view_id('<?php echo $row[0]; ?>')" class="btn btn-outline-info btn-sm">
                            <img src="img/eye.svg">
                          </a>
                        </td>
                      <td align="center">
                        <a href="javascript:edt_id('<?php echo $row[4]; ?>')" class="btn btn-outline-warning btn-sm">
                          <img src="img/pencil-square.svg">
                        </a>
                      </td>
                      <td align="center">
                        <a href="javascript:edt_upload_id('<?php echo $row[0]; ?>')" class="btn btn-outline-info btn-sm">
                          <img src="img/upload.svg">
                        </a>
                      </td>
                      <td align="center">
                        <a href="javascript:delete_id('<?php echo $row[0]; ?>')" class="btn btn-outline-danger btn-sm">
                          <img src="img/trash3.svg">
                        </a>
                      </td>-->
                    </tr>
                  <?php
                    $i++;
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="tab-pane fade" id="tabla5">
            <div class="table-responsive">
              <table class="table" id="iddatatable5">
                <thead style="background-color: #4c6176;color: white;">
                  <tr>
                    <th>N° Packing</th>
                    <th>Proveedor</th>
                    <th>N° OC/PO</th>
                    <th>Tipo Material</th>
                    <th>N° TRK/AWB</th>
                    <th>N° PDQ</th>
                    <th>Estado PL</th>
                    <th>Estado Pago</th>
                    <!--<th>Ver</th>
                    <th>Editar</th>
                    <th>Subir</th>
                    <th>Eliminar</th>-->
                  </tr>
                </thead>
                <tfoot style="background-color: #4c6176;color: white;">
                  <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <!--<th></th>
                    <th></th>
                    <th></th>
                    <th></th>-->
                  </tr>
                </tfoot>
                <tbody>
                  <?php
                  $sql_query = "SELECT * 
                    FROM abast_lftm_cmp_int 
                    WHERE fch_pago != '' 
                    AND estd_comp_int = 'EN BODEGA'
                    ORDER BY num_oc_po ASC";
                  $result_set = $mysqli->query($sql_query);
                  $i = 1;
                  while ($row = mysqli_fetch_row($result_set)) {
                  ?>
                    <tr>
                      <td align="center">
                        <?php echo $row[18]; ?>
                      </td>
                      <td align="center">
                        <?php echo $row[2] . "/" . $row[3]; ?>
                      </td>
                      <td align="center">
                        <?php echo $row[4]; ?>
                      </td>
                      <td align="center">
                        <?php echo $row[13]; ?>
                      </td>
                      <td align="center">
                        <?php echo $row[21]; ?>
                      </td>
                      <td align="center">
                        <?php echo $row[30]; ?>
                      </td>
                      <td align="center">
                        <?php echo $row[14]; ?>
                      </td>
                      <td align="center">
                        <?php
                        if ($row[15] !== '') {
                          echo 'Pagado';
                        } else {
                          echo 'Sin pago';
                        }
                        ?>
                      </td>
                      <!--<td align="center">
                          <a href="javascript:view_id('<?php echo $row[0]; ?>')" class="btn btn-outline-info btn-sm">
                            <img src="img/eye.svg">
                          </a>
                        </td>
                      <td align="center">
                        <a href="javascript:edt_id('<?php echo $row[4]; ?>')" class="btn btn-outline-warning btn-sm">
                          <img src="img/pencil-square.svg">
                        </a>
                      </td>
                      <td align="center">
                        <a href="javascript:edt_upload_id('<?php echo $row[0]; ?>')" class="btn btn-outline-info btn-sm">
                          <img src="img/upload.svg">
                        </a>
                      </td>
                      <td align="center">
                        <a href="javascript:delete_id('<?php echo $row[0]; ?>')" class="btn btn-outline-danger btn-sm">
                          <img src="img/trash3.svg">
                        </a>
                      </td>-->
                    </tr>
                  <?php
                    $i++;
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  </div>
  <!------------------------------------------------------------------- SECCION DE MODALS  ------------------------------------------------------------------------>
  <!-- Modal Agregar Nueva Compra Internacional -->
  <div class="modal fade" id="modal_agreg_nueva_comp_int" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">AGREGAR NUEVA COMPRA INTERNACIONAL</h4>
        </div>
        <div class="modal-body">
          <div class="card">
            <div class="card-body">
              <div class="row justify-content-md-center align-items-center">
                <div class="col-lg-10">
                  <div class="card">
                    <div class="card-body">
                      <form method="post" enctype="multipart/form-data">
                        <table class="table">
                          <tr>
                            <td>
                              <label align="left" for="fch_inicio_solctd" class="form-label">Fecha de Inicio:</label>
                            </td>
                            <td>
                              <input type="date" class="form-control" id="fch_inicio_solctd" name="fch_inicio_solctd" required placeholder="DIA-MES-AÑO">
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <label align="left" for="prveedrs_webs" class="form-label">Proveedor:</label>
                            </td>
                            <td>
                              <select class="form-control" id="prveedrs_webs" name="prveedrs_webs">
                                <option value="">--- SELECIONE UNA OPCIÓN ---</option>
                                <option value="HEBEI">HEBEI</option>
                                <option value="WORLDWIDE SERVICE">WORLDWIDE SERVICE</option>
                                <option value="SHANGHAI SHAWN INDUSTRIAL CO. LTD">SHANGHAI SHAWN INDUSTRIAL CO. LTD</option>
                                <option value="SHANGHAI CONTROLAND ENGINEERING COMPANY"> SHANGHAI CONTROLAND ENGINEERING COMPANY</option>
                                <option value="FULMER/PERMA CAST"> FULMER/PERMA CAST</option>
                                <option value="ZHEJIANG GOODSENSE FORKLIFT CO. LTD"> ZHEJIANG GOODSENSE FORKLIFT CO. LTD</option>
                                <option value="WEST INSTRUMENTS DE MÉXICO S.A"> WEST INSTRUMENTS DE MÉXICO S.A</option>
                                <option value="CHANGZHOU BOGARD SEALS TECHNICAL">CHANGZHOU BOGARD SEALS TECHNICAL</option>
                                <option value="MORGANITE BRASIL LTDA">MORGANITE BRASIL LTDA</option>
                                <option value="ALIER (HONG KONG) BEARING CO. LTD"> ALIER (HONG KONG) BEARING CO. LTD</option>
                                <option value="DLL INC"> DLL INC</option>
                                <option value="MEGATONE">MEGATONE</option>
                                <option value="DIGIKEY">DIGIKEY</option>
                                <option value="PEI-GENESIS">PEI-GENESIS</option>
                                <option value="ALLIED">ALLIED</option>
                                <option value="VERICAL">VERICAL</option>
                                <option value="MICROFRAME">MICROFRAME</option>
                                <option value="MOUSER">MOUSER</option>
                                <option value="ONLINE COMPONENTS">ONLINE COMPONENTS</option>
                                <option value="MARTINDALE">MARTINDALE</option>
                                <option value="SKYGEEK">SKYGEEK</option>
                                <option value="CONTROLAND INTERNATIONAL LTD">CONTROLAND INTERNATIONAL LTD</option>
                                <option value="BENGBU DOUBLECIRCLE ELECTRONICS">BENGBU DOUBLECIRCLE ELECTRONICS</option>
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <label for="num_oc_po" class="form-label">N° de Orden de Compra (OC):</label>
                            </td>
                            <td>
                              <input type="text" class="form-control" id="num_oc_po" name="num_oc_po" required placeholder="INGRESE N° DE OC, SOLO DATOS NUMERICO!">
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <label for="num_oc_po" class="form-label">Tipo de Material:</label>
                            </td>
                            <td>
                              <input type="text" class="form-control" id="dscrpc_tip_mat" name="dscrpc_tip_mat" required placeholder="Ingrese el tipo del material">
                            </td>
                          </tr>
                        </table>
                        <div align="center"><button type="submit" name="btn-save" class="btn btn-primary">AGREGAR NUEVA COMPRA</button></div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary">Guardar cambios</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Editar OC -->
  <div class="modal fade" id="edit_oc_modal" tabindex="-1" role="dialog" aria-labelledby="edit_oc_modal_label" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="edit_oc_modal_label">Ver OC</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <table class="table">
            <thead>
              <tr>
                <th>Descripción</th>
                <th>Cantidad</th>
                <th>Precio</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
          <div class="row my-3">
            <div class="col">
              <input id="nueva_descripcion" type="text" class="form-control" placeholder="Nueva descripción">
            </div>
            <div class="col">
              <input id="nueva_cantidad" type="number" class="form-control" placeholder="Nueva cantidad">
            </div>
            <div class="col">
              <input id="nuevo_precio" type="number" class="form-control" placeholder="Nuevo precio">
            </div>
          </div>
          <button type="button" class="btn btn-primary mb-3" onclick="agregarLinea()">Agregar Linea</button>
          <form action="upload.php" method="post" enctype="multipart/form-data">
            <div class="input-group mb-3">
              <input type="file" class="form-control" name="fileToUpload" id="fileToUpload">
              <button class="btn btn-warning" type="submit">Subir Archivo</button>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary">Guardar cambios</button>
        </div>
      </div>
    </div>
  </div>


  <!------------------------------------------------------- FIN MODAL EDITAR OC   --------------------------------------------------------->


  <!-------- INICIO MODAL NUEVO PACKING LIST -------->
  <?php
  $query = "SELECT * FROM abast_lftm_cmp_int WHERE num_pack_lst = '' ORDER BY num_oc_po";
  $result = $mysqli->query($query);
  ?>
  <div class="modal fade" id="modal_agreg_nueva_pl" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">AGREGAR NUEVO PACKING LIST</h4>
        </div>
        <div class="modal-body">
          <div class="card">
            <div class="card-body">
              <div class="row justify-content-md-center align-items-center">
                <div class="col-lg-10">
                  <div class="card">
                    <div class="card-body">
                      <form method="post" enctype="multipart/form-data">
                        <table class="table">
                          <tr>
                            <td>
                              <label align="left" for="prveedrs_webs" class="form-label">Proveedor:</label>
                            </td>
                            <td>
                              <select class="form-control" id="prveedrs_webs" name="prveedrs_webs">
                                <option value="">--- SELECIONE UNA OPCIÓN ---</option>
                                <option value="HEBEI">HEBEI</option>
                                <option value="WORLDWIDE SERVICE">WORLDWIDE SERVICE</option>
                                <option value="SHANGHAI SHAWN INDUSTRIAL CO. LTD">SHANGHAI SHAWN INDUSTRIAL CO. LTD</option>
                                <option value="SHANGHAI CONTROLAND ENGINEERING COMPANY"> SHANGHAI CONTROLAND ENGINEERING COMPANY</option>
                                <option value="FULMER/PERMA CAST"> FULMER/PERMA CAST</option>
                                <option value="ZHEJIANG GOODSENSE FORKLIFT CO. LTD"> ZHEJIANG GOODSENSE FORKLIFT CO. LTD</option>
                                <option value="WEST INSTRUMENTS DE MÉXICO S.A"> WEST INSTRUMENTS DE MÉXICO S.A</option>
                                <option value="CHANGZHOU BOGARD SEALS TECHNICAL">CHANGZHOU BOGARD SEALS TECHNICAL</option>
                                <option value="MORGANITE BRASIL LTDA">MORGANITE BRASIL LTDA</option>
                                <option value="ALIER (HONG KONG) BEARING CO. LTD"> ALIER (HONG KONG) BEARING CO. LTD</option>
                                <option value="DLL INC"> DLL INC</option>
                                <option value="MEGATONE">MEGATONE</option>
                                <option value="DIGIKEY">DIGIKEY</option>
                                <option value="PEI-GENESIS">PEI-GENESIS</option>
                                <option value="ALLIED">ALLIED</option>
                                <option value="VERICAL">VERICAL</option>
                                <option value="MICROFRAME">MICROFRAME</option>
                                <option value="MOUSER">MOUSER</option>
                                <option value="ONLINE COMPONENTS">ONLINE COMPONENTS</option>
                                <option value="MARTINDALE">MARTINDALE</option>
                                <option value="SKYGEEK">SKYGEEK</option>
                                <option value="CONTROLAND INTERNATIONAL LTD">CONTROLAND INTERNATIONAL LTD</option>
                                <option value="BENGBU DOUBLECIRCLE ELECTRONICS">BENGBU DOUBLECIRCLE ELECTRONICS</option>
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <label for="num_pack_lst" class="form-label">Packing List:</label>
                            </td>
                            <td>
                              <input type="text" class="form-control" id="num_pack_lst" name="num_pack_lst" required placeholder="¡INGRESE N° DE PACKING LIST!">
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <label for="num_invoic" class="form-label">Invoice:</label>
                            </td>
                            <td>
                              <input type="text" class="form-control" id="num_invoic" name="num_invoic" required placeholder="¡INGRESE N° DE INVOICE!">
                            </td>
                          </tr>
                        </table>
                        <div align="center"><button type="submit" name="btn-save" class="btn btn-primary">AGREGAR PACKING LIST</button></div>
                      </form>
                      <div class="rectangle">
                        <p>OC'S Sin Packing List</p>
                        <?php
                        if ($result) {
                          while ($row = $result->fetch_assoc()) {
                            echo "<p>" . $row['num_oc_po'] . "</p>"; // Muestra el valor de la columna 'num_oc_po' para cada fila obtenida
                          }
                        }
                        ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary">Guardar cambios</button>
        </div>
      </div>
    </div>
  </div>
  <!-------- FIN MODAL NUEVO PACKING LIST -------->


  <!-------- FIN SECCION DE MODALS  -------->
  </div>
  <div class="card-footer">
    Desarrollado por el Área Informática - 2022
  </div>
  </div>
  <!-------- Modal Agregar  -------->
  <script>
    $('.openBtn_agreg_nueva_comp_int').on('click', function() {
      $('.modal-body').load('content.html', function() {
        $('#modal_agreg_nueva_comp_int').modal({
          show: true
        });
      });
    });
  </script>
  <script>
    $('.openBtn_agreg_nueva_pl').on('click', function() {
      $('.modal-body').load('content.html', function() {
        $('#modal_agreg_nueva_pl').modal({
          show: true
        });
      });
    });
  </script>
  <!-------- Modal Ver detalle de OC  -------->
  <script>
    $('.openBtn_ver_det_oc').on('click', function() {
      $('.modal-body').load('content.html', function() {
        $('#modal_ver_det_oc').modal({
          show: true
        });
      });
    });
  </script>

  <script type="text/javascript">
    function configureDataTable(tableId) {
      var table = $(tableId).DataTable({
        initComplete: function() {
          this.api().columns([2, 4, 5, 6, 7]).every(function() {
            var column = this;
            var select = $('<select><option value=""></option></select>')
              .appendTo($(column.footer()).empty())
              .on('change', function() {
                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                column.search(val ? '^' + val + '$' : '', true, false).draw();
              });
            column.data().unique().sort().each(function(d, j) {
              select.append('<option value="' + d + '">' + d + '</option>');
            });
          });
        },
        "language": {
          "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
        },
        "lengthMenu": [
          [50, 100, 150, -1],
          [50, 100, 150, "Todos"]
        ]
      });
    }

    // Llamada a la función para cada tabla
    configureDataTable('#iddatatable');
    configureDataTable('#iddatatable2');
  </script>
  <script>
    $('.openBtn_ver_det_oc').on('click', function() {
      $('.modal-body').load('content.html', function() {
        $('#modal_ver_det_oc').modal({
          show: true
        });
      });
    });
  </script>

  <script type="text/javascript">
    function configureDataTable(tableId) {
      var table = $(tableId).DataTable({
        initComplete: function() {
          this.api().columns([0, 1, 2, 3, 4, 5, 6, 7]).every(function() {
            var column = this;
            var select = $('<select><option value=""></option></select>')
              .appendTo($(column.footer()).empty())
              .on('change', function() {
                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                column.search(val ? '^' + val + '$' : '', true, false).draw();
              });
            column.data().unique().sort().each(function(d, j) {
              select.append('<option value="' + d + '">' + d + '</option>');
            });
          });
        },
        "language": {
          "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
        },
        "lengthMenu": [
          [50, 100, 150, -1],
          [50, 100, 150, "Todos"]
        ]
      });
    }

    // Llamada a la función para cada tabla
    configureDataTable('#iddatatable3');
    configureDataTable('#iddatatable4');
    configureDataTable('#iddatatable5');
  </script>

  <script>
    function openModal(button) {
      var num_oc_po = button.getAttribute('data-num_oc_po');
      // Aquí puedes realizar la solicitud AJAX con el valor de num_oc_po y actualizar el contenido del modal
      $.ajax({
        url: 'get_data.php',
        type: 'GET',
        data: {
          num_oc_po: num_oc_po
        },
        success: function(data) {
          // Configurar el título del modal con la OC seleccionada
          $("#edit_oc_modal_label").text("OC - " + num_oc_po);
          $('#edit_oc_modal .modal-body table tbody').html(data);
          $('#edit_oc_modal').modal('show');
        },
        error: function() {
          alert('Error al obtener los datos');
        }
      });
    }

    function closeModal() {
      $('#edit_oc_modal').modal('hide');
    }
  </script>

  <script>
    function agregarLinea() {
      var num_oc_po = document.querySelector("[data-num_oc_po]").getAttribute("data-num_oc_po");
      var nueva_descripcion = document.getElementById("nueva_descripcion").value;
      var nueva_cantidad = document.getElementById("nueva_cantidad").value;
      var nuevo_precio = document.getElementById("nuevo_precio").value;

      $.ajax({
        url: 'add_line.php',
        type: 'POST',
        data: {
          num_oc_po: num_oc_po,
          nueva_descripcion: nueva_descripcion,
          nueva_cantidad: nueva_cantidad,
          nuevo_precio: nuevo_precio
        },
        success: function() {
          // Actualizar el modal para reflejar la nueva línea
          openModal(document.querySelector("[data-num_oc_po]"));
        },
        error: function() {
          alert('Error al agregar la línea');
        }
      });
    }
  </script>

</body>

</html>
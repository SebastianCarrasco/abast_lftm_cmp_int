<?php 
//session_start();
//if (!isset($_SESSION['tipo']) && $_SESSION['tipo'] !== 'ABSTADM') {
  //  header('Location: ../index.php');
    //die();
//}
?>
<?php
include_once 'dbconfig.php';

if(isset($_GET['edit_id']))
{
    $sql_query="SELECT * FROM abast_lftm_cmp_int WHERE id=".$_GET['edit_id'];
    $result_set = $mysqli->query($sql_query);
    $fetched_row=mysqli_fetch_array($result_set,MYSQLI_ASSOC);
}
?>
<?php 
$num_oc_grabar = $fetched_row['num_oc_po'];
$fech_creac_oc = $fetched_row['fch_inicio_solctd'];
$proveed_web = $fetched_row['prveedrs_webs'];
$pais_proveed = $fetched_row['pais_prveedr'];
echo $fech_creac_oc;
echo $proveed_web;
echo $pais_proveed;
?>
<?php
include_once 'dbconfig.php';
require_once('vendor/php-excel-reader/excel_reader2.php');
require_once('vendor/SpreadsheetReader.php');

if (isset($_POST["import"]))
{
$allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

if(in_array($_FILES["file"]["type"],$allowedFileType)){

        $targetPath = 'subidas/'.$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
        
        $Reader = new SpreadsheetReader($targetPath);
        
        $sheetCount = count($Reader->sheets());
        for($i=0;$i<$sheetCount;$i++)
        {
            
            $Reader->ChangeSheet($i);
            
            foreach ($Reader as $Row)
            {
                $dscrpc_tip_mat = "";
                if(isset($Row[0])) {
                    $dscrpc_tip_mat = $mysqli->real_escape_string($Row[0]);
                }
				
                $num_part_mat = "";
                if(isset($Row[1])) {
                    $num_part_mat = $mysqli->real_escape_string($Row[1]);
                }
				
                $dscrpc_mat = "";
                if(isset($Row[2])) {
                    $dscrpc_mat = $mysqli->real_escape_string($Row[2]);
                }

                $cant_po = "";
                if(isset($Row[3])) {
                    $cant_po = $mysqli->real_escape_string($Row[3]);
                }
                
                $vlr_usd = "";
                if(isset($Row[4])) {
                    $vlr_usd = $mysqli->real_escape_string($Row[4]);
                }

                if (!empty($dscrpc_tip_mat) || !empty($num_part_mat) || !empty($dscrpc_mat) || !empty($cant_po) || !empty($vlr_usd)) {
                    $query = "insert into abast_lftm_cmp_int(prveedrs_webs, pais_prveedr, fch_inicio_solctd, num_oc_po, dscrpc_tip_mat, num_part_mat, dscrpc_mat, cant_po, vlr_usd) values('".$proveed_web."','".$pais_proveed."','".$fech_creac_oc."','".$num_oc_grabar."','".$dscrpc_tip_mat."','".$num_part_mat."','".$dscrpc_mat."','".$cant_po."','".$vlr_usd."')";
                    $resultados = $mysqli->query($query);
                
                    if (! empty($resultados)) {
                        $type = "success";
                        $message = " Excel importado correctamente";
                    } else {
                        $type = "error";
                        $message = " Hubo un problema al importar registros";
                    }
                }
             }
         }
    }
    else
    { 
        $type = "error";
        $message = "El archivo enviado es invalido. Por favor vuelva a intentarlo";
  }
}
?>
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
</head>
<body>
<!--- Incio Boostrap---->
<div class="card text-center">
    <div class="card-header">
        <table>
            <tr>
                <td>
                <img src="img/logo_1.png" width="150" height="47">
                </td>
                <td align="left">
                    <h5 class="quote">&nbsp&nbsp&nbsp&nbspSistema de Compras Internacionales</h5>
                    <h6 class="quote"><?php echo "&nbsp&nbsp&nbsp&nbspUsuario: ".$_SESSION['usuario'];?>&nbsp|&nbsp<a href="../logout.php">Cerrar Sesión</a></h6>
                    &nbsp&nbsp&nbsp&nbsp<button type="button" class="btn btn-outline-success btn-sm" onClick="history.go(-1);"><<< Volver Atrás</button></td>
                </td>
            </tr>
        </table>
    </div>
    <div class="card-body">
        <div class="row justify-content-md-center align-items-center">
            <div class="row">
                <div class="col-12 col-md-12"> 
                <!-- Contenido -->
                    <div class="outer-container">
                    <H4>Carga de excel con detalle de OC N°: <?php echo $num_oc_grabar;?> &nbsp Creada el : <?php $creacDate = $fech_creac_oc;
                        $newCreateDate = date("d/M/y", strtotime($creacDate));
                        echo $newCreateDate;?> </H4>
                        <div>
                        <form action="" method="post" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
                        <label>Elija Archivo Excel con datos a importar</label>
                        <br>
                        <input type="file" name="file" id="file" accept=".xls,.xlsx">
                        <br>
                        <br>
                        <button type="submit" id="submit" name="import" class="btn-submit btn btn-success">Importar Registros</button>
                        </form>
                        </div>
                    </div>
                <div id="response" class="<?php if(!empty($type)) { echo $type . " display-block"; } ?>"><?php if(!empty($message)) { echo $message; } ?></div>
            <hr>
            <div align="center">
            <p>Instrucciones: para subir datos a la OC agregarlos en archivos archivo excel que se encuentra <a href="img/ejemplo.xlsx"><strong>AQUI</strong></a>, las columnas son:
            Tipo de Material / Numero de Parte / Descripción del elemento / cantidad / valor unidad USD. las columnas no deben llevar nombre o encabezado, solo los datos, como se muestra en imagen adjunta </p>  
            <img src="img/ejemplo_excel.jpg" alt="">
            <br>
            </div>
        </div>
    
        <br><br>
    
    </div>
    </div>
    </div>
    <div class="card-footer text-muted">
        <h6>Desarrollado por el área informática de Electrans - 2022</h6>
    </div>
</div>
<!--- fin Boostrap---->
</body>
</html>

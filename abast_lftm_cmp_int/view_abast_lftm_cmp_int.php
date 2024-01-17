<?php 
//session_start();
//if (!isset($_SESSION['tipo']) && $_SESSION['tipo'] !== 'ABSTADM') {
  //  header('Location: ../index.php');
    //die();
//}
?>
<?php
include_once 'dbconfig.php';

if(isset($_GET['view_id']))
{
 $sql_query="SELECT * FROM abast_lftm_cmp_int WHERE id=".$_GET['view_id'];
 $result_set=mysqli_query($con,$sql_query);
 $fetched_row=mysqli_fetch_array($result_set,MYSQLI_ASSOC);
}
?>
<?php
$num_oc_cons = $fetched_row['num_oc_po'];
?>
<?php
$sql_query_sum="SELECT SUM(total_en_po) as SUMA FROM abast_lftm_cmp_int WHERE num_oc_po=".$num_oc_cons;
$result_set_sum=mysqli_query($con,$sql_query_sum);
$fetched_row_sum=mysqli_fetch_array($result_set_sum,MYSQLI_ASSOC);

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
  <style>
        tfoot {
          display: table-header-group;
        }
        #contenidoTabla {
          font-size: 10px;
        }
        td {
          font-size: 12px;
        }

        th {
          font-size: 12px;
        }
    </style>
  <?php require_once "scripts.php"; ?>
</head>
<body>
<!-- Inicio de la Pagina -->
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
      <h2>Detalle de Compra Internacional</h2>
      <br>
      <div class="table-responsive">
         <table class="table table-bordered" id="table_view">
            <tr>
               <td>
                  <label for="fch_inicio_solctd" class="form-label">Fecha de Inicio:</label>
                  <th > <?php $originalDate = $fetched_row['fch_inicio_solctd'];
                  $newDate = date("d/M/y", strtotime($originalDate));
                  echo $newDate;
                  ?></th>
               </td>
               <td>
               <label for="prveedrs_webs" class="form-label">Proveedor o Pagina Web:</label>
               <th> <?php echo $fetched_row['prveedrs_webs'] ?></th> 
               </td>
               <td>
                  <label for="fch_inicio_solctd" class="form-label">País del Proveedor:</label>
                  <th> <?php echo $fetched_row['pais_prveedr'] ?></th>
               </td>
            </tr>
            <tr>
               <td>
                  <label for="num_oc_po" class="form-label">N° de OC:</label>
                  <th> <?php echo $fetched_row['num_oc_po'] ?></th>
               </td>
               
               <td>
                  <label for="fch_pago" class="form-label">Fecha de Recepción en Bodega:</label>
                  <th><?php $originalDate = $fetched_row['fch_rcpcn_abast'];
                  $newDate2 = date("d/M/y", strtotime($originalDate));
                  echo $newDate2;
                  ?></th>
               </td>
               <td>
               <label for="tip_trnsp" class="form-label">Tipo de Transporte:</label>
               <th> <?php echo $fetched_row['tip_trnsp'] ?></th>
               </td>
            </tr>
         <tr>
            <td>
               <label for="num_invoic" class="form-label">Total Compra en USD:</label>
               <th> <?php echo '$'.$fetched_row_sum['SUMA'];?></th>
            </td>
            <td>
               <label for="num_pack_lst" class="form-label">Fecha envío Agente Aduanero:</label>
               <th><?php $originalDate = $fetched_row['fch_doc_env_agnt'];
                  $newDate3 = date("d/M/y", strtotime($originalDate));
                  echo $newDate3;
                  ?></th>  
            </td>
            <td>
               <label for="tip_trnsp" class="form-label">Observaciones:</label>
               <th> <?php echo $fetched_row['observ'] ?></th>
            </td>
         </tr>
      </table>
      <hr>
      <table class="table table-hover table-condensed table-bordered" id="iddatatable" style="width:100%" >
		   <thead style="background-color: #4c6176;color: white; ">
          <tr>
              <th>N°</th>
              <th>Tipo Material</th>
              <th>N° Parte</th>
              <th>Descripción</th>
              <th>Cantidad</th>
              <th>Valor USD</th>
              <th>Enviados</th>
              <th>Pendiente</th>
              <th>Total en USD</th>
              <th>Estado</th>
              <th>Fecha Pago</th>
              <th>N° Invoice</th>
              <th>PDF Invoice</th>
              <th>N° Packing</th>
              <th>PDF Packing</th>
              <th>N° AWB</th>
              <th>PDF AWB</th>
              <th>Fecha Salida</th>
              <th>Currier</th>
              <th>N° NID</th>
              <th>Pago NID</th>
              <th>N° OT PDQ</th>
              <th>PDF OT PDQ</th>
              <th>Valor OT PDQ</th>
              <th>Comprobante</th>
              <th>Valor Currier</th>
              <th>Fecha Pago Transp. Nac.</th>
          </tr>
         </thead>
         <tbody >
          <?php
              $sql_query="select Id,
              dscrpc_tip_mat,
              num_part_mat,
              dscrpc_mat,
              cant_po,
              vlr_usd,
              cant_env_invc,
              cnt_pnd_env,
              total_en_po,
              estd_comp_int,
              fch_pago,
              num_invoic,
              file_invoice,
              num_pack_lst,
              file_pack_lst,
              num_awb_bl,
              file_num_awb_bl,
              fch_slda,
              curr_cmp_int,
              num_nid,
              fch_pag_nid,
              num_ot_pdq,
              file_ot_pdq,
              vlr_ot_pdq,
              pdf_cmprbnte,
              vlr_int_courr,
              fch_pag_trnsp_nac
              FROM abast_lftm_cmp_int WHERE num_oc_po =".$num_oc_cons;
              $result_set=mysqli_query($con,$sql_query);
              $i=1;
              while($row=mysqli_fetch_row($result_set))
              {
                ?>
                      <tr>
                      <td align="center" ><?php echo $i; ?></td>
                      <td align="center" ><?php echo $row[1];?></a></td>
                      <td align="center" ><?php echo $row[2];?></a></td>
                      <td ><?php echo $row[3];?></a></td>
                      <td align="center" ><?php echo $row[4];?></a></td>
                      <td align="center" ><?php echo $row[5];?></a></td>
                      <td align="center" ><?php echo $row[6];?></a></td>
                      <td align="center" ><?php echo 
                      $row[4] - $row[6];?></a></td>
                      <td align="center" ><?php echo $row[8];?></a></td>
                      <td align="center" ><?php echo $row[9];?></a></td>
                      <td align="center" ><?php echo $row[10];?></a></td>
                      <td align="center" ><?php echo $row[11];?></a></td>
                      <td align="center" ><?php echo $row[12];?></a></td>
                      <td align="center" ><?php echo $row[13];?></a></td>
                      <td align="center" ><?php echo $row[14];?></a></td>
                      <td align="center" ><?php echo $row[15];?></a></td>
                      <td align="center" ><?php echo $row[16];?></a></td>
                      <td align="center" ><?php echo $row[17];?></a></td>
                      <td align="center" ><?php echo $row[18];?></a></td>
                      <td align="center" ><?php echo $row[19];?></a></td>
                      <td align="center" ><?php echo $row[20];?></a></td>
                      <td align="center" ><?php echo $row[21];?></a></td>
                      <td align="center" ><?php echo $row[22];?></a></td>
                      <td align="center" ><?php echo $row[23];?></a></td>
                      <td align="center" ><?php echo $row[24];?></a></td>
                      <td align="center" ><?php echo $row[25];?></a></td>
                      <td align="center" ><?php echo $row[26];?></a></td>
                      </tr>
                      <?php
                    $i++;  
              }
              ?>
            </tbody>
         </table>
      </div>
      <div class="card-footer text-muted">
         <h6>Desarrollado por el área informática de Electrans - 2022</h6>
</div>
</div>
<!-- Fin de la Pagina -->
</body>
</html>


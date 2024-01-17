<?php 
//session_start();
//if (!isset($_SESSION['tipo']) && $_SESSION['tipo'] !== 'ABSTADM') {
    //header('Location: ../index.php');
    //die();
//}
?>

<?php
////////////////// CONEXION A LA BASE DE DATOS ////////////////////////////////////
$host="localhost";
$usuario="root";
$contraseña="";
$base="electrans_dsrrllo";

$conexion= new mysqli($host, $usuario, $contraseña, $base);
if ($conexion -> connect_errno)
{
	die();
}

/////////////////////// CONSULTA A LA BASE DE DATOS ////////////////////////

$edit_comp="SELECT * FROM abast_lftm_cmp_int WHERE num_oc_po=".$_GET['edit_id'];
$EditComp=$conexion->query($edit_comp);
?>
<?php require_once "scripts.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Electrans - Intranet</title>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
<link rel="icon" href="img/favicon.ico" type="image/x-icon">
</head>
<body>
<!--- NUEVO CONTENEDOR --->
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
			<div class="alert alert-info">
				<h2>Actualizar Registros de la Orden de Compra N°<?php echo $_GET['edit_id']  ;?></h2>
			</div>
			<br>
			<form method="post">
			<table class="table">
				<tr>
					<th>Tipo de Material</th>
					<th>N° de Parte</th>
					<th>Descripcion</th>
                    <th>Cant.</th>
					<th>Valor USD</th>
					<th>Estado Compra</th>
					<th>Fecha Pago</th>
					<th>N° Invoice</th>
					<th>N° Packing</th>
					<th>Transporte</th>
					<th>Fecha Env. Aduana</th>
				</tr>
				<?php
				while ($EditarCompras = $EditComp->fetch_array(MYSQLI_BOTH))
				{
					echo'<tr>
						<td hidden><input name="id_comp[]" value="'.$EditarCompras['id'].'"/></td>
						
						<td><input name="dscrpcnmat['.$EditarCompras['id'].']" value="'.$EditarCompras['dscrpc_tip_mat'].'" /></td>
						<td><input  size=10 name="numpart['.$EditarCompras['id'].']" value="'.$EditarCompras['num_part_mat'].'" /></td>
						<td><input  size=35 name="descrp['.$EditarCompras['id'].']" value="'.$EditarCompras['dscrpc_mat'].'"/></td>
						<td><input  size=2 name="cntpo['.$EditarCompras['id'].']" value="'.$EditarCompras['cant_po'].'" /></td>
						<td><input  size=3 name="vlrusd['.$EditarCompras['id'].']" value="'.$EditarCompras['vlr_usd'].'" /></td>
						<td>
						<select class="form-select" aria-label="Default select example" name="estdcomp['.$EditarCompras['id'].']"/>
							<option selected="'.$EditarCompras['estd_comp_int'].'">'.$EditarCompras['estd_comp_int'].'</option>
							<option value="NO ENVIADO">NO ENVIADO</option>
							<option value="SOLO ENVIO OC">SOLO ENVIO OC</option>
							<option value="EN TRANS. INTERNAC.">EN TRANS. INTERNAC.</option>
							<option value="PDTE. ENVÍO CARGA">PDTE. ENVÍO CARGA</option>
							<option value="PDTE. ENVÍO CARGA PARCIAL">PDTE. ENVÍO CARGA PARCIAL</option>
							<option value="PDTE. EN ADUANA">PENDIENTE ADUANA</option>
							<option value="EN TRANS. PROVEEDOR.">EN TRANS. PROVEEDOR.</option>
							<option value="EN TRANS. STGO AFTA.">EN TRANS. STGO AFTA.</option>
							<option value="EN TRANS. MEJILL. AFTA.">EN TRANS. MEJILL. AFTA.</option>
							<option value="EN BODEGA">EN BODEGA</option>
							<option value="SIN INFO">SIN INFO</option>
						</select>
						</td>
						<td><input type="date" name="fchpago['.$EditarCompras['id'].']" value="'.$EditarCompras['fch_pago'].'" /></td>
						<td><input size=7 name="numinvoic['.$EditarCompras['id'].']" value="'.$EditarCompras['num_invoic'].'" /></td>
						<td><input size=7 name="numpacklst['.$EditarCompras['id'].']" value="'.$EditarCompras['num_pack_lst'].'" /></td>
						<td>
						<select class="form-select" aria-label="Default select example" name="tiptrnsp['.$EditarCompras['id'].']"/>
							<option selected="'.$EditarCompras['tip_trnsp'].'">'.$EditarCompras['tip_trnsp'].'</option>
							<option value="AEREO">AEREO</option>
							<option value="MARITIMO">MARITIMO</option>
							<option value="TERRESTRE">TERRESTRE</option>
							<option value="SIN INFO">SIN INFO</option>
						</select>
						</td>
						<td><input type="date" name="fchdocenvagnt['.$EditarCompras['id'].']" value="'.$EditarCompras['fch_doc_env_agnt'].'" /></td>
						</tr>';
				}
				?>
			</table>
			<div align="center"><input type="submit" name="actualizar" value="Actualizar Registros" class="btn btn-info col-md-offset-9" /></div>
			<br>
			</form>
			<?php
			if(isset($_POST['actualizar']))
			{
				foreach ($_POST['id_comp'] as $ids) 
				{
					$editdscrpcnmat=mysqli_real_escape_string($conexion, $_POST['dscrpcnmat'][$ids]);
					$editnumpart=mysqli_real_escape_string($conexion, $_POST['numpart'][$ids]);
					$editdescrp=mysqli_real_escape_string($conexion, $_POST['descrp'][$ids]);
                    $editcntpo=mysqli_real_escape_string($conexion, $_POST['cntpo'][$ids]);
                    $editvlrusd=mysqli_real_escape_string($conexion, $_POST['vlrusd'][$ids]);
					$editestdcomp=mysqli_real_escape_string($conexion, $_POST['estdcomp'][$ids]);
					$editfchpago=mysqli_real_escape_string($conexion, $_POST['fchpago'][$ids]);
					$editnuminvoic=mysqli_real_escape_string($conexion, $_POST['numinvoic'][$ids]);
					$numpacklst=mysqli_real_escape_string($conexion, $_POST['numpacklst'][$ids]);
					$numtiptrnsp=mysqli_real_escape_string($conexion, $_POST['tiptrnsp'][$ids]);
					$fchdocenvagnt=mysqli_real_escape_string($conexion, $_POST['fchdocenvagnt'][$ids]);
					$actualizar=$conexion->query("UPDATE abast_lftm_cmp_int 
                    SET 
                    dscrpc_tip_mat='$editdscrpcnmat',
                    num_part_mat='$editnumpart',
                    dscrpc_mat='$editdescrp',
                    cant_po='$editcntpo',
                    vlr_usd='$editvlrusd', 
					estd_comp_int='$editestdcomp',
					fch_pago='$editfchpago',
					num_invoic='$editnuminvoic',
					num_pack_lst='$numpacklst',
					tip_trnsp='$numtiptrnsp',
					fch_doc_env_agnt='$fchdocenvagnt'
					WHERE id='$ids'");
				}
				if($actualizar==true)
				{
					echo "<script>
						alert('COMPRA ACTUALIZADA EXITOSAMENTE!!!');
						window.location.href = 'edit_abast_lftm_cmp_int.php?edit_id=" . $_GET['edit_id'] . "';
					</script>";

				}
				else
				{
					echo "NO SE REALIZÓ LA ACTUALIZACIÓN!";
				}
			}
			?>
	</div>
	<div class="card-footer text-muted">
		<h6>Desarrollado por el área informática de Electrans - 2022</h6>
	</div>
</div>

<!--- FIN NUEVO CONTENEDOR --->
</body>
</html>
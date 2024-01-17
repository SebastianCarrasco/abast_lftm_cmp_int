<?php 

	class conectar{
		public function conexion(){
			$conexion=mysqli_connect('localhost',
										'root',
										'',
										'electrans_dsrrllo');
			return $conexion;
		}
	}
 ?>
 <?php
$mysqli=new mysqli('localhost','root','','electrans_dsrrllo');
$mysqli->set_charset("utf8");
if ($mysqli->connect_errno) {
  echo "Error al conectarse con My SQL debido al error".$mysqli->connect_error;
}
?>
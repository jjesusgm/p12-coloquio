<?php require_once('Connections/conColoquio.php'); ?>
<?php 
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// INICIO: Actualizar en la base de datos el estatus y fecha de estatus del comprobante de pago
if(! $conColoquio ) {
   die('No se pudo conectar: ' . mysql_error());
}

date_default_timezone_set('America/Mexico_City');
$user_id = $_SESSION['MM_Username'];
$current_date_time = date('Y-m-d H:i:s');

$sql = "UPDATE usuarios ". "SET ultimo_acceso = '$current_date_time' ". 
   "WHERE username = '$user_id'" ;
mysql_select_db('coloquio_ie');
$retval = mysql_query( $sql, $conColoquio );

if(! $retval ) {
   die('No se pudo actualizar la informacion: ' . mysql_error());
}
echo "Informacion actualizada correctamente\n";

mysql_close($conColoquio);
// FIN: Actualizar en la base de datos el estatus y fecha de estatus del comprobante de pago

// Redirigimos al usuario al archivo sube_comp_pago.php
header('Location: index.php');
?>
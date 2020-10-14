<?php 
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

if (isset($_GET['archivo'])) {
	$mensaje = '';
	$file = $_GET['archivo'];
	
	// INICIO: Eliminamos el archivo del disco duro
	if (!unlink($file)) {
	  $mensaje = '<table class="TBL_MsgError"><tr><th scope="row">&nbsp;</th><td>Error al tratar de eliminar el archivo '.substr($file, strpos($file, $_SESSION['MM_Username'])).'</td></tr></table>';
	} else {
	  $mensaje = '<table class="TBL_MsgOk"><tr><th scope="row">&nbsp;</th><td>Archivo '.substr($file, strpos($file, $_SESSION['MM_Username'])).' eliminado con exito</td></tr></table>';
	}
	// INICIO: Eliminamos el archivo del disco duro
	
	if (strlen($mensaje) > 0) {
		$_SESSION['mensaje'] = $mensaje;
	}
	
	// Redirigimos al usuario al archivo sube_comp_pago.php
    header('Location: form_ponencia.php');
}
?>
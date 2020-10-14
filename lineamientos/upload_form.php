<?php require_once('../Connections/conColoquio.php'); ?>
<?php 
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == 'Subir al servidor') {
	$mensaje = '';
	if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK) {
		
    	// Se obtienen los detalles del archivo subido
		$fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
		$fileName = $_FILES['uploadedFile']['name'];
		$fileSize = $_FILES['uploadedFile']['size'];
		$fileType = $_FILES['uploadedFile']['type'];
		$fileNameCmps = explode(".", $fileName);
		$fileExtension = strtolower(end($fileNameCmps));
        
		// Se asigna un nuevo nombre al archivo subido, utilizando el nombre de usuario
        $newFileName = $_SESSION['MM_Username'] . '.' . $fileExtension;
        
		// Solo permitir las extensiones de archivo adecuadas
        $allowedfileExtensions = array('docx', 'pdf', 'zip');
		
		if (in_array($fileExtension, $allowedfileExtensions)) {
        	// Directorio al que se debe mover el archivo que se subio
            $uploadFileDir = './ponencias/';
            $dest_path = $uploadFileDir . $newFileName;
			
			// Establecemos el mensaje apropiado que se mostrará a los usuarios
            if(move_uploaded_file($fileTmpPath, $dest_path)) {
				$mensaje ='<table class="TBL_MsgOk"><tr><th scope="row">&nbsp;</th><td>El archivo se subió correctamente.</td></tr></table>';
				
				// INICIO: Actualizar en la base de datos el estatus y fecha de estatus del comprobante de pago
				if(! $conColoquio ) {
				   die('No se pudo conectar: ' . mysql_error());
				}
				
				$user_id = $_SESSION['MM_Username'];
				$arch_pon_status = "Subido";
				date_default_timezone_set('America/Mexico_City');
				$current_date = date('Y-m-d');
				
				$sql = "UPDATE usuarios ".
						"SET arch_pon_stat = '$arch_pon_status', arch_pon_fecha = '$current_date' ". 
				   		"WHERE username = '$user_id'" ;
				mysql_select_db('coloquio_ie');
				$retval = mysql_query( $sql, $conColoquio );
				
				if(! $retval ) {
				   die('No se pudo actualizar la informacion: ' . mysql_error());
				}
				echo "Informacion actualizada correctamente\n";
				
				mysql_close($conColoquio);
				// FIN: Actualizar en la base de datos el estatus y fecha de estatus del comprobante de pago
            } else {
				$mensaje = '<table class="TBL_MsgError"><tr><th scope="row">&nbsp;</th><td>Se presentó un error al mover el archivo a la carpeta de destino. Comuniquese con el administrador para que se asegure de que se puede escribir en esa carpeta.</td></tr></table>';
            }
		} else {
			$mensaje = '<table class="TBL_MsgError"><tr><th scope="row">&nbsp;</th><td>El tipo de archivo seleccionado no está permitido.</td></tr></table>';
		}
	} else {
		$mensaje = '<table class="TBL_MsgError"><tr><th scope="row">&nbsp;</th><td>No se pudo subir el archivo al servidor.</td></tr></table>';
	}
	
	if (strlen($mensaje) > 0) {
		$_SESSION['mensaje'] = $mensaje;
	}
	
	// Redirigimos al usuario al archivo sube_comp_pago.php
    header('Location: form_ponencia.php');
}
?>
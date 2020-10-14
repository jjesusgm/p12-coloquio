<?php require_once('../Connections/conColoquio.php'); ?>
<?php mysql_set_charset('utf8'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "../index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE usuarios SET nip=%s, nivel_de_acceso=%s, ciclo_de_ingreso=%s, email=%s, ultimo_acceso=%s, ape_pat=%s, ape_mat=%s, nombres=%s, sexo=%s, fecha_nacimiento=%s, id_universidad=%s, univ_otra=%s, id_grado_acad=%s, grado_acad_otro=%s, num_celular=%s, comp_pago_stat=%s, comp_pago_fecha=%s, arch_pon_stat=%s, arch_pon_fecha=%s, pres_pon_stat=%s, pres_pon_fecha=%s, comentario1=%s, comentario2=%s WHERE username=%s",
                       GetSQLValueString($_POST['fNip'], "text"),
                       GetSQLValueString($_POST['fNivelDeAcceso'], "text"),
                       GetSQLValueString($_POST['fCicloDeIngreso'], "text"),
                       GetSQLValueString($_POST['fEmail'], "text"),
                       GetSQLValueString($_POST['fUltimoAcceso'], "date"),
                       GetSQLValueString($_POST['fApePat'], "text"),
                       GetSQLValueString($_POST['fApeMat'], "text"),
                       GetSQLValueString($_POST['fNombres'], "text"),
                       GetSQLValueString($_POST['fSexo'], "text"),
                       GetSQLValueString($_POST['fFechaNacimiento'], "date"),
                       GetSQLValueString($_POST['fIdUniversidad'], "int"),
                       GetSQLValueString($_POST['fUnivOtra'], "text"),
                       GetSQLValueString($_POST['fIdGradoAcad'], "int"),
                       GetSQLValueString($_POST['fGradoAcadOtro'], "text"),
                       GetSQLValueString($_POST['fNumCelular'], "text"),
                       GetSQLValueString($_POST['fCompPagoStat'], "text"),
                       GetSQLValueString($_POST['fCompPagoFecha'], "date"),
                       GetSQLValueString($_POST['fArchPonStat'], "text"),
                       GetSQLValueString($_POST['fArchPonFecha'], "date"),
                       GetSQLValueString($_POST['fPresPonStat'], "text"),
                       GetSQLValueString($_POST['fPresPonFecha'], "date"),
                       GetSQLValueString($_POST['fComentario1'], "text"),
                       GetSQLValueString($_POST['fComentario2'], "text"),
                       GetSQLValueString($_POST['fUsername'], "text"));

  mysql_select_db($database_conColoquio, $conColoquio);
  $Result1 = mysql_query($updateSQL, $conColoquio) or die(mysql_error());

  $updateGoTo = "lst_usr.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_rsUsuario = "-1";
if (isset($_GET['username'])) {
  $colname_rsUsuario = $_GET['username'];
}
mysql_select_db($database_conColoquio, $conColoquio);
$query_rsUsuario = sprintf("SELECT * FROM usuarios WHERE username = %s", GetSQLValueString($colname_rsUsuario, "text"));
$rsUsuario = mysql_query($query_rsUsuario, $conColoquio) or die(mysql_error());
$row_rsUsuario = mysql_fetch_assoc($rsUsuario);
$totalRows_rsUsuario = mysql_num_rows($rsUsuario);

mysql_select_db($database_conColoquio, $conColoquio);
$query_rsNivelesDeAcceso = "SELECT * FROM usr_niveles_acceso ORDER BY nivel_de_acceso ASC";
$rsNivelesDeAcceso = mysql_query($query_rsNivelesDeAcceso, $conColoquio) or die(mysql_error());
$row_rsNivelesDeAcceso = mysql_fetch_assoc($rsNivelesDeAcceso);
$totalRows_rsNivelesDeAcceso = mysql_num_rows($rsNivelesDeAcceso);

mysql_select_db($database_conColoquio, $conColoquio);
$query_rsUniversidades = "SELECT * FROM list_universidades ORDER BY universidad ASC";
$rsUniversidades = mysql_query($query_rsUniversidades, $conColoquio) or die(mysql_error());
$row_rsUniversidades = mysql_fetch_assoc($rsUniversidades);
$totalRows_rsUniversidades = mysql_num_rows($rsUniversidades);

mysql_select_db($database_conColoquio, $conColoquio);
$query_rsGradosAcademicos = "SELECT * FROM list_grado_acad ORDER BY grado_academico ASC";
$rsGradosAcademicos = mysql_query($query_rsGradosAcademicos, $conColoquio) or die(mysql_error());
$row_rsGradosAcademicos = mysql_fetch_assoc($rsGradosAcademicos);
$totalRows_rsGradosAcademicos = mysql_num_rows($rsGradosAcademicos);
?>
<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/t_coloquio_p12.dwt" codeOutsideHTMLIsLocked="false" -->
<!-- InstanceParam name="body" type="text" value="" -->
<!-- InstanceParam name="focusFormElement" type="text" value="show_hide_fields_on_edit();" -->
<!-- InstanceBeginEditable name="RegionHead" -->
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="author" content="Jose de Jesus Gutierrez Martinez" />
<title>7° Coloquio de Investigación Educativa en Prepa 12, PRIMER NACIONAL</title>
<style type="text/css">
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
<link href="../css/divs.css" rel="stylesheet" type="text/css" />
<link href="../css/enlaces.css" rel="stylesheet" type="text/css" />
<link href="../css/formularios.css" rel="stylesheet" type="text/css" />
<link href="../css/imagenes.css" rel="stylesheet" type="text/css" />
<link href="../css/menu1.css" rel="stylesheet" type="text/css" />
<link href="../css/tablas.css" rel="stylesheet" type="text/css" />
<link href="../css/varios.css" rel="stylesheet" type="text/css" />
<link href="../widgets/jquery-ui/jquery-ui.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/menus.js"></script>
<script type="text/javascript" src="../widgets/jquery-ui/external/jquery/jquery.js"></script>
<script type="text/javascript" src="../widgets/jquery-ui/jquery-ui.js"></script>
<script type="text/javascript" src="../js/show_hide_fields.js"></script>
<script>
$( function() {
	$( "#fFechaNacimiento" ).datepicker({
		changeMonth:true,
		changeYear:true,
		dateFormat: "yy-mm-dd",
		yearRange: "1950:2019",
		firstDay:1,
		minDate:new Date(2019-70,1,1),
		maxDate:new Date(2019-15,12,1),
		showOn:"button",
		showButtonPanel:true,
		monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic" ]
	});
	$( "#fCompPagoFecha" ).datepicker({
		dateFormat: "yy-mm-dd",
		yearRange: "2019:2019",
		firstDay:1,
		minDate:new Date(2019,1,1),
		maxDate:new Date(2019,12,1),
		showOn:"button",
		showButtonPanel:true,
		monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ]
	});
	$( "#fArchPonFecha" ).datepicker({
		dateFormat: "yy-mm-dd",
		yearRange: "2019:2019",
		firstDay:1,
		minDate:new Date(2019,1,1),
		maxDate:new Date(2019,12,1),
		showOn:"button",
		showButtonPanel:true,
		monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ]
	});
	$( "#fPresPonFecha" ).datepicker({
		dateFormat: "yy-mm-dd",
		yearRange: "2019:2019",
		firstDay:1,
		minDate:new Date(2019,1,1),
		maxDate:new Date(2019,12,1),
		showOn:"button",
		showButtonPanel:true,
		monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ]
	});
 }
);
</script>
</head>
<!-- InstanceEndEditable -->
<body onload="show_hide_fields_on_edit();">
<div id="div_hdr_links">
<?php if(isset($_SESSION['MM_Username'])){?>
Bienvenido, <strong><?php echo $_SESSION['MM_Username']; ?></strong>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo $logoutAction; ?>">Cerrar sesion</a>
<?php }else{ ?>
Ninguna sesion iniciada&nbsp;&nbsp;&nbsp;&nbsp;<a href="../login.php">Iniciar sesion</a>
<?php } ?></div>
<div id="div_hdr_logo"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0"><tr><td><a href="http://www.udg.mx/" target="_blank"><img src="../imagenes/logo.jpg" alt="Banner Red Universitaria de Jaliasco" width="350" height="82" class="opaca" /></a></td><td align="right"><table border="0">
  <tr>
    <td><a href="https://www.facebook.com/coloquioprepa12/" target="_blank"><img src="../imagenes/rs_facebook_3.png" alt="Facebook" width="32" height="32" class="opaca"></a></td>
    <td><a href="https://twitter.com/coloquioprepa12" target="_blank"><img src="../imagenes/rs_twitter_3.png" alt="Twitter" width="32" height="32" class="opaca"></a></td>
    <td><a href="https://www.youtube.com/channel/UCQQazLioUpSawwnajslv6dA" target="_blank"><img src="../imagenes/rs_youtube_3.png" alt="Youtube" width="32" height="32" class="opaca"></a></td>
    <td><a href="https://www.instagram.com/coloquioprepa12/" target="_blank"><img src="../imagenes/rs_instagram_3.png" alt="Instagram" width="32" height="32" class="opaca"></a></td>
  </tr>
</table></td></tr></table></div>
<div id="div_hdr_sitename"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0"><tr><td width="2%">&nbsp;</td>
<td><a href="http://coloquio.prepa12.sems.udg.mx/" class="estilo1">7° Coloquio  de Investigación Educativa en Prepa 12, PRIMER NACIONAL<br>Los engranajes de la inclusión en el modelo educativo del Sistema de Educación Media Superior</a></td></tr></table></div>
<!-- InstanceBeginEditable name="MenuPrincipal" -->
<div id="div_hdr_menu">
<script language="javascript" type="text/javascript">muestraMenuMain("<?php if(isset($_SESSION['MM_UserGroup'])){echo $_SESSION['MM_UserGroup'];}else {echo '';} ?>", "../", "");</script>
</div>
<!-- InstanceEndEditable --><!-- InstanceBeginEditable name="Path" -->
<div id="div_hdr_path">&nbsp;Inicio &gt; Administración &gt; Usuarios &gt; Editar</div>
<!-- InstanceEndEditable --><!-- InstanceBeginEditable name="Contenido" -->
<div id="div_contenido">
  <table width="90%" border="0" align="center">
    <tr>
      <td><h1 class="H_Estilo1">Editar  usuario</h1></td>
    </tr>
    <tr>
      <td><form name="form1" method="POST" action="<?php echo $editFormAction; ?>">
        <div class="DivShadowMsg">
          <table width="800" border="0" align="center" class="tabla_info_msg">
            <tr>
              <th colspan="2" align="left" scope="col">Datos del usuario</th>
              </tr>
            <tr>
              <td align="right"><label for="fUsername">Usuario</label></td>
              <td><input name="fUsername" type="text" id="fUsername" value="<?php echo $row_rsUsuario['username']; ?>" size="20" maxlength="20" readonly></td>
            </tr>
            <tr>
              <td align="right"><label for="fNip">Contraseña*</label></td>
              <td><input name="fNip" type="text" id="fNip" value="<?php echo $row_rsUsuario['nip']; ?>" size="20" maxlength="100" pattern="[a-zA-Z0-9_-]{4,100}" required><span class="validity"></span></td>
            </tr>
            <tr>
              <td align="right"><label for="fNivelDeAcceso">Nivel de acceso*</label></td>
              <td><select name="fNivelDeAcceso" id="fNivelDeAcceso">
                <?php
do {  
?>
                <option value="<?php echo $row_rsNivelesDeAcceso['nivel_de_acceso']?>"<?php if (!(strcmp($row_rsNivelesDeAcceso['nivel_de_acceso'], $row_rsUsuario['nivel_de_acceso']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsNivelesDeAcceso['nivel_de_acceso']?></option>
                <?php
} while ($row_rsNivelesDeAcceso = mysql_fetch_assoc($rsNivelesDeAcceso));
  $rows = mysql_num_rows($rsNivelesDeAcceso);
  if($rows > 0) {
      mysql_data_seek($rsNivelesDeAcceso, 0);
	  $row_rsNivelesDeAcceso = mysql_fetch_assoc($rsNivelesDeAcceso);
  }
?>
              </select>
                <input name="fCicloDeIngreso" type="hidden" id="fCicloDeIngreso" value="2019"></td>
            </tr>
            <tr>
              <td align="right"><label for="fEmail">e-mail</label></td>
              <td><input name="fEmail" type="text" id="fEmail" value="<?php echo $row_rsUsuario['email']; ?>" size="50" maxlength="100" Pattern="([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})"><span class="validity"></span></td>
            </tr>
            <tr>
              <td align="right"><label for="fUltimoAcceso">Ultimo acceso</label></td>
              <td><input name="fUltimoAcceso" type="text" id="fUltimoAcceso" value="<?php echo $row_rsUsuario['ultimo_acceso']; ?>" size="25" maxlength="19" readonly></td>
            </tr>
            <tr>
              <td align="right"><label for="fNombres">Nombre(s)*</label></td>
              <td><input name="fNombres" type="text" id="fNombres" value="<?php echo $row_rsUsuario['nombres']; ?>" size="30" maxlength="30" required><span class="validity"></span></td>
            </tr>
            <tr>
              <td align="right"><label for="fApePat">Apellido paterno*</label></td>
              <td><input name="fApePat" type="text" id="fApePat" value="<?php echo $row_rsUsuario['ape_pat']; ?>" size="30" maxlength="30" required><span class="validity"></span></td>
            </tr>
            <tr>
              <td align="right"><label for="fApeMat">Apellido materno</label></td>
              <td><input name="fApeMat" type="text" id="fApeMat" value="<?php echo $row_rsUsuario['ape_mat']; ?>" size="30" maxlength="30"><span class="validity"></span></td>
            </tr>
            <tr>
              <td align="right"><label for="fSexo">Sexo</label></td>
              <td>
                <input <?php if (!(strcmp($row_rsUsuario['sexo'],"Hombre"))) {echo "checked=\"checked\"";} ?> type="radio" name="fSexo" value="Hombre" id="fSexo_0">Hombre
                <input <?php if (!(strcmp($row_rsUsuario['sexo'],"Mujer"))) {echo "checked=\"checked\"";} ?> type="radio" name="fSexo" value="Mujer" id="fSexo_1">Mujer
              </td>
            </tr>
            <tr>
              <td align="right"><label for="fFechaNacimiento">Fecha nacimiento*</label></td>
              <td><input name="fFechaNacimiento" type="text" id="fFechaNacimiento" value="<?php echo $row_rsUsuario['fecha_nacimiento']; ?>" size="15" maxlength="10" required></td>
            </tr>
            <tr>
              <td align="right"><label for="fIdUniversidad">Universidad de procedencia*</label></td>
              <td><select name="fIdUniversidad" id="fIdUniversidad" onchange="hide_show_otra_universidad();">
                <?php
do {  
?>
                <option value="<?php echo $row_rsUniversidades['id_universidad']?>"<?php if (!(strcmp($row_rsUniversidades['id_universidad'], $row_rsUsuario['id_universidad']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsUniversidades['universidad']?></option>
                <?php
} while ($row_rsUniversidades = mysql_fetch_assoc($rsUniversidades));
  $rows = mysql_num_rows($rsUniversidades);
  if($rows > 0) {
      mysql_data_seek($rsUniversidades, 0);
	  $row_rsUniversidades = mysql_fetch_assoc($rsUniversidades);
  }
?>
              </select></td>
            </tr>
            <tr id="fUnivOtra">
              <td align="right"><label for="fUnivOtra">Otra universidad</label></td>
              <td><input name="fUnivOtra" type="text" id="fUnivOtra" value="<?php echo $row_rsUsuario['univ_otra']; ?>" size="50" maxlength="100"></td>
            </tr>
            <tr>
              <td align="right"><label for="fIdGradoAcad">Grado académico*</label></td>
              <td><select name="fIdGradoAcad" id="fIdGradoAcad" onchange="hide_show_otro_grado_academico();">
                <?php
do {  
?>
                <option value="<?php echo $row_rsGradosAcademicos['id_grado_acad']?>"<?php if (!(strcmp($row_rsGradosAcademicos['id_grado_acad'], $row_rsUsuario['id_grado_acad']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsGradosAcademicos['grado_academico']?></option>
                <?php
} while ($row_rsGradosAcademicos = mysql_fetch_assoc($rsGradosAcademicos));
  $rows = mysql_num_rows($rsGradosAcademicos);
  if($rows > 0) {
      mysql_data_seek($rsGradosAcademicos, 0);
	  $row_rsGradosAcademicos = mysql_fetch_assoc($rsGradosAcademicos);
  }
?>
              </select></td>
            </tr>
            <tr id="fGradoAcadOtro">
              <td align="right"><label for="fGradoAcadOtro">Otro grado academico</label></td>
              <td><input name="fGradoAcadOtro" type="text" id="fGradoAcadOtro" value="<?php echo $row_rsUsuario['grado_acad_otro']; ?>" size="20" maxlength="30"></td>
            </tr>
            <tr>
              <td align="right"><label for="fNumCelular">Celular*</label></td>
              <td><input name="fNumCelular" type="tel" id="fNumCelular" value="<?php echo $row_rsUsuario['num_celular']; ?>" size="15" maxlength="15" pattern="[0-9]{10}" placeholder="Lada+Numero" required><span class="validity"></span></td>
            </tr>
            <tr>
              <td align="right"><label for="fCompPagoStat">Estatus pago</label></td>
              <td><select name="fCompPagoStat" id="fCompPagoStat">
                <option value="Pendiente" <?php if (!(strcmp("Pendiente", $row_rsUsuario['comp_pago_stat']))) {echo "selected=\"selected\"";} ?>>Pendiente</option>
                <option value="Subido" <?php if (!(strcmp("Subido", $row_rsUsuario['comp_pago_stat']))) {echo "selected=\"selected\"";} ?>>Subido</option>
                <option value="Validado" <?php if (!(strcmp("Validado", $row_rsUsuario['comp_pago_stat']))) {echo "selected=\"selected\"";} ?>>Validado</option>
              </select></td>
            </tr>
            <tr>
              <td align="right"><label for="fCompPagoFecha">Fecha estatus pago</label></td>
              <td><input name="fCompPagoFecha" type="text" id="fCompPagoFecha" value="<?php echo $row_rsUsuario['comp_pago_fecha']; ?>" size="15" maxlength="10"></td>
            </tr>
            <tr>
              <td align="right"><label for="fArchPonStat">Estatus entrega ponencia</label></td>
              <td><select name="fArchPonStat" id="fArchPonStat">
                <option value="Pendiente" <?php if (!(strcmp("Pendiente", $row_rsUsuario['arch_pon_stat']))) {echo "selected=\"selected\"";} ?>>Pendiente</option>
                <option value="Subido" <?php if (!(strcmp("Subido", $row_rsUsuario['arch_pon_stat']))) {echo "selected=\"selected\"";} ?>>Subido</option>
                <option value="Validado" <?php if (!(strcmp("Validado", $row_rsUsuario['arch_pon_stat']))) {echo "selected=\"selected\"";} ?>>Validado</option>
              </select></td>
            </tr>
            <tr>
              <td align="right"><label for="fArchPonFecha">Fecha estatus ponencia</label></td>
              <td><input name="fArchPonFecha" type="text" id="fArchPonFecha" value="<?php echo $row_rsUsuario['arch_pon_fecha']; ?>" size="15" maxlength="10"></td>
            </tr>
            <tr>
              <td align="right"><label for="fPresPonStat">Estatus presentación ponencia</label></td>
              <td><select name="fPresPonStat" id="fPresPonStat">
                <option value="Pendiente" <?php if (!(strcmp("Pendiente", $row_rsUsuario['pres_pon_stat']))) {echo "selected=\"selected\"";} ?>>Pendiente</option>
                <option value="Subido" <?php if (!(strcmp("Subido", $row_rsUsuario['pres_pon_stat']))) {echo "selected=\"selected\"";} ?>>Subido</option>
                <option value="Validado" <?php if (!(strcmp("Validado", $row_rsUsuario['pres_pon_stat']))) {echo "selected=\"selected\"";} ?>>Validado</option>
              </select></td>
            </tr>
            <tr>
              <td align="right"><label for="fPresPonFecha">Fecha estatus presentación</label></td>
              <td><input name="fPresPonFecha" type="text" id="fPresPonFecha" value="<?php echo $row_rsUsuario['pres_pon_fecha']; ?>" size="15" maxlength="10"></td>
            </tr>
            <tr>
              <td align="right"><label for="fComentario1">Comentario 1</label></td>
              <td><input name="fComentario1" type="text" id="fComentario1" value="<?php echo $row_rsUsuario['comentario1']; ?>" size="50" maxlength="50"><span class="validity"></span></td>
            </tr>
            <tr>
              <td align="right"><label for="fComentario2">Comentario 2</label></td>
              <td><input name="fComentario2" type="text" id="fComentario2" value="<?php echo $row_rsUsuario['comentario2']; ?>" size="50" maxlength="50"><span class="validity"></span></td>
            </tr>
            <tr>
              <td colspan="2" align="right"><input type="submit" name="bEnviar" id="bEnviar" value="Enviar">
                <input type="reset" name="bRestablecer" id="bRestablecer" value="Restablecer">
                <a href="lst_usr.php" class="button-link">Cancelar</a></td>
            </tr>
          </table>
        </div>
        <input type="hidden" name="MM_update" value="form1">
      </form></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
</div>
<!-- InstanceEndEditable -->
<div id="div_footer">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <th scope="col">&nbsp;</th>
    </tr>
    <tr>
      <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="2%">&nbsp;</td>
              <td colspan="2"><img src="../imagenes/footer_red_universitaria_jalisco.png" width="329" height="51" alt="Banner Gris Red Universitaria de Jalisco" /></td>
              </tr>
            <tr>
              <th width="2%" align="left">&nbsp;</th>
              <th width="4%" align="left">&nbsp;</th>
              <th align="left">ESCUELA PREPARATORIA 12</th>
            </tr>
            <tr>
              <td width="2%">&nbsp;</td>
              <td width="4%">&nbsp;</td>
              <td>Corregidora No. 500 (calle 40), C.P. 44420, Guadalajara, Jalisco, México.</td>
            </tr>
            <tr>
              <td width="2%">&nbsp;</td>
              <td width="4%">&nbsp;</td>
              <td>Teléfono(s): (33) 3617-1980, 3617-1870</td>
            </tr>
          </table></td>
          <td valign="top"><!-- InstanceBeginEditable name="MenuFooterRegion" -->
<script language="javascript" type="text/javascript">muestraMenuFooter("<?php if(isset($_SESSION['MM_UserGroup'])){echo $_SESSION['MM_UserGroup'];}else {echo '';} ?>", "../", "");</script>
		  <!-- InstanceEndEditable -->
          </td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">Derechos reservados ©1997-2019. Universidad de Guadalajara. Sitio desarrollado por <a href="https://www.facebook.com/jjesusgm" target="_blank">JJGM</a> | <a href="../creditos/">Créditos de sitio</a> | <a href="../ppymd/">Política de privacidad y manejo de datos</a></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
</div>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($rsUsuario);

mysql_free_result($rsNivelesDeAcceso);

mysql_free_result($rsUniversidades);

mysql_free_result($rsGradosAcademicos);
?>

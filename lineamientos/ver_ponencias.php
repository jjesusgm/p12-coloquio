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
  $updateSQL = sprintf("UPDATE usuarios SET arch_pon_stat=%s, arch_pon_fecha=%s, arch_pon_validador=%s, comentario2=%s WHERE username=%s",
                       GetSQLValueString($_POST['fArchPonStat'], "text"),
                       GetSQLValueString($_POST['fArchPonFecha'], "date"),
                       GetSQLValueString($_POST['fArchPonValidador'], "text"),
                       GetSQLValueString($_POST['fComentario2'], "text"),
                       GetSQLValueString($_POST['fUsername'], "text"));

  mysql_select_db($database_conColoquio, $conColoquio);
  $Result1 = mysql_query($updateSQL, $conColoquio) or die(mysql_error());

  $updateGoTo = "val_ponencias.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
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

$colname_rsValidador = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_rsValidador = $_SESSION['MM_Username'];
}
mysql_select_db($database_conColoquio, $conColoquio);
$query_rsValidador = sprintf("SELECT * FROM usuarios WHERE username = %s", GetSQLValueString($colname_rsValidador, "text"));
$rsValidador = mysql_query($query_rsValidador, $conColoquio) or die(mysql_error());
$row_rsValidador = mysql_fetch_assoc($rsValidador);
$totalRows_rsValidador = mysql_num_rows($rsValidador);
?>
<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/t_coloquio_p12.dwt" codeOutsideHTMLIsLocked="false" -->
<!-- InstanceParam name="body" type="text" value="" -->
<!-- InstanceParam name="focusFormElement" type="text" value="" -->
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
<script type="text/javascript" src="../js/menus.js"></script>
</head>
<!-- InstanceEndEditable -->
<body onload="">
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
<div id="div_hdr_path">&nbsp;Inicio &gt; Lineamientos &gt; Ponencias &gt; Ver ponencias para validar</div>
<!-- InstanceEndEditable --><!-- InstanceBeginEditable name="Contenido" -->
<div id="div_contenido">
  <table width="90%" align="center">
    <tr>
      <td><h1 class="H_Estilo1">Ver ponencias para validar</h1></td>
    </tr>
    <tr>
      <td><table width="100%">
        <tr><td colspan="2">Archivos que se han subido para validar:</td></tr>
<?php
date_default_timezone_set('America/Mexico_City');
$files = glob("./ponencias/".$colname_rsUsuario.".*");
$num_files = count($files);

if ($num_files > 0){
	foreach($files as $nombre_archivo){
        echo "<tr><td width='3%'>&nbsp;</td><td>";
		echo "- <a href='".$nombre_archivo."' target='_blank' class='estilo3'>".substr($nombre_archivo, strpos($nombre_archivo, $colname_rsUsuario))."</a>";
        echo "</td></tr>";
	}
}
?>
      </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><form action="<?php echo $editFormAction; ?>" name="form1" method="POST"><div class="DivShadowMsgValidar">
        <table width="550" align="center" class="tabla_info_msg">
          <tr>
            <th colspan="2" align="left" scope="col">¿Qué desea hacer con esta ponencia?</th>
          </tr>
          <tr>
            <td align="right"><label for="fUsername2">Usuario</label></td>
            <td><input name="fUsername" type="text" id="fUsername2" value="<?php echo $row_rsUsuario['username']; ?>" readonly></td>
          </tr>
          <tr>
            <td align="right"><label for="fNivelDeAcceso">Tipo</label></td>
            <td><input name="fNivelDeAcceso" type="text" id="fNivelDeAcceso" value="<?php echo $row_rsUsuario['nivel_de_acceso']; ?>" readonly></td>
          </tr>
          <tr>
            <td align="right"><label for="fNombre">Nombre</label></td>
            <td><input name="fNombre" type="text" id="fNombre" value="<?php echo $row_rsUsuario['nombres']." ".$row_rsUsuario['ape_pat']." ".$row_rsUsuario['ape_mat']; ?>" size="50" maxlength="92" readonly></td>
          </tr>
          <tr>
            <td align="right"><label for="fArchPonStat">Estatus</label></td>
            <td><select name="fArchPonStat" id="fArchPonStat">
              <option value="Rechazado">Rechazado</option>
              <option value="Validado">Validado</option>
            </select></td>
          </tr>
          <tr>
            <td align="right"><label for="fArchPonFecha">Fecha</label></td>
            <td><input name="fArchPonFecha" type="text" id="fArchPonFecha" value="<?php echo date("Y-m-d"); ?>" size="15" maxlength="10" readonly></td>
          </tr>
          <tr>
            <td align="right"><label for="fArchPonValidador">Validó</label></td>
            <td><input name="fArchPonValidador" type="text" id="fArchPonValidador" value="<?php echo $row_rsValidador['username']; ?>" size="10" maxlength="20" readonly>
              <?php echo " ".$row_rsValidador['nombres']." ".$row_rsValidador['ape_pat']." ".$row_rsValidador['ape_mat']; ?></td>
          </tr>
          <tr>
            <td align="right"><label for="fComentario2">Comentario</label></td>
            <td><input name="fComentario2" type="text" id="fComentario2" size="50" maxlength="100"></td>
          </tr>
          <tr>
            <td colspan="2" align="right"><input type="submit" name="button" id="button" value="Enviar">
              <a href="val_ponencias.php" class="button-link">Cancelar</a></td>
          </tr>
        </table></div>
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

mysql_free_result($rsValidador);
?>

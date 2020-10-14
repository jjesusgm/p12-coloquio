<?php require_once('../Connections/conColoquio.php'); ?>
<?php date_default_timezone_set('America/Mexico_City'); ?>
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
  $updateSQL = sprintf("UPDATE contacto SET estatus=%s, fecha_respuesta=%s, respuesta=%s WHERE id_contacto=%s",
                       GetSQLValueString($_POST['fEstatus'], "text"),
                       GetSQLValueString($_POST['fFechaRespuesta'], "date"),
                       GetSQLValueString($_POST['fRespuesta'], "text"),
                       GetSQLValueString($_POST['fIdContacto'], "int"));

  mysql_select_db($database_conColoquio, $conColoquio);
  $Result1 = mysql_query($updateSQL, $conColoquio) or die(mysql_error());

  $updateGoTo = "contacto.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rsContacto = "-1";
if (isset($_GET['id_contacto'])) {
  $colname_rsContacto = $_GET['id_contacto'];
}
mysql_select_db($database_conColoquio, $conColoquio);
$query_rsContacto = sprintf("SELECT * FROM contacto WHERE id_contacto = %s", GetSQLValueString($colname_rsContacto, "int"));
$rsContacto = mysql_query($query_rsContacto, $conColoquio) or die(mysql_error());
$row_rsContacto = mysql_fetch_assoc($rsContacto);
$totalRows_rsContacto = mysql_num_rows($rsContacto);

$colname_rsUsuario = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_rsUsuario = $_SESSION['MM_Username'];
}
mysql_select_db($database_conColoquio, $conColoquio);
$query_rsUsuario = sprintf("SELECT * FROM usuarios WHERE username = %s", GetSQLValueString($colname_rsUsuario, "text"));
$rsUsuario = mysql_query($query_rsUsuario, $conColoquio) or die(mysql_error());
$row_rsUsuario = mysql_fetch_assoc($rsUsuario);
$totalRows_rsUsuario = mysql_num_rows($rsUsuario);
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
<script type="text/javascript" src="../js/fechas.js"></script>
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
<div id="div_hdr_path">&nbsp;Inicio &gt; Soporte &gt; Contacto &gt; Procesar mensaje</div>
<!-- InstanceEndEditable --><!-- InstanceBeginEditable name="Contenido" -->
<div id="div_contenido">
  <table width="90%" align="center">
    <tr>
      <td><h1 class="margin_both H_Estilo1">Procesar mensaje de contacto</h1></td>
    </tr>
    <tr>
      <td align="center"><form name="form1" method="POST" action="<?php echo $editFormAction; ?>">
        <div class="DivShadowMsg">
          <table width="800" class="tabla_info_msg">
            <tr>
              <th colspan="2" align="left" scope="col">Datos del mensaje</th>
              </tr>
            <tr>
              <td align="right"><label for="fIdContacto">ID</label></td>
              <td><input name="fIdContacto" type="text" id="fIdContacto" value="<?php echo $row_rsContacto['id_contacto']; ?>" size="10" maxlength="10" style="background-color:#CCC" readonly></td>
            </tr>
            <tr>
              <td align="right"><label for="fFechaContacto">Fecha contacto</label></td>
              <td><input name="fFechaContacto" type="text" id="fFechaContacto" value="<?php echo $row_rsContacto['fecha_contacto']; ?>" size="20" style="background-color:#CCC" readonly></td>
            </tr>
            <tr>
              <td align="right"><label for="fEstatus">Estatus</label></td>
              <td><select name="fEstatus" id="fEstatus" style="background-color:#FC0">
                <option value="Abierto" <?php if (!(strcmp("Abierto", $row_rsContacto['estatus']))) {echo "selected=\"selected\"";} ?>>Abierto</option>
                <option value="Contestado" <?php if (!(strcmp("Contestado", $row_rsContacto['estatus']))) {echo "selected=\"selected\"";} ?>>Contestado</option>
              </select></td>
            </tr>
            <tr>
              <td align="right"><label for="fNombre">Nombre</label></td>
              <td><input name="fNombre" type="text" id="fNombre" value="<?php echo $row_rsContacto['nombre']; ?>" size="80" maxlength="100" style="background-color:#CCC" readonly></td>
            </tr>
            <tr>
              <td align="right"><label for="fEmail">Email</label></td>
              <td><input name="fEmail" type="text" id="fEmail" value="<?php echo $row_rsContacto['email']; ?>" size="80" maxlength="100" style="background-color:#CCC" readonly></td>
            </tr>
            <tr>
              <td align="right"><label for="fTelefono">Telefono</label></td>
              <td><input name="fTelefono" type="text" id="fTelefono" value="<?php echo $row_rsContacto['telefono']; ?>" size="20" maxlength="15" style="background-color:#CCC" readonly></td>
            </tr>
            <tr>
              <td align="right"><label for="fInscrito">Inscrito</label></td>
              <td><input name="fInscrito" type="text" id="fInscrito" value="<?php echo $row_rsContacto['inscrito']; ?>" size="10" maxlength="5" style="background-color:#CCC" readonly></td>
            </tr>
            <tr>
              <td align="right" valign="top"><label for="fMensaje">Mensaje</label></td>
              <td><textarea name="fMensaje" cols="80" rows="4" readonly id="fMensaje" style="background-color:#CCC"><?php echo $row_rsContacto['mensaje']; ?></textarea></td>
            </tr>
            <tr>
              <td align="right"><label for="fNombreRespuesta">Respondió</label></td>
              <td><input name="fNombreRespuesta" type="text" id="fNombreRespuesta" value="<?php echo $row_rsUsuario['nombres']." ".$row_rsUsuario['ape_pat']." ".$row_rsUsuario['ape_mat']; ?>" size="80" maxlength="90" style="background-color:#CCC" readonly>
                <input name="fRespondio" type="hidden" id="fRespondio" value="<?php echo $row_rsUsuario['username']; ?>"></td>
            </tr>
            <tr>
              <td align="right"><label for="fFechaRespuesta">Fecha respuesta</label></td>
              <td><input name="fFechaRespuesta" type="text" id="fFechaRespuesta" value="<?php echo date('Y-m-d H:i:s'); ?>" size="20" style="background-color:#FC0">
                <input type="button" name="bActualizar" id="bActualizar" value="&lt;&lt; Actualizar" onClick="this.form.elements['fFechaRespuesta'].value = curDateToStringForDB();"></td>
            </tr>
            <tr>
              <td align="right" valign="top"><label for="fRespuesta">Respuesta</label></td>
              <td><textarea name="fRespuesta" cols="80" rows="4" id="fRespuesta" style="background-color:#FC0"></textarea></td>
            </tr>
            <tr>
              <td colspan="2" align="right"><input type="submit" name="bEnviar" id="bEnviar" value="Enviar">
                <input type="reset" name="bRestablecer" id="bRestablecer" value="Restablecer">
                <a href="contacto.php" class="button-link">Cancelar</a>&nbsp;</td>
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
mysql_free_result($rsContacto);

mysql_free_result($rsUsuario);
?>

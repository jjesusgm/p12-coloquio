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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_rsContactos = 50;
$pageNum_rsContactos = 0;
if (isset($_GET['pageNum_rsContactos'])) {
  $pageNum_rsContactos = $_GET['pageNum_rsContactos'];
}
$startRow_rsContactos = $pageNum_rsContactos * $maxRows_rsContactos;

mysql_select_db($database_conColoquio, $conColoquio);
$query_rsContactos = "SELECT * FROM contacto ORDER BY estatus DESC";
$query_limit_rsContactos = sprintf("%s LIMIT %d, %d", $query_rsContactos, $startRow_rsContactos, $maxRows_rsContactos);
$rsContactos = mysql_query($query_limit_rsContactos, $conColoquio) or die(mysql_error());
$row_rsContactos = mysql_fetch_assoc($rsContactos);

if (isset($_GET['totalRows_rsContactos'])) {
  $totalRows_rsContactos = $_GET['totalRows_rsContactos'];
} else {
  $all_rsContactos = mysql_query($query_rsContactos);
  $totalRows_rsContactos = mysql_num_rows($all_rsContactos);
}
$totalPages_rsContactos = ceil($totalRows_rsContactos/$maxRows_rsContactos)-1;$maxRows_rsContactos = 50;
$pageNum_rsContactos = 0;
if (isset($_GET['pageNum_rsContactos'])) {
  $pageNum_rsContactos = $_GET['pageNum_rsContactos'];
}
$startRow_rsContactos = $pageNum_rsContactos * $maxRows_rsContactos;

mysql_select_db($database_conColoquio, $conColoquio);
$query_rsContactos = "SELECT * FROM contacto ORDER BY estatus ASC";
$query_limit_rsContactos = sprintf("%s LIMIT %d, %d", $query_rsContactos, $startRow_rsContactos, $maxRows_rsContactos);
$rsContactos = mysql_query($query_limit_rsContactos, $conColoquio) or die(mysql_error());
$row_rsContactos = mysql_fetch_assoc($rsContactos);

if (isset($_GET['totalRows_rsContactos'])) {
  $totalRows_rsContactos = $_GET['totalRows_rsContactos'];
} else {
  $all_rsContactos = mysql_query($query_rsContactos);
  $totalRows_rsContactos = mysql_num_rows($all_rsContactos);
}
$totalPages_rsContactos = ceil($totalRows_rsContactos/$maxRows_rsContactos)-1;

$queryString_rsContactos = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsContactos") == false && 
        stristr($param, "totalRows_rsContactos") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsContactos = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsContactos = sprintf("&totalRows_rsContactos=%d%s", $totalRows_rsContactos, $queryString_rsContactos);
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
<div id="div_hdr_path">&nbsp;Inicio &gt; Soporte &gt; Contacto</div>
<!-- InstanceEndEditable --><!-- InstanceBeginEditable name="Contenido" -->
<div id="div_contenido">
  <table width="90%" align="center">
    <tr>
      <td><h1 class="H_Estilo1 margin_both">Administrar mensajes de contacto</h1></td>
    </tr>
    <?php if ($totalRows_rsContactos == 0) { // Show if recordset empty ?>
      <tr>
        <td align="center"><h2 class="margin_bottom H_Estilo2">No existe ningún mensaje de contacto para procesar</h2></td>
      </tr>
      <?php } // Show if recordset empty ?>
    <?php if ($totalRows_rsContactos > 0) { // Show if recordset not empty ?>
  <tr>
    <td align="center"><h2 class="H_Estilo2 margin_bottom">Mostrando mensajes <?php echo ($startRow_rsContactos + 1) ?> al <?php echo min($startRow_rsContactos + $maxRows_rsContactos, $totalRows_rsContactos) ?> de <?php echo $totalRows_rsContactos ?> </h2></td>
  </tr>
      <tr>
        <td align="center"><table>
          <tr>
            <td>Navegación:</td>
            <td><a href="<?php printf("%s?pageNum_rsContactos=%d%s", $currentPage, 0, $queryString_rsContactos); ?>" class="estilo3">Primera</a></td>
            <td>|</td>
            <td><a href="<?php printf("%s?pageNum_rsContactos=%d%s", $currentPage, max(0, $pageNum_rsContactos - 1), $queryString_rsContactos); ?>" class="estilo3">Anterior</a></td>
            <td>|</td>
            <td><a href="<?php printf("%s?pageNum_rsContactos=%d%s", $currentPage, min($totalPages_rsContactos, $pageNum_rsContactos + 1), $queryString_rsContactos); ?>" class="estilo3">Siguiente</a></td>
            <td>|</td>
            <td><a href="<?php printf("%s?pageNum_rsContactos=%d%s", $currentPage, $totalPages_rsContactos, $queryString_rsContactos); ?>" class="estilo3">Ultima</a></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td align="center"><table width="100%" class="TablaListaInventario">
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Fecha</th>
            <th scope="col">Estatus</th>
            <th scope="col">Nombre</th>
            <th scope="col">Email</th>
            <th scope="col">Inscrito</th>
            <th scope="col">Mensaje</th>
            <th scope="col">Acción</th>
          </tr>
          <?php do { ?>
            <tr>
              <td align="center"><?php echo $row_rsContactos['id_contacto']; ?></td>
              <td align="center"><?php echo $row_rsContactos['fecha_contacto']; ?></td>
              <td align="center"><?php echo $row_rsContactos['estatus']; ?></td>
              <td><?php echo $row_rsContactos['nombre']; ?></td>
              <td align="center"><?php echo $row_rsContactos['email']; ?></td>
              <td align="center"><?php echo $row_rsContactos['inscrito']; ?></td>
              <td><?php echo $row_rsContactos['mensaje']; ?></td>
              <td align="center"><a href="contacto_procesar.php?id_contacto=<?php echo $row_rsContactos['id_contacto']; ?>" class="estilo3">Procesar</a></td>
            </tr>
            <?php } while ($row_rsContactos = mysql_fetch_assoc($rsContactos)); ?>
        </table></td>
      </tr>
      <tr>
        <td align="center"><table>
          <tr>
            <td>Navegación:</td>
            <td><a href="<?php printf("%s?pageNum_rsContactos=%d%s", $currentPage, 0, $queryString_rsContactos); ?>" class="estilo3">Primera</a></td>
            <td>|</td>
            <td><a href="<?php printf("%s?pageNum_rsContactos=%d%s", $currentPage, max(0, $pageNum_rsContactos - 1), $queryString_rsContactos); ?>" class="estilo3">Anterior</a></td>
            <td>|</td>
            <td><a href="<?php printf("%s?pageNum_rsContactos=%d%s", $currentPage, min($totalPages_rsContactos, $pageNum_rsContactos + 1), $queryString_rsContactos); ?>" class="estilo3">Siguiente</a></td>
            <td>|</td>
            <td><a href="<?php printf("%s?pageNum_rsContactos=%d%s", $currentPage, $totalPages_rsContactos, $queryString_rsContactos); ?>" class="estilo3">Ultima</a></td>
            </tr>
        </table></td>
      </tr>
      <?php } // Show if recordset not empty ?>
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
mysql_free_result($rsContactos);
?>

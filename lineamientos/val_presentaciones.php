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

$maxRows_rsPresentaciones = 20;
$pageNum_rsPresentaciones = 0;
if (isset($_GET['pageNum_rsPresentaciones'])) {
  $pageNum_rsPresentaciones = $_GET['pageNum_rsPresentaciones'];
}
$startRow_rsPresentaciones = $pageNum_rsPresentaciones * $maxRows_rsPresentaciones;

mysql_select_db($database_conColoquio, $conColoquio);
$query_rsPresentaciones = "SELECT * FROM usuarios WHERE pres_pon_stat = 'Subido' ORDER BY ape_pat ASC";
$query_limit_rsPresentaciones = sprintf("%s LIMIT %d, %d", $query_rsPresentaciones, $startRow_rsPresentaciones, $maxRows_rsPresentaciones);
$rsPresentaciones = mysql_query($query_limit_rsPresentaciones, $conColoquio) or die(mysql_error());
$row_rsPresentaciones = mysql_fetch_assoc($rsPresentaciones);

if (isset($_GET['totalRows_rsPresentaciones'])) {
  $totalRows_rsPresentaciones = $_GET['totalRows_rsPresentaciones'];
} else {
  $all_rsPresentaciones = mysql_query($query_rsPresentaciones);
  $totalRows_rsPresentaciones = mysql_num_rows($all_rsPresentaciones);
}
$totalPages_rsPresentaciones = ceil($totalRows_rsPresentaciones/$maxRows_rsPresentaciones)-1;

$queryString_rsPresentaciones = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsPresentaciones") == false && 
        stristr($param, "totalRows_rsPresentaciones") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsPresentaciones = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsPresentaciones = sprintf("&totalRows_rsPresentaciones=%d%s", $totalRows_rsPresentaciones, $queryString_rsPresentaciones);
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
<div id="div_hdr_path">&nbsp;Inicio &gt; Lineamientos &gt; Validacion de presentaciones</div>
<!-- InstanceEndEditable --><!-- InstanceBeginEditable name="Contenido" -->
<div id="div_contenido">
  <table width="90%" align="center">
    <tr>
      <td><h1 class="H_Estilo1">Validación de presentaciones</h1></td>
    </tr>
    <tr>
      <td>En esta página se pueden ver todas las presentaciones que han sido subidas al servidor y de esta manera validarlas para que se pueda continuar con el proceso.</td>
    </tr>
    <?php if ($totalRows_rsPresentaciones == 0) { // Show if recordset empty ?>
      <tr>
        <td><h2 class="H_Estilo2">No hay presentaciones por validar</h2></td>
      </tr>
      <?php } // Show if recordset empty ?>
    <?php if ($totalRows_rsPresentaciones > 0) { // Show if recordset not empty ?>
  <tr>
    <td align="center"><h2 class="H_Estilo2">Mostrando presentaciones&nbsp;<?php echo ($startRow_rsPresentaciones + 1) ?>&nbsp;al&nbsp;<?php echo min($startRow_rsPresentaciones + $maxRows_rsPresentaciones, $totalRows_rsPresentaciones) ?>&nbsp;de&nbsp;<?php echo $totalRows_rsPresentaciones ?> </h2></td>
  </tr>
  <tr>
    <td align="center"><table>
      <tr>
        <td>Navegación:</td>
        <td><a href="<?php printf("%s?pageNum_rsPresentaciones=%d%s", $currentPage, 0, $queryString_rsPresentaciones); ?>" class="estilo3">Primera</a></td>
        <td>|</td>
        <td><a href="<?php printf("%s?pageNum_rsPresentaciones=%d%s", $currentPage, max(0, $pageNum_rsPresentaciones - 1), $queryString_rsPresentaciones); ?>" class="estilo3">Anterior</a></td>
        <td>|</td>
        <td><a href="<?php printf("%s?pageNum_rsPresentaciones=%d%s", $currentPage, min($totalPages_rsPresentaciones, $pageNum_rsPresentaciones + 1), $queryString_rsPresentaciones); ?>" class="estilo3">Siguiente</a></td>
        <td>|</td>
        <td><a href="<?php printf("%s?pageNum_rsPresentaciones=%d%s", $currentPage, $totalPages_rsPresentaciones, $queryString_rsPresentaciones); ?>" class="estilo3">Ultima</a></td>
      </tr>
    </table></td>
  </tr>
      <tr>
        <td><table width="100%" class="TablaListaInventario">
          <tr>
            <th scope="col">Usuario</th>
            <th scope="col">Tipo</th>
            <th scope="col">Nombre</th>
            <th scope="col">Sexo</th>
            <th scope="col">Estatus</th>
            <th scope="col">Fecha estatus</th>
            <th scope="col">Acción</th>
          </tr>
          <?php do { ?>
            <tr align="center">
              <td><?php echo $row_rsPresentaciones['username']; ?></td>
              <td><?php echo $row_rsPresentaciones['nivel_de_acceso']; ?></td>
              <td align="left"><?php echo $row_rsPresentaciones['nombres']; ?>&nbsp;<?php echo $row_rsPresentaciones['ape_pat']; ?>&nbsp;<?php echo $row_rsPresentaciones['ape_mat']; ?></td>
              <td><?php echo $row_rsPresentaciones['sexo']; ?></td>
              <td><?php echo $row_rsPresentaciones['pres_pon_stat']; ?></td>
              <td><?php echo $row_rsPresentaciones['pres_pon_fecha']; ?></td>
              <td><a href="ver_presentaciones.php?username=<?php echo $row_rsPresentaciones['username']; ?>" class="estilo3">Ver archivo</a></td>
            </tr>
            <?php } while ($row_rsPresentaciones = mysql_fetch_assoc($rsPresentaciones)); ?>
        </table></td>
      </tr>
      <?php } // Show if recordset not empty ?>
<tr>
      <td align="center"><table>
        <tr>
          <td>Navegación:</td>
          <td><a href="<?php printf("%s?pageNum_rsPresentaciones=%d%s", $currentPage, 0, $queryString_rsPresentaciones); ?>" class="estilo3">Primera</a></td>
          <td>|</td>
          <td><a href="<?php printf("%s?pageNum_rsPresentaciones=%d%s", $currentPage, max(0, $pageNum_rsPresentaciones - 1), $queryString_rsPresentaciones); ?>" class="estilo3">Anterior</a></td>
          <td>|</td>
          <td><a href="<?php printf("%s?pageNum_rsPresentaciones=%d%s", $currentPage, min($totalPages_rsPresentaciones, $pageNum_rsPresentaciones + 1), $queryString_rsPresentaciones); ?>" class="estilo3">Siguiente</a></td>
          <td>|</td>
          <td><a href="<?php printf("%s?pageNum_rsPresentaciones=%d%s", $currentPage, $totalPages_rsPresentaciones, $queryString_rsPresentaciones); ?>" class="estilo3">Ultima</a></td>
        </tr>
      </table></td>
    </tr>
<tr>
  <td align="center">&nbsp;</td>
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
mysql_free_result($rsPresentaciones);
?>

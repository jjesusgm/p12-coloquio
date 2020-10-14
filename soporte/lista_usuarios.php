<?php require_once('../Connections/conColoquio.php'); ?>
<?php mysql_set_charset('utf8'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
if(isset($_POST['bAgregarFiltro'])){
  if (isset($_POST['fUsername']) or isset($_POST['fNivelDeAcceso']) or isset($_POST['fNombres']) or isset($_POST['fApePat']) or isset($_POST['fApeMat'])){
	  //$_SESSION['FILTRO_ACTIVO'] = false;
	  if (strlen($_POST['fUsername']) > 0){
		  $_SESSION['FILTRO_ACTIVO'] = true;
		  $_SESSION['FLT_Username'] = $_POST['fUsername'];
	  }else{unset($_SESSION['FLT_Username']);}
	  if (strlen($_POST['fNivelDeAcceso']) > 0){
		  $_SESSION['FILTRO_ACTIVO'] = true;
		  $_SESSION['FLT_NivAcc'] = $_POST['fNivelDeAcceso'];
	  }else{unset($_SESSION['FLT_NivAcc']);}
	  if (strlen($_POST['fNombres']) > 0){
		  $_SESSION['FILTRO_ACTIVO'] = true;
		  $_SESSION['FLT_Nombres'] = "%".$_POST['fNombres']."%";
	  }else{unset($_SESSION['FLT_Nombres']);}
	  if (strlen($_POST['fApePat']) > 0){
		  $_SESSION['FILTRO_ACTIVO'] = true;
		  $_SESSION['FLT_ApePat'] = $_POST['fApePat'];
	  }else{unset($_SESSION['FLT_ApePat']);}
	  if (strlen($_POST['fApeMat']) > 0){
		  $_SESSION['FILTRO_ACTIVO'] = true;
		  $_SESSION['FLT_ApeMat'] = $_POST['fApeMat'];
	  }else{unset($_SESSION['FLT_ApeMat']);}
  }
}elseif(isset($_POST['bEliminarFiltro'])){
	unset($_SESSION['FLT_Username']);
	unset($_SESSION['FLT_NivAcc']);
	unset($_SESSION['FLT_Nombres']);
	unset($_SESSION['FLT_ApePat']);
	unset($_SESSION['FLT_ApeMat']);
	unset($_SESSION['FILTRO_ACTIVO']);
}
?>
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

$maxRows_rsUsuarios = 50;
$pageNum_rsUsuarios = 0;
if (isset($_GET['pageNum_rsUsuarios'])) {
  $pageNum_rsUsuarios = $_GET['pageNum_rsUsuarios'];
}
$startRow_rsUsuarios = $pageNum_rsUsuarios * $maxRows_rsUsuarios;

$q_username_rsUsuarios = "%";
if (isset($_SESSION['FLT_Username'])) {
  $q_username_rsUsuarios = $_SESSION['FLT_Username'];
}
$q_ape_pat_rsUsuarios = "%";
if (isset($_SESSION['FLT_ApePat'])) {
  $q_ape_pat_rsUsuarios = $_SESSION['FLT_ApePat'];
}
$q_niv_acc_rsUsuarios = "%";
if (isset($_SESSION['FLT_NivAcc'])) {
  $q_niv_acc_rsUsuarios = $_SESSION['FLT_NivAcc'];
}
$q_ape_mat_rsUsuarios = "%";
if (isset($_SESSION['FLT_ApeMat'])) {
  $q_ape_mat_rsUsuarios = $_SESSION['FLT_ApeMat'];
}
$q_nombres_rsUsuarios = "%";
if (isset($_SESSION['FLT_Nombres'])) {
  $q_nombres_rsUsuarios = $_SESSION['FLT_Nombres'];
}
mysql_select_db($database_conColoquio, $conColoquio);
$query_rsUsuarios = sprintf("SELECT * FROM usuarios WHERE username LIKE %s AND nivel_de_acceso LIKE %s AND nombres LIKE %s AND ape_pat LIKE %s AND ape_mat LIKE %s ORDER BY ape_pat ASC", GetSQLValueString($q_username_rsUsuarios, "text"),GetSQLValueString($q_niv_acc_rsUsuarios, "text"),GetSQLValueString($q_nombres_rsUsuarios, "text"),GetSQLValueString($q_ape_pat_rsUsuarios, "text"),GetSQLValueString($q_ape_mat_rsUsuarios, "text"));
$query_limit_rsUsuarios = sprintf("%s LIMIT %d, %d", $query_rsUsuarios, $startRow_rsUsuarios, $maxRows_rsUsuarios);
$rsUsuarios = mysql_query($query_limit_rsUsuarios, $conColoquio) or die(mysql_error());
$row_rsUsuarios = mysql_fetch_assoc($rsUsuarios);

if (isset($_GET['totalRows_rsUsuarios'])) {
  $totalRows_rsUsuarios = $_GET['totalRows_rsUsuarios'];
} else {
  $all_rsUsuarios = mysql_query($query_rsUsuarios);
  $totalRows_rsUsuarios = mysql_num_rows($all_rsUsuarios);
}
$totalPages_rsUsuarios = ceil($totalRows_rsUsuarios/$maxRows_rsUsuarios)-1;

mysql_select_db($database_conColoquio, $conColoquio);
$query_rsNivelesDeAcceso = "SELECT * FROM usr_niveles_acceso ORDER BY nivel_de_acceso ASC";
$rsNivelesDeAcceso = mysql_query($query_rsNivelesDeAcceso, $conColoquio) or die(mysql_error());
$row_rsNivelesDeAcceso = mysql_fetch_assoc($rsNivelesDeAcceso);
$totalRows_rsNivelesDeAcceso = mysql_num_rows($rsNivelesDeAcceso);

$queryString_rsUsuarios = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsUsuarios") == false && 
        stristr($param, "totalRows_rsUsuarios") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsUsuarios = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsUsuarios = sprintf("&totalRows_rsUsuarios=%d%s", $totalRows_rsUsuarios, $queryString_rsUsuarios);
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
<div id="div_hdr_path">&nbsp;Inicio &gt; Soporte &gt; Lista usuarios</div>
<!-- InstanceEndEditable --><!-- InstanceBeginEditable name="Contenido" -->
<div id="div_contenido">
  <table width="90%" border="0" align="center">
    <tr>
      <td><h1 class="H_Estilo1">Ver lista completa de usuarios</h1></td>
    </tr>
    <tr>
      <td align="center"><h2 class="H_Estilo2">Mostrando usuarios&nbsp;<?php echo ($startRow_rsUsuarios + 1) ?>&nbsp;al&nbsp;<?php echo min($startRow_rsUsuarios + $maxRows_rsUsuarios, $totalRows_rsUsuarios) ?>&nbsp;de&nbsp;<?php echo $totalRows_rsUsuarios ?></h2></td>
    </tr>
    <tr>
      <td><table width="600" border="0" align="center">
        <tr>
          <td><form name="form1" method="post" action="">
            <fieldset>
              <legend>Filtrar resultados</legend>
              <table width="600" border="0" align="center">
                <tr>
                  <td align="right"><label for="fUsername">Usuario</label></td>
                  <td><input name="fUsername" type="text" id="fUsername" size="20" maxlength="20" placeholder="Debe ser exacto"></td>
                </tr>
                <tr>
                  <td align="right"><label for="fNombres">Nombre(s)</label></td>
                  <td><input name="fNombres" type="text" id="fNombres" size="30" maxlength="30" placeholder="Puede ser parcial"></td>
                </tr>
                <tr>
                  <td align="right"><label for="fApePat">Apellido paterno</label></td>
                  <td><input name="fApePat" type="text" id="fApePat" size="30" maxlength="30" placeholder="Debe ser exacto"></td>
                </tr>
                <tr>
                  <td align="right"><label for="fApeMat">Apellido materno</label></td>
                  <td><input name="fApeMat" type="text" id="fApeMat" size="30" maxlength="30" placeholder="Debe ser exacto"></td>
                </tr>
                <tr>
                  <td align="right"><label for="fNivelDeAcceso">Nivel de acceso</label></td>
                  <td><select name="fNivelDeAcceso" id="fNivelDeAcceso">
                    <option value="">Todos</option>
                    <?php
do {  
?>
                    <option value="<?php echo $row_rsNivelesDeAcceso['nivel_de_acceso']?>"><?php echo $row_rsNivelesDeAcceso['nivel_de_acceso']?></option>
                    <?php
} while ($row_rsNivelesDeAcceso = mysql_fetch_assoc($rsNivelesDeAcceso));
  $rows = mysql_num_rows($rsNivelesDeAcceso);
  if($rows > 0) {
      mysql_data_seek($rsNivelesDeAcceso, 0);
	  $row_rsNivelesDeAcceso = mysql_fetch_assoc($rsNivelesDeAcceso);
  }
?>
                  </select></td>
                </tr>
                <tr>
                  <td colspan="2" align="center"><input type="submit" name="bAgregarFiltro" id="bAgregarFiltro" value="Agregar filtro">
                    <input type="submit" name="bEliminarFiltro" id="bEliminarFiltro" value="Eliminar filtro"></td>
                </tr>
<?php
if (isset($_SESSION['FILTRO_ACTIVO'])){
  $mensaje_filtro = "Filtro actual: ";
  if(isset($_SESSION['FLT_Username'])){
	$mensaje_filtro = $mensaje_filtro."Usuario=".$_SESSION['FLT_Username'];
  }
  if(isset($_SESSION['FLT_NivAcc'])){
	if(strlen($mensaje_filtro) == 15){
	  $mensaje_filtro = $mensaje_filtro."Nivel de acceso=".$_SESSION['FLT_NivAcc'];
	}else{$mensaje_filtro = $mensaje_filtro.", Nivel de acceso=".$_SESSION['FLT_NivAcc'];}
  }
  if(isset($_SESSION['FLT_Nombres'])){
	if(strlen($mensaje_filtro) == 15){
	  $mensaje_filtro = $mensaje_filtro."Nombre(s)=".$_SESSION['FLT_Nombres'];
	}else{$mensaje_filtro = $mensaje_filtro.", Nombre(s)=".$_SESSION['FLT_Nombres'];}
  }
  if(isset($_SESSION['FLT_ApePat'])){
	if(strlen($mensaje_filtro) == 15){
	  $mensaje_filtro = $mensaje_filtro."Apellido paterno=".$_SESSION['FLT_ApePat'];
	}else{$mensaje_filtro = $mensaje_filtro.", Apellido paterno=".$_SESSION['FLT_ApePat'];}
  }
  if(isset($_SESSION['FLT_ApeMat'])){
	if(strlen($mensaje_filtro) == 15){
	  $mensaje_filtro = $mensaje_filtro."Apellido materno=".$_SESSION['FLT_ApeMat'];
	}else{$mensaje_filtro = $mensaje_filtro.", Apellido materno=".$_SESSION['FLT_ApeMat'];}
  }
  echo "<tr><td colspan='2'>";
  echo $mensaje_filtro;
  echo "</tr></td>";
}
?>
              </table>
            </fieldset>
          </form></td>
        </tr>
      </table></td>
    </tr>
  </table>
  <table width="100%">
  <tr>
    <td align="center"><table>
      <tr>
        <td>Navegación:</td>
        <td><a href="<?php printf("%s?pageNum_rsUsuarios=%d%s", $currentPage, 0, $queryString_rsUsuarios); ?>" class="estilo3">Primera</a></td>
        <td>|</td>
        <td><a href="<?php printf("%s?pageNum_rsUsuarios=%d%s", $currentPage, max(0, $pageNum_rsUsuarios - 1), $queryString_rsUsuarios); ?>" class="estilo3">Anterior</a></td>
        <td>|</td>
        <td><a href="<?php printf("%s?pageNum_rsUsuarios=%d%s", $currentPage, min($totalPages_rsUsuarios, $pageNum_rsUsuarios + 1), $queryString_rsUsuarios); ?>" class="estilo3">Siguiente</a></td>
        <td>|</td>
        <td><a href="<?php printf("%s?pageNum_rsUsuarios=%d%s", $currentPage, $totalPages_rsUsuarios, $queryString_rsUsuarios); ?>" class="estilo3">Ultima</a></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="center"><table width="100%" border="0" class="TablaListaInventario">
      <tr>
        <th scope="col">Usuario</th>
        <th scope="col">Nivel acceso</th>
        <th scope="col">Nombre</th>
        <th scope="col">Correo electrónico</th>
        <th scope="col">Pago</th>
        <th scope="col">Ponencia</th>
        <th scope="col">Presentación</th>
        <th scope="col">Ultimo acceso</th>
        <th scope="col">ACCION</th>
      </tr>
      <?php do { ?>
      <tr>
        <td align="center"><?php echo $row_rsUsuarios['username']; ?></td>
        <td align="center"><?php echo $row_rsUsuarios['nivel_de_acceso']; ?></td>
        <td><?php echo $row_rsUsuarios['ape_pat']." ".$row_rsUsuarios['ape_mat']." ".$row_rsUsuarios['nombres']; ?></td>
        <td align="center"><?php echo $row_rsUsuarios['email']; ?></td>
        <td align="center"><?php echo $row_rsUsuarios['comp_pago_stat']; ?></td>
        <td align="center"><?php echo $row_rsUsuarios['arch_pon_stat']; ?></td>
        <td align="center"><?php echo $row_rsUsuarios['pres_pon_stat']; ?></td>
        <td align="center"><?php echo $row_rsUsuarios['ultimo_acceso']; ?></td>
        <td align="center"><a href="detalle_usuario.php?username=<?php echo $row_rsUsuarios['username']; ?>" class="estilo3">Ver detalle</a></td>
      </tr>
      <?php } while ($row_rsUsuarios = mysql_fetch_assoc($rsUsuarios)); ?>
    </table></td>
  </tr>
  <tr>
    <td align="center"><table>
      <tr>
        <td>Navegación:</td>
        <td><a href="<?php printf("%s?pageNum_rsUsuarios=%d%s", $currentPage, 0, $queryString_rsUsuarios); ?>" class="estilo3">Primera</a></td>
        <td>|</td>
        <td><a href="<?php printf("%s?pageNum_rsUsuarios=%d%s", $currentPage, max(0, $pageNum_rsUsuarios - 1), $queryString_rsUsuarios); ?>" class="estilo3">Anterior</a></td>
        <td>|</td>
        <td><a href="<?php printf("%s?pageNum_rsUsuarios=%d%s", $currentPage, min($totalPages_rsUsuarios, $pageNum_rsUsuarios + 1), $queryString_rsUsuarios); ?>" class="estilo3">Siguiente</a></td>
        <td>|</td>
        <td><a href="<?php printf("%s?pageNum_rsUsuarios=%d%s", $currentPage, $totalPages_rsUsuarios, $queryString_rsUsuarios); ?>" class="estilo3">Ultima</a></td>
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
      <td align="center">Derechos reservados ©1997-2019. Universidad de Guadalajara. Sitio desarrollado por <a href="https://www.facebook.com/jjesusgm" target="_blank">JJGM</a> | <a href="../creditos">Créditos de sitio</a> | <a href="../ppymd">Política de privacidad y manejo de datos</a></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
</div>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($rsUsuarios);

mysql_free_result($rsNivelesDeAcceso);
?>

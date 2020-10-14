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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO contacto (fecha_contacto, nombre, email, telefono, inscrito, mensaje) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['fFechaContacto'], "date"),
                       GetSQLValueString($_POST['fNombre'], "text"),
                       GetSQLValueString($_POST['fEmail'], "text"),
                       GetSQLValueString($_POST['fTelefono'], "text"),
                       GetSQLValueString($_POST['fInscrito'], "text"),
                       GetSQLValueString($_POST['fMensaje'], "text"));

  mysql_select_db($database_conColoquio, $conColoquio);
  $Result1 = mysql_query($insertSQL, $conColoquio) or die(mysql_error());

  $insertGoTo = "msg_cont_enviado.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
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
<link href="../css/formulario_contacto.css" rel="stylesheet" type="text/css" />
<link href="../css/menu1.css" rel="stylesheet" type="text/css" />
<link href="../css/tablas.css" rel="stylesheet" type="text/css" />
<link href="../css/varios.css" rel="stylesheet" type="text/css" />
<link href="../css/imagenes.css" rel="stylesheet" type="text/css">
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
<div id="div_hdr_path">&nbsp;Inicio &gt; Contacto</div>
<!-- InstanceEndEditable --><!-- InstanceBeginEditable name="Contenido" -->
<div id="div_contenido">
  <table width="90%" border="0" align="center">
    <tr>
      <td align="left"><h1 class="H_Estilo1">Póngase en contacto con nosotros</h1></td>
    </tr>
    <tr>
      <td align="left"><table width="100%">
        <tr>
          <td width="49%" valign="top"><table width="100%">
            <tr>
                <td><h2 class="H_Estilo2 margin_none">Aviso de confidencialidad:</h2></td>
              </tr>
              <tr>
                <td><p class="justificado Indentado margin_none">La Universidad de Guadalajara (UdeG), con domicilio en Avenida Juárez 976, colonia Centro, en Guadalajara, Jalisco, hace de su conocimiento que se considerará como información confidencial aquella que se encuentre contemplada en el artículo 21 de la LTAIPEJM, Lineamientos Cuadragésimo Octavo y Cuadragésimo Noveno de los Lineamientos de Clasificación, Lineamientos Décimo Quinto, Décimo Sexto y Décimo Séptimo de los Lineamientos de Protección, y en general todos aquellos datos de una persona física identificada o identificable y la inherente a las personas jurídicas, los cuales podrán ser sometidos a tratamiento y serán única y exclusivamente utilizados para los fines que fueron proporcionados, de acuerdo con las finalidades y atribuciones establecidas en los artículos 1, 5 y 6 de la Ley Orgánica, así como 2 y 3 del Estatuto General, ambas legislaciones de la Universidad de Guadalajara, de igual forma, para la prestación de los servicios que la misma ofrece conforme a las facultades y prerrogativas de la entidad universitaria correspondiente y estarán a resguardo y protección de la misma. Usted puede consultar nuestro Aviso de Confidencialidad integral en la siguiente página web: <a href="http://transparencia.udg.mx/aviso-confidencialidad-integral" target="_blank" class="estilo3">http://transparencia.udg.mx/aviso-confidencialidad-integral</a></p></td>
              </tr>
              <tr>
                <td><h2 class="H_Estilo2">Formas de contacto:</h2></td>
              </tr>
              <tr>
                <td><strong>México | Oficina del coloquio</strong><br>
                  Corregidora 500, Colonia universitaria<br>
                  Guadalajara, Jalisco, 44420</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><strong>Contacto directo</strong><br>
Tel: (33) 3617-1980 ext. 108<br>
Email: <a href="mailto:coloquio.investigacion.prepa12@gmail.com">coloquio.investigacion.prepa12@gmail.com</a></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><strong>Equipo organizador</strong><br>
                  <a href="mailto:badi60@gmail.com">badi60@gmail.com</a><br>
                  ...<br>
                  ...<br>
                  ...</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><strong>Soporte</strong><br>
                  José de Jesús Gutiérrez Martínez<br>
                  <a href="mailto:jjesusgm@gmail.com">jjesusgm@gmail.com</a></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><strong>Mantengase en contacto</strong>
                  <table border="0">
  <tr>
    <td><a href="https://www.facebook.com/coloquioprepa12/" target="_blank"><img src="../imagenes/rs_facebook_7.png" alt="Facebook" width="48" height="48" class="opaca"></a></td>
    <td><a href="https://twitter.com/coloquioprepa12" target="_blank"><img src="../imagenes/rs_twitter_7.png" alt="Twitter" width="48" height="48" class="opaca"></a></td>
    <td><a href="https://www.youtube.com/channel/UCQQazLioUpSawwnajslv6dA" target="_blank"><img src="../imagenes/rs_youtube_7.png" alt="Youtube" width="48" height="48" class="opaca"></a></td>
    <td><a href="https://www.instagram.com/coloquioprepa12/" target="_blank"><img src="../imagenes/rs_instagram_7.png" alt="Instagram" width="48" height="48" class="opaca"></a></td>
    <td><a href="mailto:coloquio.investigacion.prepa12@gmail.com"><img src="../imagenes/rs_email_7.png" alt="Correo electrónico" width="48" height="48" class="opaca"></a></td>
    <td><img src="../imagenes/rs_whatsapp_7.png" alt="Whatsapp" width="48" height="48" class="opaca"></td>
    <td><img src="../imagenes/rs_skype_7.png" alt="Skype" width="48" height="48" class="opaca"></td>
  </tr>
</table></td>
              </tr>
          </table>
            </td>
            <td>&nbsp;</td>
          <td width="49%" valign="top"><form name="form1" method="POST" action="<?php echo $editFormAction; ?>">
            <table width="100%">
                <tr>
                  <td><h2 class="H_Estilo2 margin_none">Formulario de contacto:</h2></td>
                </tr>
                <tr>
                  <td>
<?php
date_default_timezone_set('America/Mexico_City');
$current_date_time = date('Y-m-d H:i:s');
?>
                    <input type="hidden" name="fFechaContacto" id="fFechaContacto" value="<?php $current_date_time ?>">
                    <label for="fNombre">Nombre completo (requerido)</label>
				  </td>
                </tr>
                <tr>
                  <td><input name="fNombre" type="text" id="fNombre" maxlength="100" required></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><label for="fEmail">Correo electrónico (requerido)</label></td>
                </tr>
                <tr>
                  <td><input name="fEmail" type="email" id="fEmail" maxlength="100" required></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><label for="fTelefono">Número de teléfono (requerido)</label></td>
                </tr>
                <tr>
                  <td><input name="fTelefono" type="tel" id="fTelefono" maxlength="15" pattern="[0-9]{10}" required></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><label for="fInscrito">¿Está inscrito al coloquio? (requerido)</label></td>
                </tr>
                <tr>
                  <td><select name="fInscrito" id="fInscrito">
                    <option value="No">No</option>
                    <option value="Si">Si</option>
                  </select></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><label for="fMensaje">¿En qué le podemos ayudar? (requerido)</label></td>
                </tr>
                <tr>
                  <td><textarea name="fMensaje" rows="4" id="fMensaje" required></textarea></td>
                </tr>
                <tr>
                  <td align="center">&nbsp;</td>
                </tr>
                <tr>
                  <td align="center"><input type="submit" name="bEnviar" id="bEnviar" value="Enviar"></td>
                </tr>
              </table>
              <input type="hidden" name="MM_insert" value="form1">
          </form></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td align="left">&nbsp;</td>
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
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
  $insertSQL = sprintf("INSERT INTO usuarios (username, nip, nivel_de_acceso, ciclo_de_ingreso, email, ape_pat, ape_mat, nombres, sexo, fecha_nacimiento, id_universidad, id_grado_acad, num_celular) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['fUsername'], "text"),
                       GetSQLValueString($_POST['fNip'], "text"),
                       GetSQLValueString($_POST['fNivelDeAcceso'], "text"),
                       GetSQLValueString($_POST['fCicloDeIngreso'], "text"),
                       GetSQLValueString($_POST['fEmail'], "text"),
                       GetSQLValueString($_POST['fApePat'], "text"),
                       GetSQLValueString($_POST['fApeMat'], "text"),
                       GetSQLValueString($_POST['fNombres'], "text"),
                       GetSQLValueString($_POST['fSexo'], "text"),
                       GetSQLValueString($_POST['fFechaNacimiento'], "date"),
                       GetSQLValueString($_POST['fIdUniversidad'], "int"),
                       GetSQLValueString($_POST['fIdGradoAcad'], "int"),
                       GetSQLValueString($_POST['fNumCelular'], "text"));

  mysql_select_db($database_conColoquio, $conColoquio);
  $Result1 = mysql_query($insertSQL, $conColoquio) or die(mysql_error());

  $insertGoTo = "registro_exitoso.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

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
<link href="../css/formularios.css" rel="stylesheet" type="text/css">
<link href="../css/imagenes.css" rel="stylesheet" type="text/css">
<link href="../css/menu1.css" rel="stylesheet" type="text/css" />
<link href="../css/tablas.css" rel="stylesheet" type="text/css" />
<link href="../css/varios.css" rel="stylesheet" type="text/css" />
<link href="../widgets/jquery-ui/jquery-ui.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/menus.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<script type="text/javascript" src="../js/validar_usuario_nuevo.js"></script>
<script type="text/javascript" src="../js/show_hide_fields.js"></script>
<script type="text/javascript" src="../widgets/jquery-ui/jquery-ui.js"></script>
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
		showOn:"both",
		showButtonPanel:true,
		monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic" ]
	});
 }
);
$(document).ready(function () {
  $('#mostrar_contrasena').click(function () {
    if ($('#mostrar_contrasena').is(':checked')) {
      $('#fNip').attr('type', 'text');
    } else {
      $('#fNip').attr('type', 'password');
    }
  });
});
</script>
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
<div id="div_hdr_path">&nbsp;Inicio &gt; Inscripción &gt; Ponente</div>
<!-- InstanceEndEditable --><!-- InstanceBeginEditable name="Contenido" -->
<div id="div_contenido">
  <table width="90%" border="0" align="center">
    <tr>
      <td align="left"><h1 class="H_Estilo1">Inscripción como PONENTE al coloquio</h1></td>
    </tr>
    <tr>
      <td align="center"><form name="form1" method="POST" action="<?php echo $editFormAction; ?>">
        <div class="DivShadowMsg"><table width="800" border="0" class="tabla_info_msg">
          <tr>
            <th colspan="2" align="left" scope="col">Información del ponente</th>
          </tr>
          <tr>
            <td align="right"><label for="fUsername">Usuario*</label></td>
            <td><table class="TablaInvisible"><tr><td><input name="fUsername" type="text" id="fUsername" size="20" maxlength="20" placeholder="4+ letras y/o números" autocomplete="off" pattern="[a-zA-Z0-9_-]{4,20}" required><span class="validity"></span></td><td><div id="div_resultado"></div></td></tr></table></td>
          </tr>
          <tr>
            <td align="right"><label for="fNip">Contraseña*</label></td>
            <td><input name="fNip" type="password" id="fNip" size="30" maxlength="100" placeholder="4+ letras y/o números" pattern="[a-zA-Z0-9_-]{4,100}" required><span class="validity"></span>
              <input type="checkbox" name="mostrar_contrasena" id="mostrar_contrasena">Mostrar contraseña</td>
          </tr>
          <tr>
            <td align="right"><label for="fEmail">Correo electrónico</label></td>
            <td><input name="fEmail" type="text" id="fEmail" size="50" maxlength="100" Pattern="([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})"><span class="validity"></span></td>
          </tr>
          <tr>
            <td align="right"><label for="fNombres">Nombre(s)*</label></td>
            <td><input name="fNombres" type="text" id="fNombres" size="30" maxlength="30" required><span class="validity"></span></td>
          </tr>
          <tr>
            <td align="right"><label for="fApePat">Apellido paterno*</label></td>
            <td><input name="fApePat" type="text" id="fApePat" size="30" maxlength="30" required><span class="validity"></span>
              <input name="fNivelDeAcceso" type="hidden" id="fNivelDeAcceso" value="Ponente"></td>
          </tr>
          <tr>
            <td align="right"><label for="fApeMat">Apellido materno</label></td>
            <td><input name="fApeMat" type="text" id="fApeMat" size="30" maxlength="30"><span class="validity"></span>
              <input name="fCicloDeIngreso" type="hidden" id="fCicloDeIngreso" value="2019"></td>
          </tr>
          <tr>
            <td align="right"><label for="fSexo">Sexo*</label></td>
            <td>
              <input type="radio" name="fSexo" value="Hombre" id="fSexo_0" checked>Hombre
              <input type="radio" name="fSexo" value="Mujer" id="fSexo_1">Mujer
            </td>
          </tr>
          <tr>
            <td align="right"><label for="fFechaNacimiento">Fecha nacimiento*</label></td>
            <td><input name="fFechaNacimiento" type="text" id="fFechaNacimiento" size="15" maxlength="10" placeholder="aaaa-mm-dd" required></td>
          </tr>
          <tr>
            <td align="right"><label for="fIdUniversidad">Universidad de procedencia*</label></td>
            <td><select name="fIdUniversidad" id="fIdUniversidad" onchange="hide_show_otra_universidad();">
              <?php
do {  
?>
              <option value="<?php echo $row_rsUniversidades['id_universidad']?>"><?php echo $row_rsUniversidades['universidad']?></option>
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
          <tr id="fUnivOtra" class="ElemOculto">
            <td align="right"><label for="fUnivOtra">Otra universidad</label></td>
            <td><input name="fUnivOtra" type="text" id="fUnivOtra" size="50" maxlength="100"></td>
          </tr>
          <tr>
            <td align="right"><label for="fIdGradoAcad">Grado académico*</label></td>
            <td><select name="fIdGradoAcad" id="fIdGradoAcad" onchange="hide_show_otro_grado_academico();">
              <?php
do {  
?>
              <option value="<?php echo $row_rsGradosAcademicos['id_grado_acad']?>"><?php echo $row_rsGradosAcademicos['grado_academico']?></option>
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
          <tr id="fGradoAcadOtro" class="ElemOculto">
            <td align="right"><label for="fGradoAcadOtro">Otro grado academico</label></td>
            <td><input name="fGradoAcadOtro" type="text" id="fGradoAcadOtro" size="30" maxlength="30"></td>
          </tr>
          <tr>
            <td align="right"><label for="fNumCelular">Celular*</label></td>
            <td><input name="fNumCelular" type="tel" id="fNumCelular" size="20" maxlength="15" pattern="[0-9]{10}" placeholder="10 digitos" required><span class="validity"></span></td>
          </tr>
          <tr>
            <td colspan="2" align="right"><input type="submit" name="bEnviar" id="bEnviar" value="Enviar">
              <input type="reset" name="bRestablecer" id="bRestablecer" value="Restablecer">
              <a href="../index.php" class="button-link">Cancelar</a></td>
          </tr>
        </table>
        <input type="hidden" name="MM_insert" value="form1"></div>
      </form></td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><table width="800" border="0">
        <tr>
          <td><table class="TBL_MsgError">
            <tr>
              <th scope="row">&nbsp;</th>
              <td>NOTA: Las constancias se generarán tal como se registren los ponentes. Sólo se extenderá constancia a  ponentes debidamente registrados y que hayan cubierto la cuota de inscripción.</td>
            </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><table width="100%" border="0">
        <tr>
          <td><table class="TBL_MsgInfo">
            <tr>
              <th scope="row">&nbsp;</th>
              <td><h2 class="H_Estilo2 margin_none">AVISO DE CONFIDENCIALIDAD</h2></td>
            </tr>
            <tr>
              <th scope="row">&nbsp;</th>
              <td><p class="justificado Indentado margin_none">La Universidad de Guadalajara (UdeG), con domicilio en Avenida Juárez 976, colonia Centro, en Guadalajara, Jalisco, hace de su conocimiento que se considerará como información confidencial aquella que se encuentre contemplada en el artículo 21 de la LTAIPEJM, Lineamientos Cuadragésimo Octavo y Cuadragésimo Noveno de los Lineamientos de Clasificación, Lineamientos Décimo Quinto, Décimo Sexto y Décimo Séptimo de los Lineamientos de Protección, y en general todos aquellos datos de una persona física identificada o identificable y la inherente a las personas jurídicas, los cuales podrán ser sometidos a tratamiento y serán única y exclusivamente utilizados para los fines que fueron proporcionados, de acuerdo con las finalidades y atribuciones establecidas en los artículos 1, 5 y 6 de la Ley Orgánica, así como 2 y 3 del Estatuto General, ambas legislaciones de la Universidad de Guadalajara, de igual forma, para la prestación de los servicios que la misma ofrece conforme a las facultades y prerrogativas de la entidad universitaria correspondiente y estarán a resguardo y protección de la misma. Usted puede consultar nuestro Aviso de Confidencialidad integral en la siguiente página web: <a href="http://transparencia.udg.mx/aviso-confidencialidad-integral" target="_blank" class="estilo3">http://transparencia.udg.mx/aviso-confidencialidad-integral</a></p></td>
            </tr>
          </table></td>
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
mysql_free_result($rsUniversidades);

mysql_free_result($rsGradosAcademicos);
?>

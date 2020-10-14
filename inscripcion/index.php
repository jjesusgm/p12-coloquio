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
<div id="div_hdr_path">&nbsp;Inicio &gt; Inscripción</div>
<!-- InstanceEndEditable --><!-- InstanceBeginEditable name="Contenido" -->
<div id="div_contenido">
  <table width="90%" border="0" align="center">
    <tr>
      <td align="left"><h1 class="H_Estilo1">Inscripción</h1></td>
    </tr>
    <tr>
      <td align="left"><p class="justificado">En esta página se muestran opciones de forma dinámica, dependiendo de si el usuario inició sesión o no y del rol que éste tiene (Asistente, Ponente, etc.).</p></td>
    </tr>
    <tr>
      <td align="left"><h3 class="H_Estilo2">Opciones disponibles</h3></td>
    </tr>
    <tr>
      <td align="left"><table width="100%" border="0">
      <?php if(isset($_SESSION['MM_UserGroup'])) {
		if($_SESSION['MM_UserGroup'] == "Administrador" or $_SESSION['MM_UserGroup'] == "Soporte") { ?>
        <tr>
          <td align="right" valign="top">-</td>
          <td valign="bottom"><a href="val_pagos.php" class="estilo3">Validar pagos de ponentes y asistentes</a></td>
        </tr>
		<?php } else { ?>
        <tr>
          <td align="right" valign="top">-</td>
          <td valign="bottom"><a href="sube_comp_pago.php" class="estilo3">Subir el comprobante de pago escaneado</a></td>
        </tr>
        <tr>
          <td align="right" valign="top">-</td>
          <td valign="bottom"><a href="../adjuntos/procedimiento_para_solicitud_factura_electrónica+formato+diagrama.doc" target="_blank" class="estilo3">Descarga del formato para solicitud de Emisión de Factura Electrónica (EFE)</a></td>
        </tr>
        <tr>
          <td align="right" valign="top">-</td>
          <td valign="bottom"><a href="cartas_aceptacion.php" class="estilo3">Descarga de carta de aceptación</a></td>
        </tr>
		<?php } ?>
        <tr>
          <td align="right" valign="top">-</td>
          <td valign="bottom"><a href="constancias.php" class="estilo3">Descarga de constancia</a></td>
        </tr>
      <?php } else { ?>
        <tr>
          <td width="30" align="right" valign="top">-</td>
          <td valign="bottom"><a href="ins_asistente.php" class="estilo3">Inscripción como asistente</a></td>
        </tr>
        <tr>
          <td align="right" valign="top">-</td>
          <td valign="bottom"><a href="ins_ponente.php" class="estilo3">Inscripción como ponente</a></td>
        </tr>
      <?php } ?>
      </table>
        </td>
    </tr>
    <tr>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td align="left"><h3 class="H_Estilo2">Información adicional</h3></td>
    </tr>
    <tr>
      <td align="left"><table width="100%" border="0">
        <tr>
          <td colspan="2"><p class="justificado">1) El costo de inscripción general es de $800.00 y $500.00 para estudiantes con 
            identificación oficial y vigente. El pago debe realizarse en BBVA (antes BBVA Bancomer), número 
            de referencia: 90000217035, Coloquio Engranaje Incluc M.E./Prepa 12/SEMS. La fecha límite 
            de pago es el 30 de septiembre de 2019. <em><strong>Convenio CIE 0588313 - BBVA.</strong></em><strong></strong></p></td>
        </tr>
        <tr>
          <td colspan="2"><p class="justificado">2) Una vez realizado el pago escriba su nombre completo en el comprobante, después debe subir el comprobante escaneado.</p></td>
        </tr>
        <tr>
          <td colspan="2"><p class="justificado">3) La tarifa para la persona inscrita incluye:</p></td>
          </tr>
        <tr>
          <td width="30" align="right" valign="top">-</td>
          <td>Acceso a todos los eventos del coloquio</td>
        </tr>
        <tr>
          <td align="right" valign="top">-</td>
          <td>Servicio de cafetería</td>
        </tr>
        <tr>
          <td align="right" valign="top">-</td>
          <td>Kit del coloquio</td>
        </tr>
        <tr>
          <td align="right" valign="top">-</td>
          <td>Constancia de asistencia y presentación de ponencia</td>
        </tr>
        <tr>
          <td align="right" valign="top">-</td>
          <td>Publicación de la ponencia siempre y cuando cubra los requisitos solicitados y sean aprobadas por el comité evaluador (máximo dos coautores inscritos en el coloquio)</td>
        </tr>
        <tr>
          <td align="right" valign="top">-</td>
          <td>Comida el viernes</td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td align="left">&nbsp;</td>
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
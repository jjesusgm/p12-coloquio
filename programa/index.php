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
<div id="div_hdr_path">&nbsp;Inicio &gt; Programa</div>
<!-- InstanceEndEditable --><!-- InstanceBeginEditable name="Contenido" -->
<div id="div_contenido">
  <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><h1 class="H_Estilo1">Programa general</h1></td>
    </tr>
    <tr>
      <td><h2 class="H_Estilo2">Noviembre 22</h2></td>
    </tr>
    <tr>
      <td><table width="100%" border="0" align="center" class="tabla_programa">
        <tr>
          <th align="left">Horario</th>
          <th align="left">Actividad</th>
          </tr>
        <tr>
          <td align="center">8:00 - 9:00</td>
          <td>Registro de participantes</td>
        </tr>
        <tr>
          <td align="center">9:15 - 9:30</td>
          <td>Inauguración</td>
        </tr>
        <tr>
          <td align="center">9:30 - 9:35</td>
          <td>Intermedio musical</td>
        </tr>
        <tr>
          <td align="center">9:35 - 10:30</td>
          <td>Conferencia Magistral <em>Evaluación para el aprendizaje</em>, <a href="../conferencistas/sandra_c_f.php" class="estilo3">Dra. Sandra Castañeda Figueiras</a> SNI</td>
        </tr>
        <tr>
          <td align="center">10:30 - 11:30</td>
          <td>Conferencia Magistral <em>Oportunidades y desigualdad educativa</em>, <a href="../conferencistas/nicolas_c_j.php" class="estilo3">Dr. Nicolás Corona Juárez</a> SNI</td>
        </tr>
        <tr>
          <td align="center">11:30 - 12:30</td>
          <td><p class="margin_bottom"><strong>Panel Políticas públicas:</strong></p>
            <p class="margin_none">- Derechos humanos, <a href="../panelistas/sergio_m_e_m.php" class="estilo3">Mtro. Sergio Mariano Estrada Muñiz</a><br>
            - Inclusión educativa de personas con discapacidad, <a href="../panelistas/tonatiuh_l_a.php" class="estilo3">Dr. Israel Tonatiuh Lay Arellano</a><br>
            - Inclusión educativa para población indígena, <a href="../panelistas/enrique_l_r.php" class="estilo3">Dr. Enrique López Ramírez</a><br>
            - Educación ambiental, <a href="../panelistas/jose_j_h_l.php" class="estilo3">Dr. José de Jesús Hernández López</a> SNI</p></td>
        </tr>
        <tr>
          <td align="center">12:30 - 12:35</td>
          <td>Intermedio musical</td>
        </tr>
        <tr>
          <td align="center">12:45 - 14:00</td>
          <td>Ponencias</td>
        </tr>
        <tr>
          <td align="center">14:00 - 15:30</td>
          <td>Comida</td>
        </tr>
        <tr>
          <td align="center">15:30 - 20:00</td>
          <td>Ponencias</td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><h2 class="H_Estilo2">Noviembre 23</h2></td>
    </tr>
    <tr>
      <td><table width="100%" border="0" align="center" class="tabla_programa">
        <tr>
          <th align="left">Horario</th>
          <th align="left">Actividad</th>
        </tr>
        <tr>
          <td align="center">9:00 - 10:00</td>
          <td>Conferencia Magistral <em>Modelos pedagógicos incluyentes</em>, <a href="../conferencistas/martha_v_f.php" class="estilo3">Dra. Martha Vergara Fregoso</a> SNI</td>
        </tr>
        <tr>
          <td align="center">10:00 - 14:00</td>
          <td>Talleres</td>
        </tr>
        <tr>
          <td align="center">14:00 - 14:20</td>
          <td>Clausura</td>
        </tr>
      </table></td>
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
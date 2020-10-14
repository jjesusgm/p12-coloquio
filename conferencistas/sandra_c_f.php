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
<div id="div_hdr_path">&nbsp;Inicio &gt; Conferencistas &gt; Nicolás Corona Juárez</div>
<!-- InstanceEndEditable --><!-- InstanceBeginEditable name="Contenido" -->
<div id="div_contenido">
  <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><h1 class="H_Estilo1 margin_both">Perfil del conferencista</h1></td>
    </tr>
    <tr>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="20%" align="left" valign="top"><img src="imagenes/sandra_c_f.png" alt="Dra. Sandra Castañeda Figueiras" style="width:90%; max-width:150px;" class="img_borde1"></td>
          <td><strong>Nombre:</strong> Dra. Sandra Castañeda Figueiras<br>
            <strong>Correo electrónico:</strong>
            <a href="mailto:sandra@unam.mx" class="estilo3">sandra@unam.mx</a>
<p class="justificado Indentado">Es doctora en Psicóloga General Experimental por la UNAM y profesora Titular “C”, Definitiva, de Tiempo Completo en dos Facultades y dos Institutos de Investigación. Ha recibido distinciones y reconocimientos académicos (tres menciones honoríficas, la Medalla Gabino Barreda, la Cátedra Especial “José Gómez Robleda”, el “Premio Nacional a la Enseñanza de la Psicología” y el “Premio Nacional en Investigación”).</p>
<p class="justificado Indentado">CONACyT reconoció su proyecto de investigación actual sobre Agencia Académica en Estudiantes Universitarios como “CASO DE ÉXITO. Pertenece al Sistema Nacional de Investigadores (II). Propuso y logró la creación de dos niveles formativos en Ciencias Cognitivas y del Comportamiento (licenciatura y Especialización). Es PRIDE “D” desde su inicio. Su trabajo se centra en la evaluación y el fomento de atributos psicológicos, de naturaleza diversa y esencial, compatibles entre sí, que han mostrado predecir el éxito académico y que son sensibles a interactuar estratégicamente (o no) durante el Aprendizaje Académico. Su investigación analiza y modela (por ecuaciones estructurales e investigación experimental), estructuras relacionales entre componentes cognitivos, epistemológicos, auto regulatorios, sociales, volitivos y de personalidad que son responsables del éxito académico. El marco de trabajo es incremental/instrumental, con método experimental de grupo, en un contexto de Episodios de Aprendizaje que elicitan y ponen a prueba determinantes del aprendizaje, en un contexto con alta interactividad y significado formativo. Tales actividades son apoyadas por técnicas experimentales y simulacionales, en ambientes presencial, Web y Móvil.</p>
<p class="justificado Indentado">Su producción de instrumentos de medición en estos factores es altamente apreciada en IES nacionales y extranjeras. Entre ellos, el Meta Evaluador Académico es una plataforma Web que registra, aplica, califica y reportea resultados acerca del desempeño de estudiantes de educación media superior y superior en heurísticas cognitivas, metacognitivas, autorregulatorias, volitivas, de regulación emocional y de epistemología personal que han mostrado predecir la capacidad de auto gestión de los estudiantes. Además de aplicarse en México, actualmente se está desarrollando una investigación con cuatro países latinoamericanos. También está en desarrollo un Meta tutor móvil para fomentar áreas de oportunidad del estudiante en habilidades de estudio y para toda la vida.</p>
<p class="justificado Indentado">Fue coautora del modelo y de los los exámenes de ingreso al Bachillerato y a las licenciaturas de la UNAM, como también es la autora de los modelos y los exámenes de Egreso de dos licenciaturas para el Centro Nacional de la Evaluación para la Educación Superior.</p>
<p class="justificado Indentado">La Dra. Castañeda es miembro del Consejo Editorial de nueve revistas especializadas; cuatro mexicanas y cinco internacionales. Ha sido editora invitada de números monográficos y de colecciones de libros. A la fecha, ha elaborado 82 capítulos en libros y más de un centenar de artículos científicos en revistas nacionales e internacionales. También es reconocida por gestionar obra especializada en español que incluye avances sobre Aprendizaje Académico Autorregulado, Diseño de la Instrucción y Tecnologías de la Información y la Comunicación. La correspondiente a 1998 fue seleccionada para ser incluida en la Colección “Problemas Educativos de México”. La de 2004 lleva varias ediciones, la de 2006 se agotó a los 4 meses de haber salido a la venta, la de 2014 fue premiada por CONACyT como CASO DE ÉXITO, la de 2016 dibuja la Fenomenología de los componentes de Agencia Académica en varias regiones y profesiones en el país. El último libro (2018), muestra diversas derivaciones tecnológicas en y para la evaluación y el fomento de la Agencia Académica. Es reconocida en el ámbito nacional y latinoamericano de la evaluación y fomento del aprendizaje académico autorregulado.</p>
<p class="center">Ciudad Universitaria, 19 de julio de 2019<br>
Dra. Sandra Castañeda Figueiras<br>
Cel. (55)5969-1246
</p></td>
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
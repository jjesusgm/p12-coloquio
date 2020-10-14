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
<div id="div_hdr_path">&nbsp;Inicio</div>
<!-- InstanceEndEditable --><!-- InstanceBeginEditable name="Contenido" -->
<div id="div_contenido">
  <table width="90%" border="0" align="center" class="TablaContenido">
    <tr>
      <td><h1 class="H_Estilo1">Política de privacidad y manejo de datos</h1>
        <h2 class="H_Estilo2">Políticas de publicación en sitios web udg.mx</h2>
        <p>Los sitios web de la <strong>Universidad de Guadalajara</strong> tiene como objetivo presentar contenidos dirigidos hacia los integrantes de su comunidad universitaria y público en general, que apoyen cumplir los fines establecidos en el artículo 5 de su Ley Orgánica; con la misión y visión descritas en su <strong>Plan de Desarrollo Institucional 2014-2030</strong>. De esta manera, se busca fortalecer su presencia en internet y ser la fuente de información institucional oportuna y confiable. A fin de asegurar el logro de este objetivo, se han definido los siguientes lineamientos generales para la publicación de los sitios web:</p>
        <ol>
          <li>Toda la información será verificada por los editores del sitio para garantizar su veracidad, oportunidad y exactitud antes y durante su publicación.</li>
        <li>La información publicada en el sitio deberá ser de utilidad a la comunidad universitaria y siempre buscará destacar los aspectos que favorezcan la buena imagen de la Universidad de Guadalajara, el respeto de los derechos humanos, el fomento de la cultura de la legalidad y bienestar de la sociedad.</li>
        <li>Este sitio será un espacio de expresión democrática de los miembros de la comunidad universitaria, por lo que siempre se privilegiará la difusión de opiniones plurales que se hagan dentro de un marco de respeto, tolerancia e imparcialidad.</li>
        <li>No se podrá hacer ningún tipo de proselitismo de ideas políticas o gremiales, así como no están permitidos los contenidos que promuevan violencia, sectarismo, intolerancia, racismo, vicios o cualquier acto ilícito.</li>
        <li>Se tiene prohibida la comercialización de los espacios dentro de este sitio web. Si fuese necesario publicar algún contenido especial por una institución externa a la Universidad de Guadalajara, deberá solicitarse de manera formal a los administradores del sitio, donde deberán especificar las características y duración de dicha publicación. Ningún acuerdo de publicación con una entidad externa podrá ser vitalicio.</li>
        <li>Toda petición de publicación en este sitio, que provenga de las diferentes entidades de la Red Universitaria, deberá solicitarse de manera formal a los administradores del sitio. Cada solicitud de publicación deberá incluir los siguientes datos.
          <ul>
            <li>Nombre completo y cargo de quien lo solicita.</li>
            <li>Dependencia a la que se encuentra adscrito.</li>
            <li>Nombre del evento, actividad, así como una breve descripción de un párrafo.</li>
            <li>Duración y vigencia de su publicación.</li>
          </ul>
        </li>
        <li>Estas políticas de publicación son susceptibles de actualizarse para mejorar el servicio que se ofrece en este sitio web, por lo que se recomienda revisarlas periódicamente en esta misma dirección.</li>
        </ol>
        <h2 class="H_Estilo2"><br>
          Política de privacidad y confidencialidad para los sitios web udg.mx</h2>
        <p>Este documento enuncia a la política de privacidad y confidencialidad de los sitios que forman parte de la Universidad de Guadalajara y que emplean el dominio udg.mx.</p>
        <p>Esta política de privacidad y confidencialidad establece que datos obtiene la Universidad de Guadalajara de los usuarios que visitan los sitios web de su Red Universitaria; la manera en que protege la información personal que el usuario proporciona al momento en que hace uso los sitios web y, también le permite conocer cómo se procesa y utiliza esta información.</p>
        <p>La Universidad de Guadalajara se compromete a garantizar que su privacidad sea protegida cuando visita uno de sus sitios web. Si por alguna razón, le solicitamos a un usuario que proporcione cierta información será para poder identificarlo para brindar el servicio que solicite, puede estar seguro que la información es manejada de acuerdo a esta declaración de privacidad y confidencialidad, la cual le sugerimos leer para entender el tratamiento de su información personal.</p>
        <h3>Información que se recolecta en este sitio</h3>
        <p>Los datos que se pueden recopilar en los sitios web de la Universidad de Guadalajara son:</p>
        <ul>
          <li>Información técnica del equipo con que accede al sitio web. (Dirección IP, navegador que emplea, versión, etc.)</li>
          <li>Información estadística de la navegación del usuario por el sitio web (archivos del sitio solicitados, palabras claves utilizadas en motores de búsqueda, etc.)</li>
          <li>Información pertinente para el uso de encuestas o sondeos de opinión en los sitios web.</li>
          <li>Información de contacto cuando el usuario desee comunicarse con los administradores de este sitio web (correo electrónico, nombre, asunto, teléfono o mensaje)</li>
        </ul>
        <h3>¿Qué se hace con la información que se recolecta?</h3>
        <p>La información que se recolecta en este sitio se emplea para entender las necesidades de los usuarios y de esta forma proveer un mejor servicio; y de manera particular se emplea para:</p>
        <ul>
          <li>Registro de actividad en los servidores.</li>
          <li>Atención de problemas específicos de los sitios web para su corrección.</li>
          <li>Identificación y seguimiento de comentarios que se reciban a través de las formas de contacto y correo electrónico del sitio web.</li>
          <li>Utilizar la información para mejorar los servicios que se ofrecen en línea.</li>
        </ul>
        <h3>Tecnología empleada en los sitios web: Cookies</h3>
        <p>Una cookie es una pequeña pieza de información que es enviadas por el sitio web a su navegador. Las cookies se almacenan en el disco duro de su equipo y se utilizan para determinar sus preferencias cuando se conecta a los servicios de nuestros sitios, así como para rastrear determinados comportamientos o actividades llevadas a cabo por usted dentro de nuestros sitios.</p>
        <p>Las cookies permiten que los servicios que se ofrecen por el web, puedan adaptar su funcionamiento para que respondan a Usted como un usuario diferente del resto que visitan el sitio web y que esta identificación se refleje en que cada usuario tenga una experiencia personalizada al visitar este sitio.</p>
        <p>Utilizamos cookies de registro del tráfico para identificar qué páginas se están visitando. Esto nos ayuda a analizar datos sobre el tráfico de la página web y mejorar la calidad de nuestro sitio web para adaptarlo y ajustar la información a las necesidades del cliente. Sólo utilizamos esta información para fines de análisis estadístico, por lo que después de esta acción los datos son eliminados automáticamente del sistema.</p>
        <p>En general, las cookies nos ayudan a brindarle una mejor experiencia de navegación al momento de visitar nuestro sitio web. Una cookie de ninguna manera nos da acceso a su computadora o a cualquier información sobre usted, excepto los datos que usted decida compartir con nosotros.</p>
        <p>Como usuario siempre puede elegir entre aceptar o rechazar las cookies. La mayoría de los navegadores web están configurados para aceptar automáticamente las cookies, pero cada usuario puede modificar este permiso en el explorador para rechazar las cookies si así él lo prefiere, aunque esto puede afectar la manera en que funciona este sitio web.</p>
        <h3>Los enlaces a otros sitios web y correo electrónico</h3>
        <p>Los sitios web pueden tener enlaces a otros sitios webs o correos electrónicos ajenos a la red universitaria o que estén fuera del dominio udg.mx. Sin embargo, una vez que haya utilizado estos enlaces para salir de nuestro sitio, debe tener en cuenta que los administradores de la Universidad de Guadalajara no tienen ningún control sobre estos sitios web. Por lo tanto, no podemos ser responsables de la protección y la privacidad de cualquier información confidencial o no confidencial que los usuarios proporcionen al visitar los mismos, ya que quedarán sujeto a las políticas de privacidad y manejo de datos de estos sitios web.</p>
        <p>La Universidad de Guadalajara no se hace responsable cuando el usuario proporcione información de cualquier tipo, a los enlaces y/o correos electrónicos publicados diferentes al de los administradores de los sitios de la Universidad de Guadalajara, incluyendo funcionarios y dependencias de esta institución; el manejo de esta información quedará bajo la responsabilidad y propio riesgo del usuario.</p>
        <h3>Seguridad de la información</h3>
        <p>De conformidad con los artículos 25, fracciones XV, XVII, XIX, XX y 26, fracción IV de la Ley de Transparencia y Acceso a la información pública del estado de Jalisco y sus municipios, estamos comprometidos a asegurar que su información personal esté protegida. Con el fin de evitar el acceso no autorizado o divulgación, se cuenta con la infraestructura física e informática, así como los procedimientos administrativos apropiados para salvaguardar y asegurar la información que recopilamos en línea.</p>
        <h3>Confidencialidad de datos personales</h3>
        <p>Cuando se encuentre haciendo uso del sitio web y le sean solicitados datos personales, Usted compartirá esta información sólo con la Universidad de Guadalajara, ya que esta casa de estudios no compartirá la información confidencial con terceras personas, salvo que sea requerida por orden judicial o que Usted de manera expresa lo autorice de conformidad con la ley en la materia.</p>
        <p>La Universidad de Guadalajara puede difundir las estadísticas de acceso a su sitio web del conjunto de sus usuarios para describir nuestros servicios y para otros propósitos lícitos en los casos que marque la ley.</p>
        <p>En todo momento, la Universidad de Guadalajara está atenta a las inquietudes que manifiesten sus usuarios respecto al manejo de la información que proporcionen para los diversos procesos en línea.</p>
        <p>La Universidad de Guadalajara se reserva el derecho de realizar actualizaciones a esta política de privacidad por lo que le recomendamos revisar este documento periódicamente para estar enterado de estos cambios.</p>
        <h2 class="H_Estilo2">Declaración del límite de responsabilidad</h2>
        <p><strong>Sobre el origen de los contenidos.</strong> Los contenidos publicados en este sitio web de la Universidad de Guadalajara son exclusivamente de carácter informativo. La información que se presenta es, en la mayoría de los casos, proporcionada por entidades de la red universitaria y a menos que se especifique lo contrario, se puede consultar a través de los créditos de este sitio web.</p>
        <p><strong>Sobre la veracidad y exactitud de la información.</strong> Los responsables del sitio, se encargan de verificar la veracidad y exactitud de la información que se presente. En los casos en que exista alguna corrección u observación de los contenidos del sitio se deberá enviar a través de uno de los métodos que son mencionados en la página de créditos del sitio, para su verificación y en su caso, la corrección.</p>
        <p><strong>Sobre los enlaces a sitios ajenos.</strong> A través de este sitio web se pueden encontrar enlaces hacia otros sitios web que no están bajo el control de la UDG, por lo que el contenido presentado en ellos o su disponibilidad depende de sus responsables. En los casos en que el enlace referencie a un evento, actividad, convocatoria o promoción, son sus organizadores los responsables de la exactitud y fiabilidad de la información, así como de todo lo relacionado a la ejecución.</p>
        <p><strong>Sobre la disponibilidad del servicio.</strong> Los responsables de este sitio web se comprometen a hacer todo lo posible para tenerlo siempre disponible al público, sin embargo no nos hacemos responsables de problemas técnicos fuera de nuestro control que ocasione fallas temporales.</p>
      <p>La Universidad de Guadalajara se reserva el derecho de realizar actualizaciones a esta declaración del límite de responsabilidad por lo que le recomendamos revisar este documento periódicamente para estar enterado de estos cambios.</p></td>
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
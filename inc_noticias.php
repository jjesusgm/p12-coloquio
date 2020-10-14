<?php require_once('Connections/conColoquio.php'); ?>
<?php mysql_set_charset('utf8'); ?>
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

mysql_select_db($database_conColoquio, $conColoquio);
$query_rsNoticias = "SELECT * FROM noticias WHERE estatus = 'Publicada' ORDER BY fecha DESC";
$rsNoticias = mysql_query($query_rsNoticias, $conColoquio) or die(mysql_error());
$row_rsNoticias = mysql_fetch_assoc($rsNoticias);
$totalRows_rsNoticias = mysql_num_rows($rsNoticias);
?>

<?php 
// INICIO: Codigo que muestra la tabla con hasta ocho noticias
$contador = 0;
echo "<table class='TBL_NotiPrincipal'>";
echo "<caption style='text-align:left;margin:0px 5px 0px 5px;'>Noticias</caption>";
do {
  $contador++;
  if($contador % 2 != 0){
    echo "<tr>";
  }
  if($row_rsNoticias['imagen'] == NULL){
    echo "<td width='10%'><a href='noticias/ver_noticia.php?id_noticia=".$row_rsNoticias['id_noticia']."'><img src='noticias/imagenes/ico_noticia.jpg' style='width:120px;' /></a></td>";
  }else{
    echo "<td width='10%'><a href='noticias/ver_noticia.php?id_noticia=".$row_rsNoticias['id_noticia']."'><img src='data:image/jpeg;base64,".base64_encode($row_rsNoticias['imagen'])."' style='width:120px;' /></a></td>";
  }
  echo "<td width='40%'><p class='margin_bottom'>Fecha: ".$row_rsNoticias['fecha']."</p><p class='margin_bottom'>".$row_rsNoticias['titulo']."</p></td>";
  if($contador % 2 == 0){
    echo "</tr>";
  }
} while ($row_rsNoticias = mysql_fetch_assoc($rsNoticias) and $contador < 8);
if ($contador % 2 != 0) {
  echo "<td>&nbsp;</td><td>&nbsp;</td>";
  echo "</tr>";
}
echo "<tr><th colspan='4'><a href='noticias/publica_noticias.php' class='estilo3'>Ver todas las noticias<a></td></tr>";
echo "</table>";
// FIN: Codigo que muestra la tabla con hasta ocho noticias
?>

<?php
mysql_free_result($rsNoticias);
?>

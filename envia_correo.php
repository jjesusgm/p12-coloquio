<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<?php
if (function_exists('mail')) { 
    echo "La función mail -SI- esta activada"; 
} else { 
    echo "La función mail -NO- esta activada"; 
} 
    ini_set( 'display_errors', 1 );
    error_reporting( E_ALL );
    $from = "test@prepa12.sems.udg.mx";
    $to = "jjesusgm@gmail.com";
    $subject = "Probando PHP mail";
    $message = "PHP mail funciona correctamente";
    $headers = "From:" . $from;
    mail($to,$subject,$message, $headers);
    echo "<br>El mensaje de correo electrónico fue enviado.";
?>
</body>
</html>
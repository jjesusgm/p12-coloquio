<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_conColoquio = "localhost";
$database_conColoquio = "coloquio_ie";
$username_conColoquio = "coloquio_ie";
$password_conColoquio = "p12coloquio";
$conColoquio = mysql_pconnect($hostname_conColoquio, $username_conColoquio, $password_conColoquio) or trigger_error(mysql_error(),E_USER_ERROR); 
?>
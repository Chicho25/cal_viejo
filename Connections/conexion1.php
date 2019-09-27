<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_conexion = "localhost";
//$hostname_conexion = "grupocalpe.com";
//$database_conexion = "grupocal_test";
$database_conexion = "grupocal_calpe";
$username_conexion = "grupocal_root";
$password_conexion = "compaq12";
$conexion1 = mysqli_connect($hostname_conexion, $username_conexion, $password_conexion) or trigger_error(mysqli_error(),E_USER_ERROR); 
 //mysqli_select_db($database_conexion, $conexion1);
?>
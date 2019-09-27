<?php require_once('../../Connections/conexion.php'); ?>
<?php function changueFormatDate($cdate){
    list($day,$month,$year)=explode("/",$cdate);
    return $year."-".$month."-".$day;
}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body style="color:#FFF">
<center><img src="../image/cargando.gif" width="48" height="48" /></center>
<?php 
$query = $_SERVER['QUERY_STRING'];
$vars = array();
foreach (explode('&', $query) as $pair) 
{
    list($key, $value) = explode('=', $pair);
    $vars[] = array(urldecode($key), urldecode($value));
}

print_r(count($vars));
$b=count($vars);
echo $b;
for($a=1;$a<=$b;$a++){
	echo '<br>';
	echo $vars[$a-1][0]."=".$vars[$a-1][1];
}

$fecha = changueFormatDate($_GET['fecha']); 
mysql_select_db($database_conexion, $conexion);
$query_inmueble = "INSERT INTO inmuebles_mov (ID_INMUEBLES_MASTER, ID_PRO_CLI_MASTER, FECHA, PRECIO_VENTA) VALUES ('".$_GET['INMUEBLE']."', '".$_GET['id_pro_cli']."', '".$fecha."', '".$_GET['monto']."' )";
echo "</br>Inmueble mov: </br>".$query_inmueble."</br>";
$inmueble = mysql_query($query_inmueble, $conexion) or die(mysql_error());
$id_inmueble=mysql_insert_id();

for($contador=8;$contador<=$b-2;$contador=$contador+2)
{
	if($vars[$contador+1][1]>0)
	{
		mysql_select_db($database_conexion, $conexion);
		$query_inmueble_detalle = "INSERT INTO inmuebles_mov_detalle (ID_INMUEBLES_MOV, ID_PRO_CLI_VENDEDOR, PORCENTAJE_COMISION) VALUES ('".$id_inmueble."', '".$vars[$contador][1]."', '".$vars[$contador+1][1]."' )";
		$inmueble_detalle = mysql_query($query_inmueble_detalle, $conexion) or die(mysql_error());
		$id_inmueble_mov_detalle=mysql_insert_id();
		
		
		mysql_select_db($database_conexion, $conexion);
		$query_proyectos = "SELECT ID_PARTIDA_COMISION, CODIGO FROM inmuebles_master WHERE ID_INMUEBLES_MASTER=".$_GET['INMUEBLE'];
		$proyectos = mysql_query($query_proyectos, $conexion) or die(mysql_error());
		$row_proyectos = mysql_fetch_assoc($proyectos);
		$totalRows_proyectos = mysql_num_rows($proyectos);
		
		if($_GET['documentos']==1){
		mysql_select_db($database_conexion, $conexion);
		$query_inmueble_documento = "INSERT INTO documentos (ID_PRO_CLI, TIPO, FECHA_EMISION, FECHA_VENCIMIENTO, DESCRIPCION, ID_PARTIDA, MONTO_EXENTO, COD_PROYECTO, ID_INMUEBLES_MOV_DETALLE) VALUES ('".$vars[$contador][1]."', '2', '".$fecha."', '".$fecha."', 'Comision por venta del ".$vars[$contador+1][1]."% por el inmueble ".$row_proyectos['CODIGO']." [auto]', '".$row_proyectos['ID_PARTIDA_COMISION']."', '".$_GET['monto']*($vars[$contador+1][1]/100)."', '".$_GET['combo1']."', '".$id_inmueble_mov_detalle."'  )";
		echo $query_inmueble_documento."</br>";
		$inmueble_documento = mysql_query($query_inmueble_documento, $conexion) or die(mysql_error());
		}
		
		echo $query_inmueble_detalle."</br>";
		
	}
echo "</br>";	
};




 ?>
 <script type="text/javascript">
<!--
alert("Proceso Completado con Exito.");
window.location = "add.php";
//-->
</script>
</body>
</html>

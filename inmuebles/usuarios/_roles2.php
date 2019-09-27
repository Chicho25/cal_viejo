 <?php 
include('../include/header.php');
$menu=34;
$usua=$_SESSION['i'];
$texto="";

$query = $_SERVER['QUERY_STRING'];
$acum=0;
$vars = array();
foreach (explode('&', $query) as $pair) 
{
    list($key, $value) = explode('=', $pair);
    $vars[] = array(urldecode($key), urldecode($value));
}


$b=count($vars);
$variable = array();
$id_acceso_old=0;

for($a=1;$a<=$b;$a++){
	echo '<br>';
	list($nombre, $id_acceso) = explode('-', $vars[$a-1][0]);
	
	if(($nombre!='ID_MENU')&&($nombre!='roles') &&($nombre!='ID_ROLE'&&($nombre!='guardar'))){

$variable[$_GET['roles-1']][$id_acceso][$nombre] = $vars[$a-1][1];
if($id_acceso_old==$id_acceso)
{
	
	//echo $id_acceso_old;
	${"cadena".$id_acceso_old}.=$vars[$a-1][1];
	//echo ${"cadena".$id_acceso_old};
}
else
{
	//echo $id_acceso;
	$id_acceso_old=$id_acceso;
	${"cadena".$id_acceso_old}=$vars[$a-1][1];
	
}

$id_acceso_old=$id_acceso;
//}


 $texto.=$vars[$a-1][1];
 $acum= $acum+1;
		if ($acum>5){
		$acum=0;
		$query_Recordset2 = "UPDATE usuarios_acceso SET DETALLE_ACCESO= '".$texto."' WHERE ID_ROLE=".$_GET['roles-1']." AND ID_MENU =".$id_acceso;
		//echo $query_Recordset2;
		mysql_select_db($database_conexion, $conexion);
		$Recordset2 = mysql_query($query_Recordset2, $conexion);
		//echo mysql_error();
		$texto="";
		}
 "rol".$_GET['roles-1'];
 "acceso".$id_acceso;
	}
}
echo  '<script language="javascript">alert("Se han realizado los cambios satisfactoriamente.");location.href="roles.php?titulo_formulario=Roles%20y%20Permisos";</script>'; ?>
<!-- echo  '<script language="javascript">alert("Se han realizado los cambios satisfactoriamente.");location.href="roles.php?titulo_formulario=Roles%20y%20Permisos";</script>';	
-->
<script type="text/javascript">

//window.location = "roles.php"
</script>
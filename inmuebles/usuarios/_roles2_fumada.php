 <?php /*include('../Connections/conexion.php'); ?>
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
}*/
include('../include/header.php');
$menu=34;
$usua=$_SESSION['i'];

//$variable='00000000000000000000';
/*for ($i = 1; $i <= 21; $i++) {
	$nombre_var="var_".$i;
	$arr[$i]=$arr($i=>$i+1);
	
    $variable=array($nombre_var=>0);
}*/

/*$variable = array();
for ($i = 0; $i < 20; $i++) {
	$nombre_var="var_".$i;
$variable[] = array($nombre_var => 0);
}*/
//$variable=array_fill(0,20,0);


echo $variable;
$query = $_SERVER['QUERY_STRING'];
echo $query;

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
	//echo $nombre.'='.$vars[$a-1][1];//.'  '.$id_acceso;
/*	if($nombre!='ID_ACCESO'){$valor_id_acceso=$id_acceso; echo $valor_id_acceso;
		}
		
*/


//for ($i = 0; $i < 20; $i++) {
	//$nombre_var="var_".$i;
$variable[$nombre][$_GET['roles-1']][$id_acceso] = $vars[$a-1][1];
if($id_acceso_old==$id_acceso)
{
	${"cadena".$id_acceso}.=$vars[$a-1][1];
}
else
{
	${"cadena".$id_acceso}=$vars[$a-1][1];
}

$id_acceso_old=$id_acceso;
//}


		
$texto.=$vars[$a-1][1];
$query_Recordset2 = "UPDATE usuarios_acceso SET ".$nombre. "=".$vars[$a-1][1]." WHERE ID_ROLE=".$_GET['roles-1']." AND ID_MENU =".$id_acceso;
		//echo $texto;
		//echo $query_Recordset2;
		mysql_select_db($database_conexion, $conexion);
		//$Recordset2 = mysql_query($query_Recordset2, $conexion) or die(mysql_error());
		
	//echo 'update usuario_acceso set '.$nombre. '='.$vars[$a-1][1].' where ID_ACCESO ='.$id_acceso.' and ID_ROLE='.$_GET['roles-1'];
	//echo '<br>';
	}

	//echo $rol='ID_ROLE';
	//echo $menu=$id_acceso;
	//echo $FORMULARIO_VIEW=$vars[$a-1][1];
	
}
echo "<PRE>";
print_r($variable);
echo "</PRE>";
$cadena=implode($variable);
  //aud($usua,'','Actualizando en acceso al rol cod. '.$_POST['roles-1'],$menu);
  echo "<br>";
echo $cadena7;

 ?>
 
<!--<script type="text/javascript">

window.location = "roles.php"
</script>-->
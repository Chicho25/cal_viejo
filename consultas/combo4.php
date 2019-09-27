<?php require_once('../../Connections/conexion.php'); ?>
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

$colname_Recordset1 = "-1";
if (isset($_POST['elegido'])) {
  $colname_Recordset1 = $_POST['elegido'];
}
mysql_select_db($database_conexion, $conexion);
$query_Recordset1 = sprintf("SELECT * FROM partidas_presupuesto WHERE CORRELATIVO_GRUPO = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $conexion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

?>

<?php do { ?><option value="<?php echo $row_Recordset1['CORRELATIVO_PRINCIPAL']; ?>">
<?php echo htmlentities($row_Recordset1['DESCRIPCION']); ?></option>
<?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>


<?php
mysql_free_result($Recordset1);
?>

<?php
$rpta="";
if ($_POST["elegido"]=="op4_1") {
	$rpta= '
	<option value="op4_1">Estructura</option>
	<option value="op4_2">Albañileria</option>
	<option value="op4_3">Acabados</option>
	<option value="op4_4">Plomeria</option>
	<option value="op4_5">Electricidad</option>
	<option value="op4_6">Aires acondicionados</option>
	<option value="op4_7">Gypson</option>
	';	
}
if ($_POST["elegido"]=="op4_8") {
	$rpta= '
	<option value="op5_8">Concreto</option>
	<option value="op5_9">Acero</option>
	<option value="op5_10">Bloques Encofrados</option>
	<option value="op5_11">Mano de obra</option>
	';	
}
if ($_POST["elegido"]=="op4_9") {
	$rpta= '
	<option value="op5_12">Bloques</option>
	<option value="op5_13">Pego</option>
	<option value="op5_3">Arena</option>
	<option value="op5_12">Cemento</option>
	<option value="op5_13">Pintura</option>
	<option value="op5_3">Ceramica</option>
	<option value="op5_11">Mano de obra</option>
	
	';	
}
if ($_POST["elegido"]=="op4_12") {
	$rpta= '
	<option value="op5_12">Puertas</option>
	<option value="op5_13">Cocinas</option>
	<option value="op5_3">Closet</option>
	<option value="op5_12">Puertas de Baño</option>
	<option value="op5_13">Sanitarios</option>
	<option value="op5_3">Ventanas</option>
	<option value="op5_11">Barandas</option>
	<option value="op5_11">Equipos</option>
	
	';	
}
if ($_POST["elegido"]=="op4_14") {
	$rpta= '
	<option value="op5_12">Bloques</option>
	<option value="op5_13">Pego</option>
	<option value="op5_3">Arena</option>
	<option value="op5_12">Cemento</option>
	<option value="op5_13">Pintura</option>
	<option value="op5_3">Ceramica</option>
	<option value="op5_11">Mano de obra</option>
	
	';	
}
if ($_POST["elegido"]=="op4_16") {
	$rpta= '
	<option value="op5_12">Puertas</option>
	<option value="op5_11">Barandas</option>
	<option value="op5_11">Equipos</option>
	
	';	
}
if ($_POST["elegido"]=="op4_18") {
	$rpta= '
	<option value="op5_8">Concreto</option>
	<option value="op5_9">Acero</option>
	<option value="op5_10">Bloques Encofrados</option>
	<option value="op5_11">Mano de obra</option>
	';	
}
if ($_POST["elegido"]=="op4_19") {
	$rpta= '
	<option value="op5_12">Bloques</option>
	<option value="op5_13">Pego</option>
	<option value="op5_3">Arena</option>
	<option value="op5_12">Cemento</option>
	<option value="op5_13">Pintura</option>
	<option value="op5_11">Mano de obra</option>
	
	';	
}
if ($_POST["elegido"]=="op4_22") {
	$rpta= '
	<option value="op5_12">Puertas</option>
	<option value="op5_13">Cocinas</option>
	<option value="op5_3">Closet</option>
	<option value="op5_12">Puertas de Baño</option>
	<option value="op5_13">Sanitarios</option>
	<option value="op5_3">Ventanas</option>
	<option value="op5_11">Barandas</option>
	<option value="op5_11">Equipos</option>
	
	';	
}
if ($_POST["elegido"]=="op4_28") {
	$rpta= '
	<option value="op5_8">Concreto</option>
	<option value="op5_9">Acero</option>
	<option value="op5_11">Mano de obra</option>
	';	
}
if ($_POST["elegido"]=="op4_29") {
	$rpta= '
	<option value="op5_12">Bloques</option>
	<option value="op5_13">Pego</option>
	<option value="op5_3">Arena</option>
	<option value="op5_12">Cemento</option>
	<option value="op5_13">Pintura</option>
	<option value="op5_11">Mano de obra</option>
	
	';	
}
if ($_POST["elegido"]=="op4_32") {
	$rpta= '
	<option value="op5_8">Barandas</option>
	<option value="op5_9">Equipos</option>
	';	
}
if ($_POST["elegido"]=="op4_39") {
	$rpta= '
	<option value="op5_8">Concreto</option>
	<option value="op5_9">Acero</option>
	<option value="op5_11">Bloque Losa</option>
	<option value="op5_11">Encofrado</option>
	';	
}
if ($_POST["elegido"]=="op4_40") {
	$rpta= '
	<option value="op5_12">Bloques</option>
	<option value="op5_13">Pego</option>
	<option value="op5_3">Arena</option>
	<option value="op5_12">Cemento</option>
	<option value="op5_13">Pintura</option>
	<option value="op5_13">Ceramica</option>
	<option value="op5_11">Instalacion Varias</option>
	
	';	
}
if ($_POST["elegido"]=="op4_41") {
	$rpta= '
	<option value="op5_12">Puertas</option>
	<option value="op5_13">Cocinas</option>
	<option value="op5_3">Closet</option>
	<option value="op5_12">Puertas de Baño</option>
	<option value="op5_13">Sanitarios y Accesorios</option>
	<option value="op5_3">Ventanas</option>
	<option value="op5_11">Barandas</option>
	<option value="op5_11">Equipos</option>
	
	';	
}

//echo $rpta;	
?>
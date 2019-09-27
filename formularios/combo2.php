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
<?php echo $row_Recordset1['DESCRIPCION']; ?></option>
<?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>


<?php
mysql_free_result($Recordset1);
?>







<?php
$rpta="";
if ($_POST["elegido"]=="5") {
	$rpta= '
	<option value="op3_1">Vialidad</option>
	<option value="op3_2">Electricidad Externa</option>
	<option value="op3_3">Garita de Control</option>
	<option value="op3_4">Servicio Publico en Entrada</option>
	<option value="op3_5">Paisajisrmo</option>
	<option value="op3_6">Planta de Tratamiento</option>
	<option value="op3_7">Sistema de Agua Portable</option>
	';	
}
if ($_POST["elegido"]=="37") {
	$rpta= '
	<option value="op3_8">Impresos</option>
	<option value="op3_9">Vallas</option>
	<option value="op3_10">Eventos</option>
	<option value="op3_11">Internet</option>
	';	
}
if ($_POST["elegido"]=="op2_4") {
	$rpta= '
	<option value="op3_12">Infraestructura</option>
	<option value="op3_13">Edificio</option>
	<option value="op3_14">Area Social</option>
	<option value="op3_15">Copias</option>
	<option value="op3_16">Est. de Campo</option>
	<option value="op3_17">Permisologia</option>
	';	
}
if ($_POST["elegido"]=="op2_5") {
	$rpta= '
	<option value="op3_18">Piscina</option>
	<option value="op3_19">Canchas</option>
	<option value="op3_20">Casa Club</option>
	<option value="op3_21">Parque Infantil</option>
	';	
}
if ($_POST["elegido"]=="op2_6") {
	$rpta= '
	<option value="op3_22">Terreno(alicuota)</option>
	<option value="op3_23">Infraestructura(alicuota)</option>
	<option value="op3_24">Area Social(alicuota)</option>
	<option value="op3_25">Directos</option>
	<option value="op3_26">Indirectos</option>
	';	
}

//echo $rpta;	
?>
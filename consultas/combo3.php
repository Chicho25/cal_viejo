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
if ($_POST["elegido"]=="op3_3") {
	$rpta= '
	<option value="op4_1">Garita</option>
	<option value="op4_2y">Control de Acceso</option>
	';	
}
if ($_POST["elegido"]=="op3_8") {
	$rpta= '
	<option value="op4_3">Folletos</option>
	<option value="op4_4">Publicaciones</option>
	';	
}
if ($_POST["elegido"]=="op3_17") {
	$rpta= '
	<option value="op4_5">Tasas</option>
	<option value="op4_6">Gastos de Representacion</option>
	';	
}
if ($_POST["elegido"]=="op3_18") {
	$rpta= '
	<option value="op4_7">Movimiento de Tierra</option>
	<option value="op4_8">Estructura</option>
	<option value="op4_9">Albañileria</option>
	<option value="op4_10">Plomeria</option>
	<option value="op4_11">Electricidad</option>
	<option value="op4_12">Acabados</option>
	
	';	
}
if ($_POST["elegido"]=="op3_19") {
	$rpta= '
	<option value="op4_13">Movimiento de Tierra</option>
	<option value="op4_14">Estructura</option>
	<option value="op4_15">Albañileria</option>
	<option value="op4_16">Acabados</option>
	';	
}
if ($_POST["elegido"]=="op3_20") {
	$rpta= '
	<option value="op4_17">Movimiento de Tierra</option>
	<option value="op4_18">Estructura</option>
	<option value="op4_19">Albañileria</option>
	<option value="op4_20">Plomeria</option>
	<option value="op4_21">Electricidad</option>
	<option value="op4_22">Acabados</option>
	<option value="op4_23">Aires acondicionados</option>
	<option value="op4_24">Gypson</option>
	<option value="op4_25">Sistemas Contraincendios</option>
	<option value="op4_26">Alquiler de Equipos</option>

	';	
}
if ($_POST["elegido"]=="op3_21") {
	$rpta= '
	<option value="op4_27">Movimiento de Tierra</option>
	<option value="op4_28">Estructura</option>
	<option value="op4_29">Albañileria</option>
	<option value="op4_30">Plomeria</option>
	<option value="op4_31">Electricidad</option>
	<option value="op4_32">Acabados</option>
	<option value="op4_33">Aires acondicionados</option>
	<option value="op4_34">Gypson</option>
	<option value="op4_35">Sistemas Contraincendios</option>
	<option value="op4_36">Alquiler de Equipos</option>

	';	
}
if ($_POST["elegido"]=="op3_25") {
	$rpta= '
	<option value="op4_37">Movimiento de Tierra</option>
	<option value="op4_38">Pilotes</option>
	<option value="op4_39">Estructura</option>
	<option value="op4_40">Albañileria</option>
	<option value="op4_41">Acabados</option>
	<option value="op4_42">Plomeria</option>
	<option value="op4_43">Electricidad</option>
	<option value="op4_44">Asensor</option>
	<option value="op4_45">Aires acondicionados</option>
	<option value="op4_46">Gypson</option>
	<option value="op4_47">Sistemas Contraincendios</option>
	<option value="op4_48">Alquiler de Equipos</option>
	<option value="op4_49">Extras</option>

	';	
}
if ($_POST["elegido"]=="op3_26") {
	$rpta= '
	<option value="op4_50">Administracion Calpe</option>
	<option value="op4_51">Gerencia, Inspeccion y control de obra(H.N.L.P)</option>
	<option value="op4_52">Proyecto y Permisologia</option>
	<option value="op4_53">Comision por venta</option>
	<option value="op4_54">Publicidad</option>
	<option value="op4_55">Impuestos</option>
	<option value="op4_56">Financiamiento</option>
	';	
}



//echo $rpta;	
?>
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

$colname_TIPO = "-1";
if (isset($_POST['TIPO_IO'])) {
  $colname_TIPO = $_POST['TIPO_IO'];
}
if($colname_TIPO=='T'){
	$colname_TIPO="I' OR TIPO_IO='O";
};
mysql_select_db($database_conexion, $conexion);
$query_TIPO = "SELECT * FROM tesoreria_tipo_mov WHERE MODULO=3 AND TIPO_IO ='".$colname_TIPO."'";
$TIPO = mysql_query($query_TIPO, $conexion) or die(mysql_error());
$row_TIPO = mysql_fetch_assoc($TIPO);
$totalRows_TIPO = mysql_num_rows($TIPO);

?>

<option value="">Seleccione...................</option>
<?php do { ?><option value="<?php echo $row_TIPO['ID_TESORERIA_TIPO_MOV']; ?>">
<?php echo $row_TIPO['NOMBRE'] ?></option>
<?php } while ($row_TIPO = mysql_fetch_assoc($TIPO)); ?>


<?php
mysql_free_result($TIPO);
?>

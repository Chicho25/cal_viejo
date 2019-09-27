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

$colname_inmuebles = "-1";
if (isset($_POST['ID_INMUEBLES_GRUPO'])) {
  $colname_inmuebles = $_POST['ID_INMUEBLES_GRUPO'];
}
mysql_select_db($database_conexion, $conexion);
$query_inmuebles = sprintf("SELECT ID_INMUEBLES_MASTER, NOMBRE FROM inmuebles_master WHERE ID_INMUEBLES_GRUPO = %s", GetSQLValueString($colname_inmuebles, "int"));
$inmuebles = mysql_query($query_inmuebles, $conexion) or die(mysql_error());
$row_inmuebles = mysql_fetch_assoc($inmuebles);
$totalRows_inmuebles = mysql_num_rows($inmuebles);

?>
<option value="">Seleccione...................</option>
<?php do { ?><option value="<?php echo $row_inmuebles['ID_INMUEBLES_MASTER']; ?>">
<?php echo $row_inmuebles['NOMBRE'] ?></option>
<?php } while ($row_inmuebles = mysql_fetch_assoc($inmuebles)); ?>

<?php
mysql_free_result($inmuebles);
?>

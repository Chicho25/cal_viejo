
<?php require_once('../Connections/conexion.php'); ?>
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

$colname_rst_niveles = "-1";
if (isset($_POST['ID_CUENTA'])) {
  $colname_rst_niveles = $_POST['ID_CUENTA'];
}
mysql_select_db($database_conexion, $conexion);
$query_rst_niveles = sprintf("SELECT * FROM contabilidad_cuentas WHERE ID_CUENTA = %s", GetSQLValueString($colname_rst_niveles, "int"));
//echo $query_rst_niveles;
$rst_niveles = mysql_query($query_rst_niveles, $conexion) or die(mysql_error());
$row_rst_niveles = mysql_fetch_assoc($rst_niveles);
$totalRows_rst_niveles = mysql_num_rows($rst_niveles);
?>
<form name="form1" method="post" action="">
  <label for="NIVEL"></label>
  <input name="NIVEL" type="text" id="NIVEL" value="<?php echo $row_rst_niveles['NIVEL']+1; ?>" size="3" readonly>
</form>



<?php include('../Connections/conexion.php'); ?>
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

$colname_cta = "-1";
if (isset($_POST['ID_CUENTA_BANCARIA'])) {
  $colname_cta = $_POST['ID_CUENTA_BANCARIA'];
}
mysql_select_db($database_conexion, $conexion);
$query_cta = sprintf("SELECT * FROM vista_banco_chequeras WHERE ID_CUENTA_BANCARIA = %s", GetSQLValueString($colname_cta, "int"));
$cta = mysql_query($query_cta, $conexion) or die(mysql_error());
$row_cta = mysql_fetch_assoc($cta);
$totalRows_cta = mysql_num_rows($cta);

?>

<input type="hidden" name="PROYECTO" id="PROYECTO" value="<?php echo $row_cta['CODIGO_PROYECTO']; ?>"/>

<?php
mysql_free_result($cta);
?>

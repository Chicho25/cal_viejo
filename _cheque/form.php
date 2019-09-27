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

$colname_rst_chequeras = "-1";
if (isset($_POST['ID_CHEQUERA'])) {
  $colname_rst_chequeras = $_POST['ID_CHEQUERA'];
}
mysql_select_db($database_conexion, $conexion);
$query_rst_chequeras = sprintf("SELECT * FROM vista_banco_chequeras WHERE ID_CHEQUERA = ".$_POST['ID_CHEQUERA']);
//echo $query_rst_chequeras;
$rst_chequeras = mysql_query($query_rst_chequeras, $conexion) or die(mysql_error());
$row_rst_chequeras = mysql_fetch_assoc($rst_chequeras);
$totalRows_rst_chequeras = mysql_num_rows($rst_chequeras);

?>

<input name="cheque" id="cheque" type="text"  readonly="readonly" value="<?php echo str_pad($row_rst_chequeras['ULTIMO_CHEQUE']+1, $row_rst_chequeras['LONGITUD_NUMERO'], "0", STR_PAD_LEFT) ?>" />
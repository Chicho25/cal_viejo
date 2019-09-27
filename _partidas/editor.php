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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE partidas SET DESCRIPCION=%s, COD_PROYECTO=%s, ID_GRUPO=%s, TIPO=%s, ALICUOTA=%s, ID_ALICUOTA=%s, PORCENTAJE_ALICUOTA=%s, COMISION_VENTA=%s, MONTO_ESTIMADO=%s, MONTO_ASIGNADO=%s, MONTO_PAGADO=%s, MONTO_DISPONIBLE=%s WHERE ID=%s",
                       GetSQLValueString($_POST['DESCRIPCION'], "text"),
                       GetSQLValueString($_POST['COD_PROYECTO'], "text"),
                       GetSQLValueString($_POST['ID_GRUPO'], "int"),
                       GetSQLValueString($_POST['TIPO'], "int"),
                       GetSQLValueString($_POST['ALICUOTA'], "int"),
                       GetSQLValueString($_POST['ID_ALICUOTA'], "int"),
                       GetSQLValueString($_POST['PORCENTAJE_ALICUOTA'], "double"),
                       GetSQLValueString($_POST['COMISION_VENTA'], "int"),
                       GetSQLValueString($_POST['MONTO_ESTIMADO'], "double"),
                       GetSQLValueString($_POST['MONTO_ASIGNADO'], "double"),
                       GetSQLValueString($_POST['MONTO_PAGADO'], "double"),
                       GetSQLValueString($_POST['MONTO_DISPONIBLE'], "double"),
                       GetSQLValueString($_POST['ID'], "int"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
}

$colname_rst_partidas = "-1";
if (isset($_GET['ID_PARTIDA'])) {
  $colname_rst_partidas = $_GET['ID_PARTIDA'];
}
mysql_select_db($database_conexion, $conexion);
$query_rst_partidas = sprintf("SELECT * FROM partidas WHERE ID = %s", GetSQLValueString($colname_rst_partidas, "int"));
$rst_partidas = mysql_query($query_rst_partidas, $conexion) or die(mysql_error());
$row_rst_partidas = mysql_fetch_assoc($rst_partidas);
$totalRows_rst_partidas = mysql_num_rows($rst_partidas);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">DESCRIPCION:</td>
      <td><input type="text" name="DESCRIPCION" value="<?php echo htmlentities($row_rst_partidas['DESCRIPCION'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">COD_PROYECTO:</td>
      <td><input type="text" name="COD_PROYECTO" value="<?php echo htmlentities($row_rst_partidas['COD_PROYECTO'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">ID_GRUPO:</td>
      <td><input type="text" name="ID_GRUPO" value="<?php echo htmlentities($row_rst_partidas['ID_GRUPO'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">TIPO:</td>
      <td><input type="text" name="TIPO" value="<?php echo htmlentities($row_rst_partidas['TIPO'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">ALICUOTA:</td>
      <td><input type="text" name="ALICUOTA" value="<?php echo htmlentities($row_rst_partidas['ALICUOTA'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">ID_ALICUOTA:</td>
      <td><input type="text" name="ID_ALICUOTA" value="<?php echo htmlentities($row_rst_partidas['ID_ALICUOTA'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">PORCENTAJE_ALICUOTA:</td>
      <td><input type="text" name="PORCENTAJE_ALICUOTA" value="<?php echo htmlentities($row_rst_partidas['PORCENTAJE_ALICUOTA'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">COMISION_VENTA:</td>
      <td><input type="text" name="COMISION_VENTA" value="<?php echo htmlentities($row_rst_partidas['COMISION_VENTA'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">MONTO_ESTIMADO:</td>
      <td><input type="text" name="MONTO_ESTIMADO" value="<?php echo htmlentities($row_rst_partidas['MONTO_ESTIMADO'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">MONTO_ASIGNADO:</td>
      <td><input type="text" name="MONTO_ASIGNADO" value="<?php echo htmlentities($row_rst_partidas['MONTO_ASIGNADO'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">MONTO_PAGADO:</td>
      <td><input type="text" name="MONTO_PAGADO" value="<?php echo htmlentities($row_rst_partidas['MONTO_PAGADO'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">MONTO_DISPONIBLE:</td>
      <td><input type="text" name="MONTO_DISPONIBLE" value="<?php echo htmlentities($row_rst_partidas['MONTO_DISPONIBLE'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Update record" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="ID" value="<?php echo $row_rst_partidas['ID']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rst_partidas);
?>

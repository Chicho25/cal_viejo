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

$colname_rst_proveedores = "-1";
if (isset($_POST['COD_PROYECTO'])) {
  $colname_rst_proveedores = $_POST['COD_PROYECTO'];
  echo $_POST['COD_PROYECTO'];
}
mysql_select_db($database_conexion, $conexion);
$query_rst_proveedores = sprintf("SELECT DISTINCT ID_PRO_CLI, NOMBRE_PRO_CLI FROM vista_documentos WHERE MONTO_PENDIENTE>0 AND COD_PROYECTO = %s", GetSQLValueString($colname_rst_proveedores, "text"));
$rst_proveedores = mysql_query($query_rst_proveedores, $conexion) or die(mysql_error());
$row_rst_proveedores = mysql_fetch_assoc($rst_proveedores);
$totalRows_rst_proveedores = mysql_num_rows($rst_proveedores);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<title>Untitled Document</title>
</head>

<body>

</body>
<?php
if ($totalRows_rst_proveedores>0){?>
<option value=" ">Seleccione el Proveedor</option>
<?php do { ?><option value="<?php echo $row_rst_proveedores['ID_PRO_CLI']; ?>">
<?php echo $row_rst_proveedores['NOMBRE_PRO_CLI'] ?></option>
<?php } while ($row_rst_proveedores = mysql_fetch_assoc($rst_proveedores)); ?>
<?php } else{?>
<option value=" ">No hay proveedores con saldo pendiente para este proyecto</option>
<?php do { ?><option value="<?php echo $row_rst_proveedores['ID_PRO_CLI']; ?>">
<?php echo $row_rst_proveedores['NOMBRE_PRO_CLI'] ?></option>
<?php } while ($row_rst_proveedores = mysql_fetch_assoc($rst_proveedores)); ?>	
<?php }?>
<?php
mysql_free_result($rst_proveedores);
?>
</html>
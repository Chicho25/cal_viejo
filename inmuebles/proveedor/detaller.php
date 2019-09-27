<?php require_once('../../Connections/conexion.php'); ?><?php
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

$maxRows_DetailRS1 = 10;
$pageNum_DetailRS1 = 0;
if (isset($_GET['pageNum_DetailRS1'])) {
  $pageNum_DetailRS1 = $_GET['pageNum_DetailRS1'];
}
$startRow_DetailRS1 = $pageNum_DetailRS1 * $maxRows_DetailRS1;

$colname_DetailRS1 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS1 = $_GET['recordID'];
}
mysql_select_db($database_conexion, $conexion);
$query_DetailRS1 = sprintf("SELECT * FROM proveedores_clientes WHERE idprovecliente = %s", GetSQLValueString($colname_DetailRS1, "int"));
$query_limit_DetailRS1 = sprintf("%s LIMIT %d, %d", $query_DetailRS1, $startRow_DetailRS1, $maxRows_DetailRS1);
$DetailRS1 = mysql_query($query_limit_DetailRS1, $conexion) or die(mysql_error());
$row_DetailRS1 = mysql_fetch_assoc($DetailRS1);

if (isset($_GET['totalRows_DetailRS1'])) {
  $totalRows_DetailRS1 = $_GET['totalRows_DetailRS1'];
} else {
  $all_DetailRS1 = mysql_query($query_DetailRS1);
  $totalRows_DetailRS1 = mysql_num_rows($all_DetailRS1);
}
$totalPages_DetailRS1 = ceil($totalRows_DetailRS1/$maxRows_DetailRS1)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/redmond/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
<link href="../css.css" rel="stylesheet" type="text/css" />
<link href="../a/menu_style.css" rel="stylesheet" type="text/css" />
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body><?php $opcion_menu=7; ?>
<?php include("../include/menu.php"); ?>

<table width="600" border="1" align="center">
  <tr>
    <td width="150" class="textos_form">codigo</td>
    <td class="textos_form"><?php echo $row_DetailRS1['codigo']; ?></td>
  </tr>
  <tr>
    <td width="150" class="textos_form">razon_social</td>
    <td class="textos_form"><?php echo $row_DetailRS1['razon_social']; ?></td>
  </tr>
  <tr>
    <td width="150" class="textos_form">alias</td>
    <td class="textos_form"><?php echo $row_DetailRS1['alias']; ?></td>
  </tr>
  <tr>
    <td width="150" class="textos_form">RUC</td>
    <td class="textos_form"><?php echo $row_DetailRS1['RUC']; ?></td>
  </tr>
  <tr>
    <td width="150" class="textos_form">NIT</td>
    <td class="textos_form"><?php echo $row_DetailRS1['NIT']; ?></td>
  </tr>
  <tr>
    <td width="150" class="textos_form">dv</td>
    <td class="textos_form"><?php echo $row_DetailRS1['dv']; ?></td>
  </tr>
  <tr>
    <td width="150" class="textos_form">telefono1</td>
    <td class="textos_form"><?php echo $row_DetailRS1['telefono1']; ?></td>
  </tr>
  <tr>
    <td width="150" class="textos_form">telefono_oficina2</td>
    <td class="textos_form"><?php echo $row_DetailRS1['telefono_oficina2']; ?></td>
  </tr>
  <tr>
    <td width="150" class="textos_form">fax1</td>
    <td class="textos_form"><?php echo $row_DetailRS1['fax1']; ?></td>
  </tr>
  <tr>
    <td width="150" class="textos_form">email1</td>
    <td class="textos_form"><?php echo $row_DetailRS1['email1']; ?></td>
  </tr>
  <tr>
    <td width="150" class="textos_form">email2</td>
    <td class="textos_form"><?php echo $row_DetailRS1['email2']; ?></td>
  </tr>
  <tr>
    <td width="150" class="textos_form">pagina_web</td>
    <td class="textos_form"><?php echo $row_DetailRS1['pagina_web']; ?></td>
  </tr>
  <tr>
    <td width="150" class="textos_form">direccion</td>
    <td class="textos_form"><?php echo $row_DetailRS1['direccion']; ?></td>
  </tr>
  <tr>
    <td width="150" class="textos_form">direccion2</td>
    <td class="textos_form"><?php echo $row_DetailRS1['direccion2']; ?></td>
  </tr>
  <tr>
    <td width="150" class="textos_form">persona_contacto</td>
    <td class="textos_form"><?php echo $row_DetailRS1['persona_contacto']; ?></td>
  </tr>
  <tr>
    <td width="150" class="textos_form">telefono_contacto</td>
    <td class="textos_form"><?php echo $row_DetailRS1['telefono_contacto']; ?></td>
  </tr>
  <tr>
    <td width="150" class="textos_form">tipo</td>
    <td class="textos_form"><?php echo $row_DetailRS1['tipo']; ?></td>
  </tr>
</table>
</body>
</html><?php
mysql_free_result($DetailRS1);
?>
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

$currentPage = $_SERVER["PHP_SELF"];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE pro_cli_master SET TIPO=%s, NOMBRE=%s, CONTACTO=%s, ID_PRO_CLI_GRUPO=%s, ID_TRIBUTARIA_CEDULA=%s, VENDEDOR=%s, DIRECCION=%s, TELEFONO_FIJO_1=%s, TELEFONO_FIJO_2=%s, TELEFONO_MOVIL_1=%s, TELEFONO_MOVIL_2=%s, EMAIL_1=%s, EMAIL_2=%s, WEB_SITE=%s, OBSERVACIONES=%s WHERE ID_PRO_CLI_MASTER=%s",
                       GetSQLValueString($_POST['TIPO'], "int"),
                       GetSQLValueString($_POST['NOMBRE'], "text"),
                       GetSQLValueString($_POST['CONTACTO'], "text"),
                       GetSQLValueString($_POST['GRUPO'], "text"),
                       GetSQLValueString($_POST['ID_TRIBUTARIA_CEDULA'], "text"),
                       GetSQLValueString(isset($_POST['VENDEDOR']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['DIRECCION'], "text"),
                       GetSQLValueString($_POST['TELEFONO_FIJO_1'], "text"),
                       GetSQLValueString($_POST['TELEFONO_FIJO_2'], "text"),
                       GetSQLValueString($_POST['TELEFONO_MOVIL_1'], "text"),
                       GetSQLValueString($_POST['TELEFONO_MOVIL_2'], "text"),
                       GetSQLValueString($_POST['EMAIL_1'], "text"),
                       GetSQLValueString($_POST['EMAIL_2'], "text"),
                       GetSQLValueString($_POST['WEB_SITE'], "text"),
                       GetSQLValueString($_POST['OBSERVACIONES'], "text"),
                       GetSQLValueString($_POST['id_pro_cli'], "int"));

  mysql_select_db($database_conexion, $conexion);
  //echo $updateSQL;
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());

  $updateGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  //header(sprintf("Location: %s", $updateGoTo));
}

$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_conexion, $conexion);
$query_Recordset1 = "SELECT * FROM pro_cli_master where tipo=1 or tipo=3 order by nombre";
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $conexion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;

$colname_editar_proveedor = "-1";
if (isset($_GET['ID_PRO_CLI'])) {
  $colname_editar_proveedor = $_GET['ID_PRO_CLI'];
}
mysql_select_db($database_conexion, $conexion);
$query_editar_proveedor = sprintf("SELECT * FROM pro_cli_master WHERE ID_PRO_CLI_MASTER = %s", GetSQLValueString($colname_editar_proveedor, "int"));
$editar_proveedor = mysql_query($query_editar_proveedor, $conexion) or die(mysql_error());
$row_editar_proveedor = mysql_fetch_assoc($editar_proveedor);
$totalRows_editar_proveedor = mysql_num_rows($editar_proveedor);

$queryString_Recordset1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recordset1") == false && 
        stristr($param, "totalRows_Recordset1") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recordset1 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recordset1 = sprintf("&totalRows_Recordset1=%d%s", $totalRows_Recordset1, $queryString_Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<title>Untitled Document</title>
<script src="../js/jquery-1.4.2.min.js" language="javascript"></script>
<script src="../js/jquery-ui-1.8.5.custom.min.js" language="javascript"></script>
<script src="../js/jquery.ui.datepicker-es.js" language="javascript"></script>
<script src="../js/jquery.infieldlabel.min.js" language="javascript"></script>
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<title>Untitled Document</title>
<link href="../js/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
<link href="../css/form.css" rel="stylesheet" type="text/css" />
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../css/menu_style.css" type="text/css" media="all" />
<link href="../css/redmond/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
<style type="text/css">

#form1 #listado {
	text-decoration: none;
}
</style>
</head>

<body><?php $opcion_menu=7; ?>
<?php include("../include/menu.php"); ?>


<table width="1100" align="center" class="ui-widget-header" >
	<tr>
	<td width="1100" align="center" class="textos_form"><div class="titulo_formulario">Editar Cliente</div></tr></table>
	<table width="1100" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#999999">
	<tr class="textos_form">
		<td width="50" align="center" bgcolor="#FFFFFF">
		<table width="100%" border="0" cellspacing="0" cellpadding="4">
			<tr>
				<td align="right" bgcolor="#E5E5E5"><input type="button" name="button3" id="button3" value="Insertar" onClick="parent.location='add.php'"/></td>
				<td bgcolor="#E5E5E5"><input type="button" name="button" id="button" value="Buscar" onClick="parent.location='index.php'"/></td>
			</tr>
		</table>
		</td>
	</tr>
</table>

<form action="<?php echo $editFormAction; ?>" method="POST" name="form2" id="form2">
	<table width="1100" align="center" class="textos_form" bgcolor="#F5F5F5">
		<tr valign="baseline">
			<td width="200" align="right" nowrap="nowrap">Tipo:</td>
			<td align="left"><select name="TIPO">
			  <option value="2" <?php if (!(strcmp(2, $row_editar_proveedor['TIPO']))) {echo "selected=\"selected\"";} ?>>Cliente</option>
			  <option value="3" <?php if (!(strcmp(3, $row_editar_proveedor['TIPO']))) {echo "selected=\"selected\"";} ?>>Cliente-Proveedor</option>
</select>
		  <input name="id_pro_cli" type="hidden" id="id_pro_cli" value="<?php echo $row_editar_proveedor['ID_PRO_CLI_MASTER']; ?>" /></td>
		  <td width="200" align="right">Grupo:</td>
			<td width="350" align="left"><input name="GRUPO" type="text" value="<?php echo $row_editar_proveedor['ID_PRO_CLI_GRUPO']; ?>" size="50" readonly="readonly" /></td>
		</tr>
		<tr valign="baseline">
			<td width="200" align="right" nowrap="nowrap">Nombre:</td>
			<td width="350" align="left"><input type="text" name="NOMBRE" value="<?php echo $row_editar_proveedor['NOMBRE']; ?>" size="50" /></td>
			<td width="200" align="right">RUC / CI / Pasaporte:</td>
			<td width="350" align="left"><input type="text" name="ID_TRIBUTARIA_CEDULA" value="<?php echo $row_editar_proveedor['ID_TRIBUTARIA_CEDULA']; ?>" size="50" /></td>
		</tr>
		<tr valign="baseline">
			<td width="200" align="right" nowrap="nowrap">Contacto:</td>
			<td colspan="3" align="left"><input type="text" name="CONTACTO" value="<?php echo $row_editar_proveedor['CONTACTO']; ?>" size="50" /></td>
		</tr>
		<tr valign="baseline">
			<td width="200" align="right" valign="top" nowrap="nowrap">Direccion:</td>
			<td colspan="3" align="left"><textarea name="DIRECCION" cols="102" rows="3"><?php echo $row_editar_proveedor['DIRECCION']; ?></textarea></td>
		</tr>
		<tr valign="baseline">
			<td width="200" align="right" nowrap="nowrap">Telefono Fijo 1:</td>
			<td align="left"><input type="text" name="TELEFONO_FIJO_1" value="<?php echo $row_editar_proveedor['TELEFONO_FIJO_1']; ?>" size="50" /></td>
			<td align="right">Telefono Fijo 2:</td>
			<td align="left"><input type="text" name="TELEFONO_FIJO_2" value="<?php echo $row_editar_proveedor['TELEFONO_FIJO_2']; ?>" size="50" /></td>
		</tr>
		<tr valign="baseline">
			<td width="200" align="right" nowrap="nowrap">Telefono Movil 1:</td>
			<td align="left"><input type="text" name="TELEFONO_MOVIL_1" value="<?php echo $row_editar_proveedor['TELEFONO_MOVIL_1']; ?>" size="50" /></td>
			<td align="right">Telefono Movil 2:</td>
			<td align="left"><input type="text" name="TELEFONO_MOVIL_2" value="<?php echo $row_editar_proveedor['TELEFONO_MOVIL_2']; ?>" size="50" /></td>
		</tr>
		<tr valign="baseline">
			<td width="200" align="right" nowrap="nowrap">Email 1:</td>
			<td align="left"><input type="text" name="EMAIL_1" value="<?php echo $row_editar_proveedor['EMAIL_1']; ?>" size="50" /></td>
			<td align="right">Email 2:</td>
			<td align="left"><input type="text" name="EMAIL_2" value="<?php echo $row_editar_proveedor['EMAIL_2']; ?>" size="32" /></td>
		</tr>
		<tr valign="baseline">
			<td width="200" align="right" nowrap="nowrap">Website:</td>
			<td colspan="3" align="left"><input type="text" name="WEB_SITE" value="<?php echo $row_editar_proveedor['WEB_SITE']; ?>" size="100" /></td>
		</tr>
		<tr valign="baseline">
			<td width="200" align="right" valign="top" nowrap="nowrap">Observaciones:</td>
			<td colspan="3" align="left"><textarea name="OBSERVACIONES" cols="102" rows="3"><?php echo $row_editar_proveedor['OBSERVACIONES']; ?></textarea></td>
		</tr>
		<tr valign="baseline">
			<td colspan="4" align="center" nowrap="nowrap"><input type="submit" value="Modificar" /></td>
		</tr>
	</table>
	<input type="hidden" name="MM_update" value="form2" />
</form>

</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($editar_proveedor);
?>

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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO pro_cli_master (TIPO, NOMBRE, CONTACTO, ID_PRO_CLI_GRUPO, ID_TRIBUTARIA_CEDULA, VENDEDOR, DIRECCION, TELEFONO_FIJO_1, TELEFONO_FIJO_2, TELEFONO_MOVIL_1, TELEFONO_MOVIL_2, EMAIL_1, EMAIL_2, WEB_SITE, OBSERVACIONES, BENEFICIARIOS) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
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
					   GetSQLValueString($_POST['BENEFICIARIO'], "text"));
			

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
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
<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
<title>Untitled Document</title>
<link href="../css/redmond/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
<link href="../css.css" rel="stylesheet" type="text/css" />
<link href="../a/menu_style.css" rel="stylesheet" type="text/css" />
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../css/form.css" rel="stylesheet" type="text/css" />
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
	<td width="1100" align="center" class="textos_form"><div class="titulo_formulario">A&ntilde;adir Proveedor</div></tr></table>
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
<form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
	<table width="1100" align="center" class="textos_form" bgcolor="#F5F5F5">
		<tr valign="baseline">
			<td width="200" align="right" nowrap="nowrap">Tipo:</td>
			<td width="174" align="left"><select name="TIPO">
				
				<option value="1" >Proveedor</option>
				<option value="3" >Cliente-Proveedor</option>
</select></td>
			<td width="174" align="left">Vendedor:
			  <input type="checkbox" name="VENDEDOR" id="VENDEDOR" />
		    <label for="VENDEDOR"></label></td>
			<td width="200" align="right">Grupo:</td>
			<td width="350" align="left"><input name="GRUPO" type="text"  readonly="readonly" value="1" size="50" /></td>
		</tr>
		<tr valign="baseline">
			<td width="200" align="right" nowrap="nowrap">Nombre:</td>
			<td width="300" colspan="2" align="left"><input type="text" name="NOMBRE" value="" size="50" /></td>
			<td width="200" align="right">RUC / CI / Pasaporte:</td>
			<td width="300" align="left"><input type="text" name="ID_TRIBUTARIA_CEDULA" value="" size="50" /></td>
		</tr>
		<tr valign="baseline">
			<td width="200" align="right" nowrap="nowrap">Contacto:</td>
			<td colspan="4" align="left"><input type="text" name="CONTACTO" value="" size="50" /></td>
		</tr>
		<tr valign="baseline">
		  <td width="200" align="right" nowrap="nowrap">Beneficiarios:</td>
		  <td colspan="4" align="left"><p>
		    <label for="BENEFICIARIO"></label>
		    <input name="BENEFICIARIO" type="text" id="BENEFICIARIO" size="133" />
		  </p>
	      <p>Nota:<span class="textos_formrojo"> Los beneficiarios deben estar separados por ; ejemplo: Pedro Perez; Juan Perez; Maria Gonzalez. Hasta un maximo de 5 Beneficiarios</span></p></td>
	  </tr>
		<tr valign="baseline">
			<td width="200" align="right" valign="top" nowrap="nowrap">Direccion:</td>
			<td colspan="4" align="left"><textarea name="DIRECCION" cols="102" rows="3"></textarea></td>
		</tr>
		<tr valign="baseline">
			<td width="200" align="right" nowrap="nowrap">Telefono Fijo 1:</td>
			<td width="300" colspan="2" align="left"><input type="text" name="TELEFONO_FIJO_1" value="" size="50" /></td>
			<td align="right">Telefono Fijo 2:</td>
			<td width="300" align="left"><input type="text" name="TELEFONO_FIJO_2" value="" size="50" /></td>
		</tr>
		<tr valign="baseline">
			<td width="200" align="right" nowrap="nowrap">Telefono Movil 1:</td>
			<td width="300" colspan="2" align="left"><input type="text" name="TELEFONO_MOVIL_1" value="" size="50" /></td>
			<td align="right">Telefono Movil 2:</td>
			<td width="300" align="left"><input type="text" name="TELEFONO_MOVIL_2" value="" size="50" /></td>
		</tr>
		<tr valign="baseline">
			<td width="200" align="right" nowrap="nowrap">Email 1:</td>
			<td width="300" colspan="2" align="left"><input type="text" name="EMAIL_1" value="" size="50" /></td>
			<td align="right">Email 2:</td>
			<td width="300" align="left"><input type="text" name="EMAIL_2" value="" size="50" /></td>
		</tr>
		<tr valign="baseline">
			<td width="200" align="right" nowrap="nowrap">Website:</td>
			<td colspan="4" align="left"><input type="text" name="WEB_SITE" value="" size="80" /></td>
		</tr>
		<tr valign="baseline">
			<td width="200" align="right" valign="top" nowrap="nowrap">Observaciones:</td>
			<td colspan="4" align="left"><textarea name="OBSERVACIONES" cols="102" rows="3"></textarea></td>
		</tr>
		<tr valign="baseline">
			<td colspan="5" align="right" class="campos"><input type="submit" value="Guardar" /></td>
		</tr>
	</table>
	<input type="hidden" name="MM_insert" value="form2" />
</form>

</body>
</html>
<?php
mysql_free_result($Recordset1);
?>

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
  $updateSQL = sprintf("UPDATE pro_cli SET TIPO=%s, NOMBRE=%s, CONTACTO=%s, GRUPO=%s, ID_TRIBUTARIA_CEDULA=%s, DIRECCION=%s, TELEFONO_FIJO_1=%s, TELEFONO_FIJO_2=%s, TELEFONO_MOVIL_1=%s, TELEFONO_MOVIL_2=%s, EMAIL_1=%s, EMAIL_2=%s, WEB_SITE=%s, OBSERVACIONES=%s WHERE ID_PRO_CLI=%s",
                       GetSQLValueString($_POST['TIPO'], "int"),
                       GetSQLValueString($_POST['NOMBRE'], "text"),
                       GetSQLValueString($_POST['CONTACTO'], "text"),
                       GetSQLValueString($_POST['GRUPO'], "text"),
                       GetSQLValueString($_POST['ID_TRIBUTARIA_CEDULA'], "text"),
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
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());

  $updateGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_conexion, $conexion);
$query_Recordset1 = "SELECT * FROM pro_cli where tipo=1 or tipo=3 order by nombre";
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $conexion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_conexion, $conexion);
$query_Recordset1 = "SELECT * FROM pro_cli WHERE tipo=2 or tipo=3 ORDER BY nombre";
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
$query_editar_proveedor = sprintf("SELECT * FROM pro_cli WHERE ID_PRO_CLI = %s", GetSQLValueString($colname_editar_proveedor, "int"));
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
<link href="../css/redmond/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
<link href="../css.css" rel="stylesheet" type="text/css" />
<link href="../a/menu_style.css" rel="stylesheet" type="text/css" />
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../css/form.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body {
	background-color: #ffffff;
}
#form1 #listado {
	text-decoration: none;
}
</style>
</head>

<body><?php $opcion_menu=7; ?>
<?php include("../include/menu.php"); ?><table width="1100" align="center" class="ui-widget-header" >
	<tr>
	<td width="1100" align="center" class="textos_form"><div class="titulo_formulario">Editar Cliente</div></tr></table>
<form method="post" name="form1" id="form1">
    <table width="1100" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#CCCCCC" id="listado">
    <tr class="campos">
      <td width="100" bgcolor="#CCCCCC">Tipo</td>
      <td bgcolor="#CCCCCC">Nombre</td>
      <td width="200" bgcolor="#CCCCCC">Contacto</td>
      <td width="150" bgcolor="#CCCCCC">Telefono Fijo</td>
      <td width="150" bgcolor="#CCCCCC">Telefono Movil</td>
      <td width="100" bgcolor="#CCCCCC">&nbsp;</td>
      </tr><?php $fondo=0;?>
    <?php do { ?>
    <?php 
    $fondo=$fondo+1;
    if($fondo%2==1){$color="#FFFFFF";}else{$color="#F2F2F2";}
    
    ?>
      <tr bgcolor="<?php echo $color ?>">
        <td width="100" align="center" bgcolor="<?php echo $color ?>" class="lista">
	  <?php if($row_Recordset1['TIPO']==1)
	  { echo "Proveedor";}
	  else
	  { echo "Prov/Cliente";}; ?></td>
        <td bgcolor="<?php echo $color ?>" class="lista"><?php echo $row_Recordset1['NOMBRE']; ?></td>
        <td width="200" bgcolor="<?php echo $color ?>" class="lista"><?php echo $row_Recordset1['CONTACTO']; ?></td>
        <td width="150" bgcolor="<?php echo $color ?>" class="lista"><?php echo $row_Recordset1['TELEFONO_FIJO_1']; ?></td>
        <td width="150" bgcolor="<?php echo $color ?>" class="lista"><?php echo $row_Recordset1['TELEFONO_MOVIL_1']; ?></td>
        <td width="100" align="center" bgcolor="#F2F2F2" class="textos_form"><a href="editar.php?ID_PRO_CLI=<?php echo $row_Recordset1['ID_PRO_CLI']; ?>">Editar</a></td>
        </tr>
      <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
	<tr bgcolor="#F2F2F2"><td colspan="6" align="center"><table border="0" align="center" class="textos_form">
    <tr>
      <td><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>">Primero</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>">Previo</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>">Siguiente</a>
          <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>">Ultimo</a>
          <?php } // Show if not last page ?></td>
    </tr>
  </table>
		<span class="lista">Registros <?php echo ($startRow_Recordset1 + 1) ?> al <?php echo min($startRow_Recordset1 + $maxRows_Recordset1, $totalRows_Recordset1) ?> de <?php echo $totalRows_Recordset1 ?></span></td></tr>
  </table>
    </span>
<table width="1100" align="center" class="ui-widget-header" >
	<tr>
	<td width="1100" align="center" class="textos_form"><div class="titulo_formulario">Editar Cliente</div></tr></table>
</form>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form2" id="form2">
	<table width="1100" align="center" class="campos">
		<tr valign="baseline">
			<td width="200" align="right" nowrap="nowrap">Tipo:</td>
			<td width="350" align="left"><select name="TIPO">
				<option value="1" <?php if (!(strcmp(1, $row_editar_proveedor['TIPO']))) {echo "selected=\"selected\"";} ?>>Proveedor</option>
				<option value="3" <?php if (!(strcmp(3, $row_editar_proveedor['TIPO']))) {echo "selected=\"selected\"";} ?>>Cliente-Proveedor</option>
</select>
			<input name="id_pro_cli" type="hidden" id="id_pro_cli" value="<?php echo $row_editar_proveedor['ID_PRO_CLI']; ?>" /></td>
			<td width="200" align="right">Grupo:</td>
			<td width="350" align="left"><input type="text" name="GRUPO" value="<?php echo $row_editar_proveedor['GRUPO']; ?>" size="50" /></td>
		</tr>
		<tr valign="baseline">
			<td width="200" align="right" nowrap="nowrap">Nombre:</td>
			<td width="350" align="left"><input type="text" name="NOMBRE" value="<?php echo $row_editar_proveedor['NOMBRE']; ?>" size="50" /></td>
			<td width="200" align="right">RUC/CI/Pasaporte:</td>
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
			<td align="left">Telefono Fijo 2:</td>
			<td align="left"><input type="text" name="TELEFONO_FIJO_2" value="<?php echo $row_editar_proveedor['TELEFONO_FIJO_2']; ?>" size="50" /></td>
		</tr>
		<tr valign="baseline">
			<td width="200" align="right" nowrap="nowrap">&nbsp;</td>
			<td colspan="3" align="left">&nbsp;</td>
		</tr>
		<tr valign="baseline">
			<td width="200" align="right" nowrap="nowrap">Telefono Movil 1:</td>
			<td align="left"><input type="text" name="TELEFONO_MOVIL_1" value="<?php echo $row_editar_proveedor['TELEFONO_MOVIL_1']; ?>" size="50" /></td>
			<td align="left">Telefono Movil 2:</td>
			<td align="left"><input type="text" name="TELEFONO_MOVIL_2" value="<?php echo $row_editar_proveedor['TELEFONO_MOVIL_2']; ?>" size="50" /></td>
		</tr>
		<tr valign="baseline">
			<td width="200" align="right" nowrap="nowrap">&nbsp;</td>
			<td colspan="3" align="left">&nbsp;</td>
		</tr>
		<tr valign="baseline">
			<td width="200" align="right" nowrap="nowrap">Email 1:</td>
			<td align="left"><input type="text" name="EMAIL_1" value="<?php echo $row_editar_proveedor['EMAIL_1']; ?>" size="50" /></td>
			<td align="left">Email 2:</td>
			<td align="left"><input type="text" name="EMAIL_2" value="<?php echo $row_editar_proveedor['EMAIL_2']; ?>" size="32" /></td>
		</tr>
		<tr valign="baseline">
			<td width="200" align="right" nowrap="nowrap">&nbsp;</td>
			<td colspan="3" align="left">&nbsp;</td>
		</tr>
		<tr valign="baseline">
			<td width="200" align="right" nowrap="nowrap">Website:</td>
			<td colspan="3" align="left"><input type="text" name="WEB_SITE" value="<?php echo $row_editar_proveedor['WEB_SITE']; ?>" size="100" /></td>
		</tr>
		<tr valign="baseline">
			<td width="200" align="right" nowrap="nowrap">Observaciones:</td>
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

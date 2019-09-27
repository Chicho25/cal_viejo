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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO banco_master (CODIGO, NOMBRE, NACIONAL) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['CODIGO'], "text"),
                       GetSQLValueString($_POST['NOMBRE'], "text"),
                       GetSQLValueString(isset($_POST['NACIONAL']) ? "true" : "", "defined","1","0"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
}

/*Definiciones*/
$formulario="Partidas00-Editar";
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
<title>Untitled Document</title>
<?php include("../include/_js.php"); ?>
<?php include("../include/_css.php"); ?>

<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body style="font-family:Verdana, Geneva, sans-serif; font-size:12px">
<?php $opcion_menu=2; ?>
<?php include("../include/menu.php"); ?>

      <table width="1100" align="center" class="ui-widget-header" >
    <tr>
          <td width="100%" align="center" ><div class="titulo_formulario">Añadir Banco</div>
    </tr>
  </table>
<?php include("_menu.php"); ?>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
      <table width="1100" align="center" >
    <tr>
      <td width="398" align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >

Codigo: 
      <td align="left" bgcolor="#F3F3F3" ><span id="sprytextfield1">
      <label for="textfield">
      	<input type="text" name="CODIGO" value="" size="32" />
      	</label>
      <span class="textfieldRequiredMsg">Requerido.</span></span></tr>
    <tr>
      <td width="398" align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >Nombre:      
      <td align="left" bgcolor="#F3F3F3" ><span id="sprytextfield2">
      <label for="MONTO_ESTIMADO2">
      	<input type="text" name="NOMBRE" value="" size="32" />
      	</label>
      <span class="textfieldRequiredMsg">Requerido.</span></span></tr>
    <tr>
      <td width="398" align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >Nacional:      
      <td align="left" bgcolor="#F3F3F3" ><label for="textfield3">
      	<input type="checkbox" name="NACIONAL" value="" checked="checked" />
      </label>      </tr>
    <tr>
    	<td colspan="2" align="left" >
    		<div class="validity-summary-container" style="color:#F00">
    			
    			<ul></ul>
</div></tr>

          <td colspan="2" align="center" bgcolor="#999999"  ><input name="button" type="submit" class="ui-widget-header" id="button" value="Guardar" /></tr>
</table>
    <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
<?php include("../include/_foot.php"); ?>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
</script>
</body>
</html>
<?php
mysql_free_result($CONSULTA);

?>

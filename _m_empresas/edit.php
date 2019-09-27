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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE empresas_master SET NOMBRE=%s WHERE CODIGO_EMPRESAS_MASTER=%s",
                       GetSQLValueString($_POST['NOMBRE'], "text"),
                       GetSQLValueString($_POST['CODIGO_EMPRESA_MASTER'], "text"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());

  $updateGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_conexion, $conexion);
$query_empresas = "SELECT * FROM empresas_master";
$empresas = mysql_query($query_empresas, $conexion) or die(mysql_error());
$row_empresas = mysql_fetch_assoc($empresas);
$totalRows_empresas = mysql_num_rows($empresas);

$colname_CONSULTA = "-1";
if (isset($_GET['CODIGO_EMPRESAS_MASTER'])) {
  $colname_CONSULTA = $_GET['CODIGO_EMPRESAS_MASTER'];
}
mysql_select_db($database_conexion, $conexion);
$query_CONSULTA = sprintf("SELECT * FROM empresas_master WHERE CODIGO_EMPRESAS_MASTER = %s", GetSQLValueString($colname_CONSULTA, "text"));
$CONSULTA = mysql_query($query_CONSULTA, $conexion) or die(mysql_error());
$row_CONSULTA = mysql_fetch_assoc($CONSULTA);
$totalRows_CONSULTA = mysql_num_rows($CONSULTA);

/*Definiciones*/
$formulario="Empresa00-Editar";
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
          <td width="100%" align="center" class="textos_form"><div class="titulo_formulario">Editar Empresas</div>
    </tr>
  </table>
<?php //include("_menu.php"); ?>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
      <table width="1100" align="center" >
    <tr>
      <td width="389" align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >

Codigo: 
      <td colspan="3" align="left" bgcolor="#F3F3F3" ><label for="CODIGO_EMPRESA_MASTER"></label>
      	<input name="CODIGO_EMPRESA_MASTER" type="text" id="CODIGO_EMPRESA_MASTER" value="<?php echo $row_CONSULTA['CODIGO_EMPRESAS_MASTER']; ?>" readonly="readonly" />      
      	</tr>
    <tr>
      <td width="389" align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >Nombre:      
      <td colspan="3" align="left" bgcolor="#F3F3F3" ><label for="NOMBRE"></label>
        <span id="sprytextfield1">
        <input name="NOMBRE" type="text" id="NOMBRE" value="<?php echo $row_CONSULTA['NOMBRE']; ?>" size="50" />
        <span class="textfieldRequiredMsg">Requerido.</span></span>
      <label for="MONTO_ESTIMADO"></label></tr>
    <tr>
    	<td colspan="4" align="left" >
    		<div class="validity-summary-container" style="color:#F00">
    			
    			<ul></ul>
</div></tr>

          <td colspan="4" align="center" bgcolor="#999999" class="textos_form" ><input name="button" type="submit" class="ui-widget-header" id="button" value="Guardar" /></tr></table>
      <p>&nbsp;</p>
      <p><br />
        
      </p>
  <table align="center" width="1100"><tr>
      <td width="389" align="center" bgcolor="#F3F3F3" class="textos_form" >

Codigo 
      <td width="643" align="center" bgcolor="#F3F3F3" class="textos_form" >Nombre      
      <td width="24" align="center" bgcolor="#F3F3F3" class="textos_form" >		
          <td width="24" align="center" bgcolor="#F3F3F3" class="textos_form" >			
          </tr>
          <?php do { ?>
          	<tr>
          		<td align="center" bgcolor="#FFFFFF" ><?php echo $row_empresas['CODIGO_EMPRESAS_MASTER']; ?>							
          		<td align="left" bgcolor="#FFFFFF" ><?php echo $row_empresas['NOMBRE']; ?>			
          		<td align="left" bgcolor="#FFFFFF" ><a href="edit.php?CODIGO_EMPRESAS_MASTER=<?php echo $row_empresas['CODIGO_EMPRESAS_MASTER']; ?>"><img src="../image/icon_doc.png" width="24" height="24" /></a>				
          		<td align="left" bgcolor="#FFFFFF" ><img src="../image/Delete-iconbw.png" width="24" height="24" />				          	</tr>
          	<?php } while ($row_empresas = mysql_fetch_assoc($empresas)); ?>
	</table>
  <input type="hidden" name="MM_update" value="form1" />
</form>
<p>&nbsp;</p>
<?php include("../include/_foot.php"); ?>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
</script>
</body>
</html>
<?php
mysql_free_result($empresas);

mysql_free_result($CONSULTA);


?>

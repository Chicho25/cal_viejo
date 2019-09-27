<?php require_once('../Connections/conexion.php'); ?>

<?php 			$codigo="";
			$nombre="";?>
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
	
		$colname_VERIFICA = "-1";
		if (isset($_POST['CODIGO_EMPRESAS_MASTER'])) {
		$colname_VERIFICA = $_POST['CODIGO_EMPRESAS_MASTER'];
		}
		mysql_select_db($database_conexion, $conexion);
		$query_VERIFICA = sprintf("SELECT * FROM empresas_master WHERE CODIGO_EMPRESAS_MASTER = %s", GetSQLValueString($colname_VERIFICA, "text"));
		$VERIFICA = mysql_query($query_VERIFICA, $conexion) or die(mysql_error());
		$row_VERIFICA = mysql_fetch_assoc($VERIFICA);
		$totalRows_VERIFICA = mysql_num_rows($VERIFICA);
		
		if($totalRows_VERIFICA>0){
			$alerta="Codigo ya existente";
			$codigo=$_POST['CODIGO_EMPRESAS_MASTER'];
			$nombre=$_POST['NOMBRE'];
		}else{
	
  $insertSQL = sprintf("INSERT INTO empresas_master (CODIGO_EMPRESAS_MASTER, NOMBRE) VALUES (%s, %s)",
                       GetSQLValueString($_POST['CODIGO_EMPRESAS_MASTER'], "text"),
                       GetSQLValueString($_POST['NOMBRE'], "text"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());

  $insertGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  //header(sprintf("Location: %s", $insertGoTo));
}

}

mysql_select_db($database_conexion, $conexion);
$query_empresas = "SELECT * FROM empresas_master";
$empresas = mysql_query($query_empresas, $conexion) or die(mysql_error());
$row_empresas = mysql_fetch_assoc($empresas);
$totalRows_empresas = mysql_num_rows($empresas);



/*Definiciones*/
$formulario="Empresa00-add";
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
          <td width="100%" align="center" class="textos_form"><div class="titulo_formulario">Añadir Empresas</div>
    </tr>
  </table>
<?php //include("_menu.php"); ?><!--<div class="ui-state-error-text"><center><?php echo $alerta ?></center></div>-->
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
      <table width="1100" align="center" >
    <tr>
      <td width="389" align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >

Codigo: 
      <td colspan="3" align="left" bgcolor="#F3F3F3" ><label for="CODIGO_EMPRESAS_MASTER"></label>
        <span id="sprytextfield1">
        <input type="text" name="CODIGO_EMPRESAS_MASTER" id="CODIGO_EMPRESAS_MASTER" />
      <span class="textfieldRequiredMsg">Requerido.</span></span></tr>
    <tr>
      <td width="389" align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >Nombre:      
      <td colspan="3" align="left" bgcolor="#F3F3F3" ><label for="NOMBRE"></label>
        <span id="sprytextfield2">
        <input name="NOMBRE" type="text" id="NOMBRE" size="50" />
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
  <table align="center" width="1100">
    <tr>
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
mysql_free_result($empresas);




?>

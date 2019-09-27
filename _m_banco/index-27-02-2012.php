<?php require_once('../../Connections/conexion.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "0,1,2";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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
  $insertSQL = sprintf("INSERT INTO banco_master (NOMBRE, NACIONAL) VALUES (%s, %s)",
                       GetSQLValueString($_POST['NOMBRE'], "text"),
                       GetSQLValueString($_POST['NACIONAL'], "int"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
}
 			$codigo="";
			$nombre="";?>
<?php


mysql_select_db($database_conexion, $conexion);
$query_CONSULTAS = "SELECT * FROM banco_master ORDER BY NOMBRE ASC";
$CONSULTAS = mysql_query($query_CONSULTAS, $conexion) or die(mysql_error());
$row_CONSULTAS = mysql_fetch_assoc($CONSULTAS);
$totalRows_CONSULTAS = mysql_num_rows($CONSULTAS);



/*Definiciones*/
$formulario="Banco00-add";
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<title>Untitled Document</title>
<?php include("../include/_js.php"); ?>
<?php include("../include/_css.php"); ?>

<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body style="font-family:Verdana, Geneva, sans-serif; font-size:12px">
<?php $opcion_menu=2; ?>1
<?php include("../include/menu.php"); ?>

      <table width="1100" align="center" class="ui-widget-header" >
    <tr>
          <td width="100%" align="center" class="textos_form"><div class="titulo_formulario">A&ntilde;adir Banco</div>
    </tr>
  </table>
<?php //include("_menu.php"); ?><div class="ui-state-error-text"><center><?php echo $alerta ?></center></div>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
      <table width="1100" align="center" >
    <tr>
      <td width="389" align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >

Nombre: 
      <td colspan="3" align="left" bgcolor="#F3F3F3" ><label for="NOMBRE"></label>
        <span id="sprytextfield1">
        <input name="NOMBRE" type="text" id="NOMBRE" size="50" />
      <span class="textfieldRequiredMsg">Requerido.</span></span></tr>
    <tr>
      <td width="389" align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >Nacional:      
      <td colspan="3" align="left" bgcolor="#F3F3F3" ><label for="NOMBRE"></label>
        <label for="NACIONAL"></label>
        <select name="NACIONAL" id="NACIONAL">
          <option value="1" selected="selected">Si</option>
          <option value="0">No</option>
        </select>
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
      <td width="221" align="center" bgcolor="#F3F3F3" class="textos_form" >ID
      <td width="634" align="center" bgcolor="#F3F3F3" class="textos_form" >Nombre      
      <td width="160" align="center" bgcolor="#F3F3F3" class="textos_form" >Nacional      
      <td width="31" align="center" bgcolor="#F3F3F3" class="textos_form" >		
          <td width="30" align="center" bgcolor="#F3F3F3" class="textos_form" >			
          </tr>
          <?php do { ?>
          	<tr>
          		<td align="center" bgcolor="#FFFFFF" ><?php echo $row_CONSULTAS['ID_BANCO_MASTER']; ?>
       		    <td align="left" bgcolor="#FFFFFF" ><?php echo $row_CONSULTAS['NOMBRE']; ?>                
	          <td align="left" bgcolor="#FFFFFF" ><?php if($row_CONSULTAS['NACIONAL']==1){echo 'SI'; }; ?>			
       		  <td align="left" bgcolor="#FFFFFF" ><a href="edit.php?ID_BANCO_MASTER=<?php echo $row_CONSULTAS['ID_BANCO_MASTER']; ?>"><img src="../image/icon_doc.png" width="24" height="24" /></a>				
   		  <td align="left" bgcolor="#FFFFFF" ><img src="../image/Delete-iconbw.png" width="24" height="24" />				          	</tr>
          	<?php } while ($row_CONSULTAS = mysql_fetch_assoc($CONSULTAS)); ?>
	</table>
      <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
<?php include("../include/_foot.php"); ?>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
</script>
</body>
</html>
<?php
mysql_free_result($VERIFICA);

mysql_free_result($CONSULTAS);




?>

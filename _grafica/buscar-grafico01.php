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

mysql_select_db($database_conexion, $conexion);
$query_GRUPOS = "SELECT * FROM vista_inmuebles GROUP BY ID_GRUPO";
$GRUPOS = mysql_query($query_GRUPOS, $conexion) or die(mysql_error());
$row_GRUPOS = mysql_fetch_assoc($GRUPOS);
$totalRows_GRUPOS = mysql_num_rows($GRUPOS);

mysql_select_db($database_conexion, $conexion);
$query_ANOS = "SELECT * FROM vista_egresos_ingresos_inmuebles_grupo GROUP BY ANO";
$ANOS = mysql_query($query_ANOS, $conexion) or die(mysql_error());
$row_ANOS = mysql_fetch_assoc($ANOS);
$totalRows_ANOS = mysql_num_rows($ANOS);

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

</head>

<body style="font-family:Verdana, Geneva, sans-serif; font-size:12px">
<?php $opcion_menu=2; ?>
<?php include("../include/menu.php"); ?>

      <table width="1100" align="center" class="ui-widget-header" >
    <tr>
          <td width="100%" align="center" class="textos_form"><div class="titulo_formulario">Buscar</div>
    </tr>
  </table>
<?php //include("_menu.php"); ?>
<form name="enviar" method="GET" id="enviar" action="grafico01.php">
      <table width="1100" align="center" >
    <tr>
      <td width="398" align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >

Grupo: 
      <td align="left" bgcolor="#F3F3F3" ><label for="GRUPO"></label>
      	<select name="GRUPO" id="GRUPO">
      		<?php
do {  
?>
      		<option value="<?php echo $row_GRUPOS['ID_GRUPO']?>"><?php echo $row_GRUPOS['NOMBRE_PROYECTO']; ?> - <?php echo $row_GRUPOS['NOMBRE_GRUPO']?></option>
      		<?php
} while ($row_GRUPOS = mysql_fetch_assoc($GRUPOS));
  $rows = mysql_num_rows($GRUPOS);
  if($rows > 0) {
      mysql_data_seek($GRUPOS, 0);
	  $row_GRUPOS = mysql_fetch_assoc($GRUPOS);
  }
?>
      		</select>
      	<label for="textfield"></label></tr>
    <tr>
      <td width="398" align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >Año:      
      <td align="left" bgcolor="#F3F3F3" ><label for="ANOS"></label>
      	<select name="ANOS" id="ANOS">
      		<?php
do {  
?>
      		<option value="<?php echo $row_ANOS['ANO']?>"><?php echo $row_ANOS['ANO']?></option>
      		<?php
} while ($row_ANOS = mysql_fetch_assoc($ANOS));
  $rows = mysql_num_rows($ANOS);
  if($rows > 0) {
      mysql_data_seek($ANOS, 0);
	  $row_ANOS = mysql_fetch_assoc($ANOS);
  }
?>
      		</select>
      	<label for="MONTO_ESTIMADO"></label></tr>
    <tr>
    	<td colspan="2" align="left" >
    		<div class="validity-summary-container" style="color:#F00">
    			
    			<ul></ul>
</div></tr>

          <td colspan="2" align="center" bgcolor="#999999" class="textos_form" ><input name="button" type="submit" class="ui-widget-header" id="button" value="Buscar" /></tr>
</table>
</form>


<?php include("../include/_foot.php"); ?>
</body>
</html>
<?php
mysql_free_result($GRUPOS);

mysql_free_result($ANOS);

//mysql_free_result($CONSULTA);

?>

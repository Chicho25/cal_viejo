<?php //require_once('../Connections/conexion.php'); ?>
<?php //require_once('../include/css_js.php'); ?>
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
$query_rst_proyecto = "SELECT * FROM proyectos";
$rst_proyecto = mysql_query($query_rst_proyecto, $conexion) or die(mysql_error());
$row_rst_proyecto = mysql_fetch_assoc($rst_proyecto);
$totalRows_rst_proyecto = mysql_num_rows($rst_proyecto);

mysql_select_db($database_conexion, $conexion);
$query_rst_partidas = "SELECT distinct  ID_PARTIDA, DESCRIPCION_COMPLETA FROM pagos_partidas ORDER BY DESCRIPCION_COMPLETA ASC";
$rst_partidas = mysql_query($query_rst_partidas, $conexion) or die(mysql_error());
$row_rst_partidas = mysql_fetch_assoc($rst_partidas);
$totalRows_rst_partidas = mysql_num_rows($rst_partidas);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script type="text/javascript">
$("document").ready
	(function()
		{$("#proyecto2").change(function () { 
		if($(this).val()!=' '){
				$("#proyecto2 option:selected").each(
						function () {
								//alert($(this).val());
					$("#partida").attr("disabled",false);
						elegido=$(this).val();
						$.post("part.php", 
						{PROYECTO: elegido}, function(data)
						{$("#partida").html(data);									
				});	
        		
		});} else{$("#partida").attr("disabled",true);}		
   	})
	})
	</script>
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form action="pdf-.php" method="post" enctype="multipart/form-data" name="frm_partida" target="_new" >
<table width="990" border="0" align="center"  class="Campos">
  <tr>
    <td width="337" align="right">Proyecto:</td>
    <td width="643"><label for="proyecto2"></label>
      <span id="spryproyecto">
      <select name="proyecto" id="proyecto2">
        
        <option value=" ">TODOS</option>
        <?php
do {  
?>
        <option value=" WHERE COD_PROYECTO=<?php echo $row_rst_proyecto['CODIGO']?>"><?php echo htmlentities($row_rst_proyecto['NOMBRE'])?></option>
        <?php
} while ($row_rst_proyecto = mysql_fetch_assoc($rst_proyecto));
  $rows = mysql_num_rows($rst_proyecto);
  if($rows > 0) {
      mysql_data_seek($rst_proyecto, 0);
	  $row_rst_proyecto = mysql_fetch_assoc($rst_proyecto);
  }
?>
      </select>
      <span class="selectInvalidMsg">Seleccione un proyecto.</span><span class="selectRequiredMsg">Seleccione un proyecto.</span></span></td>
  </tr>
  <tr>
    <td align="right">Partida:</td>
    <td><label for="partida"></label>
      <select name="partida" id="partida" disabled="disabled">
        <option value="-1">Para seleccionar la partida debe seleccionar el proyecto primero...</option>
      </select></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><input type="submit" name="aceptar" id="aceptar" value="Aceptar"  class="ui-state-hover" /></td>
    </tr>
</table>
</form>
<script type="text/javascript">
var spryselect1 = new Spry.Widget.ValidationSelect("spryproyecto", {invalidValue:"-1", validateOn:["blur", "change"]});
</script>
</body>
</html>
<?php
mysql_free_result($rst_proyecto);

mysql_free_result($rst_partidas);
?>

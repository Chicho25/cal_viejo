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
$query_combo1 = "SELECT ID, DESCRIPCION FROM partidas WHERE NIVEL = 1";
$combo1 = mysql_query($query_combo1, $conexion) or die(mysql_error());
$row_combo1 = mysql_fetch_assoc($combo1);
$totalRows_combo1 = mysql_num_rows($combo1);
?>
<!--<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<title>Calpe</title>-->
<link rel="stylesheet" href="../a/menu_style.css" type="text/css" media="all" />
<script language="javascript" src="../js/jquery-1.4.2.min.js"></script>
<script language="javascript" src="../js/jquery-ui-1.8.5.custom.min.js"></script>
<link rel="stylesheet" href="../css/redmond/jquery-ui-1.8.5.custom.css" type="text/css" media="all" />
<style>
.titulo_formulario {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 24px;
	color: #FFF;
}
</style>
	<script>
	$(function() {
		$( "#accordion" ).accordion({
			autoHeight: false,
			navigation: true
		});
	});
	</script>

<script language="javascript">
$(document).ready(function(){

	// Parametros para e combo1
   $("#combo1").change(function () {
   		$("#combo1 option:selected").each(function () {
			//alert($(this).val());
				elegido=$(this).val();
				$.post("informacion.php", { elegido: elegido }, function(data){
				$("div.resultado").html(data);
				
			});	
				
				
				$.post("combo1.php", { elegido: elegido }, function(data){
				$("#combo2").html(data);
				$("#combo3").html("");
				$("#combo4").html("");
				$("#combo5").html("");

				
			});			
        });
   })
	// Parametros para el combo2
	$("#combo2").change(function () {
   		$("#combo2 option:selected").each(function () {
			//alert($(this).val());
				elegido=$(this).val();
				$.post("informacion.php", { elegido: elegido }, function(data){
				$("div.resultado").html(data);
				
			});	
				
				$.post("combo1.php", { elegido: elegido }, function(data){
				$("#combo3").html(data);
				$("#combo4").html("");
				$("#combo5").html("");

			});			
        });
   })
   	// Parametros para el combo3
	$("#combo3").change(function () {
   		$("#combo3 option:selected").each(function () {
			//alert($(this).val());
							elegido=$(this).val();
				$.post("informacion.php", { elegido: elegido }, function(data){
				$("div.resultado").html(data);
				
			});	
			
			
				elegido=$(this).val();
				$.post("combo1.php", { elegido: elegido }, function(data){
				$("#combo4").html(data);
				$("#combo5").html("");

			});			
        });
   })
   // Parametros para el combo4
   	$("#combo4").change(function () {
   		$("#combo4 option:selected").each(function () {
			//alert($(this).val());
							elegido=$(this).val();
				$.post("informacion.php", { elegido: elegido }, function(data){
				$("div.resultado").html(data);
				
			});	
			
				elegido=$(this).val();
				
				$.post("combo1.php", { elegido: elegido }, function(data){
				$("#combo5").html(data);
			});	
				
        });
   })
   

});
</script>
<link href="../css.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php $opcion_menu=2; ?>
<?php include('../include/header.php'); ?><table width="1000" align="center" class="ui-widget-header" >
	<tr>
	<td width="100%" align="center" class="textos_form"><div class="titulo_formulario">Consulta de Partidas</div></tr></table>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <td bgcolor="#FFFFFF"><br /><table border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="100" align="center" bgcolor="#fff"><select name="combo1" size="8" class="lista" id="combo1" style="width:180px"  >
          	<option value="2" >Altamira</option>
          	<option value="193" >Parcela 1</option>
          	<option value="194" >Parcela 2</option>
          	<option value="601" >Canaima</option>
		</select></td>
          <td width="100" align="center" bgcolor="#fff"><select name="combo2" size="8" class="lista" id="combo2" style="width:180px">
            </select></td>
          <td width="100" align="center" bgcolor="#fff"><select name="combo3" size="8" class="lista" id="combo3" style="width:180px">
            </select></td>
          <td width="100" align="center" bgcolor="#fff"><select name="combo4" size="8" class="lista" id="combo4" style="width:180px">
            </select></td>
          <td width="100" align="center" bgcolor="#fff"><select name="combo5" size="8" class="lista" id="combo5" style="width:180px">
            </select></td>
        </tr>
        <tr>
          <td colspan="5" align="center" bgcolor="#FFFFFF"><!-- <table width="400" border="0" cellspacing="5" cellpadding="5">
              <tr>
                <td align="center"><input name="button4" type="submit" class="botones" id="button4" value="Ver Reporte" /></td>
                <td align="center">&nbsp;</td>
                <td align="center"><input name="button4" type="submit" class="botones" id="button6" value="Reiniciar" /></td>
              </tr>
            </table> --><a href="suma.php"><span class="botones"><br />
          	Actualizar Valores</span></a><br />
            </td>
        </tr>
        <tr>
          <td colspan="5" align="center" bgcolor="#CCCCCC"></td>
        </tr>
        <tr>
          <td colspan="5" align="center" bgcolor="#FFFFFF">
          <!--<table width="400" border="0" cellspacing="5" cellpadding="5">
              <tr>
                <td align="center"><input name="button" type="submit" class="botones" id="button" value="Imprimir" /></td>
                <td align="center"><input name="button2" type="submit" class="botones" id="button2" value="Exp. a Excel" /></td>
                <td align="center"><input name="button3" type="submit" class="botones" id="button3" value="Exp. a PDF" /></td>
              </tr>
            </table>--></td>
        </tr>
      </table></td>
  </tr>
</table><div align="center">
<div id="accordion" style="height:400px; width:1000px" align="left">
    <h3><a href="#">Totales Partidas</a></h3>
    <div><div class="resultado"></div></div>
    <h3><a href="#">Detalle Movimientos</a></h3>
    <div>Detalle de los cheques u otros movimientos</div>
</div></div>
</body>
</html>
<?php
mysql_free_result($combo1);
?>

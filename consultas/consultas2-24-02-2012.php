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

$colname_rs1 = "-1";
if (isset($_GET['1'])) {
  $colname_rs1 = $_GET['1'];
}
mysql_select_db($database_conexion, $conexion);
$query_rs1 = "SELECT ID, DESCRIPCION FROM partidas WHERE NIVEL = 1 ORDER BY ORDEN ASC";
$rs1 = mysql_query($query_rs1, $conexion) or die(mysql_error());
$row_rs1 = mysql_fetch_assoc($rs1);
$totalRows_rs1 = mysql_num_rows($rs1);
?>
<!--<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html">
<title>Calpe</title>
--><link rel="stylesheet" href="../a/menu_style.css" type="text/css" media="all" />
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


<script language="javascript">
$(document).ready(function(){
	$( "#accordion" ).accordion({
		autoHeight: false,
		navigation: true
	});

	// Parametros para e combo1
	$("#combo1").change(function () 
		{
			$("#combo1 option:selected").each(function () 
				{
					elegido=$(this).val();
					$.post("informacion - Copy.php", { elegido: elegido }, function(data)
						{
							$("div.resultado").html("");
							$("div.resultado").html(data);							
						}
					);
					$.post("movimientos.php", { elegido: elegido }, function(data)
						{
							$("div.movimientos").html("");
							$("div.movimientos").html(data);
						}
					);	
					$.post("grafica.php", { elegido: elegido }, function(data)
						{
							$("div.grafica").html("");
							$("div.grafica").html(data);
						}
					);
					$.post("combo1.php", { elegido: elegido }, function(data)
						{
							$("#combo2").html("");
							$("#combo2").html(data);
							$("#combo3").html("");
							$("#combo4").html("");
							$("#combo5").html("");
							$("#combo6").html("");
						}
					);			
				}
			);
		}
	)

	// Parametros para el combo2
	$("#combo2").change(function () 
		{
			$("#combo2 option:selected").each(function () 
				{
					elegido=$(this).val();
					//$.post("informacion.php", { elegido: elegido }, function(data)
					$.post("informacion - Copy.php", { elegido: elegido }, function(data)
					
						{
							$("div.resultado").html("");
							$("div.resultado").html(data);							
						}
					);
					$.post("movimientos.php", { elegido: elegido }, function(data)
						{
							$("div.movimientos").html("");
							$("div.movimientos").html(data);
						}
					);
					$.post("grafica.php", { elegido: elegido }, function(data)
						{
							$("div.grafica").html("");
							$("div.grafica").html(data);
						}
					);
	
					$.post("combo1.php", { elegido: elegido }, function(data)
						{
							$("#combo3").html("");
							$("#combo3").html(data);
							$("#combo4").html("");
							$("#combo5").html("");
							$("#combo6").html("");
						}
					);			
				}
			);
		}
	)
   	// Parametros para el combo3
	$("#combo3").change(function () {
   		$("#combo3 option:selected").each(function () {
			//alert($(this).val());
				elegido=$(this).val();
				$.post("informacion - Copy.php", { elegido: elegido }, function(data){
					$("div.resultado").html("");
					$("div.resultado").html(data);
				
			});	
						
				$.post("movimientos.php", { elegido: elegido }, function(data){
					$("div.movimientos").html("");
					$("div.movimientos").html(data);
				
				
			});	
				$.post("grafica.php", { elegido: elegido }, function(data)
						{
							$("div.grafica").html("");
							$("div.grafica").html(data);
						}
					);

				
			
			
				elegido=$(this).val();
				$.post("combo1.php", { elegido: elegido }, function(data){
					$("#combo4").html("");
					$("#combo4").html(data);
					$("#combo5").html("");
					$("#combo6").html("");

			});			
        });
   })
   // Parametros para el combo4
   	$("#combo4").change(function () {
   		$("#combo4 option:selected").each(function () {
			//alert($(this).val());
				elegido=$(this).val();
				$.post("informacion - Copy.php", { elegido: elegido }, function(data){
				$("div.resultado").html("");	
				$("div.resultado").html(data);
				
			});	
						
				$.post("movimientos.php", { elegido: elegido }, function(data){
				$("div.movimientos").html("");
				$("div.movimientos").html(data);
				
				
			});
			
					$.post("grafica.php", { elegido: elegido }, function(data)
						{
							$("div.grafica").html("");
							$("div.grafica").html(data);
						}
					);
	
				
			
				elegido=$(this).val();
				
				$.post("combo1.php", { elegido: elegido }, function(data){
				$("#combo5").html("");	
				$("#combo5").html(data);
				$("#combo6").html("");
				
			});	
				
        });
   })
   
      // Parametros para el combo5
   	$("#combo5").change(function () {
   		$("#combo5 option:selected").each(function () {
			//alert($(this).val());
							elegido=$(this).val();
				$.post("informacion - Copy.php", { elegido: elegido }, function(data){
					$("div.resultado").html("");	
					$("div.resultado").html(data);
				
			});	
						
				$.post("movimientos.php", { elegido: elegido }, function(data){
					$("div.movimientos").html("");
					$("div.movimientos").html(data);
				
				
			});
					$.post("grafica.php", { elegido: elegido }, function(data)
						{
							$("div.grafica").html("");
							$("div.grafica").html(data);
						}
					);
	
				
			
				elegido=$(this).val();
				
				$.post("combo1.php", { elegido: elegido }, function(data){
					$("#combo6").html("");
				$("#combo6").html(data);
			});	
				
        });
   })
   
   $("#combo6").change(function () {
   		$("#combo6 option:selected").each(function () {
			//alert($(this).val());
					elegido=$(this).val();
				$.post("informacion.php", { elegido: elegido }, function(data){
					$("div.resultado").html("");	
					$("div.resultado").html(data);
				
			});	
						
				$.post("movimientos.php", { elegido: elegido }, function(data){
					$("div.movimientos").html("");
					$("div.movimientos").html(data);
				
				
			});	
					$.post("grafica.php", { elegido: elegido }, function(data)
						{
							$("div.grafica").html("");
							$("div.grafica").html(data);
						}
					);

				
			
				elegido=$(this).val();
				
				//$.post("combo1.php", { elegido: elegido }, function(data){
					//$("#combo6").html("");
				//$("#combo6").html(data);
			//});	
				
        });
   })
   
   

});
</script>
<link href="../css.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php $opcion_menu=2; ?>
<?php include("../include/menu.php"); ?><table width="1100" align="center" class="ui-widget-header" >
	<tr>
	<td width="100%" align="center" class="textos_form"><div class="titulo_formulario">Consulta de Partidas</div></tr></table>
<table width="1100" border="0" align="center" cellpadding="0" cellspacing="0">
    <td bgcolor="#FFFFFF"><br /><table border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="180" align="center" bgcolor="#fff"><select name="combo1" size="8" class="lista" id="combo1" style="width:180px"  >
          	<?php
do {  
?>
          	<option value="<?php echo $row_rs1['ID']?>"><?php echo $row_rs1['DESCRIPCION']?></option>
          	<?php
} while ($row_rs1 = mysql_fetch_assoc($rs1));
  $rows = mysql_num_rows($rs1);
  if($rows > 0) {
      mysql_data_seek($rs1, 0);
	  $row_rs1 = mysql_fetch_assoc($rs1);
  }
?>
		</select></td>
          <td width="180" align="center" bgcolor="#fff"><select name="combo2" size="8" class="lista" id="combo2" style="width:180px">
            </select></td>
          <td width="180" align="center" bgcolor="#fff"><select name="combo3" size="8" class="lista" id="combo3" style="width:180px">
            </select></td>
          <td width="180" align="center" bgcolor="#fff"><select name="combo4" size="8" class="lista" id="combo4" style="width:180px">
            </select></td>
          <td width="180" align="center" bgcolor="#fff"><select name="combo5" size="8" class="lista" id="combo5" style="width:180px">
            </select></td>
          <td width="180" align="center" bgcolor="#fff"><select name="combo6" size="8" class="lista" id="combo6" style="width:180px">
          	</select></td>
        </tr>
        <tr>
          <td colspan="6" align="center" bgcolor="#FFFFFF">&nbsp;&nbsp;
          	

            </td>
        </tr>
        <tr>
          <td colspan="6" align="center" bgcolor="#CCCCCC"></td>
        </tr>
        <tr>
          <td colspan="6" align="center" bgcolor="#FFFFFF">
          </td>
        </tr>
      </table></td>
  </tr>
</table><div align="center">
<div id="accordion" style="height:400px; width:1100px" align="left">
    <h3><a href="#">Totales Partidas</a></h3>
    <div><div class="resultado"></div></div>
    <h3><a href="#">Detalle de Pagos</a></h3><div>
    <div class="movimientos"></div></div>
    <h3><a href="#">Graficas</a></h3><div>
    <div class="grafica" align="center"></div></div>
    
    
</div></div>
</body>
</html>
<?php
mysql_free_result($rs1);
?>

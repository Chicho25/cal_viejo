<?php
include('../Connections/conexion.php');
include('../include/css_js.php');
mysql_select_db($database_conexion, $conexion);
$query_Recordset1 = "SELECT DISTINCT NOMBRE_PROYECTO, CODIGO_PROYECTO FROM vista_rpt_ventas_inmuebles";
$Recordset1 = mysql_query($query_Recordset1, $conexion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<script type="text/javascript">
$("document").ready
	(function()
		{$("#proyecto").change(function () { 
		if($(this).val()!=' '){
						 $("#proyecto option:selected").each(
								function () {
								//alert($(this).val());
									$("#grupo").attr("disabled",false);
									elegido=$(this).val();
									$.post("_grupos_busqueda.php", 
									{COD_PROYECTOS_MASTER: elegido}, function(data)
									{$("#grupo").html(data);													
										
				});	
        		
		});} else{$("#grupo").attr("disabled",true);}		
   	})
/*	// Parametros para el combo2
	$("#grupo").change(function () { if($(this).val()!=' '){
   		$("#grupo option:selected").each(function () {
			//alert($(this).val());
				$("#inmueble").attr("disabled",false);
				$("#habitaciones").attr("disabled",false);
				$("#sanitarios").attr("disabled",false);
				$("#depositos").attr("disabled",false);
				$("#estacionamientos").attr("disabled",false);
				elegido=$(this).val();
				$.post("_inmueble.php", {ID_INMUEBLES_GRUPO: elegido }, function(data){
				$("#inmueble").html(data);
			});			
        });;} else{$("#inmueble").attr("disabled",true);}
   	})
	$("#inmueble").change(function () {
		if($(this).val()!=' '){
			 	$("#habitaciones").attr("disabled",true);
		$("#sanitarios").attr("disabled",true);
			$("#depositos").attr("disabled",true);
				$("#estacionamientos").attr("disabled",true);
		}
				else
				{
   	$("#habitaciones").attr("disabled",false);
		$("#sanitarios").attr("disabled",false);
			$("#depositos").attr("disabled",false);
				$("#estacionamientos").attr("disabled",false);
		}
   	})*/
})
</script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<form action="pdf.php" method="GET" name="form_buscar" target="_new" id="form_buscar">
  <table width="470" border="0" align="center" class="Campos">
    <tr align="center">
    </tr>
    <tr align="center">
      <td width="181" height="32" align="right" class="Campos">Partida:</td>
      <td width="279" align="left"><label for="descripcion"></label>        <label for="descripcion"></label>
      <input type="text" name="descripcion" id="descripcion" />        <label for="valor"></label></td>
    </tr>
    <tr align="center">
      <td height="38" align="right">Porcentaje:</td>
      <td height="38" align="left"> <span id="sprytextfield1">
        <label for="valor2"></label>
        <input name="valor" type="text" id="valor2" size="10" />
      <span class="textfieldRequiredMsg">Valor requerido.</span></span>%</td>
    </tr>
    <tr align="center">
      <td height="38" colspan="2"><input type="hidden" name="detalles" id="detalles"  value="1"/>        <input type="submit" class="ui-state-hover" name="buscar" id="buscar" value="Buscar" /></td>
    </tr>
    </table>  
</form>
<?php
mysql_free_result($Recordset1);

?>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur", "change"]});
</script>

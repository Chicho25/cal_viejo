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
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />



<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>

<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />

<form action="rpt_excel.php" method="GET" name="form_buscar" target="_new" id="form_buscar">
  <table width="470" border="0" align="center" class="Campos">
    <tr>
      <th width="143" height="32" align="right" class="Campos">Proyecto:</th>
      <th colspan="2" align="left" scope="col"><span id="spryselect1">
        <select name="proyecto" id="proyecto">
          <option value=" ">Seleccione el Proyecto</option>
          <?php
do {  
?>
          <option value=" AND CODIGO_PROYECTO=<?php echo $row_Recordset1['CODIGO_PROYECTO']?>"><?php echo $row_Recordset1['NOMBRE_PROYECTO']?></option>
          <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
        </select>
      <span class="selectInvalidMsg">Seleccione un proyecto.</span><span class="selectRequiredMsg">Please select an item.</span></span></th>
      <th width="118" class="txt_4" scope="col">&nbsp;</th>
    </tr>
    <tr align="center">
      <td width="143" height="32" align="right" class="Campos">Grupo de Inmueble:</td>
      <td colspan="2" align="left"><select name="grupo" id="grupo" disabled="disabled">
          <option value=" ">TODOS</option>
      </select></td>
      <td width="118">&nbsp;</td>
    </tr>
    <tr align="center">
      <td width="143" height="32" align="right" class="Campos">Monto Cesi&oacute;n a Multibank:</td>
      <td width="101" align="left"><select name="tipo" id="tipo">
        <option value="por">Porcentaje</option>
        <option value="mon">Monto</option>
      </select></td>
      <td width="90" align="left"><label for="valor"></label>
        <span id="sprytextfield1">
        <label for="valor2"></label>
        <input name="valor" type="text" id="valor2" size="15" />
      <span class="textfieldRequiredMsg">Valor requerido.</span><span class="textfieldInvalidFormatMsg">Solo numeros.</span></span></td>
      <td width="118">&nbsp;</td>
    </tr>
    <tr align="center">
      <td height="38" colspan="4"><input type="submit" class="ui-state-hover" name="buscar" id="buscar" value="Buscar" />
       </td>
    </tr>
    </table>  
</form>
<?php
mysql_free_result($Recordset1);

?>
<script type="text/javascript">
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1", {invalidValue:"-1"});
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {validateOn:["blur", "change"]});
</script>

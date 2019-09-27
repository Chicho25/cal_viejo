<?php
include('../Connections/conexion.php');
include('../include/css_js.php');
mysql_select_db($database_conexion, $conexion);
//$query_Recordset1 = "SELECT DISTINCT NOMBRE_PROYECTO, CODIGO_PROYECTO FROM vista_rpt_ventas_inmuebles";
$query_Recordset1 = "SELECT DISTINCT NOMBRE, CODIGO FROM proyectos";

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
									$.post("_grupos_busquedanew.php", 
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



<form action="rpt_pdf.php" method="GET" name="form_buscar" target="_new" id="form_buscar">
  <table width="470" border="0" align="center" class="Campos">
    <th width="143" height="32" align="right" class="Campos">Proyecto:</th>
      <th width="283" align="left" scope="col"><span id="spryselect1">
        <select name="proyecto" id="proyecto">
          <option value="-1">Seleccione el Proyecto</option>
          <?php
do {  
?>
          <option value=" AND COD_PROYECTOS_MASTER=<?php echo $row_Recordset1['CODIGO']?>"><?php echo $row_Recordset1['NOMBRE']?></option>
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
      <th width="30" class="txt_4" scope="col">&nbsp;</th>
    </tr>
    <tr align="center">
      <td width="143" height="32" align="right" class="Campos">Grupo de Inmueble:</td>
      <td width="283" align="left"><select name="grupo" id="grupo" disabled="disabled">
          <option value=" ">TODOS</option>
      </select></td>
      <td width="30">&nbsp;</td>
    </tr>
    <tr align="center">
      <td height="38" align="right" class="Campos">Detallado</td>
      <td height="38" align="left"><label for="formato"></label>
        <select name="detalles" id="detalles">
          <option value="1">SI</option>
          <option value="0">NO</option>
      </select></td>
      <td height="38">&nbsp;</td>
    </tr>
        <tr align="center">
      <td height="38" align="right" class="Campos">Formato</td>
      <td height="38" align="left"><label for="formato"></label>
        <select name="formato" id="formato">
          <option value="00">PDF</option>
          <option value="01">EXCEL</option>
      </select></td>
      <td height="38">&nbsp;</td>
    </tr>
    <tr align="center">
      <td height="38" colspan="3"><input type="submit" class="ui-state-hover" name="buscar" id="buscar" value="Buscar" />
        <input name="defecto" type="hidden" id="defecto" value="2" />
      <input type="hidden" name="busc" id="busc"  value="1"/></td>
    </tr>
    </table>  
</form>
<?php
mysql_free_result($Recordset1);

?>
<script type="text/javascript">
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1", {invalidValue:"-1"});
</script>

<?php

mysql_select_db($database_conexion, $conexion);
$query_Recordset1 = "SELECT DISTINCT NOMBRE_PROYECTO, COD_PROYECTO FROM vista_inmuebles";
$Recordset1 = mysql_query($query_Recordset1, $conexion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
mysql_select_db($database_conexion, $conexion);
$query_Recordset3 = "SELECT DISTINCT AREA  FROM vista_inmuebles ORDER BY AREA";
$Recordset3 = mysql_query($query_Recordset3, $conexion) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);
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
									$("#inmueble").attr("disabled",true);
									$("#habitaciones").attr("disabled",false);
									$("#sanitarios").attr("disabled",false);
									$("#depositos").attr("disabled",false);
									$("#estacionamientos").attr("disabled",false); 
									elegido=$(this).val();
									$.post("_grupos_busqueda.php", 
									{COD_PROYECTOS_MASTER: elegido}, function(data)
									{$("#grupo").html(data);													
										
				});	
        		
		});} else{$("#grupo").attr("disabled",true);
		$("#inmueble").attr("disabled",true);}		
   	})
	// Parametros para el combo2
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
   	})
})
</script>


<form id="form_buscar" name="form_buscar" method="GET" action="#">
  <table width="470" border="0" align="center" class="Campos">
    <th width="143" height="32" align="right" class="Campos">Proyecto:</th>
      <th width="283" align="left" scope="col"> <select name="proyecto" id="proyecto">
          <option value=" ">Seleccione el Proyecto</option>
          <?php
do {  
?>
          <option value=" AND COD_PROYECTO=<?php echo $row_Recordset1['COD_PROYECTO']?>"><?php echo $row_Recordset1['NOMBRE_PROYECTO']?></option>
          <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
        </select></th>
      <th width="30" class="txt_4" scope="col">&nbsp;</th>
    </tr>
    <tr align="center">
      <td width="143" height="32" align="right" class="Campos">Grupo de Inmueble:</td>
      <td width="283" align="left"><select name="grupo" id="grupo" disabled="disabled">
          <option value=" ">Seleccione el Grupo</option>
      </select></td>
      <td width="30">&nbsp;</td>
    </tr>
    <tr align="center">
      <td height="32" align="right" class="Campos">Inmueble:</td>
      <td height="32" align="left"><select name="inmueble" id="inmueble" disabled="disabled">
          <option value=" ">Selecione un Inmueble</option>
      </select></td>
      <td height="32">&nbsp;</td>
    </tr>
        <tr align="center">
      <td align="right" class="Campos">Area mts2:</td>
      <td align="left"><select name="area" id="area">
          <option value=" ">Superficie</option>
          <?php
do {  
?>
          <option value=" AND AREA=<?php echo $row_Recordset3['AREA']?>"><?php echo $row_Recordset3['AREA']?></option>
          <?php
} while ($row_Recordset3 = mysql_fetch_assoc($Recordset3));
  $rows = mysql_num_rows($Recordset3);
  if($rows > 0) {
      mysql_data_seek($Recordset3, 0);
	  $row_Recordset3 = mysql_fetch_assoc($Recordset3);
  }
?>
        </select></td>
      <td></td>
    </tr>

    <tr align="center">
      <td height="32" align="right" class="Campos">No. de Habitaciones:</td>
      <td height="32" align="left"><select name="habitaciones" id="habitaciones">
          <option value=" ">0</option>
          <option value=" AND HABITACIONES=1">1</option>
          <option value=" AND HABITACIONES=2">2</option>
          <option value=" AND HABITACIONES=3">3</option>
          <option value=" AND HABITACIONES=4">4</option>
          <option value=" AND HABITACIONES=5">5</option>
          
      </select></td>
      <td height="32">&nbsp;</td>
    </tr>
     <tr align="center">
      <td height="32" align="right" class="Campos">No. de Sanitarios:</td>
      <td height="32" align="left" class="Campos">
        <select name="sanitarios" id="sanitarios">
          <option value=" ">0</option>
          <option value=" AND SANITARIOS=1">1</option>
          <option value=" AND SANITARIOS=2">2</option>
          <option value=" AND SANITARIOS=3">3</option>
          <option value=" AND SANITARIOS=4">4</option>
          <option value=" AND SANITARIOS=5">5</option>
        </select>
      </td>
      <td height="32">&nbsp;</td>
    </tr>
     <tr align="center">
      <td height="32" align="right" class="Campos">No. de Depositos:</td>
      <td height="32" align="left" class="Campos">
        <select name="depositos" id="depositos">
          <option value=" ">0</option>
          <option value=" AND DEPOSITOS=1">1</option>
          <option value=" AND DEPOSITOS=2">2</option>
          <option value=" AND DEPOSITOS=3">3</option>
          <option value=" AND DEPOSITOS=4">4</option>
          <option value=" AND DEPOSITOS=5">5</option>
        </select>
      </td>
      <td height="32">&nbsp;</td>
    </tr>
     <tr align="center">
      <td height="32" align="right" class="Campos">No. de Estacionamientos:</td>
      <td height="32" align="left" class="Campos">
        <select name="estacionamientos" id="estacionamientos">
          <option value=" ">0</option>
          <option value=" AND ESTACIONAMIENTOS=1">1</option>
          <option value=" AND ESTACIONAMIENTOS=2">2</option>
          <option value=" AND ESTACIONAMIENTOS=3">3</option>
          <option value=" AND ESTACIONAMIENTOS=4">4</option>
          <option value=" AND ESTACIONAMIENTOS=5">5</option>
        </select>
      </td>
      <td height="32">&nbsp;</td>
    </tr>
    <tr align="center">
      <td height="28" align="right" class="Campos">Status:</td>
      <td align="left"><select name="status" id="status">
          <option value=" ">Todos</option>
          <option value=" AND VENDIDO=0">Disponible</option>
          <option value=" AND VENDIDO=1">Vendido</option>
          <option value=" AND VENDIDO=2">Reservado</option>
      </select></td>
      <td>&nbsp;</td>
    </tr>
    <tr align="center">
      <td height="38" colspan="3"><input type="submit" class="ui-state-hover" name="buscar" id="buscar" value="Buscar" />
      <input name="defecto" type="hidden" id="defecto" value="2" />
      <input type="hidden" name="busc" id="busc"  value="1"/>
      <input name="titulo_formulario" type="hidden" id="titulo_formulario" value="Inmuebles" />
      
        <input name="formato" type="hidden" id="formato" value="1" />
      </td>
    </tr>
    </table>
</form>
<?php
mysql_free_result($Recordset1);
mysql_free_result($Recordset3);
?>

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
				elegido=$(this).val();
				$.post("_inmueble.php", {ID_INMUEBLES_GRUPO: elegido }, function(data){
				$("#inmueble").html(data);
			});			
        });} else{$("#inmueble").attr("disabled",true);}
   	})
	})
</script>
<script>
$(function() {
	var dates = $( "#FROM, #TO" ).datepicker({
		changeMonth: true,
		changeYear: true,
		numberOfMonths: 1,
		onSelect: function( selectedDate ) {
			var option = this.id == "from" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" );
				date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
			//dates.not( this ).datepicker( "option", option, date );
		}
	});

});
</script>

<form action="#" method="GET" enctype="multipart/form-data" name="form_buscar" id="form_buscar">
  <table width="553" border="0" align="center" class="Campos">
  <tr align="center">
      <td height="21" colspan="4" align="left" class="Campos"><?php 
	  $tabla="vista_pro_cli";
	  $where=" WHERE COD_TIPO IN(2,3)";
	  $label="Cliente";
	  $nombre_campo_mostrar="NOMBRE";
	  $nombre_campo_value="ID_PRO_CLI";
	  $nombre_campo_form="nombre";
	  $parametro=" AND pro_cli_master.ID_PRO_CLI_MASTER=";
	  $ancho=220;
	  $boton=0;
	  $accion="accion()";
	  
	  
	  include_once('../include/autocompletar.php');?> </td>
    </tr>
    <tr>
      <th width="127" height="24" align="right" class="Campos">Proyecto:</th>
      <th colspan="2" align="left" scope="col"> <select name="proyecto" id="proyecto">
          <option value=" ">Seleccione el Proyecto</option>
          <?php
do {  
?>
          <option value=" AND COD_PROYECTOS_MASTER=<?php echo $row_Recordset1['COD_PROYECTO']?>"><?php echo $row_Recordset1['NOMBRE_PROYECTO']?></option>
          <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
        </select></th>
      <th width="225" class="txt_4" scope="col">&nbsp;</th>
    </tr>
    <tr align="center">
      <td width="127" height="24" align="right" class="Campos">Grupo de Inmueble:</td>
      <td colspan="2" align="left"><select name="grupo" id="grupo" disabled="disabled">
          <option value=" ">Seleccione el Grupo</option>
      </select></td>
      <td width="225">&nbsp;</td>
    </tr>
    <tr align="center">
      <td height="24" align="right" class="Campos">Inmueble:</td>
      <td height="24" colspan="2" align="left"><select name="inmueble" id="inmueble" disabled="disabled">
          <option value=" ">Selecione un Inmueble</option>
      </select></td>
      <td height="24">&nbsp;</td>
    </tr>
        <tr align="center">
      <td align="right" class="Campos">Desde:</td>
      <td width="145" align="left"><label for="FROM"></label>
        <input type="text" name="FROM" id="FROM" /></td>
      <td width="38" align="left">Hasta:</td>
      <td align="left"><label for="TO"></label>
      <input type="text" name="TO" id="TO" /></td>
    </tr>

    <tr align="center">
      <td height="21" align="right" class="Campos">Vista
        
      :</td>
      <td height="21" align="left" class="Campos"><select name="vista" id="vista">
        <option value="2">RESUMIDO</option>
        <option value="1">LISTADO</option>
      </select></td>
      <td height="21" align="right" class="Campos">&nbsp;</td>
      <td height="21" align="left"><label for="vista"></label></td>
    </tr>
    <tr align="center">
      <td height="38" colspan="4"><input name="titulo_formulario" type="hidden" id="titulo_formulario" value="Cobranzas" />        <input type="submit" class="ui-state-hover" name="Aceptar" id="Aceptar" value="Buscar" /></td>
    </tr>
    </table>  
</form>
<?php
mysql_free_result($Recordset1);
mysql_free_result($Recordset3);
?>

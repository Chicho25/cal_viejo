<?php include('../include/css_js.php'); ?>
<?php $modulo=$modulo; ?>
<?php
mysql_select_db($database_conexion, $conexion);
$query_proveeedor = "SELECT * FROM pro_cli WHERE tipo=1 or tipo=3";
$proveeedor = mysql_query($query_proveeedor, $conexion) or die(mysql_error());
$row_proveeedor = mysql_fetch_assoc($proveeedor);
$totalRows_proveeedor = mysql_num_rows($proveeedor);

mysql_select_db($database_conexion, $conexion);
$query_proyectos = "SELECT CODIGO, NOMBRE FROM proyectos";
$proyectos = mysql_query($query_proyectos, $conexion) or die(mysql_error());
$row_proyectos = mysql_fetch_assoc($proyectos);
$totalRows_proyectos = mysql_num_rows($proyectos);

mysql_select_db($database_conexion, $conexion);
$query_tipo = "SELECT TIPO, DESCRIPCION FROM tipo_pago";
$tipo = mysql_query($query_tipo, $conexion) or die(mysql_error());
$row_tipo = mysql_fetch_assoc($tipo);
$totalRows_tipo = mysql_num_rows($tipo);

?>
<?php 
$visivilidad="none";
?>
<script>
$(function() {
	var dates = $( "#from, #to" ).datepicker({
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
			dates.not( this ).datepicker( "option", option, date );
		}
	});

});
</script>
<script>
$('#from').change(function() {
  alert('Handler for .change() called.');
});
</script>
<!--<script type="text/javascript">
 function accion()
 {
//este es el parametro que pasa del objeto a la variable que envias al formulario result.php
			proyecto=$("#proyecto").val();
			proveedor=$("#proveedor").val();
			modulos=$("#tmodulo").val();
//
			if(($("#proyecto").val()!="")&&($("#proveedor").val()!="")){
			$.post("result.php",{ID_PRO_CLI: proveedor, PROYECTO: proyecto, MODULO:modulos}, function(data){
				$("#resul").html(data);
				});	
				}else
				{alert("Por favor seleccione el proyecto para realizar la busqueda...");}
				
 }
  function accion2()
 {
alert("Por favor seleccione el proyecto para realizar la busqueda...");

				
 }

  </script>-->
<form id="buscar" action="list.php" method="get">
<table width="990" border="0" align="center" class="Campos">
	<tr>
		<td width="233" align="right" class="Campos">ID Pago</td>
	  <td width="210"  class="Campos"><label for="ID_PAGO"></label>
	    <input type="text" name="ID_PAGO" id="ID_PAGO" /></td>
		<td width="116" align="right" class="Campos">ID Documento</td>
		<td width="413"  class="Campos"><input type="text" name="ID_DOCUMENTO" id="ID_DOCUMENTO" /></td>
	</tr>
	<tr>
	  <td align="right" class="Campos">Proyecto:</td>
	  <td colspan="3"  class="Campos"><select name="PROYECTO" id="PROYECTO">
	    <option value="">Todos</option>
	    <?php
do {  
?>
	    <option value=" AND COD_PROYECTO=<?php echo $row_proyectos['CODIGO']?>"><?php echo $row_proyectos['NOMBRE']?></option>
	    <?php
} while ($row_proyectos = mysql_fetch_assoc($proyectos));
  $rows = mysql_num_rows($proyectos);
  if($rows > 0) {
      mysql_data_seek($proyectos, 0);
	  $row_proyectos = mysql_fetch_assoc($proyectos);
  }
?>
      </select></td>
    </tr>
	<tr>
		<td colspan="4" align="left" class="Campos">
           	  <?php 
	  if ($modulo == 1){
	  $tabla="pro_cli_master";
	  $where=" WHERE TIPO IN(1,3)";
	  $label="Proveedores";
	  $nombre_campo_mostrar="NOMBRE";
	  $nombre_campo_value="ID_PRO_CLI_MASTER";
	  $nombre_campo_form="proveedores";
	  $ancho=550;
	  $parametro="";
	  $boton=0;
	  $accion="accion()";}
	  else
	  {	  $tabla="pro_cli_master";
	  $where=" WHERE TIPO IN(2,3)";
	  $label="Clientes";
	  $nombre_campo_mostrar="NOMBRE";
	  $nombre_campo_value="ID_PRO_CLI_MASTER";
	  $nombre_campo_form="proveedores";
	  $ancho=550;
	  $parametro="";
	  $boton=0;
	  $accion="accion()";}
	  
	  
	  include_once('../include/autocompletar2.php');?>

	</tr>
	<tr>
		<td align="right" class="Campos">Tipo:</td>
		<td  class="Campos"><label for="PROYECTO">
			<select name="TIPO" id="TIPO">
				<option value="">Todos</option>
				<?php
do {  
?>
				<option value=" AND TIPO_PAGO='<?php echo $row_tipo['DESCRIPCION']?>'"><?php echo $row_tipo['DESCRIPCION']?></option>
				<?php
} while ($row_tipo = mysql_fetch_assoc($tipo));
  $rows = mysql_num_rows($tipo);
  if($rows > 0) {
      mysql_data_seek($tipo, 0);
	  $row_tipo = mysql_fetch_assoc($tipo);
  }
?>
			</select>
		</label></td>
		<td align="right" class="Campos">Numero</td>
		<td  class="Campos"><input type="text" name="NUMERO" id="NUMERO" /></td>
	</tr>
	<tr>
		<td align="right" class="Campos">Desde</td>
		<td  class="Campos"><input type="text" id="from" name="FROM"/></td>
		<td align="right" class="Campos">Hasta</td>
		<td  class="Campos"><input type="text" id="to" name="TO"/></td>
	</tr>
	<tr>
	  <td align="right" class="Campos">Status</td>
	  <td colspan="2"  class="Campos"><label for="STATUS"></label>
	    <select name="STATUS" id="STATUS">
	      <option value="2">Todos</option>
	      <option value="0">Sin cheque emitido</option>
	      <option value="1">Con cheque emitido</option>
      </select></td>
    </tr>
	<tr>
		<td colspan="4" td height="38" align="center"><input name="titulo_formulario" type="hidden" id="titulo_formulario" value="<?php if($modulo==1){echo htmlentities('Emision de Pagos');} else {echo htmlentities('Recepcion de Pagos');} ?>" />
	  <input name="modulo" type="hidden" id="modulo" value="<?php echo $modulo; ?>" />		  <input type="submit" class="ui-state-hover" name="buscar" id="buscar" value="Aceptar" /></td>
	</tr>
</table>
</form>
<?php
mysql_free_result($proveeedor);

mysql_free_result($proyectos);

mysql_free_result($tipo);

?>

<?php require_once('../Connections/conexion.php'); ?>
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
$query_proyecto = "SELECT CODIGO AS ID_PROYECTO, NOMBRE AS PROYECTO FROM proyectos";
$proyecto = mysql_query($query_proyecto, $conexion) or die(mysql_error());
$row_proyecto = mysql_fetch_assoc($proyecto);
$totalRows_proyecto = mysql_num_rows($proyecto);

mysql_select_db($database_conexion, $conexion);
$query_clientes = "SELECT DISTINCT id_cliente, nombre_cliente FROM vista_ventas_comisiones ";
$clientes = mysql_query($query_clientes, $conexion) or die(mysql_error());
$row_clientes = mysql_fetch_assoc($clientes);
$totalRows_clientes = mysql_num_rows($clientes);

mysql_select_db($database_conexion, $conexion);
$query_vendedores = "SELECT DISTINCT ID_VENDEDOR, NOMBRE_VENDEDOR FROM vista_ventas_comisiones ";
$vendedores = mysql_query($query_vendedores, $conexion) or die(mysql_error());
$row_vendedores = mysql_fetch_assoc($vendedores);
$totalRows_vendedores = mysql_num_rows($vendedores);

mysql_select_db($database_conexion, $conexion);
$query_grupos = "SELECT DISTINCT  id_grupo, nombre_grupo FROM vista_ventas_comisiones ";
$grupos = mysql_query($query_grupos, $conexion) or die(mysql_error());
$row_grupos = mysql_fetch_assoc($grupos);
$totalRows_grupos = mysql_num_rows($grupos);
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
									$.post("_grupos_busqueda1.php", 
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
        });;} else{$("#inmueble").attr("disabled",true);}
   	})
})
</script>
<script>
$(function() {
	var dates = $( "#DESDE, #HASTA" ).datepicker({
		changeMonth: true,
		changeYear: true,
		numberOfMonths: 1,
		onSelect: function( selectedDate ) {
			var option = this.id == "DESDE" ? "minDate" : "maxDate",
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
<form action="relacion_ventas_vendedores.php" method="get" name="form1" target="_new">
  <table  align="center" width="383" border="0">
    <tr>
      <td colspan="2" align="right">Proyecto:</td>
      <td colspan="2"><select name="proyecto" id="proyecto">
        <option value=" ">Seleccione...</option>
        <?php
do {  
?>
        <option value=" AND ID_PROYECTO=<?php echo $row_proyecto['ID_PROYECTO']?>"><?php echo $row_proyecto['PROYECTO']?></option>
        <?php
} while ($row_proyecto = mysql_fetch_assoc($proyecto));
  $rows = mysql_num_rows($proyecto);
  if($rows > 0) {
      mysql_data_seek($proyecto, 0);
	  $row_proyecto = mysql_fetch_assoc($proyecto);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td colspan="2" align="right">Grupo:</td>
      <td colspan="2"><select name="grupo" id="grupo">
        <option value=" ">Seleccione...</option>
        <?php
do {  
?>
        <option value=" AND ID_GRUPO=<?php echo $row_grupos['ID_GRUPO']?>"><?php echo $row_grupos['NOMBRE_GRUPO']?></option>
        <?php
} while ($row_grupos = mysql_fetch_assoc($grupos));
  $rows = mysql_num_rows($grupos);
  if($rows > 0) {
      mysql_data_seek($grupos, 0);
	  $row_grupos = mysql_fetch_assoc($grupos);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td colspan="2" align="right">Inmueble:</td>
      <td colspan="2"><select name="inmueble" id="inmueble">
        <option value=" ">Seleccione...</option>
        <?php
do {  
?>
        <option value=""></option>
        <?php
} while ($row_grupos = mysql_fetch_assoc($grupos));
  $rows = mysql_num_rows($grupos);
  if($rows > 0) {
      mysql_data_seek($grupos, 0);
	  $row_grupos = mysql_fetch_assoc($grupos);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td colspan="2" align="right">Cliente:</td>
      <td colspan="2">
        <select name="CLIENTES" id="CLIENTES">
          <option value=" ">Seleccione...</option>
          <?php
do {  
?>
          <option value="<?php echo $row_clientes['ID_CLIENTE']?>"><?php echo $row_clientes['NOMBRE_CLIENTE']?></option>
          <?php
} while ($row_clientes = mysql_fetch_assoc($clientes));
  $rows = mysql_num_rows($clientes);
  if($rows > 0) {
      mysql_data_seek($clientes, 0);
	  $row_clientes = mysql_fetch_assoc($clientes);
  }
?>
        </select>
      </td>
    </tr>
    <tr>
      <td colspan="2" align="right">Vendedor:</td>
      <td colspan="2">      <select name="VENDEDORES" id="VENDEDORES">
        <option value=" ">Seleccione...</option>
        <?php
do {  
?>
        <option value="<?php echo $row_vendedores['ID_VENDEDOR']?>"><?php echo $row_vendedores['NOMBRE_VENDEDOR']?></option>
        <?php
} while ($row_vendedores = mysql_fetch_assoc($vendedores));
  $rows = mysql_num_rows($vendedores);
  if($rows > 0) {
      mysql_data_seek($vendedores, 0);
	  $row_vendedores = mysql_fetch_assoc($vendedores);
  }
?>
      </select>
  </td>
    </tr>
    <tr>
      <td width="42" align="right">Desde:</td>
      <td width="144" align="center">
        <input type="text" name="DESDE" id="DESDE">
      </td>
      <td width="38" align="right">Hasta:</td>
      <td width="144" align="left">
        <input type="text" name="HASTA" id="HASTA">
      </td>
    </tr>
    <tr>
      <td colspan="4" align="center" valign="middle">
        <input type="submit" name="Aceptar" id="Aceptar" class="ui-state-hover" value="Aceptar">
      </td>
    </tr>
  </table>
</form>
<?php
mysql_free_result($proyecto);

mysql_free_result($clientes);

mysql_free_result($vendedores);

mysql_free_result($grupos);
?>

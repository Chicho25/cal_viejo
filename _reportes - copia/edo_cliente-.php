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
$query_INMUEBLES = "SELECT * FROM vista_inmuebles";
$INMUEBLES = mysql_query($query_INMUEBLES, $conexion) or die(mysql_error());
$row_INMUEBLES = mysql_fetch_assoc($INMUEBLES);
$totalRows_INMUEBLES = mysql_num_rows($INMUEBLES);



/*Definiciones*/
$formulario="Reporte01-Editar";
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
<title>Untitled Document</title>
<?php include("../include/menu.php"); ?>
<?php include("../include/_js.php"); ?>
<?php include("../include/_css.php"); ?>

</head>

<body style="font-family:Verdana, Geneva, sans-serif; font-size:12px">
<?php $opcion_menu=2; ?>


      <table width="1100" align="center" class="ui-widget-header" >
    <tr>
          <td width="100%" align="center" class="textos_form"><div class="titulo_formulario">Estado de Cuenta Cliente</div>
    </tr>
  </table>
<?php //include("_menu.php"); ?>
<form name="enviar" method="GET" id="enviar" action="edo_cliente_listado.php">
      <table width="1100" align="center" >
<!-- Busqueda Proyectos-->    
<?php include('../include/_combo_proyectos.php'); ?>
<!--Fin Proyectos-->
<!-- Busqueda Partidas-->    
<?php //include('../include/_combo_partidas.php'); ?>
<!--Fin Partidas-->
<!-- Busqueda Proveedor-->
<?php $where_proveedor="where tipo=2 or tipo=3"?>

<style>
.ui-button { margin-left: -1px; }
.ui-button-icon-only .ui-button-text { padding: 0.35em; } 
.ui-autocomplete-input { margin: 0; padding: 0.48em 0 0.47em 0.45em; width:550px; font-family:Arial, Helvetica, sans-serif; font-size:13px; font-weight:bolder }
</style>
<script>
	(function( $ ) {
		$.widget( "ui.combobox", {
			_create: function() {
				var self = this,
					select = this.element.hide(),
					selected = select.children( ":selected" ),
					value = selected.val() ? selected.text() : "";
				var input = this.input = $( "<input>" )
					.insertAfter( select )
					.val( value )
					.autocomplete({
						delay: 0,
						minLength: 0,
						source: function( request, response ) {
							var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
							response( select.children( "option" ).map(function() {
								var text = $( this ).text();
								if ( this.value && ( !request.term || matcher.test(text) ) )
									return {
										label: text.replace(
											new RegExp(
												"(?![^&;]+;)(?!<[^<>]*)(" +
												$.ui.autocomplete.escapeRegex(request.term) +
												")(?![^<>]*>)(?![^&;]+;)", "gi"
											), "<strong>$1</strong>" ),
										value: text,
										option: this
									};
							}) );
						},
						select: function( event, ui ) {
							ui.item.option.selected = true;
							self._trigger( "selected", event, {
								item: ui.item.option
							});
						},
						change: function( event, ui ) {
							if ( !ui.item ) {
								var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( $(this).val() ) + "$", "i" ),
									valid = false;
								select.children( "option" ).each(function() {
									if ( $( this ).text().match( matcher ) ) {
										this.selected = valid = true;
										return false;
									}
								});
								if ( !valid ) {
									// remove invalid value, as it didn't match anything
									$( this ).val( "" );
									select.val( "" );
									input.data( "autocomplete" ).term = "";
									return false;
								}
							}
						}
					})
				

				input.data( "autocomplete" )._renderItem = function( ul, item ) {
					return $( "<li></li>" )
						.data( "item.autocomplete", item )
						.append( "<a>" + item.label + "</a>" )
						.appendTo( ul );
				};

				
			},

			destroy: function() {
				this.input.remove();
				this.button.remove();
				this.element.show();
				$.Widget.prototype.destroy.call( this );
			}
		});
	})( jQuery );

	$(function() {
		$( "#combobox2" ).combobox();
		$( "#toggle" ).click(function() {
			$( "#combobox2" ).toggle();
		});
	});
	</script>
<?php 
mysql_select_db($database_conexion, $conexion);
$query_proveeedor = "SELECT * FROM pro_cli ".$where_proveedor;
$proveeedor = mysql_query($query_proveeedor, $conexion) or die(mysql_error());
$row_proveeedor = mysql_fetch_assoc($proveeedor);
$totalRows_proveeedor = mysql_num_rows($proveeedor);
?>
<tr>
	<td bgcolor="#F0F0F0" class="textos_form_derecha">Cliente:</td>
	<td bgcolor="#F0F0F0"><label for="TIPO"></label>
	<select name="PROVEEDOR" id="combobox2" style="width: 300px; font-size:10px" width="300">
	<option value="" <?php if (!(strcmp("", 0))) {echo "selected=\"selected\"";} ?>></option>
	<?php
		do {  
	?>
	<option value="AND ID_PRO_CLI=<?php echo $row_proveeedor['ID_PRO_CLI']?>"<?php if (!(strcmp($row_proveeedor['ID_PRO_CLI'], 0))) {echo "selected=\"selected\"";} ?>><?php echo $row_proveeedor['NOMBRE']?></option>
	<?php
	} while ($row_proveeedor = mysql_fetch_assoc($proveeedor));
	$rows = mysql_num_rows($proveeedor);
	if($rows > 0) {
		mysql_data_seek($proveeedor, 0);
		$row_proveeedor = mysql_fetch_assoc($proveeedor);
	}
?>
		</select></td>
	</tr>
	
<?php
// include('../include/_combo_proveedor.php'); 



?>
<!--Fin Proveedor-->
<!-- Busqueda Desde_Hasta-->    
<?php //include('../include/_combo_desde_hasta.php'); ?>
<!--Fin Desde_Hasta-->
    <tr>
      	<td width="398" align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >Inmueble:
      		<td align="left" bgcolor="#F3F3F3" ><label for="INMUEBLE"></label>
      			<select name="INMUEBLE" id="INMUEBLE">
				<option value=" "> Todos </option>
      				<?php
do {  
?>
      				<option value=" AND ID_INMUEBLES=<?php echo $row_INMUEBLES['ID_INMUEBLE']?> "><?php echo $row_INMUEBLES['NOMBRE_GRUPO']; ?> - <?php echo $row_INMUEBLES['NOMBRE_INMUEBLE']?></option>
      				<?php
} while ($row_INMUEBLES = mysql_fetch_assoc($INMUEBLES));
  $rows = mysql_num_rows($INMUEBLES);
  if($rows > 0) {
      mysql_data_seek($INMUEBLES, 0);
	  $row_INMUEBLES = mysql_fetch_assoc($INMUEBLES);
  }
?>
				</select>      		
		  </tr>
    <tr>
    	<td colspan="2" align="left" >
    		<div class="validity-summary-container" style="color:#F00">
    			
    			<ul></ul>
</div></tr>

          <td colspan="2" align="center" bgcolor="#999999" class="textos_form" ><input name="button" type="submit" class="ui-widget-header" id="button" value="Buscar" /></tr>
</table>
</form>


<?php include("../include/_foot.php"); ?>
</body>
</html>
<?php
mysql_free_result($INMUEBLES);




?>

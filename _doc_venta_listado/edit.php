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
$query_proveeedor = "SELECT * FROM pro_cli WHERE tipo=2 or tipo=3";
$proveeedor = mysql_query($query_proveeedor, $conexion) or die(mysql_error());
$row_proveeedor = mysql_fetch_assoc($proveeedor);
$totalRows_proveeedor = mysql_num_rows($proveeedor);

mysql_select_db($database_conexion, $conexion);
$query_proyectos = "SELECT CODIGO, NOMBRE FROM proyectos";
$proyectos = mysql_query($query_proyectos, $conexion) or die(mysql_error());
$row_proyectos = mysql_fetch_assoc($proyectos);
$totalRows_proyectos = mysql_num_rows($proyectos);

mysql_select_db($database_conexion, $conexion);
$query_tipo = "SELECT TIPO, DESCRIPCION FROM doc_tipo WHERE MODULO = 2";
$tipo = mysql_query($query_tipo, $conexion) or die(mysql_error());
$row_tipo = mysql_fetch_assoc($tipo);
$totalRows_tipo = mysql_num_rows($tipo);

mysql_select_db($database_conexion, $conexion);
$query_inmueble = "SELECT * FROM inmuebles_tipo";
$inmueble = mysql_query($query_inmueble, $conexion) or die(mysql_error());
$row_inmueble = mysql_fetch_assoc($inmueble);
$totalRows_inmueble = mysql_num_rows($inmueble);

mysql_select_db($database_conexion, $conexion);
$query_rst_rst_grupo = "SELECT * FROM inmuebles_grupo";
$rst_rst_grupo = mysql_query($query_rst_rst_grupo, $conexion) or die(mysql_error());
$row_rst_rst_grupo = mysql_fetch_assoc($rst_rst_grupo);
$totalRows_rst_rst_grupo = mysql_num_rows($rst_rst_grupo);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<title>Untitled Document</title>
<?php include("../include/menu.php"); ?>
<?php include("../include/funciones.php"); ?>
<?php include("../include/_js.php"); ?>
<?php include("../include/_css.php"); ?>

<!--Autocompletar--->
<style>
#project-label {
	display: block;
	font-weight: bold;
	margin-bottom: 1em;
}
#project-icon {
	float: left;
	height: 32px;
	width: 32px;
}
#project-description {
	margin: 0;
	padding: 0;
	color:#F00;
}
body, td, th {
	font-size: 12px;
	font-family: Arial, Helvetica, sans-serif;
}
input:focus, input.focused {
	border-color: #000;
	color: #333;
}
</style>
	<style>
	.ui-button { margin-left: -1px; }
	.ui-button-icon-only .ui-button-text { padding: 0.35em; } 
	.ui-autocomplete-input { margin: 0; padding: 0.48em 0 0.47em 0.45em; width:600px; font-family:Arial, Helvetica, sans-serif; font-size:13px; font-weight:bolder }
	body, td, th {
	font-size: 12px;
	font-family: Arial, Helvetica, sans-serif;
}
	</style>
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
$(function() {
	var dates = $( "#FROM1, #TO1" ).datepicker({
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
		$( "#combobox" ).combobox();
		$( "#toggle" ).click(function() {
			$( "#combobox" ).toggle();
		});
	});
	</script>



<?php 
$visivilidad="none";
?>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../css/menu_style.css" type="text/css" media="all" />
</head>

<body>
<?php $opcion_menu=2; ?>
<table width="1100" align="center" class="ui-widget-header" >
	<tr>
		<td width="100%" align="center" class="textos_form"><div class="titulo_formulario">Buscar Documentos Venta</div>
	</tr>
</table>
<?php include("_menu.php"); ?><form action="edit2.php" method="get">
<table width="1075" border="0" cellpadding="0" cellspacing="2" align="center">
	<tr>
		<td width="352" bgcolor="#F0F0F0" class="textos_form_derecha">ID Documento</td>
		<td colspan="4" bgcolor="#F0F0F0"><span class="textos_form">
		  <label for="ID_DOCUMENTO"></label>
		  <input type="text" name="ID_DOCUMENTO" id="ID_DOCUMENTO" />
		  <input name="col" type="hidden" id="col" value="FECHA_VENCIMIENTO_DATE" />
			<input name="orden" type="hidden" id="orden" value="asc" />
		</span></td>
	</tr>
	<tr>
	  <td bgcolor="#F0F0F0" class="textos_form_derecha">Cliente:</td>
	  <td colspan="4" bgcolor="#F0F0F0"><span class="textos_form">
	    <select name="elegido" id="combobox" style="width: 300px; font-size:10px" width="300">
	      <option value="" <?php if (!(strcmp("", 0))) {echo "selected=\"selected\"";} ?>></option>
	      <?php
do {  
?>
	      <option value="<?php echo $row_proveeedor['ID_PRO_CLI']?>"<?php if (!(strcmp($row_proveeedor['ID_PRO_CLI'], 0))) {echo "selected=\"selected\"";} ?>><?php echo $row_proveeedor['NOMBRE']?></option>
	      <?php
} while ($row_proveeedor = mysql_fetch_assoc($proveeedor));
  $rows = mysql_num_rows($proveeedor);
  if($rows > 0) {
      mysql_data_seek($proveeedor, 0);
	  $row_proveeedor = mysql_fetch_assoc($proveeedor);
  }
?>
        </select>
	  </span></td>
    </tr>
	<tr>
		<td bgcolor="#F0F0F0" class="textos_form_derecha">Tipo:</td>
		<td colspan="4" bgcolor="#F0F0F0"><label for="TIPO"></label>
			<select name="TIPO" id="TIPO">
				<option value="0">Todos</option>
				<?php
do {  
?>
				<option value="<?php echo $row_tipo['TIPO']?>"><?php echo $row_tipo['DESCRIPCION']?></option>
				<?php
} while ($row_tipo = mysql_fetch_assoc($tipo));
  $rows = mysql_num_rows($tipo);
  if($rows > 0) {
      mysql_data_seek($tipo, 0);
	  $row_tipo = mysql_fetch_assoc($tipo);
  }
?>
			</select></td>
	</tr>
	<tr>
		<td bgcolor="#F0F0F0" class="textos_form_derecha">Proyecto:</td>
		<td colspan="4" bgcolor="#F0F0F0"><label for="PROYECTO"></label>
			<select name="PROYECTO" id="PROYECTO">
				<option value="0">Todos</option>
				<?php
do {  
?>
				<option value="<?php echo $row_proyectos['CODIGO']?>"><?php echo $row_proyectos['NOMBRE']?></option>
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
		<td bgcolor="#F0F0F0" class="textos_form_derecha">Grupo de Inmueble:</td>
		<td colspan="7" bgcolor="#F0F0F0"><label for="rst_grupo"></label>
			<select name="grupo" id="grupo">
			  <option value="0">Todos</option>
			  <?php
do {  
?>
			  <option value="<?php echo $row_rst_rst_grupo['ID_INMUEBLES_GRUPO']?>"><?php echo $row_rst_rst_grupo['NOMBRE']?></option>
			  <?php
} while ($row_rst_rst_grupo = mysql_fetch_assoc($rst_rst_grupo));
?>
          </select></td>
	</tr>

	<tr>
		<td height="23" bgcolor="#F0F0F0" class="textos_form_derecha">Status:</td>
		<td colspan="7" bgcolor="#F0F0F0"><label for="select2"></label>
			<select name="STATUS" id="select2">
				<option selected="selected">Todos</option>
				<option value="0">Sin Abonos</option>
				<option value="1">Pendientes</option>
				<option value="2">Con Abonos</option>
				<option value="3">Pagados</option>
                <option value="4">Vencidos</option>
                <option value="5">Aprobadas</option>
                <option value="6">No Aprobadas</option>
	  </select></td>
	</tr>
    <tr>
    <td height="20" bgcolor="#F0F0F0" class="textos_form_derecha">Rango Fecha de Documento:</td>
    <td width="82"  bgcolor="#F0F0F0" class="textos_form_derecha">Desde:</td>
    <td width="165" align="left"  bgcolor="#F0F0F0" ><input type="text" name="FROM" id="FROM" /></td>
    <td width="78"  bgcolor="#F0F0F0" class="textos_form_derecha">Hasta:</td>
    <td width="386" align="left"  bgcolor="#F0F0F0" ><input type="text" name="TO" id="TO" /></td>
    
    </tr>
        <tr>
    <td height="20"  bgcolor="#F0F0F0" class="textos_form_derecha">Rango Fecha de Vencimiento:</td>
    <td  bgcolor="#F0F0F0" class="textos_form_derecha">Desde:</td>
    <td align="left"  bgcolor="#F0F0F0"><input type="text" name="FROM1" id="FROM1" /></td>
    <td  bgcolor="#F0F0F0" class="textos_form_derecha">Hasta:</td>
    <td align="left"  bgcolor="#F0F0F0"><input type="text" name="TO1" id="TO1" /></td>
    
    </tr>
	<tr>
		<td colspan="5" align="center" bgcolor="#F0F0F0" class="textos_form"><input name="button" type="submit" class="ui-widget-header" id="button" value="Buscar" /></td>
		</tr>
</table>
</form>

</body>
</html>
<?php
mysql_free_result($proveeedor);

mysql_free_result($proyectos);

mysql_free_result($tipo);

//mysql_free_result($rst_rst_grupo);

?>

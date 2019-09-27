<?php require_once('../../Connections/conexion.php'); ?>
<?php
/*Definiciones*/
$formulario="documentos_edit01";
?>
<?php function changueFormatDate($cdate){
    list($year, $month,$day)=explode("-",$cdate);
    return $day."/".$month."/".$year;
}?>
<?php function changueFormatDateYMD($cdate){
    list($day,$month,$year)=explode("/",$cdate);
    return $year."-".$month."-".$day;
}?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form")) {
	$monto_documento=$_POST['MONTO_EXENTO']+$_POST['MONTO_GRABADO']+$_POST['MONTO_IMPUESTO'];
	if($_POST['MONTO_PAGADO']<=($_POST['MONTO_EXENTO']+$_POST['MONTO_GRABADO']+$_POST['MONTO_IMPUESTO']))
	{
	$updateSQL = sprintf("UPDATE documentos SET NUMERO=%s, FECHA_EMISION=%s, FECHA_VENCIMIENTO=%s, DESCRIPCION=%s, ID_PARTIDA=%s, MONTO_EXENTO=%s, MONTO_GRABADO=%s, MONTO_IMPUESTO=%s, TIPO=%s WHERE ID_DOCUMENTO=%s",
                       GetSQLValueString($_POST['NUMERO'], "text"),
                       GetSQLValueString(changueFormatDateYMD($_POST['fecha_emision']), "date"),
                       GetSQLValueString(changueFormatDateYMD($_POST['fecha_vencimiento']), "date"),
                       GetSQLValueString($_POST['DESCRIPCION'], "text"),
                       GetSQLValueString($_POST['id_partida'], "int"),
					   GetSQLValueString($_POST['MONTO_EXENTO'], "DOUBLE"),
					   GetSQLValueString($_POST['MONTO_GRABADO'], "DOUBLE"),
					   GetSQLValueString($_POST['MONTO_IMPUESTO'], "DOUBLE"),
					   GetSQLValueString($_POST['TIPO'], "int"),
					   GetSQLValueString($_POST['id_documento'], "int"));
	
mysql_select_db($database_conexion, $conexion);
$Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
	}else{?>
<script type="text/javascript">

alert("El monto del Documento no puede ser inferior al monto pagado");
//window.location = "edit2.php?elegido=&col=FECHA_DOCUMENTO&orden=asc&TIPO=0&PROYECTO=0&STATUS=Todos";

</script>
		
		<?php 
		
	}
?> 

<script type="text/javascript">
<!--
//alert("<?php echo $updateSQL;?>");
//window.location = "edit2.php?elegido=&col=FECHA_DOCUMENTO&orden=asc&TIPO=0&PROYECTO=0&STATUS=Todos";
//-->
</script>
<?php 
}

$colname_documento = "-1";
if (isset($_GET['ID_DOCUMENTO'])) {
  $colname_documento = $_GET['ID_DOCUMENTO'];
}
mysql_select_db($database_conexion, $conexion);
$query_documento = sprintf("SELECT * FROM documentos WHERE ID_DOCUMENTO = %s", GetSQLValueString($colname_documento, "int"));
$documento = mysql_query($query_documento, $conexion) or die(mysql_error());
$row_documento = mysql_fetch_assoc($documento);
$totalRows_documento = mysql_num_rows($documento);

mysql_select_db($database_conexion, $conexion);
$query_proyectos = "SELECT CODIGO, NOMBRE FROM proyectos";
$proyectos = mysql_query($query_proyectos, $conexion) or die(mysql_error());
$row_proyectos = mysql_fetch_assoc($proyectos);
$totalRows_proyectos = mysql_num_rows($proyectos);

mysql_select_db($database_conexion, $conexion);
$query_tipo = "SELECT TIPO, DESCRIPCION FROM doc_tipo WHERE MODULO = 1";
$tipo = mysql_query($query_tipo, $conexion) or die(mysql_error());
$row_tipo = mysql_fetch_assoc($tipo);
$totalRows_tipo = mysql_num_rows($tipo);

$colname_partidas = "-1";
if (isset($_GET['CODIGO'])) {
  $colname_partidas = $_GET['CODIGO'];
}
mysql_select_db($database_conexion, $conexion);
$query_partidas = sprintf("SELECT ID, DESCRIPCION_COMPLETA FROM partidas WHERE TIPO = 2 AND COD_PROYECTO = %s", GetSQLValueString($colname_partidas, "text"));
$partidas = mysql_query($query_partidas, $conexion) or die(mysql_error());
$row_partidas = mysql_fetch_assoc($partidas);
$totalRows_partidas = mysql_num_rows($partidas);

mysql_select_db($database_conexion, $conexion);
$query_proveeedor = "SELECT * FROM pro_cli WHERE tipo=1 or tipo=3";
$proveeedor = mysql_query($query_proveeedor, $conexion) or die(mysql_error());
$row_proveeedor = mysql_fetch_assoc($proveeedor);
$totalRows_proveeedor = mysql_num_rows($proveeedor);

mysql_select_db($database_conexion, $conexion);
$query_vista = sprintf("SELECT MONTO_PAGADO FROM vista_documentos WHERE ID_DOCUMENTO = %s", GetSQLValueString($colname_documento, "int"));
$vista = mysql_query($query_vista, $conexion) or die(mysql_error());
$row_vista = mysql_fetch_assoc($vista);
$totalRows_vista = mysql_num_rows($vista);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />

<title>Untitled Document</title>
	<?php include("../include/_js.php"); ?>
	<?php include("../include/_css.php"); ?>
	<style>
	.ui-button { margin-left: -1px; }
	.ui-button-icon-only .ui-button-text { padding: 0.35em; } 
	.ui-autocomplete-input { margin: 0; padding: 0.48em 0 0.47em 0.45em; width:600px; font-family:Arial, Helvetica, sans-serif; font-size:13px; font-weight:bolder }
	body, td, th {
	font-size: 12px;
	font-family: Arial, Helvetica, sans-serif;
}
	</style>
<script src="../../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
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
		
		$( "#fecha_emision" ).datepicker({
			changeMonth: true,
			changeYear: true,
			currentText: 'Now'
			
		});

		$( "#fecha_vencimiento" ).datepicker({
			changeMonth: true,
			changeYear: true,
			currentText: 'Now'
		});
		
		$.validity.setup({ outputMode:"summary" });

	$("form").validity(function() {
		$("#ID_PRO_CLI")
			.require('Selecciones un Proveedor')
			.match("number", 'Debe ser numerico')
		$("#id_partida")
			.require('Seleccione una partida')
			.match("number", 'Debe seleccionar un proyecto')
		
	});
	
	
	
	
	
	
	
	
	
	
		
});
</script>
<?php 
$visivilidad="none";
?>

<link rel="stylesheet" href="../css/menu_style.css" type="text/css" media="all" />
<link href="../../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php $opcion_menu=2; ?>
<?php include("../include/menu.php"); ?>

<table width="1100" align="center" class="ui-widget-header" >
	<tr>
		<td width="100%" align="center" class="textos_form"><div class="titulo_formulario">Editar Documentos con Abonos</div>
	</tr>
</table><table width="1100" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#999999">
	<tr class="textos_form">
		<td width="50" align="center" bgcolor="#FFFFFF">
		<table width="100%" border="0" cellspacing="0" cellpadding="4">
			<tr>
				<td align="right" bgcolor="#E5E5E5"><input type="button" name="button3" id="button3" value="Insertar" onClick="parent.location='../formularios/partidas_proyecto.php'"/></td>
				<td bgcolor="#E5E5E5"><input type="button" name="button" id="button" value="Buscar" onClick="parent.location='edit.php'"/></td>
			</tr>

		</table>
		</td>
	</tr>
</table><form name="form" action="<?php echo $editFormAction; ?>" method="POST">
<table width="1100" border="0" cellpadding="0" cellspacing="2" align="center"><tr>
		<td colspan="2" align="center" bgcolor="#F0F0F0" class="textos_form"><div class="validity-summary-container" style="color:#F00">
    
    <ul></ul>
</div></td>
	</tr> 
	<tr>
		<td width="346" bgcolor="#F0F0F0" class="textos_form_derecha">Proyecto:</td>
		<td width="654" bgcolor="#F0F0F0"><input name="COD_PROYECTO" type="hidden" id="COD_PROYECTO" value="<?php echo $row_proyectos['CODIGO']?>" />
			<select name="COD_PROYECTO_NOMBRE2" id="COD_PROYECTO_NOMBRE2" disabled="disabled">
			  <?php
do {  
?>
		    <option value="<?php echo $row_proyectos['CODIGO']?>"<?php if (!(strcmp($row_proyectos['CODIGO'], $row_documento['COD_PROYECTO']))) {echo "selected=\"selected\"";} ?>><?php echo $row_proyectos['NOMBRE']?></option>
		    <?php
} while ($row_proyectos = mysql_fetch_assoc($proyectos));
  $rows = mysql_num_rows($proyectos);
  if($rows > 0) {
      mysql_data_seek($proyectos, 0);
	  $row_proyectos = mysql_fetch_assoc($proyectos);
  }
?>
			</select>
  <input name="id_documento" type="hidden"  id="id_documento" value="<?php echo $row_documento['ID_DOCUMENTO']; ?>" />
			<input name="COD_PROYECTO_NOMBRE" type="hidden"  id="COD_PROYECTO_NOMBRE" value="<?php echo $row_documento['COD_PROYECTO']; ?>" />
            <input name="ID_PRO_CLI" type="hidden"  id="ID_PRO_CLI" value="<?php echo $row_documento['ID_PRO_CLI']; ?>" />
          <label for="TOTAL"></label></td>
	</tr>
	<tr>
		<td bgcolor="#F0F0F0" class="textos_form_derecha">Proveedor:</td>
		<td width="654" bgcolor="#F0F0F0"><label for="ID_PRO_CLI"></label><select name="ID_PRO_CLI2" disabled="disabled" class="textos_form" id="ID_PRO_CLI2" style="width: 300px; font-size:10px" width="300">
		  <option value="" <?php if (!(strcmp("", $row_documento['ID_PRO_CLI']))) {echo "selected=\"selected\"";} ?>></option>
		  <?php
do {  
?>
		  <option value="<?php echo $row_proveeedor['ID_PRO_CLI']?>"<?php if (!(strcmp($row_proveeedor['ID_PRO_CLI'], $row_documento['ID_PRO_CLI']))) {echo "selected=\"selected\"";} ?>><?php echo $row_proveeedor['NOMBRE']?></option>
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
	<tr>
		<td bgcolor="#F0F0F0" class="textos_form_derecha">Tipo:</td>
		<td bgcolor="#F0F0F0"><label for="TIPO"></label>
			<select name="TIPO" id="TIPO">
			  <?php
do {  
?>
		    <option value="<?php echo $row_tipo['TIPO']?>"<?php if (!(strcmp($row_tipo['TIPO'], $row_documento['TIPO']))) {echo "selected=\"selected\"";} ?>><?php echo $row_tipo['DESCRIPCION']?></option>
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
		<td bgcolor="#F0F0F0" class="textos_form_derecha">Numero:</td>
		<td bgcolor="#F0F0F0"><label for="NUMERO"></label>
			<input name="NUMERO" type="text" id="NUMERO" value="<?php echo $row_documento['NUMERO']; ?>" /></td>
	</tr>
	<tr>
		<td bgcolor="#F0F0F0" class="textos_form_derecha">Fecha Emision:</td>
		<td bgcolor="#F0F0F0"><label for="fecha_emision"></label>
	  <input name="fecha_emision" type="text" id="fecha_emision" value="<?php echo changueFormatDate($row_documento['FECHA_EMISION']); ?>" /></td>
	</tr>
	<tr>
		<td bgcolor="#F0F0F0" class="textos_form_derecha">Fecha Vencimiento:</td>
		<td bgcolor="#F0F0F0"><label for="fecha_vencimiento"></label>
	  <input name="fecha_vencimiento" type="text" id="fecha_vencimiento" value="<?php echo changueFormatDate($row_documento['FECHA_VENCIMIENTO']); ?>" /></td>
	</tr>
	<tr>
		<td bgcolor="#F0F0F0" class="textos_form_derecha">Descripcion:</td>
		<td bgcolor="#F0F0F0"><label for="DESCRIPCION"></label>
			<textarea name="DESCRIPCION" id="DESCRIPCION" cols="45" rows="5"><?php echo $row_documento['DESCRIPCION']; ?></textarea></td>
	</tr>
	<tr>
		<td bgcolor="#F0F0F0" class="textos_form_derecha">Partida:</td>
		<td bgcolor="#F0F0F0"><label for="textfield5"></label>
		  <span id="spryselect1">
		  <select id="combobox" name="id_partida" width="300" style="width: 300px; font-size:10px">
		    <option value=""  <?php if (!(strcmp("", $row_documento['ID_PARTIDA']))) {echo "selected=\"selected\"";} ?>></option>
		    <?php
do {  
?>
		    <option value="<?php echo $row_partidas['ID']?>"<?php if (!(strcmp($row_partidas['ID'], $row_documento['ID_PARTIDA']))) {echo "selected=\"selected\"";} ?>><?php echo $row_partidas['DESCRIPCION_COMPLETA']?></option>
		    <?php
} while ($row_partidas = mysql_fetch_assoc($partidas));
  $rows = mysql_num_rows($partidas);
  if($rows > 0) {
      mysql_data_seek($partidas, 0);
	  $row_partidas = mysql_fetch_assoc($partidas);
  }
?>
	      </select>
	    <span class="selectRequiredMsg">Seleccione</span></span></td>
	</tr>
	<tr>
		<td bgcolor="#F0F0F0" class="textos_form_derecha">Monto Exento:</td>
		<td bgcolor="#F0F0F0"><label for="MONTO_EXENTO"></label>
			<input name="MONTO_EXENTO" type="text" class="textos_form_derecha" id="MONTO_EXENTO" value="<?php echo $row_documento['MONTO_EXENTO']; ?>" align="right"/></td>
	</tr>
	<tr>
		<td bgcolor="#F0F0F0" class="textos_form_derecha"><p>Monto Gravado:</p></td>
		<td bgcolor="#F0F0F0"><label for="MONTO_GRABADO"></label>
			<input name="MONTO_GRABADO" type="text" class="textos_form_derecha" id="MONTO_GRABADO" value="<?php echo $row_documento['MONTO_GRABADO']; ?>" align="right"/></td>
	</tr>
	<tr>
		<td bgcolor="#F0F0F0" class="textos_form_derecha">Impuesto:</td>
		<td bgcolor="#F0F0F0"><label for="MONTO_IMPUESTO"></label>
			<input name="MONTO_IMPUESTO" type="text" class="textos_form_derecha" id="MONTO_IMPUESTO" value="<?php echo $row_documento['MONTO_IMPUESTO']; ?>" align="right"/></td>
	</tr>
	<!--<tr>
	  <td bgcolor="#F0F0F0" class="textos_form_derecha">Total Documento:</td>
	  <td bgcolor="#F0F0F0"><label for="TOTAL_PENDIENTE"></label>
      <input name="TOTAL" type="text" class="textos_form" id="textfield2" value="<?php echo $row_documento['MONTO_DOCUMENTO']; ?>" /></td>
    </tr>
	<tr>
	  <td bgcolor="#F0F0F0" class="textos_form_derecha">Total Pagado:</td>
	  <td bgcolor="#F0F0F0"><input name="TOTAL_PAGADO" type="text" class="textos_form" id="TOTAL_PAGADO" value="<?php echo $row_documento['MONTO_PAGADO']; ?>" /></td>
    </tr>
	<tr>
	  <td bgcolor="#F0F0F0" class="textos_form_derecha">Total Pendiente:</td>
	  <td bgcolor="#F0F0F0"><input name="TOTAL_PENDIENTE" type="text" class="textos_form" id="textfield3" value="<?php echo $row_documento['MONTO_DOCUMENTO']-$row_documento['MONTO_PAGADO']; ?>"/></td>
    </tr> 	 -->         
	<tr>
		<td colspan="2" align="center" bgcolor="#F0F0F0" class="textos_form"><input type="submit" name="button2" id="button2" value="Modificar" /></td>
	</tr>
</table>
<input type="hidden" name="MM_update" value="form" /><input type="hidden"  name="MONTO_PAGADO" value="<?php echo $row_vista['MONTO_PAGADO']; ?>" />
</form>
<script type="text/javascript">
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
</script>
</body>
</html>
<?php
mysql_free_result($documento);

mysql_free_result($proyectos);

mysql_free_result($tipo);

mysql_free_result($vista);
?>

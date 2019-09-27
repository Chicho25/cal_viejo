<?php
/*Definiciones*/
$formulario="inmuebles00-lote";
?>
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
$query_proyectos = "SELECT CODIGO, NOMBRE FROM proyectos";
$proyectos = mysql_query($query_proyectos, $conexion) or die(mysql_error());
$row_proyectos = mysql_fetch_assoc($proyectos);
$totalRows_proyectos = mysql_num_rows($proyectos);

mysql_select_db($database_conexion, $conexion);
$query_GRUPOS = "SELECT ID_INMUEBLES_GRUPO, NOMBRE FROM inmuebles_grupo WHERE COD_PROYECTOS_MASTER = '0002'";
$GRUPOS = mysql_query($query_GRUPOS, $conexion) or die(mysql_error());
$row_GRUPOS = mysql_fetch_assoc($GRUPOS);
$totalRows_GRUPOS = mysql_num_rows($GRUPOS);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
	<title>Untitled Document</title>
	<?php include("../include/_js.php"); ?>
	<?php include("../include/_css.php"); ?>
	<style>
.ui-button {
	margin-left: -1px;
}
.ui-button-icon-only .ui-button-text {
	padding: 0.35em;
}
.ui-autocomplete-input {
	width:450px;
	font-family:Arial, Helvetica, sans-serif;
	font-size:13px;
	font-weight:bolder
}
.validity-summary-container { display:none; }
.validity-summary-output ul { }
.validity-erroneous { border:solid 2px red !important; }
</style>

	<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
	<script type="text/javascript">
    function calculateSum() {
 
        var sum = 0;
        //iterate through each textboxes and add the values
        $(".amr").each(function() {
 
            //add only if the value is number
            if(!isNaN(this.value) && this.value.length!=0) {
                sum += parseFloat(this.value);
            }
 
        });
        //.toFixed() method will roundoff the final sum to 2 decimal places
        $("#sum").html(sum.toFixed(2));
		total=parseFloat(monto.value)*sum/100;
		$("#monto_total").html(total.toFixed(2));
	}
	
	
$("document").ready(function(){

        $(".amr").each(function() {
 
            $(this).keyup(function(){
                calculateSum();
            });
        });

 
	
	var myDate = new Date();
	var month = myDate.getMonth() + 1;
	var prettyDate = myDate.getDate()  + '/' + month + '/' + myDate.getFullYear();
	$("#fecha").val(prettyDate);
	/* Fecha */
	$( "#fecha" ).datepicker({
		changeMonth: true,
		changeYear: true,
		currentText: 'Now'			
	});
	$( "#FECHA_VENTA_DATE" ).datepicker({
		changeMonth: true,
		changeYear: true,
		currentText: 'Now'			
	});
	$( "#FECHA_HASTA" ).datepicker({
		changeMonth: true,
		changeYear: true,
		currentText: 'Now'			
	});

	
	$("#COD_PROYECTO").change(function () {
   		$("#COD_PROYECTO option:selected").each(function () {
			//alert($(this).val());
				elegido=$(this).val();
				$.post("_grupos_busqueda.php", { COD_PROYECTOS_MASTER: elegido }, function(data){
				$("#ID_GRUPO").html(data);
				$("#ID_INMUEBLE").html("<option value=''>Seleccione...................</option>");
			});			
        });
   	})
	// Parametros para el combo2
	$("#ID_GRUPO").change(function () {
   		$("#ID_GRUPO option:selected").each(function () {
			//alert($(this).val());
				elegido=$(this).val();
				$.post("_inmueble.php", { ID_INMUEBLES_GRUPO: elegido }, function(data){
				$("#ID_INMUEBLE").html(data);
			});			
        });
   	})
})
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
	<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
	</head>

<body style="font-family:Verdana, Geneva, sans-serif; font-size:12px">
<?php $opcion_menu=2; ?>
<?php include("../include/menu.php"); ?>

      <table width="1100" align="center" class="ui-widget-header" >
    <tr>
          <td width="100%" align="center" class="textos_form"><div class="titulo_formulario">Editar Precios de Inmuebles por Lote</div>
    </tr>
  </table>
<?php //include("_menu.php"); ?>
<form action="update.php" method="get" id="enviar">
      <table width="1100" align="center" >
    <tr>
    	<td colspan="2" align="center" bgcolor="#F3F3F3" class="ui-state-error-text" >Nota: Recuerde que este Proceso	no	es reversible.</tr>
    <tr>
    	<td align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >Proyecto:	
    	<td width="544" align="left" bgcolor="#F3F3F3" class="textos_form" ><select name="COD_PROYECTO" id="COD_PROYECTO">
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
    		</select>		
    	</tr>
    <tr>
    	<td width="544" align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >Grupo:		
    	<td align="left" bgcolor="#F3F3F3" class="textos_form" ><select name="ID_GRUPO" id="ID_GRUPO">
    		<?php
do {  
?>
    		<option value="<?php echo $row_GRUPOS['ID_INMUEBLES_GRUPO']?>"><?php echo $row_GRUPOS['NOMBRE']?></option>
    		<?php
} while ($row_GRUPOS = mysql_fetch_assoc($GRUPOS));
  $rows = mysql_num_rows($GRUPOS);
  if($rows > 0) {
      mysql_data_seek($GRUPOS, 0);
	  $row_GRUPOS = mysql_fetch_assoc($GRUPOS);
  }
?>
		</select>    	    	</tr>
    <tr>
    	<td width="544" align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >Area:<td align="left" bgcolor="#F3F3F3" class="textos_form" ><label for="AREA"></label>
    		<span id="sprytextfield1">
    		<input type="text" name="AREA" id="AREA" />
    		<span class="textfieldRequiredMsg">REQUERIDO.</span></span></tr>
    <tr>
    	<td width="544" align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >Modelo:		
    	<td align="left" bgcolor="#F3F3F3" class="textos_form" ><label for="MODELO"></label>
    		<span id="sprytextfield2">
    		<input type="text" name="MODELO" id="MODELO" />
    		<span class="textfieldRequiredMsg">REQUERIDO.</span></span></tr>
    <tr>
    	<td width="544" align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >Precio		
    	<td align="left" bgcolor="#F3F3F3" class="textos_form" ><label for="textfield2"></label>
    		<span id="sprytextfield3">
			<input type="text" name="PRECIO" id="textfield2" />
			<span class="textfieldRequiredMsg">REQUERIDO.</span><span class="textfieldInvalidFormatMsg">DEBE SER NUMERICO.</span></span></tr>
    <tr>
    	<td colspan="2" align="left" >
    		<div class="validity-summary-container" style="color:#F00">
    			
    			<ul></ul>
</div></tr>

          <td colspan="2" align="center" bgcolor="#999999" class="textos_form" ><input name="button" type="submit" class="ui-widget-header" id="button" value="Cambiar Precios" /></tr>
</table>
    </form>


<?php include("../include/_foot.php"); ?>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "real");
</script>
</body>
</html>
<?php
mysql_free_result($proyectos);

mysql_free_result($GRUPOS);
?>

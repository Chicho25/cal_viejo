    <?php include('../include/header.php'); ?>

<?php
/*Definiciones*/
$formulario="venta00-busqueda";
?>
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
$query_proyectos = "SELECT CODIGO, NOMBRE FROM proyectos";
$proyectos = mysql_query($query_proyectos, $conexion) or die(mysql_error());
$row_proyectos = mysql_fetch_assoc($proyectos);
$totalRows_proyectos = mysql_num_rows($proyectos);

mysql_select_db($database_conexion, $conexion);
$query_vendedores = "SELECT ID_PRO_CLI_MASTER, NOMBRE FROM pro_cli_master WHERE VENDEDOR = 1";
$vendedores = mysql_query($query_vendedores, $conexion) or die(mysql_error());
$row_vendedores = mysql_fetch_assoc($vendedores);
$totalRows_vendedores = mysql_num_rows($vendedores);

mysql_select_db($database_conexion, $conexion);
$query_proveeedor = "SELECT * FROM pro_cli_master WHERE tipo=2 or tipo=3";
$proveeedor = mysql_query($query_proveeedor, $conexion) or die(mysql_error());
$row_proveeedor = mysql_fetch_assoc($proveeedor);
$totalRows_proveeedor = mysql_num_rows($proveeedor);
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

	
	$("#ID_PROYECTO").change(function () {
   		$("#ID_PROYECTO option:selected").each(function () {
			//alert($(this).val());
				elegido=$(this).val();
				$.post("_grupos_busqueda.php", { COD_PROYECTOS_MASTER: elegido }, function(data){
				$("#ID_GRUPO").html(data);
				$("#ID_INMUEBLES").html("<option value=''>Seleccione...................</option>");
			});			
        	});
   	})
	// Parametros para el combo2
	$("#ID_GRUPO").change(function () {
   		$("#ID_GRUPO option:selected").each(function () {
			//alert($(this).val());
				elegido=$(this).val();
				$.post("_inmueble2.php", { ID_INMUEBLES_GRUPO: elegido }, function(data){
				$("#ID_INMUEBLES").html(data);
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
	</head>

<body style="font-family:Verdana, Geneva, sans-serif; font-size:12px">
<?php $opcion_menu=2; ?>
<?php //include("../include/menu.php"); ?>

      <table width="1100" align="center" class="ui-widget-header" >
    <tr>
          <td width="100%" align="center" class="textos_form"><div class="titulo_formulario">Buscar Venta</div>
    </tr>
  </table>
<?php include("_menu.php"); ?>
<form action="edit2.php" method="get" id="enviar">
      <table width="1100" align="center" >
    <tr>
          <td width="252" align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >ID:
      <td colspan="5" bgcolor="#F3F3F3" ><label for="ID_INMUEBLES_MOV"></label>
        <input type="text" name="ID_INMUEBLES_MOV" id="ID_INMUEBLES_MOV" />
        <input name="col" type="hidden" id="col" value="FECHA_VENTA_DATE" />      <input name="orden" type="hidden" id="orden" value="1" />      <input name="MONTO_VENTA" type="hidden" id="MONTO_VENTA" />          <input name="CODIGO_INMUEBLE" type="hidden" id="CODIGO_INMUEBLE" />      </tr>
    <tr>
      <td width="252" align="right" bgcolor="#F3F3F3" class="textos_form_derecha" ><input name="CANTIDAD_VENDEDORES" type="hidden" id="CANTIDAD_VENDEDORES" value="<?php echo $totalRows_vendedores; ?>" />
Proyecto: 
      <td width="208" align="left" bgcolor="#F3F3F3" class="textos_form_derecha" ><select name="ID_PROYECTO" id="ID_PROYECTO">
        <option value="">Seleccione...................</option>
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
      <td width="76" bgcolor="#F3F3F3" class="textos_form_derecha" >Grupo:      
      <td width="216" bgcolor="#F3F3F3" ><select name="ID_GRUPO" id="ID_GRUPO">
        <option value="">Seleccione...................</option>
      </select>      
      <td width="78" align="center" bgcolor="#F3F3F3" class="textos_form_derecha" >Inmueble:      
      <td width="242" bgcolor="#F3F3F3" ><select name="ID_INMUEBLES" id="ID_INMUEBLES">
        <option value="">Seleccione...................</option>
      </select>      
      </tr>
    <tr>
          <td width="252" align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >Desde:
      <td width="208" bgcolor="#F3F3F3" ><input name="FECHA_VENTA_DATE" type="text" id="FECHA_VENTA_DATE" />
      <td width="76" align="left" bgcolor="#F3F3F3" class="textos_form_derecha" >Hasta:      
      <td align="left" bgcolor="#F3F3F3" class="textos_form" ><input name="FECHA_HASTA" type="text" id="FECHA_HASTA" />
      <td colspan="2" bgcolor="#F3F3F3" ></tr>
    <tr>
          <td align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >Cliente:
      <td colspan="5" bgcolor="#F3F3F3" ><select name="ID_CLIENTE" id="combobox" title="cliente" style="width: 300px; font-size:10px" width="300">
          <option value="" <?php if (!(strcmp("", 0))) {echo "selected=\"selected\"";} ?>></option>
          <?php
do {  
?>
          <option value="<?php echo $row_proveeedor['ID_PRO_CLI_MASTER']?>"<?php if (!(strcmp($row_proveeedor['ID_PRO_CLI_MASTER'], 0))) {echo "selected=\"selected\"";} ?>>[ID:<?php echo $row_proveeedor['ID_PRO_CLI_MASTER']?>] <?php echo $row_proveeedor['NOMBRE']?></option>
          <?php
} while ($row_proveeedor = mysql_fetch_assoc($proveeedor));
  $rows = mysql_num_rows($proveeedor);
  if($rows > 0) {
      mysql_data_seek($proveeedor, 0);
	  $row_proveeedor = mysql_fetch_assoc($proveeedor);
  }
?>
        </select>
    </tr>
    <tr>
          <td colspan="6" align="left" >
              <div class="validity-summary-container" style="color:#F00">
    
    <ul></ul>
</div></tr>

          <td colspan="6" align="center" bgcolor="#999999" class="textos_form" ><input name="button" type="submit" class="ui-widget-header" id="button" value="Buscar" />
            <input name="button2" type="reset" class="ui-state-hover" id="button2" value="Borrar" />
          </tr>
</table>
    </form>


<?php include("../include/_foot.php"); ?>
</body>
</html>
<?php
mysql_free_result($proyectos);

mysql_free_result($vendedores);
?>

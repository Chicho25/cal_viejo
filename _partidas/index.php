<?php
/*Definiciones*/
$formulario="partidas00-busqueda";
?>
<?php require_once('../Connections/conexion.php'); ?>
    <?php include('../include/header.php'); ?>
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
$query_proveeedor = "SELECT * FROM partidas";
$proveeedor = mysql_query($query_proveeedor, $conexion) or die(mysql_error());
$row_proveeedor = mysql_fetch_assoc($proveeedor);
$totalRows_proveeedor = mysql_num_rows($proveeedor);

mysql_select_db($database_conexion, $conexion);
$query_nivel = "SELECT * FROM partidas GROUP BY NIVEL ORDER BY NIVEL";
$nivel = mysql_query($query_nivel, $conexion) or die(mysql_error());
$row_nivel = mysql_fetch_assoc($nivel);
$totalRows_nivel = mysql_num_rows($nivel);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1" />
	<title>Untitled Document</title>

     <?php //include('../include/funciones.php'); ?>
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
				$("#INMUEBLE").html("<option value=''>Seleccione...................</option>");
			});			
        	});
   	})
	// Parametros para el combo2
	$("#ID_GRUPO").change(function () {
   		$("#ID_GRUPO option:selected").each(function () {
			//alert($(this).val());
				elegido=$(this).val();
				$.post("_inmueble.php", { ID_INMUEBLES_GRUPO: elegido }, function(data){
				$("#INMUEBLE").html(data);
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


      <table width="1100" align="center" class="ui-widget-header" >
    <tr>
          <td width="100%" align="center" class="textos_form"><div class="titulo_formulario">Buscar Partida</div>
    </tr>
  </table>
<?php include("_menu.php"); ?>
<form action="listado.php" method="get" id="enviar">
      <table width="1100" align="center" >
    <tr>
      <td width="398" align="right" bgcolor="#F3F3F3" class="textos_form_derecha" ><input name="MONTO_ESTIMADO_DISPONIBLE" type="hidden" id="MONTO_ESTIMADO_DISPONIBLE" />
Proyecto: 
      <td align="left" bgcolor="#F3F3F3" ><select name="COD_PROYECTO" class="textos_form" id="COD_PROYECTO">
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
        <input name="col" type="hidden" id="col" value="ALICUOTA, ORDEN" />
      <input name="orden" type="hidden" id="orden" value="1" />
      <input name="DESCRIPCION_COMPLETA" type="hidden" id="DESCRIPCION_COMPLETA" />
      <input name="MONTO_ESTIMADO" type="hidden" id="MONTO_ESTIMADO" />      <input name="MONTO_ASIGNADO" type="hidden" id="MONTO_ASIGNADO" />      <input name="MONTO_PAGADO" type="hidden" id="MONTO_PAGADO" />      
      </tr>
    <tr>
          <td width="398" align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >Estado:
          <td bgcolor="#F3F3F3" ><label for="ESTIMADO_EXCEDIDO"></label>
            <select name="ESTIMADO_EXCEDIDO" id="ESTIMADO_EXCEDIDO">
              <option value="" >Todos</option>
              <option value="1">Excedidos</option>
              <option value="0">Normal</option>
        </select>      </tr>
    <tr>
          <td align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >Partida:
      <td bgcolor="#F3F3F3" ><select name="ID_PARTIDA" id="combobox" title="cliente" style="width: 300px; font-size:10px" width="300">
          <option value="" <?php if (!(strcmp("", 0))) {echo "selected=\"selected\"";} ?>></option>
          <?php
do {  
?>
          <option value="<?php echo $row_proveeedor['ID']?>"<?php if (!(strcmp($row_proveeedor['DESCRIPCION_COMPLETA'], 0))) {echo "selected=\"selected\"";} ?>>[ID:<?php echo $row_proveeedor['ID']?>] <?php echo $row_proveeedor['DESCRIPCION_COMPLETA']?></option>
          <?php
} while ($row_proveeedor = mysql_fetch_assoc($proveeedor));
  $rows = mysql_num_rows($proveeedor);
  if($rows > 0) {
      mysql_data_seek($proveeedor, 0);
	  $row_proveeedor = mysql_fetch_assoc($proveeedor);
  }
?>
        </select>
      	<input name="DETALLE" type="checkbox" id="DETALLE" value="1" />
      	<label for="DETALLE"></label>
      	Detalle
      </tr>
    <!--<tr>
    	<td align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >Nivel:<td bgcolor="#F3F3F3" ><label for="NIVEL"></label>
    		<select name="NIVEL" id="NIVEL">
			<option value="">Todos</option>
    			<?php
do {  
?>
    			<option value="AND NIVEL=<?php echo $row_nivel['NIVEL']?>">Nivel <?php echo $row_nivel['NIVEL']?></option>
    			<?php
} while ($row_nivel = mysql_fetch_assoc($nivel));
  $rows = mysql_num_rows($nivel);
  if($rows > 0) {
      mysql_data_seek($nivel, 0);
	  $row_nivel = mysql_fetch_assoc($nivel);
  }
?>
			</select>
    	</tr>-->
    <tr>
          <td colspan="2" align="left" >
              <div class="validity-summary-container" style="color:#F00">
    
    <ul></ul>
</div></tr>

          <td colspan="2" align="center" bgcolor="#999999" class="textos_form" ><input name="button" type="submit" class="ui-widget-header" id="button" value="Buscar" />
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

mysql_free_result($nivel);
?>

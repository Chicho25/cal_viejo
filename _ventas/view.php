<?php include('../include/header.php'); ?>

<?php
/*Definiciones*/
$formulario="venta01";
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

$colname_vendedores = "-1";
if (isset($_GET['ID_INMUEBLES_MOV'])) {
  $colname_vendedores = $_GET['ID_INMUEBLES_MOV'];
}
mysql_select_db($database_conexion, $conexion);
$query_vendedores = sprintf("SELECT * FROM vista_ventas_comisiones WHERE ID_INMUEBLES_MOV = %s", GetSQLValueString($colname_vendedores, "int"));
$vendedores = mysql_query($query_vendedores, $conexion) or die(mysql_error());
$row_vendedores = mysql_fetch_assoc($vendedores);
$totalRows_vendedores = mysql_num_rows($vendedores);

mysql_select_db($database_conexion, $conexion);
$query_proveeedor = "SELECT * FROM pro_cli_master WHERE tipo=2 or tipo=3";
$proveeedor = mysql_query($query_proveeedor, $conexion) or die(mysql_error());
$row_proveeedor = mysql_fetch_assoc($proveeedor);
$totalRows_proveeedor = mysql_num_rows($proveeedor);

$colname_CONSULTA = "-1";
if (isset($_GET['ID_INMUEBLES_MOV'])) {
  $colname_CONSULTA = $_GET['ID_INMUEBLES_MOV'];
}
mysql_select_db($database_conexion, $conexion);
$query_CONSULTA = sprintf("SELECT * FROM vista_ventas WHERE ID_INMUEBLES_MOV = %s", GetSQLValueString($colname_CONSULTA, "int"));
$CONSULTA = mysql_query($query_CONSULTA, $conexion) or die(mysql_error());
$row_CONSULTA = mysql_fetch_assoc($CONSULTA);
$totalRows_CONSULTA = mysql_num_rows($CONSULTA);
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

 
$.validity.setup({ outputMode:"summary" });

	$("form").validity(function() {
		$("#monto")
			.require('Monto Requerido')
			.match("number", 'Debe ser numerico')
		$("#combo1")
			.require('Monto Requerido')
			.match("number", 'Debe seleccionar un proyecto')
		$("#GRUPO")
			.require('Monto Requerido')
			.match("number", 'Debe seleccionar un grupo')
		$("#INMUEBLE")
			.require('Monto Requerido')
			.match("number", 'Debe seleccionar un inmueble')
		$("#combobox")
			.require('Debe seleccionar un cliente')
			.match("number", 'Debe seleccionar un inmueble')
		
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

	
	$("#combo1").change(function () {
   		$("#combo1 option:selected").each(function () {
			//alert($(this).val());
				elegido=$(this).val();
				$.post("_grupos.php", { COD_PROYECTOS_MASTER: elegido }, function(data){
				$("#GRUPO").html(data);
				$("#INMUEBLE").html("<option>Seleccione...................</option>");
			});			
        	});
   	})
	// Parametros para el combo2
	$("#GRUPO").change(function () {
   		$("#GRUPO option:selected").each(function () {
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
          <td width="100%" align="center" class="textos_form"><div class="titulo_formulario"> Ver Venta</div>
    </tr>
  </table><?php include("_menu.php"); ?><form action="_add.php" method="get" id="enviar">
      <table width="1100" align="center" >
    <tr>
          <td width="40%" align="right" bgcolor="#F3F3F3" class="textos_form_derecha" ><input name="CANTIDAD_VENDEDORES" type="hidden" id="CANTIDAD_VENDEDORES" value="<?php echo $totalRows_vendedores; ?>" />
        Proyecto:
      <td width="70%" bgcolor="#F3F3F3" ><label for="textfield"></label>
        <input name="textfield" type="text" id="textfield" value="<?php echo $row_CONSULTA['PROYECTO']; ?>" readonly="readonly" />
      </tr>
    <tr>
          <td align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >Grupo:
      <td width="70%" bgcolor="#F3F3F3" ><input name="textfield2" type="text" id="textfield2" value="<?php echo $row_CONSULTA['NOMBRE_GRUPO']; ?>" readonly="readonly" />
      </tr>
    <tr>
          <td align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >Inmueble:
      <td width="70%" bgcolor="#F3F3F3" ><input name="textfield3" type="text" id="textfield3" value="<?php echo $row_CONSULTA['NOMBRE_INMUEBLE']; ?>" size="60" readonly="readonly" />
      </tr>
    <tr>
          <td align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >Fecha:
      <td width="70%" bgcolor="#F3F3F3" ><input name="fecha_1" type="text" id="fecha_1" value="<?php echo $row_CONSULTA['FECHA_VENTA']; ?>" readonly="readonly" />
    </tr>
    <tr>
          <td align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >Cliente:
      <td width="70%" bgcolor="#F3F3F3" ><label for="textfield4"></label>
        <input name="textfield4" type="text" id="textfield4" value="<?php echo $row_CONSULTA['NOMBRE_CLIENTE']; ?>" size="100" readonly="readonly" />      </tr>
    <tr>
          <td align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >Monto:
      <td width="70%" bgcolor="#F3F3F3" ><label for="textfield2"></label>
        <input name="monto" type="text" class="textos_form_derecha" id="monto" onblur="calculateSum()" onchange="calculateSum()" value="<?php echo $row_CONSULTA['MONTO_VENTA']; ?>" readonly="readonly" />
    </tr>
    <tr>
          <td align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >Descripcion:
      <td width="70%" bgcolor="#F3F3F3" ><label for="descripcion"></label>
        <textarea name="descripcion" cols="45" rows="5" readonly="readonly" id="descripcion"><?php echo $row_CONSULTA['DESCRIPCION_VENTA']; ?></textarea>
    </tr>
    <tr>
          <td colspan="2" align="left" >
              <div class="validity-summary-container" style="color:#F00">
    
    <ul></ul>
</div>
          <table width="100%" border="0" cellpadding="2" cellspacing="2" class="atable">
              <tr>
              <th colspan="3" class="textos_form">Vendedores</th>
            </tr>
              <?php do { ?>
                <tr>
                <td width="51%"><?php echo $row_vendedores['NOMBRE_VENDEDOR']; ?>
                  <input name="VENDEDOR<?php echo $row_vendedores['ID_CLIENTE']?>" type="hidden" value="<?php echo $row_vendedores['ID_CLIENTE']?>" /></td>
                <td width="20%">
                    <input name="COMISION<?php echo $row_vendedores['ID_CLIENTE']?>" type="text" class=' amr textos_form_derecha' id="amr" value="<?php echo $row_vendedores['PORCENTAJE_COMISION']; ?>" size="4" readonly="readonly" />
                    % Comision</td>
                <td width="29%">&nbsp;</td>
              </tr>
                <?php } while ($row_vendedores = mysql_fetch_assoc($vendedores)); ?>
                                <tr>
                <td width="51%" bgcolor="#CCCCCC">&nbsp;</td>
                <td width="20%" bgcolor="#CCCCCC">&nbsp;</td>
                <td width="29%" bgcolor="#CCCCCC">&nbsp;</td>
            </tr>
            </table>
    </tr>
</table>
    </form>

<?php include("../include/_foot.php"); ?>
</body>
</html>
<?php
mysql_free_result($proyectos);

mysql_free_result($vendedores);

mysql_free_result($CONSULTA);
?>

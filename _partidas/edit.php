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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "enviar")) {
  $updateSQL = sprintf("UPDATE partidas SET MONTO_ESTIMADO=%s, DESCRIPCION=%s, DESCRIPCION_COMPLETA=%s, DESCRIPCION_CORTA=%s WHERE ID=%s",
                       GetSQLValueString($_POST['MONTO_ESTIMADO'], "double"),
                       GetSQLValueString($_POST['DESCRIPCION'], "text"),
					   GetSQLValueString($_POST['DESCRIPCION_COMPLETA'].$_POST['DESCRIPCION'], "text"),
					   GetSQLValueString($_POST['DESCRIPCION_CORTA'].$_POST['DESCRIPCION'], "text"),
					   GetSQLValueString($_POST['ID_PARTIDA'], "int"));
//echo $updateSQL;
  mysql_select_db($database_conexion, $conexion);
$Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
}

$colname_CONSULTA = "-1";
if (isset($_GET['ID_PARTIDA'])) {
  $colname_CONSULTA = $_GET['ID_PARTIDA'];
}
mysql_select_db($database_conexion, $conexion);
$query_CONSULTA = sprintf("SELECT * FROM vista_partidas WHERE ID_PARTIDA = %s", GetSQLValueString($colname_CONSULTA, "int"));
$CONSULTA = mysql_query($query_CONSULTA, $conexion) or die(mysql_error());
$row_CONSULTA = mysql_fetch_assoc($CONSULTA);
$totalRows_CONSULTA = mysql_num_rows($CONSULTA);

/*Definiciones*/
$formulario="Partidas00-Editar";
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
<?php include("../include/menu.php"); ?>

      <table width="1100" align="center" class="ui-widget-header" >
    <tr>
          <td width="100%" align="center" class="textos_form"><div class="titulo_formulario">Editar Partida</div>
    </tr>
  </table>
  <?php //include("../include/funciones.php"); ?>
<?php include("_menu.php"); ?>
<form name="enviar" action="<?php echo $editFormAction; ?>" method="POST" id="enviar">
      <table width="1100" align="center" >
    <tr>
      <td width="398" align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >
<input name="ID_PARTIDA" type="hidden" id="ID_PARTIDA" value="<?php echo $row_CONSULTA['ID_PARTIDA']; ?>" />
Partida: 
      <td align="left" bgcolor="#F3F3F3" ><label for="DESCRIPCION"></label>
      <input name="DESCRIPCION" type="text" id="DESCRIPCION" value="<?php echo $row_CONSULTA['DESCRIPCION']; ?>" size="110" />    
       <?php  $desc=strlen($row_CONSULTA['DESCRIPCION']) ?> 
	   <?php $desc_comp=strlen($row_CONSULTA['DESCRIPCION_COMPLETA']) ?> 
       <?php $desc_cort=strlen($row_CONSULTA['DESCRIPCION_CORTA']) ?> 
	   <?php $TOTAL=$desc_comp -$desc?>
      <?php $TOTAL1=$desc_cort -$desc?></tr>
    <tr>
      <td width="398" align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >Monto Estimado:      
      <td align="left" bgcolor="#F3F3F3" ><label for="MONTO_ESTIMADO"></label>
        <input name="MONTO_ESTIMADO" type="text" class="textos_form_derecha" id="MONTO_ESTIMADO" value="<?php echo $row_CONSULTA['MONTO_ESTIMADO']; ?>" />
        <label for="DESCRIPCION_COMPLETA"></label>
        <input name="DESCRIPCION_COMPLETA"  type="hidden" id="DESCRIPCION_COMPLETA" value="<?php echo $cadena1 = substr($row_CONSULTA['DESCRIPCION_COMPLETA'],0,$TOTAL);$row_CONSULTA['DESCRIPCION_COMPLETA']; ?>" size="40" />
      </tr>
    <tr>
      <td width="398" align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >Monto Asignado:      
      <td align="left" bgcolor="#F3F3F3" ><label for="textfield3"></label>
        <input name="textfield3" type="text" disabled="disabled" class="textos_form_derecha" id="textfield3" value="<?php echo number_format($row_CONSULTA['MONTO_ASIGNADO'],2); ?>" />
        <label for="DESCRIPCION_CORTA"></label>
        <input name="DESCRIPCION_CORTA" type="hidden" id="DESCRIPCION_CORTA" value="<?php echo $cadena1 = substr($row_CONSULTA['DESCRIPCION_CORTA'],0,$TOTAL1);$row_CONSULTA['DESCRIPCION_CORTA']; ?>" size="40" />
      </tr>
    <tr>
      <td width="398" align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >Monto Pagado:      
      <td align="left" bgcolor="#F3F3F3" ><label for="textfield4"></label>
        <input name="textfield4" type="text" disabled="disabled" class="textos_form_derecha" id="textfield4" value="<?php echo number_format($row_CONSULTA['MONTO_PAGADO'],2); ?>" />
      </tr>
    <tr>
      <td width="398" align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >Monto Estimado Disponible:      
      <td align="left" bgcolor="#F3F3F3" ><label for="textfield5"></label>
        <input name="textfield5" type="text" disabled="disabled" class="textos_form_derecha" id="textfield5" value="<?php echo number_format($row_CONSULTA['MONTO_ESTIMADO_DISPONIBLE'],2); ?>" />
      </tr>
    <tr>
          <td colspan="2" align="left" >
              <div class="validity-summary-container" style="color:#F00">
    
    <ul></ul>
</div></tr>

          <td colspan="2" align="center" bgcolor="#999999" class="textos_form" ><input name="button" type="submit" class="ui-widget-header" id="button" value="Guardar" /></tr>
</table>
      <input type="hidden" name="MM_update" value="enviar" />
</form>


<?php include("../include/_foot.php"); ?>
</body>
</html>
<?php
mysql_free_result($CONSULTA);

?>

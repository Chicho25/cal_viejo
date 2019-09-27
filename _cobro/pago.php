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
$query_proveeedor = "SELECT * FROM pro_cli WHERE tipo=2 or tipo=3";
$proveeedor = mysql_query($query_proveeedor, $conexion) or die(mysql_error());
$row_proveeedor = mysql_fetch_assoc($proveeedor);
$totalRows_proveeedor = mysql_num_rows($proveeedor);

$colname_PROYECTO = "-1";
if (isset($_POST['CODIGO'])) {
  $colname_PROYECTO = $_POST['CODIGO'];
}
mysql_select_db($database_conexion, $conexion);
$query_PROYECTO = sprintf("SELECT NOMBRE FROM proyectos WHERE CODIGO = %s", GetSQLValueString($colname_PROYECTO, "text"));
$PROYECTO = mysql_query($query_PROYECTO, $conexion) or die(mysql_error());
$row_PROYECTO = mysql_fetch_assoc($PROYECTO);
$totalRows_PROYECTO = mysql_num_rows($PROYECTO);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<title>Untitled Document</title>
<script src="../js/jquery-1.4.2.min.js" language="javascript"></script>
<script src="../js/jquery-ui-1.8.5.custom.min.js" language="javascript"></script>
<script src="../js/jquery.ui.datepicker-es.js" language="javascript"></script>
<script src="../js/jquery.infieldlabel.min.js" language="javascript"></script>
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<title>Untitled Document</title>
<link href="../js/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
<link href="../css/form.css" rel="stylesheet" type="text/css" />

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

<script>
$(function() {

$("#tipo_pago").change(function () {
elegido=$(this).val();
//alert("si");
switch(elegido){
case "1":	
$("#cheque").hide();
$("#intercambio").hide();
$("#transferencia").hide();
$("#carta_credito").hide();
$("#deposito").hide();
break;
case "2":	
$("#cheque").show();
$("#intercambio").hide();
$("#transferencia").hide();
$("#carta_credito").hide();
$("#deposito").hide();
break;
case "3":	
$("#cheque").hide();
$("#intercambio").show();
$("#transferencia").hide();
$("#carta_credito").hide();
$("#deposito").hide();
break;
case "4":	
$("#cheque").hide();
$("#intercambio").hide();
$("#transferencia").show();
$("#carta_credito").hide();
$("#deposito").hide();
break;
case "5":	
$("#cheque").hide();
$("#intercambio").hide();
$("#transferencia").hide();
$("#carta_credito").show();
$("#deposito").hide();
break;
case "6":	
$("#cheque").hide();
$("#intercambio").hide();
$("#transferencia").hide();
$("#carta_credito").hide();
$("#deposito").show();
break;
}


});

//////////////////////////

$('input[title]').each(function() {
if($(this).val() === '') {
$(this).val($(this).attr('title'));	
}

$(this).focus(function() {
if($(this).val() == $(this).attr('title')) {
$(this).val('').addClass('focused');	
}
});
$(this).blur(function() {
if($(this).val() === '') {
$(this).val($(this).attr('title')).removeClass('focused');	
}
});
});

///////////////////////////////////////




});
</script>
<?php 
$visivilidad="none";
?>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../css/menu_style.css" type="text/css" media="all" />
<link href="../../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php $opcion_menu=2; ?>
<?php include("../include/menu.php"); ?>

<table width="1100" align="center" class="ui-widget-header" >
	<tr>
		<td width="100%" align="center" class="textos_form"><div class="titulo_formulario">Cobro - <?php echo $row_PROYECTO['NOMBRE']; ?></div>
	</tr>
</table><form action="pago2.php" method="POST">
<table width="1100" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td align="center" bgcolor="#F0F0F0" class="textos_form"><br />
		  Cliente: 
			<span id="spryselect1">
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
			<span class="selectRequiredMsg">Seleccione</span></span><br />
			<input name="button" type="submit" class="textos_form" id="button" value="Siguiente" />
	  <input type="hidden" name="CODIGO" id="CODIGO" value="<?php echo $_POST['CODIGO']; ?>" /></td>
		</tr>
</table></form>
<script type="text/javascript">
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
</script>
</body>
</html>
<?php
mysql_free_result($proveeedor);

mysql_free_result($PROYECTO);

?>

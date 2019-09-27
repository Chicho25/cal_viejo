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

$colname_PROYECTO = "-1";
if (isset($_GET['CODIGO'])) {
  $colname_PROYECTO = $_GET['CODIGO'];
}
mysql_select_db($database_conexion, $conexion);
$query_PROYECTO = sprintf("SELECT * FROM proyectos WHERE CODIGO = %s", GetSQLValueString($colname_PROYECTO, "text"));
$PROYECTO = mysql_query($query_PROYECTO, $conexion) or die(mysql_error());
$row_PROYECTO = mysql_fetch_assoc($PROYECTO);
$totalRows_PROYECTO = mysql_num_rows($PROYECTO);


/*Definiciones*/
$formulario="Partidas00-Editar";
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
<title>Untitled Document</title>
<?php //include('../include/funciones.php'); ?>
<?php include("../include/_js.php"); ?>
<?php include("../include/_css.php"); ?>

<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
</head>

<body style="font-family:Verdana, Geneva, sans-serif; font-size:12px">
<?php $opcion_menu=2; ?>


      <table width="1100" align="center" class="ui-widget-header" >
    <tr>
          <td width="100%" align="center" class="textos_form"><div class="titulo_formulario">Insertar Partida</div>
    </tr>
  </table>
<?php include("../_partidas/_menu.php"); ?>
<form action="index_add.php" method="get" name="form1" id="form1">
      <table width="1100" align="center" >
	      <tr>
      <td width="398" align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >

Proyecto: 
      <td align="left" bgcolor="#F3F3F3" ><label for="NOMBRE_PROYECTO"></label>
      	<input name="NOMBRE_PROYECTO" type="text" class="textos_form" id="NOMBRE_PROYECTO" value="<?php echo $row_PROYECTO['NOMBRE']; ?>" size="50" readonly="readonly" />
      	<input name="CODIGO" type="hidden" id="CODIGO" value="<?php echo $row_PROYECTO['CODIGO']; ?>" />      </tr>
		 <?php 
	  $nombre_campo="Partida Grupo";
	  $where=" WHERE ALICUOTA=0 AND TIPO=1 AND COD_PROYECTO=".$_GET['CODIGO'];
	  ?>
	  
	  
	  <style>
	.ui-button { margin-left: -1px; }
	.ui-button-icon-only .ui-button-text { padding: 0.35em; } 
	.ui-autocomplete-input { margin: 0; padding: 0.48em 0 0.47em 0.45em; width:500px; font-family:Arial, Helvetica, sans-serif; font-size:13px; font-weight:bolder }
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
<?php 
mysql_select_db($database_conexion, $conexion);
$query_PARTIDA = "SELECT ID, DESCRIPCION_COMPLETA FROM partidas ".$where;
$PARTIDA = mysql_query($query_PARTIDA, $conexion) or die(mysql_error());
$row_PARTIDA = mysql_fetch_assoc($PARTIDA);
$totalRows_PARTIDA = mysql_num_rows($PARTIDA);

if ($totalRows_PARTIDA==0){ ?>
	<script type="text/javascript">
window.location = "index_add_primera.php?CODIGO=<?php echo $_GET['CODIGO']; ?>"
</script>
<?php } ?>
<tr>
	<td align="right" bgcolor="#F3F3F3" class="textos_form_derecha" ><?php echo $nombre_campo ?>
	<td align="left" bgcolor="#F3F3F3" ><span id="spryselect1">
	<select id="combobox" name="ID_PARTIDA" width="300" style="width: 300px; font-size:10px">
		<option value="" <?php if (!(strcmp(" ", 0))) {echo "selected=\"selected\"";} ?>></option>
		<?php
			do {  
			?>
		<option value="<?php echo $row_PARTIDA['ID']?>" selected="selected"<?php if (!(strcmp($row_PARTIDA['ID'], 0))) {echo "selected=\"selected\"";} ?>>[ID:<?php echo $row_PARTIDA['ID']?>] <?php echo $row_PARTIDA['DESCRIPCION_COMPLETA']?></option>
		<?php
			} while ($row_PARTIDA = mysql_fetch_assoc($PARTIDA));
  			$rows = mysql_num_rows($PARTIDA);
  			if($rows > 0) {
      			mysql_data_seek($PARTIDA, 0);
	  			$row_PARTIDA = mysql_fetch_assoc($PARTIDA);
  			}
			?>
	</select>
	<span class="selectRequiredMsg">Seleccione la Partida.</span></span>		<?php
		mysql_free_result($PARTIDA);
		?>
</td>
</tr>

	  
	  
    <tr>
      <td width="311" align="right" bgcolor="#F3F3F3" class="textos_form_derecha" >Tipo:      
      <td align="left" bgcolor="#F3F3F3" ><label for="TIPO"></label>
      	<select name="TIPO" id="TIPO">
      		<option value="1" selected="selected">Grupo</option>
      		<option value="2">Movimiento</option>
      		</select>
      	<label for="MONTO_DISPONIBLE"></label></tr>
    <tr>
    	<td colspan="2" align="left" >
    		<div class="validity-summary-container" style="color:#F00">
    			
    			<ul></ul>
</div></tr>

          <td colspan="2" align="center" bgcolor="#999999" class="textos_form" ><input name="button" type="submit" class="ui-widget-header" id="button" value="Siguiente" /></tr>
</table>
</form>
<p>&nbsp;</p>
<?php include("../include/_foot.php"); ?>
<script type="text/javascript">
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
</script>
</body>
</html>
<?php
mysql_free_result($PROYECTO);
?>

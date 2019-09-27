
<?php /*require_once('../../Connections/conexion.php'); ?>
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
*/
$colname_PAGOS = "-1";
if (isset($_GET['ID_PAGO'])) {
  $colname_PAGOS = $_GET['ID_PAGO'];
}
mysql_select_db($database_conexion, $conexion);
$query_PAGOS = sprintf("SELECT * FROM vista_pagos_partidas WHERE ID_PAGO = %s", GetSQLValueString($colname_PAGOS, "int"));
$PAGOS = mysql_query($query_PAGOS, $conexion) or die(mysql_error());
$row_PAGOS = mysql_fetch_assoc($PAGOS);
$totalRows_PAGOS = mysql_num_rows($PAGOS);

mysql_select_db($database_conexion, $conexion);
$query_CHEQUE = "SELECT * FROM vista_banco_chequeras WHERE ID_CHEQUERA = '".$_GET['CUENTA']."'";
$CHEQUE = mysql_query($query_CHEQUE, $conexion) or die(mysql_error());
$row_CHEQUE = mysql_fetch_assoc($CHEQUE);
$totalRows_CHEQUE = mysql_num_rows($CHEQUE);
?>
<?php //include("../include/_js.php"); ?>
<?php //include("../include/_css.php"); ?>
<?php 
$visivilidad="none";
?>
<script type="text/javascript">
$("document").ready
	(function()

		
		//////////////funcion de numeros a letras
		{$("#MONTO").change(function () { 
		
		if($(this).val()!=' '){//alert($(this).val());
						$("#MONTO").each(
								function () {
								//alert($(this).val());
									$.post("../include/letras.php", 
									{NUM: $(this).val()}, function(data)
									{
										//$(".letra").val(data);
										$(".letra").html(data);	
										$("#MONTO_LETRAS").val(data);														
										
				});	
        	});} 
				
   	})
})
</script>
<script>
$(document).ready(function(){

        var current_id;

        $("#dialog-confirm").dialog({
            resizable: false,
            height:200,
            modal: true,
            autoOpen:true,
            buttons: {
                'Cancelar': function() {
                    $(this).dialog('close');
                },
                'Guardar': function() {
                    $(this).dialog('close');
                    DoSomething();
                }
            }
        });
            
    });
    
        
        // open dialog, set variable
        function openDialog() {
            //current_id = id;
            $("#dialog-confirm").dialog('open');
            };
            
         // Do something if OK
        function DoSomething() {
			//alert($("form.BENEFICIARIO").val());
            //local_id = current_id;
			var url = "_add.php?BENEFICIARIO=<?php echo $_GET['BENEFICIARIO']; ?>&MONTO=<?php echo $_GET['MONTO']; ?>&CHEQUE=<?php echo $_GET['CHEQUE']; ?>&DESCRIPCION=<?php echo $_GET['DESCRIPCION']; ?>&ID_CUENTA_BANCARIA=<?php echo $_GET['CUENTA']; ?>"; 
			window.location =   url; 
		$(location).attr('href',url);
            //alert('Test ' + url);
        };

</script>
<?php $opcion_menu=2; ?>
<?php //include("../include/menu.php"); ?>
<form action="_add.php" method="get" target="pdf">
  <table width="1100" border="0" cellpadding="2" cellspacing="2" align="center">
	<tr>
	  <td width="346" bgcolor="#F0F0F0" class="textos_form_derecha">Cheque:</td>
	  <td bgcolor="#F0F0F0" class="textos_form"><input name="CHEQUE" type="text" class="textos_form_derecha" value="<?php echo $_GET['cheque'] ?>" readonly />
	    <span class="textos_form_derecha">
	    <input type="hidden" name="CUENTA" id="CUENTA"  value="<?php echo $row_CHEQUE['ID_CHEQUERA']; ?>"/>
        <input type="hidden" name="CODIGO_PROYECTO" id="CODIGO_PROYECTO"  value="<?php echo $row_CHEQUE['CODIGO_PROYECTO']; ?>"/>
        <input type="hidden" name="ID_CTA_BANCARIA" id="ID_CTA_BANCARIA"  value="<?php echo $row_CHEQUE['ID_CUENTA_BANCARIA']; ?>"/>

      </span></td>
    </tr> 
	
	<tr>
	  <td rowspan="2" bgcolor="#F0F0F0" class="textos_form_derecha">Monto Cheque:</td>
	  <td width="654" bgcolor="#F0F0F0" class="textos_form"><input name="MONTO" type="text" class="textos_form_derecha" value="<?php echo $_GET['MONTO'] ?>" readonly /></td>
    </tr>
	<tr>
		<td bgcolor="#F0F0F0" class="textos_form"><div class="letra" id="letra"></div><input name="MONTO_LETRAS" type="hidden" value="<?php echo $GET['MONTO_LETRAS']; ?>" /></td>
	</tr>
	<tr>
	  <td bgcolor="#F0F0F0" class="textos_form_derecha">Cuenta:</td>
	  <td bgcolor="#F0F0F0" class="textos_form"><input name="textfield" type="text" class="textos_form" id="textfield" value="<?php echo $row_CHEQUE['NUMERO_CUENTA']; ?>" size="70" readonly /></td>
    </tr>
	<tr>	<?php  
 $MONTO=$_GET['MONTO'];
$r=($MONTO-intval($MONTO))*100; 

?>
	  <td bgcolor="#F0F0F0" class="textos_form_derecha"><input type="hidden" name="DESCRIPCION" id="DESCRIPCION" value="<?php echo $_GET['DESCRIPCION'] ?>" />
      Beneficiario:</td>
	  <td width="654" bgcolor="#F0F0F0"><input name="BENEFICIARIO" type="text" class="textos_form" value="<?php echo $_GET['BENEFICIARIO'] ?>" size="80" />
      <input type="hidden" name="MONTO_LETRAS" id="MONTO_LETRAS" value="<?php echo $_GET['MONTO_LETRAS'] ?>" />
      </td>
    </tr>


	<tr>
	  <td colspan="2" align="center" bgcolor="#F0F0F0" class="textos_form"><input name="button3" type="submit" class="ui-widget-header" id="button3" value="Guardar" />	    <input name="button" type="button" class="ui-state-error" id="button" value="Anular Cheque" onClick="window.location='cheque_anulado.php?CHEQUE=<?php echo $_GET['cheque'] ?>'" /></td>
	</tr>
</table>
</form><center>
<?php if($MONTO > 0){?>
<iframe height="400" width="1000" src="print.php?ID_PAGO=<?php echo $_GET['ID_PAGO'] ?>&BENEFICIARIO=<?php echo $_GET['BENEFICIARIO'] ?>&DESCRIPCION=<?php echo $_GET['DESCRIPCION'] ?>&MONTO=<?php echo $_GET['MONTO'] ?>&MONTO_LETRAS=<?php echo $_GET['MONTO_LETRAS'] ?>"></iframe>
<?php }?></center>

<div id="dialog-confirm" title="Impresion Correcta?">
	<p><span class="ui-icon-document" style="float:left; margin:0 7px 20px 0;"></span>
  Espere unos segundos, e imprima el cheque.<br>Si la impresion es correcta, proceda a guardar el pago</p>
</div>
<?php
mysql_free_result($PAGOS);

mysql_free_result($CHEQUE);
?>

<?php include('../Connections/conexion.php'); ?> 

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

$colname_rst_pagos_deta = "-1";
if (isset($_POST['ID_PRO_CLI'])) {
  $colname_rst_pagos_deta = $_POST['ID_PRO_CLI'];
   $mt=0;
  $mp=0;
 
}
mysql_select_db($database_conexion, $conexion);

$query_rst_pagos_deta = sprintf("SELECT * FROM vista_documentos WHERE MODULO=".$_POST['MODULO']." AND STATUS_DOCUMENTO=1  AND COD_PROYECTO=".$_POST['PROYECTO']." AND ID_PRO_CLI = %s", GetSQLValueString($colname_rst_pagos_deta, "int"));
$rst_pagos_deta = mysql_query($query_rst_pagos_deta, $conexion) or die(mysql_error());
$row_rst_pagos_deta = mysql_fetch_assoc($rst_pagos_deta);
$totalRows_rst_pagos_deta = mysql_num_rows($rst_pagos_deta);
?>


<?php
$input=0;
$fmonto=0;
?>
<form action="../pagos/guardar_sp.php" method="get" name="pagos">
<?php
if($totalRows_rst_pagos_deta>0){?>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />

<table width="990" border="0" align="center">
  <tr align="center" valign="middle">
       <td><input name="txt2" type="text" disabled="disabled" id="txt2" style="background:#ffcaca" size="4" maxlength="4" readonly="readonly" /> 
      Documentos Vencidos</td>
    <td><input name="txt3" type="text" disabled="disabled" id="txt3" style="background:#ffffff" size="4" maxlength="4" readonly="readonly" /> 
      Documentos No vencidos</td>
  </tr>
</table>
<table width="990" border="0" align="center" bgcolor="#CCCCCC">
  <tr align="center" bgcolor="#CCCCCC"  class="ui-widget-header">
    <td width="50" class="ui-widget-header">ID</td>
    <td width="50">Tipo</td>
    <td width="50">Numero</td>
    <td width="50">Fecha</td>
    <td width="50">Vencimiento</td>
    <td>Descripcion</td>
    <td width="100">Monto Total</td>
    <td width="100">Monto Pendiente</td>
    <td width="150">Monto a Pagar</td>
      </tr>
  <?php do { 
  $mt=$mt+$row_rst_pagos_deta['MONTO_DOCUMENTO'];
  $mp=$mp+$row_rst_pagos_deta['MONTO_PENDIENTE'];
 $input=$input+1;
  $fmonto=$row_rst_pagos_deta['MONTO_PENDIENTE'];
  ?>
  
    <tr <?php if($row_rst_pagos_deta['VENCIDO']==1){ echo 'style="background:#ffcaca"';} else {echo 'style="background:#ffffff"';}?>>
      <td align="center"><?php echo $row_rst_pagos_deta['ID_DOCUMENTO']; ?>
      <input type="hidden" name="ID_DOCUMENTO_<?php echo $input; ?>" id="ID_DOCUMENTO_<?php echo $input; ?>" value="<?php echo $row_rst_pagos_deta['ID_DOCUMENTO']; ?>" /></td>
      <td align="center"><?php echo $row_rst_pagos_deta['TIPO_DOCUMENTO']; ?></td>
      <td align="center"><?php echo $row_rst_pagos_deta['NUMERO_DOCUMENTO']; ?></td>
      <td><?php echo $row_rst_pagos_deta['FECHA_DOCUMENTO']; ?></td>
      <td><?php echo $row_rst_pagos_deta['FECHA_VENCIMIENTO']; ?></td>
      <td><?php echo $row_rst_pagos_deta['DESCRIPCION_DOCUMENTO']; ?></td>
      <td align="right"><?php echo number_format($row_rst_pagos_deta['MONTO_DOCUMENTO'],2,'.',',') ?></td>
      <td align="right"><?php echo number_format($row_rst_pagos_deta['MONTO_PENDIENTE'],2,'.',',') ?></td>
      <td width="100" align="center"><label for="todo"></label>
        <input name="monto<?php echo $input; ?>"  value="0" type="text" class="quantity textos_form_derecha" id="monto_<?php echo $input; ?>" size="6" onblur="calculateTotal();" onchange="calculateTotal();" />
        <input type="checkbox" name="checkbox" id="total_<?php echo $input; ?>" onchange="valor(<?php echo $input; ?>,<?php echo $fmonto; ?>)" />
        <label for="checkbox">Total</label></td>
    </tr>
    <?php } while ($row_rst_pagos_deta = mysql_fetch_assoc($rst_pagos_deta)); ?>
</table>
<table width="990" border="0" align="center" bgcolor="#CCCCCC">
  <tr align="center">
    <td align="right" bgcolor="#FFFFFF">Totales</td>
    <td width="100" bgcolor="#FFFFFF" align="right"><?php echo number_format($mt,2,'.',',') ?></td>
    <td width="100" bgcolor="#FFFFFF" align="right"><?php echo number_format($mp,2,'.',',') ?></td>
    <td width="150" align="center" bgcolor="#FFFFFF" ><label for="textfield"></label>
      <span id="spry_monto_total">
      <input name="total_quantity" type="text" id="total_quantity" onchange="valor(<?php echo $input ?>)"  value="0" size="10" readonly="readonly" />
     <span class="textfieldRequiredMsg">No se a seleccionado ningun documento a cancelar.</span></span> Totales</td>
  </tr>
</table>

<?php 
$input;
$CODIGO_PROYECTO=$_POST['PROYECTO'];
$modulo=$_POST['MODULO'];
$titulo_formulario=$_POST['FORMULARIO'];

include("form.php");?>
<?php }else{ 
echo  '<script language="javascript">alert("No hay documentos pendientes");</script>';	?>
<?php } ?>
<?php

mysql_free_result($rst_pagos_deta);
?>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("spry_monto_total", "none", {validateOn:["blur"]});
</script>

<?php 
//include('../connections/conexion.php');

mysql_select_db($database_conexion, $conexion);

$query_rst_pagos = "SELECT * FROM vista_pagos where modulo=".$modulo." ORDER BY ID_PAGO ASC";

//echo $query_rst_pagos;
$rst_pagos = mysql_query($query_rst_pagos, $conexion) or die(mysql_error());
$row_rst_pagos = mysql_fetch_assoc($rst_pagos);
$totalRows_rst_pagos = mysql_num_rows($rst_pagos);
?>
<table width="990" border="0" align="center" bgcolor="#CCCCCC">
  <tr align="center" bgcolor="#CCCCCC"  class="ui-widget-header">
    <td width="50" class="ui-widget-header">ID</td>
    <td width="50">Proyecto</td>
    <td width="80"><?php if($_GET['modulo']==1){ ?> Proveedor <?php } else { ?> Cliente <?php } ?></td>
    <td>Descripcion</td>
    <td width="50">Tipo</td>
    <td width="50">Numero</td>
    <td width="50">Fecha</td>
    <td width="50">Monto</td>
    <td  width="96"colspan="4">Opciones</td>
  </tr>
  <?php do { ?>
    <tr bgcolor="#FFFFFF">
      <td><?php echo $row_rst_pagos['ID_PAGO']; ?></td>
      <td><?php echo $row_rst_pagos['NOMBRE_PROYECTO']; ?></td>
      <td><?php echo $row_rst_pagos['NOMBRE_PRO_CLI']; ?></td>
      <td><?php echo htmlentities($row_rst_pagos['DESCRIPCION_PAGO']); ?></td>
      <td><?php echo $row_rst_pagos['TIPO_PAGO']; ?></td>
      <td><?php echo $row_rst_pagos['NUMERO_PAGO']; ?></td>
      <td><?php echo $row_rst_pagos['FECHA']; ?></td>
      <td><?php echo $row_rst_pagos['MONTO_PAGADO']; ?></td>
      <td align="center"><a href="../documentos/pago_detalle_doc.php?ID_DOCUMENTO=&amp;elegido=&amp;col=FECHA_DOCUMENTO&amp;orden=asc&amp;TIPO=0&amp;PROYECTO=0&amp;STATUS=Todos&amp;ID_PAGO=<?php echo $row_rst_pagos['ID_PAGO']; ?>" title="Ver Documento Asociado a este pago"><img src="../img/edit_find.png" width="32" height="32"></a></td>
<!--      <td align="center"><img src="../img/write.png" width="32" height="32"></td>
-->      <?php if ($_GET['modulo']==1){ ?><td align="center"><?php if (($row_rst_pagos['TIPO_PAGO']=='CHEQUE')&&($row_rst_pagos['NUMERO_PAGO']=='')){ ?>
	      <a href="../_banco/add.php?ID_PAGO=<?php echo $row_rst_pagos['ID_PAGO']; ?>"><img src="../img/Cheque1.jpg" width="42" height="32" title="Emitir cheque" /></a>
	      <?php }?></td><?php } ?>
      <?php  if (validador($menu,$_SESSION['i'],"eli")==1) {?><td align="center"><a href="del02.php?titulo_formulario=<?php echo $_GET['titulo_formulario'] ?>&menu=<?php echo $menu; ?>&CODIGO=<?php echo $row_rst_pagos['ID_PAGO']; ?>&modulo=<?php echo $modulo ?>" title="Eliminar este Pago" ><img src="../img/button_cancel_256.png" width="32" height="32" title="Eliminar este pago" /></a></td><?php } ?>
    </tr>
    <?php } while ($row_rst_pagos = mysql_fetch_assoc($rst_pagos)); ?>
</table>
	
<?php
mysql_free_result($rst_pagos);
?>

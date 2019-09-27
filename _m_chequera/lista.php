<?php


mysql_select_db($database_conexion, $conexion);
$query_CONSULTAS = "SELECT * FROM vista_banco_chequeras ORDER BY ID_CHEQUERA ASC";
$CONSULTAS = mysql_query($query_CONSULTAS, $conexion) or die(mysql_error());
$row_CONSULTAS = mysql_fetch_assoc($CONSULTAS);
$totalRows_CONSULTAS = mysql_num_rows($CONSULTAS);
?>
<table width="990" align="center" bgcolor="#CCCCCC">
    <tr bgcolor="#CCCCCC"  class="ui-widget-header">
      <td align="center">ID</td>
      <td align="center">Empresa </td>     
      <td align="center">Proyecto</td>      
      <td align="center">Banco</td>      
      <td align="center">Numero</td>      
      <td align="center">Movimiento</td>
      <td align="center">Inicio</td>
      <td align="center">Fin</td>      
    <td colspan="2" align="center">Opciones</td></tr>
          <?php do { ?>
          	<tr valign="middle"  class="Campos">
          		<td align="center"><?php echo $row_CONSULTAS['ID_CHEQUERA']; ?></td>
	          <td><?php echo $row_CONSULTAS['NOMBRE_EMPRESA']; ?></td>                
   		      <td><?php echo $row_CONSULTAS['NOMBRE_PROYECTO']; ?></td>                
   		      <td><?php echo $row_CONSULTAS['NOMBRE_BANCO']; ?></td>                
   		      <td><?php echo $row_CONSULTAS['NUMERO_CUENTA']; ?></td>                
   		      <td><?php echo $row_CONSULTAS['TIENE_MOVIMIENTOS']; ?></td>
   		      <td><?php echo $row_CONSULTAS['CHEQUE_INICIO']; ?></td>
	          <td><?php echo $row_CONSULTAS['CHEQUE_FIN']; ?></td>              
	          <?php if (validador($menu,$_SESSION['i'],"edi")==1){?><td align="center"><a href="index.php?titulo_formulario=<?php echo $_GET['titulo_formulario'] ?>&id_menu=<?php echo $menu; ?>&ID_CHEQUERA=<?php echo $row_CONSULTAS['ID_CHEQUERA']; ?>"><img src="../img/write.png" width="24" height="24" /></a><?php } ?>					
   		  <?php if (validador($menu,$_SESSION['i'],"eli")==1){?><td align="center"><?php if($row_CONSULTAS['TIENE_MOVIMIENTOS']==1){ ?><img src="../image/Delete-iconbw.png" width="24" height="24" /><?php } else { ?><a href="del.php?titulo_formulario=<?php echo $_GET['titulo_formulario'] ?>&id_menu=<?php echo $menu; ?>&ID_CHEQUERA=<?php echo $row_CONSULTAS['ID_CHEQUERA']; ?>"><img src="../image/Delete-icon.png" width="24" height="24" /></a> <?php } ?>				  </td>	<?php } ?>				          	</tr>
          	<?php } while ($row_CONSULTAS = mysql_fetch_assoc($CONSULTAS)); ?>
  </table>

<?php
mysql_select_db($database_conexion, $conexion);
$query_CONSULTAS = "SELECT NOMBRE_EMPRESA, NOMBRE_PROYECTO, NOMBRE_BANCO, BANCO_NACIONAL, ID_CUENTA, NUMERO_CUENTA, DESCRIPCION_CUENTA, TIENE_MOVIMIENTOS, TIENE_CHEQUERAS FROM vista_banco_cuentas";
$CONSULTAS = mysql_query($query_CONSULTAS, $conexion) or die(mysql_error());
$row_CONSULTAS = mysql_fetch_assoc($CONSULTAS);
$totalRows_CONSULTAS = mysql_num_rows($CONSULTAS);
?>


<table align="center" width="1100" bgcolor="#CCCCCC">
    <tr bgcolor="#CCCCCC"  class="ui-widget-header">
      <td width="221" align="center" >Empresa</td>
      <td width="221" align="center" >Proyecto</td>
      <td width="221" align="center" >Banco</td>
      <td width="221" align="center" >Numero de Cuenta</td>
      <td width="221" align="center" >Descripci&oacute;n</td>
      <?php if (validador($_GET['id_menu'],$_SESSION['i'],"edi")==1){?><td width="31" align="center" ></td>	<?php } ?>	
          <?php if (validador($_GET['id_menu'],$_SESSION['i'],"eli")==1){?><td width="30" align="center" ></td><?php } ?>			
          </tr> 
          <?php do { ?>
          	<tr class="Campos">
          	<td align="center"><?php echo $row_CONSULTAS['NOMBRE_EMPRESA']; ?>
            <td align="center"><?php echo $row_CONSULTAS['NOMBRE_PROYECTO']; ?>
            <td align="center"><?php echo $row_CONSULTAS['NOMBRE_BANCO']; ?>
            <td align="center"><?php echo $row_CONSULTAS['NUMERO_CUENTA']; ?><input name="ID_CUENTA_BANCARIA" type="hidden" value="<?php echo $row_CONSULTAS['ID_CUENTA']; ?>" />
            <td align="center"><?php echo $row_CONSULTAS['DESCRIPCION_CUENTA']; ?>				
       		<?php if (validador($_GET['id_menu'],$_SESSION['i'],"edi")==1){?><td align="left" valign="middle" ><a href="index.php?titulo_formulario=<?php echo $_GET['titulo_formulario'] ?>&ID_CUENTA_BANCARIA=<?php echo $row_CONSULTAS['ID_CUENTA']; ?>&id_menu=<?php echo $_GET['id_menu'] ?>"><img src="../img/write.png" width="24" height="24" /></a>	<?php } ?>			
	      <?php if (validador($_GET['id_menu'],$_SESSION['i'],"eli")==1){?><td align="left" valign="middle" ><?php if($row_CONSULTAS['TIENE_MOVIMIENTOS']==1){ ?><img src="../image/Delete-iconbw.png" width="24" height="24" /><?php } else { ?><a href="del.php?titulo_formulario=<?php echo $_GET['titulo_formulario'] ?>&id_menu=<?php echo $_GET['id_menu'] ?>&ID_CUENTA_BANCARIA=<?php echo $row_CONSULTAS['ID_CUENTA']; ?>"><img src="../image/Delete-icon.png" width="24" height="24" /></a> <?php } ?>				  </td> <?php } ?>				          	</tr>
          	<?php } while ($row_CONSULTAS = mysql_fetch_assoc($CONSULTAS)); ?>
	</table>
<?php
mysql_free_result($CONSULTAS);
?>

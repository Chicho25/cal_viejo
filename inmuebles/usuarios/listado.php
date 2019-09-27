<?php 
 mysql_select_db($database_conexion, $conexion);
$query_Recordset1 = "SELECT * FROM usuarios_master";
$Recordset1 = mysql_query($query_Recordset1, $conexion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

?>

    <table width="990" border="0" align="center" bgcolor="#CCCCCC">
  <tr class="ui-widget-header">
    <th width="190" scope="col">Nombre</th>
    <th width="202" scope="col">Apellido</th>
    <th width="313" scope="col">Cargo</th>
    <th width="153" scope="col">Rol</th>
    <th width="153" scope="col">Status</th>
    <th colspan="2" scope="col">Opciones</th>
  </tr>
  <?php do { ?>
    <tr align="center" bgcolor="#FFFFFF" class="Campos">
      <td><?php echo $row_Recordset1['NOMBRES']; ?>
      <input type="hidden" name="titulo_menu" id="titulo_menu" 
      value="<?php echo $_GET['titulo_formulario']; ?>"/></td>
      <td><?php echo $row_Recordset1['APELLIDOS']; ?></td>
      <td><?php echo $row_Recordset1['CARGO']; ?></td>
      <td><?php echo $row_Recordset1['ID_ROLE']; ?></td>
      <td><?php if($row_Recordset1['ACTIVO']==1){echo 'ACTIVO';} else {echo 'INACTIVO';} ?></td>
      <?php if (validador(33,$_SESSION['i'],"edi")==1){?><td width="51" align="center"><p><a href="list.php?ID_USUARIO=<?php echo $row_Recordset1['ID_USUARIO']; ?>&titulo_formulario=<?php echo $_GET['titulo_formulario'] ?>"><img src="../img/write.png" width="32" height="32" /></a></p></td><?php } ?>
      <?php if (validador(33,$_SESSION['i'],"eli")==1){?><td width="55" align="center"><p><a href="del.php?titulo_formulario=<?php echo $_GET['titulo_formulario'] ?>&menu=<?php echo $menu; ?>&ID_USUARIO=<?php echo $row_Recordset1['ID_USUARIO']; ?>"><strong><img src="../img/button_cancel_256.png" width="32" height="32" /></strong></a></p></td><?php } ?>
    </tr>
    <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>

</table>
     <!-- <input type="hidden" name="titulo_menu" id="titulo_menu" 
      value="<?php echo $_GET['titulo_formulario'] ?>"/>-->
<br/>
<?php
mysql_free_result($Recordset1);
?>

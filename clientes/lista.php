<?php 
mysql_select_db($database_conexion, $conexion);
$query_rst_clientes = "SELECT * FROM vista_pro_cli WHERE COD_TIPO IN (2,3)";
$rst_clientes = mysql_query($query_rst_clientes, $conexion) or die(mysql_error());
$row_rst_clientes = mysql_fetch_assoc($rst_clientes);
$totalRows_rst_clientes = mysql_num_rows($rst_clientes);
?>

<link href="../js/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css">

<link href="../css/encabezados.css" rel="stylesheet" type="text/css" />
<table width="990" border="0" align="center">
  <tr align="center" valign="middle">
    <td><input name="txt1" type="text" disabled="disabled" id="txt1" style="background:#b3ffb3" size="4" maxlength="4" readonly="readonly" />
    Con Documentos
    </td>
    <td><input name="txt2" type="text" disabled="disabled" id="txt2" style="background:#ffcaca" size="4" maxlength="4" readonly="readonly" /> 
      Sin Documentos</td>
     </tr>
</table>
<table width="990" border="0" align="center" bgcolor="#CCCCCC">
<tr align="center" class="ui-widget-header">
    <td>Cedula</td>
    <td>Nombre</td>
    <td>Tipo</td>
    <td>Contacto</td>
    <?php if (validador(18,$_SESSION['i'],"eli")==1 || validador(18,$_SESSION['i'],"edi")==1){?><td colspan="2">Opciones</td><?php } ?>
  </tr>
<?php do { ?>
  <tr align="center" class="Campos" <?php if($row_rst_clientes['DOCUMENTOS']==1){ echo 'style="background:#b3ffb3"';/*Verde*/} elseif ($row_rst_clientes['DOCUMENTOS']==0){echo 'style="background:#ffcaca"';/*Rosado*/} else {echo 'style="background:#ffffff"';/*Blanco*/}?>>
    <td width="150"><?php echo $row_rst_clientes['CODIGO']; ?></td>
    <td width="150"><?php echo $row_rst_clientes['NOMBRE']; ?></td>
    <td width="200"><?php echo $row_rst_clientes['TIPO']; ?></td>
    <td width="220"><?php echo $row_rst_clientes['CONTACTO']; ?></td>
    <?php if (validador(18,$_SESSION['i'],"edi")==1){?><td width="50"><?php echo '<a href="list.php?titulo_formulario=Clientes&defecto=0&EDITA=1&ID_PRO_CLI_MASTER='.$row_rst_clientes['ID_PRO_CLI'].'"><img src="../img/write.png" title="Editar" width="32" height="32" /></a>';?></td><?php } ?>
    <?php if (validador(18,$_SESSION['i'],"eli")==1){?><td width="50"><?php if ($row_rst_clientes['DOCUMENTOS']==0){echo '<a href="del.php?ID_PRO_CLI_MASTER='.$row_rst_clientes['ID_PRO_CLI'].'"><img src="../img/button_cancel_256.png" title="Eliminar" width="32" height="32" /></a>';}
	else
	  {echo '';
	  }?></td><?php } ?>
  </tr>
  <?php } while ($row_rst_clientes = mysql_fetch_assoc($rst_clientes)); ?>
</table>

<?php
mysql_free_result($rst_clientes);
?>


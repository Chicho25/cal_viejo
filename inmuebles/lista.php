<?php //include('../include/header.php'); ?>
<?php
mysql_select_db($database_conexion, $conexion);
$query_Recordset1 = "SELECT * FROM vista_inmuebles";
$Recordset1 = mysql_query($query_Recordset1, $conexion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
//echo $_SESSION['i'];
//echo 'en la lista'.$row_rst_acceso['FORMULARIO_INSERT'];
/*echo $view=substr($row_rst_acceso['DETALLE_ACCESO'],0,1);
echo $inc=substr($row_rst_acceso['DETALLE_ACCESO'],1,1);
echo $edi=substr($row_rst_acceso['DETALLE_ACCESO'],2,1);
echo $eli=substr($row_rst_acceso['DETALLE_ACCESO'],3,1);
echo $oth=substr($row_rst_acceso['DETALLE_ACCESO'],4,1);
echo $lib=substr($row_rst_acceso['DETALLE_ACCESO'],5,1);
echo $menu;
echo $usua;
*/?>
<link href="../css/encabezados.css" rel="stylesheet" type="text/css" />

<link href="../js/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />


<table width="990" border="0" align="center">
  <tr align="center" valign="middle">
    <td><input name="txt1" type="text" disabled="disabled" id="txt1" style="background:#b3ffb3" size="4" maxlength="4" readonly="readonly" />
    Disponibles
    </td>
    <td><input name="txt2" type="text" disabled="disabled" id="txt2" style="background:#ffcaca" size="4" maxlength="4" readonly="readonly" /> 
      Reservados</td>
    <td><input name="txt3" type="text" disabled="disabled" id="txt3" style="background:#ffffff" size="4" maxlength="4" readonly="readonly" /> 
      Vendidos</td>
  </tr>
</table>
<table width="990" border="0" align="center" bgcolor="#CCCCCC">
  <tr align="center" bgcolor="#CCCCCC"  class="ui-widget-header">
    <td width="50" class="ui-widget-header">Proyecto</td>
    <td width="50">Grupo</td>
    <td width="50">Inmueble</td>
    <td width="50">Hab.</td>
    <td width="50">Sanit.</td>
    <td width="50">Dep.</td>
    <td width="50">Estac.</td>
    <td width="50">Tipo</td>
    <td width="50">Modelo</td>
    <td width="50">Area mt2</td>
    <td width="50">Precio </td>
<?php if (validador(15,$_SESSION['i'],"eli")==1 || validador(15,$_SESSION['i'],"edi")==1 || validador(15,$_SESSION['i'],"oth")==1){?><td colspan="3"  class="ui-widget-header">Opciones</td><?php } ?>
  </tr>
  <?php do { ?>
    <tr align="center" class="Campos" <?php if($row_Recordset1['VENDIDO']==0){ echo 'style="background:#b3ffb3"';} elseif ($row_Recordset1['VENDIDO']==2){echo 'style="background:#ffcaca"';} else {echo 'style="background:#ffffff"';}?>>
      <td width="50"><?php echo $row_Recordset1['NOMBRE_PROYECTO']; ?></td>
      <td width="50"><?php echo $row_Recordset1['NOMBRE_GRUPO']; ?></td>
      <td width="50"><?php echo $row_Recordset1['NOMBRE_INMUEBLE']; ?></td>
      <td width="50"><?php echo $row_Recordset1['HABITACIONES']; ?></td>
      <td width="50"><?php echo $row_Recordset1['SANITARIOS']; ?></td>
      <td width="50"><?php echo $row_Recordset1['DEPOSITOS']; ?></td>
      <td width="50"><?php echo $row_Recordset1['ESTACIONAMIENTOS']; ?></td>
      <td width="50"><?php echo $row_Recordset1['NOMBRE_TIPO']; ?></td>
       <td width="50"><?php echo $row_Recordset1['MODELO']; ?></td>
      <td width="50"><?php echo $row_Recordset1['AREA']; ?></td>
      <td width="50"><?php echo $row_Recordset1['PRECIO_REAL']; ?></td>
      <td width="50"><?php 
	    if ($row_Recordset1['VENDIDO']==0){if (validador1(15,$_SESSION['i'],"oth")==1){echo '<a href="list.php?lista=1&titulo_formulario=Inmuebles&defecto=0&ID_INMUEBLE_MASTER_RESERVA='.$row_Recordset1['ID_INMUEBLE'].'"><img src="../img/Disponible.png" title="Reservar" width="70" height="30" /></a>';}}
		elseif ($row_Recordset1['VENDIDO']==2){if (validador1(15,$_SESSION['i'],"lib")==1){echo '<a href="liberar.php?lista=1&titulo_formulario=Inmuebles&defecto=0&ID_INMUEBLE_MASTERS='.$row_Recordset1['ID_INMUEBLE'].'"><img src="../img/Liberar.png" title="Liberar el Inmueble" width="70" height="30" /></a>';}}
	  else
	  {echo 'Vendido';
	  }?> 
      </td>
     <?php if (validador(15,$_SESSION['i'],"edi")==1){?><td width="50"><?php if ($row_Recordset1['VENDIDO']<>5){echo '<a href="list.php?titulo_formulario=Inmuebles&lista=1&usuario_valido='.$_SESSION['i'].'&defecto=0&ID_INMUEBLE_MASTER='.$row_Recordset1['ID_INMUEBLE'].'"><img src="../img/write.png" title="Editar" width="32" height="32" /></a>';}
	else
	  {echo '';
	  }?></td><?php } ?>
      <?php if (validador(15,$_SESSION['i'],"eli")==1){?><td width="50"><?php 
	   if ($row_Recordset1['VENDIDO']==0){echo '<a href="del.php?lista=1&titulo_formulario=Inmuebles&usuario_valido='.$_SESSION['i'].'&defecto=0&ID_INMUEBLE_MASTER='.$row_Recordset1['ID_INMUEBLE'].'"><img src="../img/button_cancel_256.png" title="Eliminar" width="32" height="32" /></a>';}
	else
	  {echo '';
	  }?></td><?php } ?>
    </tr>
    <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
</table>
<?php
mysql_free_result($Recordset1);
?>


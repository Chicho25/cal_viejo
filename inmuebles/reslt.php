
<?php
include('../include/css_js.php');
if($_GET['formato']=='2'){ ?>
<script type="text/javascript">
alert('entro');
window.location = "pdf.php?<?php echo "proyecto=".$_GET['proyecto']."&area=".$_GET['area']."&grupo=".$_GET['grupo']."&inmueble=".$_GET['inmueble']."&habitaciones=".$_GET['habitaciones']."&sanitarios".$_GET['sanitarios']."&depositos".$_GET['depositos']."&estacionamientos".$_GET['estacionamientos']."&status".$_GET['status']; ?>"

</script>
<?php } else {


mysql_select_db($database_conexion, $conexion);
$colname_Recordset1 = "-1";
if (isset($_GET['buscar']) && !empty($_GET['buscar'])){
mysql_select_db($database_conexion, $conexion);
$query_Recordset1 = sprintf("SELECT * FROM vista_inmuebles WHERE COD_PROYECTO <> ''".$_GET['proyecto']." ".isset_or($_GET['area'])." ".isset_or($_GET['grupo'])." ".isset_or($_GET['inmueble'])." ".isset_or($_GET['habitaciones'])." ".isset_or($_GET['sanitarios'])." ".isset_or($_GET['depositos'])." ".isset_or($_GET['estacionamientos'])." ".$_GET['status']." ", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $conexion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
if($totalRows_Recordset1 <= 0){echo  '<script language="javascript">alert("No existen registros para esta consulta.");location.href="list.php?defecto=2&titulo_formulario=Inmuebles";</script>';};
}
?>
<link href="../css/encabezados.css" rel="stylesheet" type="text/css" />

<link href="../js/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
<table width="990" border="0" align="center">
  <tr align="center">
    <td width="495"><form id="form1" name="form1" method="get" action="pdf.php">
      <input type="submit" name="Imprimir" id="Imprimir" value="Imprimir" />
      
      <input name="proyecto" type="hidden" id="proyecto" value="<?php echo isset_or($_GET['proyecto']) ?>" />
      <input name="area" type="hidden" id="area" value="<?php echo isset_or($_GET['area']) ?>" />
      <input name="grupo" type="hidden" id="grupo" value="<?php echo isset_or($_GET['grupo']) ?>" />
      <input name="inmueble" type="hidden" id="inmueble" value="<?php echo isset_or($_GET['inmueble']) ?>" />
      <input name="habitaciones" type="hidden" id="habitaciones" value="<?php echo isset_or($_GET['habitaciones']) ?>" />
      <input name="sanitarios" type="hidden" id="sanitarios" value="<?php echo isset_or($_GET['sanitarios']) ?>" />
      <input name="depositos" type="hidden" id="depositos" value="<?php echo isset_or($_GET['depositos']) ?>" />
      <input name="estacionamientos" type="hidden" id="estacionamientos" value="<?php echo isset_or($_GET['estacionamientos']) ?>" />
      <input name="status" type="hidden" id="status" value="<?php echo isset_or($_GET['status']) ?>" />
   </form></td>
    <td width="495" align="right" class="Campos">No. de registros: <?php echo $totalRows_Recordset1; ?></td>
  </tr>
</table>
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
    <?php if (validador(15,$_SESSION['i'],"eli")==1 || validador(15,$_SESSION['i'],"edi")==1 || $oth==1){?><td colspan="3"  class="ui-widget-header">Opciones</td><?php } ?>
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
      <td width="50" align="center" valign="middle"><?php 
	    if ($row_Recordset1['VENDIDO']==0){if (validador1(15,$_SESSION['i'],"oth")==1){echo '<a href="list.php?lista=1&titulo_formulario=Inmuebles&defecto=0&ID_INMUEBLE_MASTER_RESERVA='.$row_Recordset1['ID_INMUEBLE'].'"><img src="../img/Disponible.png" title="Reservar" width="70" height="30" /></a>';}}
		elseif ($row_Recordset1['VENDIDO']==2){if (validador1(15,$_SESSION['i'],"lib")==1){echo '<a href="liberar.php?lista=1&titulo_formulario=Inmuebles&defecto=0&ID_INMUEBLE_MASTERS='.$row_Recordset1['ID_INMUEBLE'].'"><img src="../img/Liberar.png" title="Liberar el Inmueble" width="70" height="30" /></a>';}}
	  else
	  {echo 'Vendido';
	  }?></td>
     <?php if (validador(15,$_SESSION['i'],"edi")==1){?><td width="50"> <?php if ($row_Recordset1['VENDIDO']<>5){echo '<a href="list.php?titulo_formulario=Inmuebles&lista=1&usuario_valido='.$_SESSION['i'].'&defecto=0&ID_INMUEBLE_MASTER='.$row_Recordset1['ID_INMUEBLE'].'"><img src="../img/write.png" title="Editar" width="32" height="32" /></a>';}
	else
	  {echo '';
	  }?></td><?php } ?>
      <?php if (validador(15,$_SESSION['i'],"eli")==1){?><td width="50"><?php 
	   if ($row_Recordset1['VENDIDO']==0){echo '<a href="del.php?lista=1&usuario_valido='.$_SESSION['i'].'&defecto=0&ID_INMUEBLE_MASTER='.$row_Recordset1['ID_INMUEBLE'].'"><img src="../img/button_cancel_256.png" title="Eliminar" width="32" height="32" /></a>';}
	else
	  {echo '';
	  }?></td><?php } ?>
    </tr>
    <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
</table>
<?php
mysql_free_result($Recordset1);
}?>
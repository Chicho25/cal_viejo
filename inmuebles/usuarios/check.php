<?php include('../Connections/conexion.php'); ?>
<?php //include('../include/css_js.php'); ?>
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

mysql_select_db($database_conexion, $conexion);
$query_grupos = "SELECT DISTINCT ID_MENU, DETALLE_ACCESO, DESCRIPCION_MENU FROM vista_usuarios_roles WHERE  ID_ROLE=".$_POST['COD_PROYECTOS_MASTER']." AND ID_GRUPO_MENU=".$_POST['COD_PROYECTOS_MASTERS']." ORDER BY ORDEN_MENU";
//$query_grupos = "SELECT DISTINCT ID_MENU, DETALLE_ACCESO, DESCRIPCION_MENU FROM vista_usuarios_roles WHERE  ID_ROLE=1 AND ID_GRUPO_MENU=2 ORDER BY ORDEN_MENU";

$grupos = mysql_query($query_grupos, $conexion) or die(mysql_error());
$row_grupos = mysql_fetch_assoc($grupos);
$totalRows_grupos = mysql_num_rows($grupos);
$roless =$_POST['COD_PROYECTOS_MASTER'];
if ($totalRows_grupos>0){
?>
<script>
	<?php for($i = 1 ; $i <= $totalRows_grupos*6; $i ++){?>
	$(function() {
		//alert($( "#radio_<?php echo $i; ?>" ).val());

		$( "#radio_<?php echo $i; ?>" ).buttonset();
		$( "#radio_<?php echo $i; ?>" ).val();
		
	});
	<?php }?>
	</script>

<form method="get" name="form2" action="_roles2.php">
  <input name="roles-1" type="hidden" value="<?php echo $roless ?>" />
  <table width="1300" border="0" align="center" bgcolor="#CCCCCC">
    <tr align="center" valign="middle" class="ui-widget-header">
      <td width="464">Menus</td>
      <td width="248"><p>Ver</p>
        <p>&nbsp;</p></td>
      <td width="129"><p>Incluir</p>
      <p>&nbsp;</p></td>
      <td width="62"><p>Editar</p>
      <p>&nbsp;</p></td>
      <td width="62"><p>Eliminar</p>
      <p>&nbsp;</p></td>
      <td width="62"><p>Reservar / Otros</p>
      <p>&nbsp;</p></td>
      <td width="62"><p>Liberar</p>
      <p>&nbsp;</p></td>
           </tr>
    <?php $a=1;
	//echo $query_grupos;
	do { 
	$ver=substr($row_grupos['DETALLE_ACCESO'], 0, 1);
	$incluir=substr($row_grupos['DETALLE_ACCESO'], 1, 1);
	$editar=substr($row_grupos['DETALLE_ACCESO'], 2, 1);
	$eliminar=substr($row_grupos['DETALLE_ACCESO'], 3, 1);
	$oth=substr($row_grupos['DETALLE_ACCESO'], 4, 1);
	$oth1=substr($row_grupos['DETALLE_ACCESO'], 5, 1);
	?>
  
      <tr align="center" bgcolor="#CCCCCC" class="Campos">
        <td width="464" align="left">[<?php echo htmlentities($row_grupos['ID_MENU']); ?>] <?php echo htmlentities($row_grupos['DESCRIPCION_MENU']); ?>
          <input name="ID_MENU-<?php echo $row_grupos['ID_MENU']; ?>" type="hidden" id="ID_MENU<?php echo $row_grupos['ID_MENU']; ?>" value="<?php echo $row_grupos['ID_MENU']; ?>" />
        </td>
        <td width="200">
        
        <div id="radio_<?php echo $a ?>">
        <input type="radio" id="radio1<?php echo $row_grupos['ID_MENU']; ?>" name="radio1-<?php echo $row_grupos['ID_MENU']; ?>"<?php if($ver==1){?>checked="checked" value="1" <?php } ?>   value="1"/><label for="radio1<?php echo $row_grupos['ID_MENU']; ?>">Activo</label>
		<input type="radio" id="radio2<?php echo $row_grupos['ID_MENU']; ?>" name="radio1-<?php echo $row_grupos['ID_MENU']; ?>"<?php if($ver==0){?>checked="checked" value="0" <?php } ?> value="0"/><label for="radio2<?php echo $row_grupos['ID_MENU']; ?>">Inactivo</label>
        </div><?php 
	  $a=$a+1;?>
</td>
        <td width="200"> 
        <div id="radio_<?php echo $a ?>">
        <input type="radio" id="radio3<?php echo $row_grupos['ID_MENU']; ?>" name="radio2-<?php echo $row_grupos['ID_MENU']; ?>"<?php if($incluir==1){?>checked="checked" value="1"<?php } ?> value="1"/><label for="radio3<?php echo $row_grupos['ID_MENU']; ?>">Activo</label>
		<input type="radio" id="radio4<?php echo $row_grupos['ID_MENU']; ?>" name="radio2-<?php echo $row_grupos['ID_MENU']; ?>"<?php if($incluir==0){?>checked="checked" value="0"<?php } ?> value="0"/><label for="radio4<?php echo $row_grupos['ID_MENU']; ?>">Inactivo</label>
        </div>
		<?php $a=$a+1;?>
        </td>
        <td width="200">
        <div id="radio_<?php echo $a ?>">
        <input type="radio" id="radio5<?php echo $row_grupos['ID_MENU']; ?>" name="radio3-<?php echo $row_grupos['ID_MENU']; ?>"<?php if($editar==1){?>checked="checked" value="1"<?php } ?> value="1"/><label for="radio5<?php echo $row_grupos['ID_MENU']; ?>">Activo</label>
		<input type="radio" id="radio6<?php echo $row_grupos['ID_MENU']; ?>" name="radio3-<?php echo $row_grupos['ID_MENU']; ?>"<?php if($editar==0){?>checked="checked" value="0"<?php } ?> value="0"/><label for="radio6<?php echo $row_grupos['ID_MENU']; ?>">Inactivo</label>
        </div><?php 
	  $a=$a+1;?></td>
        <td width="200">
        <div id="radio_<?php echo $a ?>">
        <input type="radio" id="radio7<?php echo $row_grupos['ID_MENU']; ?>" name="radio4-<?php echo $row_grupos['ID_MENU']; ?>"<?php if($eliminar==1){?>checked="checked" value="1"<?php } ?> value="1"/><label for="radio7<?php echo $row_grupos['ID_MENU']; ?>">Activo</label>
		<input type="radio" id="radio8<?php echo $row_grupos['ID_MENU']; ?>" name="radio4-<?php echo $row_grupos['ID_MENU']; ?>"<?php if($eliminar==0){?>checked="checked" value="0"<?php } ?> value="0"/><label for="radio8<?php echo $row_grupos['ID_MENU']; ?>">Inactivo</label>
        </div><?php 
	  $a=$a+1;?></td>
        <td width="200">
        
        <div id="radio_<?php echo $a ?>">
        <input type="radio" id="radio9<?php echo $row_grupos['ID_MENU']; ?>" name="radio5-<?php echo $row_grupos['ID_MENU']; ?>"<?php if($oth==1){?>checked="checked" value="1" <?php } ?>   value="1"/><label for="radio9<?php echo $row_grupos['ID_MENU']; ?>">Activo</label>
		<input type="radio" id="radio10<?php echo $row_grupos['ID_MENU']; ?>" name="radio5-<?php echo $row_grupos['ID_MENU']; ?>"<?php if($oth==0){?>checked="checked" value="0" <?php } ?> value="0"/><label for="radio10<?php echo $row_grupos['ID_MENU']; ?>">Inactivo</label>
        </div><?php 
	  $a=$a+1;?></td>
        <td width="200">
        
        <div id="radio_<?php echo $a ?>">
        <input type="radio" id="radio11<?php echo $row_grupos['ID_MENU']; ?>" name="radio6-<?php echo $row_grupos['ID_MENU']; ?>"<?php if($oth1==1){?>checked="checked" value="1" <?php } ?>   value="1"/><label for="radio11<?php echo $row_grupos['ID_MENU']; ?>">Activo</label>
		<input type="radio" id="radio12<?php echo $row_grupos['ID_MENU']; ?>" name="radio6-<?php echo $row_grupos['ID_MENU']; ?>"<?php if($oth1==0){?>checked="checked" value="0" <?php } ?> value="0"/><label for="radio12<?php echo $row_grupos['ID_MENU']; ?>">Inactivo</label>
        </div>
</td>
           </tr>
      <?php 
	  $a=$a+1;
	   } while ($row_grupos = mysql_fetch_assoc($grupos)); ?>
  </table>
  <table width="990" border="0" align="center">
  <tr>
    <td height="37" align="center" valign="middle">      
    <input name="guardar-1" align="middle"type="submit" class="ui-state-hover" id="guardar" value="Aceptar" /></td>
  </tr>
</table>

  <p>&nbsp;</p>
</form>

<?php
mysql_free_result($grupos); 
}
?>
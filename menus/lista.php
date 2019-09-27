
<?php require_once('../Connections/conexion.php'); ?>
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
$query_formulario_menu = "SELECT usuarios_formularios.ID_FORMULARIO,   usuarios_formularios.TITULO,   usuarios_formularios.DESCRIPCION,  usuarios_menu.DESCRIPCION, usuarios_formularios.LINK,   usuarios_formularios.PARAMETROS,   usuarios_formularios.LINK_AYUDA,   usuarios_menu.ID_MENU,   usuarios_menu.ID_GRUPO,   usuarios_menu.NIVEL,   usuarios_menu.ORDEN,   usuarios_menu.ACTIVO FROM usuarios_menu   LEFT JOIN usuarios_formularios ON (usuarios_menu.ID_FORMULARIO = usuarios_formularios.ID_FORMULARIO)";
$formulario_menu = mysql_query($query_formulario_menu, $conexion) or die(mysql_error());
$row_formulario_menu = mysql_fetch_assoc($formulario_menu);
$totalRows_formulario_menu = mysql_num_rows($formulario_menu);
?>

<table width="990" border="0" align="center" bgcolor="#CCCCCC">
  <tr align="center" class="ui-widget-header">
    <td>Id Formulario</td>
    <td>Id Menu</td>
    <td>Titulo Formulario</td>
    <td>Titulo de Menu</td>
    <td>Grupo al que pertenece</td>
    <td>Nivel</td>
    <td>Orden</td>
    <td>Parametros</td>
    <td>Link</td>
    <td>Activo</td>
    <td>Link de Ayuda</td>
    <td colspan="2">Opciones</td>
  </tr>
  <?php do { ?>
    <tr class="Campos" >
      <td align="center"><?php echo $row_formulario_menu['ID_FORMULARIO']; ?></td>
      <td align="center"><?php echo $row_formulario_menu['ID_MENU']; ?></td>
      <td><?php echo $row_formulario_menu['DESCRIPCION']; ?></td>
      <td><?php echo $row_formulario_menu['TITULO']; ?></td>
      <td align="center"><?php echo $row_formulario_menu['ID_GRUPO']; ?></td>
      <td align="center"><?php echo $row_formulario_menu['NIVEL']; ?></td>
      <td align="center"><?php echo $row_formulario_menu['ORDEN']; ?></td>
      <td><?php echo $row_formulario_menu['PARAMETROS']; ?></td>
      <td><?php echo $row_formulario_menu['LINK']; ?></td>
      <td align="center"><?php echo $row_formulario_menu['ACTIVO']; ?></td>
      <td><?php echo $row_formulario_menu['LINK_AYUDA']; ?></td>
      <td align="center"><?php echo '<a href="index.php?titulo_formulario='.$_GET['titulo_formulario'].'&id_menu='.$_GET['id_menu'].'&ID_MENU='.$row_formulario_menu['ID_MENU'].'"><img src="../img/write.png" title="Editar" width="24" height="24" /></a>';?></td>
      <td align="center"><?php echo '<a href="del.php?titulo_formulario='.$_GET['titulo_formulario'].'&id_menu='.$_GET['id_menu'].'&ID_FORMULARIO ='.$row_formulario_menu['ID_FORMULARIO'].'"><img src="../img/button_cancel_256.png" title="Eliminar" width="24" height="24" /></a>';?></td>
    </tr>
    <?php } while ($row_formulario_menu = mysql_fetch_assoc($formulario_menu)); ?>
</table>

<?php
mysql_free_result($formulario_menu);
?>

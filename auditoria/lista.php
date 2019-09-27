<?php /*require_once('../Connections/conexion.php'); ?>
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
*/
mysql_select_db($database_conexion, $conexion);
$query_rst_auditoria = "SELECT    auditoria.TIME_STAMP,   usuarios_master.NOMBRES,   usuarios_master.APELLIDOS,   auditoria.DESCRIPCION as DESC_AUD,   usuarios_menu.DESCRIPCION as MENU FROM   auditoria   INNER JOIN usuarios_master ON (auditoria.ID_USUARIO = usuarios_master.ID_USUARIO)   INNER JOIN usuarios_menu ON (auditoria.MODULO = usuarios_menu.ID_MENU)";
$rst_auditoria = mysql_query($query_rst_auditoria, $conexion) or die(mysql_error());
$row_rst_auditoria = mysql_fetch_assoc($rst_auditoria);
$totalRows_rst_auditoria = mysql_num_rows($rst_auditoria);
?>
<?php //include('../include/header.php'); ?>
<table width="990" border="0" align="center" bgcolor="#CCCCCC">
  <tr align="center" class="ui-widget-header">
    <td width="353">USUARIO</td>
    <td width="184">FECHA Y HORA</td>
    <td width="139">MENU</td>
    <td width="277">DESCRIPCION</td>
  </tr>
  <?php do { ?>
    <tr class="Campos">
      <td><?php echo $row_rst_auditoria['NOMBRES']; ?><?php echo $row_rst_auditoria['APELLIDOS']; ?> </td>
      <td><?php echo $row_rst_auditoria['TIME_STAMP']; ?></td>
      <td><?php echo $row_rst_auditoria['MENU']; ?></td>
      <td><?php echo $row_rst_auditoria['DESC_AUD']; ?></td>
    </tr>
    <?php } while ($row_rst_auditoria = mysql_fetch_assoc($rst_auditoria)); ?>
</table>
<?php
mysql_free_result($rst_auditoria);
?>

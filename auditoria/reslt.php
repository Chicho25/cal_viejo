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
if (isset($_GET['fecha1'])){
	  $f1=DMAtoAMD($_GET['fecha1']).' 00:00:00';
	
	  $f2=DMAtoAMD($_GET['fecha2']).' 23:59:59';
	
	 $fechas=" AND auditoria.TIME_STAMP BETWEEN '$f1' AND '$f2'";
	};
mysql_select_db($database_conexion, $conexion);
$query_rst_auditoria = "SELECT 
  auditoria.ID_USUARIO,
  auditoria.DESCRIPCION AS DESC_AUD,
  auditoria.MODULO,
  auditoria.IP_CONEXION,
  auditoria.TIME_STAMP,
  usuarios_master.NOMBRES,
  usuarios_master.APELLIDOS,
  usuarios_menu.DESCRIPCION AS MENU
FROM
  usuarios_master,
  auditoria,
  usuarios_menu
WHERE
auditoria.MODULO = usuarios_menu.ID_MENU and usuarios_master.id_usuario = auditoria.ID_USUARIO and
 auditoria.ID_AUDITORIA <> '' ".isset_or($_GET['usuario'])." ".isset_or($_GET['modulo'])." ".$fechas." 
ORDER BY
  auditoria.TIME_STAMP ";
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

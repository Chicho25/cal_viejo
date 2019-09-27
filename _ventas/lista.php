<?php require_once('../Connections/conexion.php'); ?>
<?php include('../include/header.php'); ?>

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
if(isset($_GET["ID_INMUEBLES_MOV"]) && $_GET["ID_INMUEBLES_MOV"] <> ""){$movimientos= ' and inmuebles_mov.ID_INMUEBLES_MOV='.$_GET["ID_INMUEBLES_MOV"];} else {$movimientos="";};
if(isset($_GET["ID_PROYECTO"]) && $_GET["ID_PROYECTO"] <> ""){$proyecto= ' and COD_PROYECTO='.$_GET["ID_PROYECTO"];} else {$proyecto="";};
if(isset($_GET["ID_GRUPO"]) && $_GET["ID_GRUPO"] <> ""){$grupo= ' and ID_GRUPO='.$_GET["ID_GRUPO"];} else {$grupo="";};
if(isset($_GET["ID_INMUEBLES"]) && $_GET["ID_INMUEBLES"] <> ""){$inmueble= ' and ID_INMUEBLE='.$_GET["ID_INMUEBLES"];} else {$inmueble="";};
if(isset($_GET["FECHA_VENTA_DATE"]) && $_GET["FECHA_VENTA_DATE"] <> "" && isset($_GET["FECHA_HASTA"]) && $_GET["FECHA_HASTA"] <> ""){$fecha= ' and FECHA BETWEEN "'.DMAtoAMD($_GET["FECHA_VENTA_DATE"]). '" AND "'.DMAtoAMD($_GET["FECHA_HASTA"]).'"' ;} else {$fecha="";};
if(isset($_GET["ID_CLIENTE"]) && $_GET["ID_CLIENTE"] <> ""){$cliente= ' and pro_cli_master.ID_PRO_CLI_MASTER='.$_GET["ID_CLIENTE"];} else {$cliente="";};





mysql_select_db($database_conexion, $conexion);
$query_listMa = "SELECT
  `inmuebles_mov`.`ID_INMUEBLES_MOV`            AS `ID_INMUEBLES_MOV`,
  `vista_inmuebles`.`CODIGO_INMUEBLE`                            AS `CODIGO_INMUEBLE`,
  `vista_inmuebles`.`NOMBRE_PROYECTO`                            AS `PROYECTO`,
  `vista_inmuebles`.`NOMBRE_GRUPO`                               AS `NOMBRE_GRUPO`,
  `vista_inmuebles`.`ID_GRUPO`                                   AS `ID_GRUPO`,
  `vista_inmuebles`.`COD_PROYECTO`                               AS `ID_PROYECTO`,
  `vista_inmuebles`.ID_INMUEBLE                                  AS `ID_INMUEBLE`,
  DATE_FORMAT(`inmuebles_mov`.`FECHA`,_utf8'%d/%m/%Y') AS `FECHA_VENTA`,
  `inmuebles_mov`.`FECHA`                       AS `FECHA_VENTA_DATE`,
  `pro_cli_master`.ID_PRO_CLI_MASTER            AS `ID_CLIENTE`,
  `pro_cli_master`.`NOMBRE`                     AS `NOMBRE_CLIENTE`,
  `inmuebles_mov`.`PRECIO_VENTA`                AS `MONTO_VENTA`,
  `inmuebles_mov_detalle`.`ID_PRO_CLI_VENDEDOR` AS `ID_VENDEDOR`,
  IF(`inmuebles_mov_detalle`.`PORCENTAJE_COMISION` >= 2 OR `inmuebles_mov_detalle`.`PORCENTAJE_COMISION` = 0.26,'VENDEDOR','') AS `STATUS`,
  `inmuebles_mov_detalle`.`PORCENTAJE_COMISION` AS `PORCENTAJE_COMISION`,
  ((`inmuebles_mov`.`PRECIO_VENTA` * `inmuebles_mov_detalle`.`PORCENTAJE_COMISION`) / 100) AS `MONTO_COMISION`,
  `pro_cli_master1`.`NOMBRE`                                     AS `NOMBRE`
FROM ((((`inmuebles_mov`
      LEFT JOIN `inmuebles_mov_detalle`
        ON ((`inmuebles_mov`.`ID_INMUEBLES_MOV` = `inmuebles_mov_detalle`.`ID_INMUEBLES_MOV`)))
     LEFT JOIN `vista_inmuebles`
       ON ((`vista_inmuebles`.`ID_INMUEBLE` = `inmuebles_mov`.`ID_INMUEBLES_MASTER`)))
    LEFT JOIN `pro_cli_master`
      ON ((`inmuebles_mov`.`ID_PRO_CLI_MASTER` = `pro_cli_master`.`ID_PRO_CLI_MASTER`)))
   JOIN `pro_cli_master` `pro_cli_master1`
     ON ((`inmuebles_mov_detalle`.`ID_PRO_CLI_VENDEDOR` = `pro_cli_master1`.`ID_PRO_CLI_MASTER`)))
	 WHERE `inmuebles_mov`.`ID_INMUEBLES_MOV` > 0 ".$movimientos.$proyecto.$grupo.$inmueble.$fecha.$cliente. "
ORDER BY `inmuebles_mov`.`ID_INMUEBLES_MOV`";
$listMa = mysql_query($query_listMa, $conexion) or die(mysql_error());
$row_listMa = mysql_fetch_assoc($listMa);
$totalRows_listMa = mysql_num_rows($listMa);
//echo $query_listMa;
?>
<title>Untitled Document</title>
</head>

<body>
      <table width="1100" align="center" class="ui-widget-header" >
    <tr>
          <td width="100%" align="center" class="textos_form"><div class="titulo_formulario">Listado de Contratos</div>
    </tr>
  </table>
<table width="1100" align="center" class="ui-widget-header" >
  <tr>
    <td width="100%" align="center" class="textos_form"><div align="center" style="background-color:#6FA7D1" ><?php include("_menuM.php"); ?></div>
  </tr>
</table>
<?php $color='#FFF'; ?>
<table width="990" border="1" align="center" cellpadding="2" cellspacing="1">
    <tr class="menu" align="center">
    <td>ID</td>
    <td>Codigo</td>
    <td>Proyecto</td>
    <td>Grupo</td>
    <td>Fecha</td>
    <td>Cliente</td>
    <td>Monto de la Venta</td>
    <td>Vendedor</td>
    <td>Porcentaje</td>
    <td>Monto de comision</td>
  </tr>
  <?php do { ?>
      <tr style="font-family:Arial, Helvetica, sans-serif; font-size:12px" bgcolor='<?php echo $color ?>' >
      <td><?php echo $row_listMa['ID_INMUEBLES_MOV']; ?></td>
      <td><?php echo $row_listMa['CODIGO_INMUEBLE']; ?></td>
      <td><?php echo $row_listMa['PROYECTO']; ?></td>
      <td><?php echo $row_listMa['NOMBRE_GRUPO']; ?></td>
      <td><?php echo $row_listMa['FECHA_VENTA']; ?></td>
      <td><?php echo $row_listMa['NOMBRE_CLIENTE']; ?></td>
      <td><?php echo number_format($row_listMa['MONTO_VENTA'],2); ?></td>
      <td><?php echo $row_listMa['NOMBRE']; ?></td>
      <td><?php echo number_format($row_listMa['PORCENTAJE_COMISION'],2); ?></td>
      <td><?php echo number_format($row_listMa['MONTO_COMISION'],2); ?></td>
    </tr>
    <?php } while ($row_listMa = mysql_fetch_assoc($listMa)); ?>
</table>

</body>
</html><?php
mysql_free_result($listMa);
?>

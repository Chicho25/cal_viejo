<?php require_once('../Connections/conexion.php'); ?>
<?php require_once('../include/css_js.php'); ?>
<?php
if(isset($_GET['proyecto']) && $_GET['proyecto']!=''){$pagos=$_GET['proyecto'] ;} else {$pagos='';}

if(isset($_GET['grupo']) && $_GET['grupo']!=''){$documentos=$_GET['grupo'];} else {$documentos='';}
if(isset($_GET['inmueble']) && $_GET['inmueble']!=''){$proveedores=$_GET['inmueble'];} else {$proveedores='';}
if(isset($_GET['VENCIDOS']) && $_GET['VENCIDOS']!=''){$numero=' AND vista_documentos_ventas.STATUS_DOCUMENTO='.$_GET['VENCIDOS'];} else {$numero='';}
if(isset($_GET['FROM']) && $_GET['FROM']!='' && isset($_GET['TO']) && $_GET['TO']!='')
{$fi=DMAtoAMD($_GET['FROM']); $ff=DMAtoAMD($_GET['TO']);
	$fecha=' AND vista_edo_cuenta_clientes.FECHA_VENCIMIENTO_DATE BETWEEN "'.$fi.'" AND "'.$ff.'"';} else {$fecha='';}



mysql_select_db($database_conexion, $conexion);
$query_rst_clientes = "SELECT DISTINCT 
  pro_cli_master.ID_PRO_CLI_MASTER,
  pro_cli_master.NOMBRE,
  pro_cli_master.PROFESION,
  terceros_estado_civil.DESCRIPCION AS EDO_CIVIL,
  terceros_relacion_laborar.DESCRIPCION AS LABORAL,
  pro_cli_master.CONTACTO,
  pro_cli_master.ID_TRIBUTARIA_CEDULA,
  pro_cli_master.CODIGO,
  pro_cli_master.DIRECCION,
  pro_cli_master.TELEFONO_FIJO_1,
  pro_cli_master.TELEFONO_FIJO_2,
  pro_cli_master.TELEFONO_MOVIL_1,
  pro_cli_master.TELEFONO_MOVIL_2,
  pro_cli_master.EMAIL_1,
  pro_cli_master.EMAIL_2,
  pro_cli_master.OBSERVACIONES,
  terceros_nacionalidad.DESCRIPCION AS NACIONALIDAD
FROM
  pro_cli_master
  LEFT OUTER JOIN terceros_relacion_laborar ON (pro_cli_master.ID_RELACION_LABORAR = terceros_relacion_laborar.ID_TERCEROS_RELACION_LABORAR)
  LEFT OUTER JOIN terceros_estado_civil ON (pro_cli_master.ID_ESTADO_CIVIL = terceros_estado_civil.ID_TERCEROS_ESTADO_CIVIL)
  LEFT OUTER JOIN terceros_nacionalidad ON (pro_cli_master.ID_NACIONALIDAD = terceros_nacionalidad.ID_TERCEROS_NACIONALIDAD)
  INNER JOIN vista_edo_cuenta_clientes ON (pro_cli_master.ID_PRO_CLI_MASTER = vista_edo_cuenta_clientes.ID_PRO_CLI)
  INNER JOIN inmuebles_master ON (vista_edo_cuenta_clientes.ID_INMUEBLES = inmuebles_master.ID_INMUEBLES_MASTER)
  INNER JOIN inmuebles_grupo ON (inmuebles_master.ID_INMUEBLES_GRUPO = inmuebles_grupo.ID_INMUEBLES_GRUPO)
WHERE
  pro_cli_master.ID_PRO_CLI_MASTER <> ''".$_GET['nombre'].$pagos.$documentos.$proveedores.$fecha;
  //echo $query_rst_clientes;
$rst_clientes = mysql_query($query_rst_clientes, $conexion) or die(mysql_error());
$row_rst_clientes = mysql_fetch_assoc($rst_clientes);
$totalRows_rst_clientes = mysql_num_rows($rst_clientes);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/encabezados.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php if ($_GET['vista']==1){ ?>
  <?php do { ?>
<table width="990" border="0" align="center" bgcolor="#CCCCCC">
  <tr align="center" bgcolor="#6699FF"  class="ui-widget-header">
    <td>NOMBRE</td>
    <td>PROFESION</td>
    <td>EDO CIVIL</td>
    <td>R LABORAL</td>
    <td>CEDULA</td>
    <td>RUC</td>
  </tr>
  <tr class="Campos">
    <td><?php echo htmlentities($row_rst_clientes['NOMBRE']); ?></td>
    <td><?php echo htmlentities($row_rst_clientes['PROFESION']); ?></td>
    <td><?php echo htmlentities($row_rst_clientes['EDO_CIVIL']); ?></td>
    <td><?php echo htmlentities($row_rst_clientes['LABORAL']); ?></td>
    <td><?php echo $row_rst_clientes['CODIGO']; ?></td>
    <td><?php echo $row_rst_clientes['ID_TRIBUTARIA_CEDULA']; ?></td>
  </tr>
</table>
<table width="990" border="0" align="center" bgcolor="#CCCCCC">
  <tr align="center" bgcolor="#6699FF"  class="ui-widget-header">
    <td>CONTACTO</td>
    <td>TELEFONO HAB</td>
    <td>TELEFONO OFI</td>
    <td>TELEFONO MOVIL</td>
    <td>TELEFONO MOVIL</td>
    <td>EMAIL</td>
  </tr>
  <tr class="Campos">
    <td><?php echo htmlentities($row_rst_clientes['CONTACTO']); ?></td>
    <td><?php echo $row_rst_clientes['TELEFONO_FIJO_1']; ?></td>
    <td><?php echo $row_rst_clientes['TELEFONO_FIJO_2']; ?></td>
    <td><?php echo $row_rst_clientes['TELEFONO_MOVIL_1']; ?></td>
    <td><?php echo $row_rst_clientes['TELEFONO_MOVIL_2']; ?></td>
    <td><?php echo $row_rst_clientes['EMAIL_1']; ?></td>
  </tr>
</table>


<?php

$sql3="SELECT DISTINCT vista_edo_cuenta_clientes.ID_INMUEBLES FROM inmuebles_grupo 
INNER JOIN inmuebles_master ON (inmuebles_grupo.ID_INMUEBLES_GRUPO = inmuebles_master.ID_INMUEBLES_GRUPO) 
INNER JOIN vista_edo_cuenta_clientes ON (inmuebles_master.ID_INMUEBLES_MASTER = vista_edo_cuenta_clientes.ID_INMUEBLES) 
WHERE vista_edo_cuenta_clientes.ID_PRO_CLI=".$row_rst_clientes['ID_PRO_CLI_MASTER'].$proveedores.$fecha." ORDER BY vista_edo_cuenta_clientes.ID_INMUEBLES";

	//echo $sql3;
mysql_select_db($database_conexion, $conexion);
$query_rpt3 = $sql3;
$rpt3 = mysql_query($query_rpt3, $conexion) or die(mysql_error());
$row_rpt3 = mysql_fetch_assoc($rpt3);
$totalRows_rpt3 = mysql_num_rows($rpt3);

 do {

			mysql_select_db($database_conexion, $conexion);
			$query_rst_inmueble = "SELECT   CODIGO_PROYECTO,  CONCEPTO,   TIPO,   NUMERO,   CODIGO_INMUEBLE,   FECHA,  FECHA_VENCIMIENTO,   DESCRIPCION,   DEBITO,   CREDITO,  ID_DOCUMENTO,   NOMBRE_PRO_CLI, ID_INMUEBLES  FROM vista_edo_cuenta_clientes where vista_edo_cuenta_clientes.ID_PRO_CLI=".$row_rst_clientes['ID_PRO_CLI_MASTER']." AND vista_edo_cuenta_clientes.ID_INMUEBLES=".$row_rpt3['ID_INMUEBLES'];
			//echo $query_rst_inmueble;
			$rst_inmueble = mysql_query($query_rst_inmueble, $conexion) or die(mysql_error());
			$row_rst_inmueble = mysql_fetch_assoc($rst_inmueble);
			$totalRows_rst_inmueble = mysql_num_rows($rst_inmueble); 
			
			?>
			
  <table width="990" border="0" align="center" bgcolor="#CCCCCC">
			  <tr align="center" bgcolor="#6699FF" class="ui-widget-header">
				<td width="60">INMUEBLE</td>
				<td>DOCUMENTOS</td>
				<td width="80">EMISION </td>
				<td width="80">VCIMIENTO</td>
				<td width="70">DEBITO</td>
				<td width="70">CREDITO</td>
				<td width="70">SALDO</td>
			  </tr>
			  <?php $saldo= 0;
			  do { ?>
				<tr class="Campos">
				  <td align="center"><?php echo $row_rst_inmueble['CODIGO_INMUEBLE']; ?></td>
				  <td align="left"><?php echo htmlentities($row_rst_inmueble['DESCRIPCION']); ?></td>
				  <td align="center"><?php echo $row_rst_inmueble['FECHA']; ?></td>
				  <td align="center"><?php echo $row_rst_inmueble['FECHA_VENCIMIENTO']; ?></td>
				  <td align="right"><?php echo number_format($row_rst_inmueble['DEBITO'],2, ",", "."); ?></td>
				  <td align="right"><?php echo number_format($row_rst_inmueble['CREDITO'],2, ",", "."); ?></td>
				  <?php $saldo=($saldo+$row_rst_inmueble['DEBITO'])-$row_rst_inmueble['CREDITO']; ?>
				  <td align="right"><?php echo number_format($saldo,2, ",", "."); ?></td>
				</tr>
                <?php } while ($row_rst_inmueble = mysql_fetch_assoc($rst_inmueble)); ?>
                </table>
                
                <?php mysql_select_db($database_conexion, $conexion);
			$query_rst_suma = "SELECT CODIGO_INMUEBLE, ID_INMUEBLES, SUM(DEBITO) as DEBITO,   SUM(CREDITO) AS CREDITO FROM vista_edo_cuenta_clientes where vista_edo_cuenta_clientes.ID_PRO_CLI=".$row_rst_clientes['ID_PRO_CLI_MASTER']." AND vista_edo_cuenta_clientes.ID_INMUEBLES=".$row_rpt3['ID_INMUEBLES'];
			//echo $query_rst_suma;
			$rst_suma = mysql_query($query_rst_suma, $conexion) or die(mysql_error());
			$row_rst_suma = mysql_fetch_assoc($rst_suma);
			$totalRows_rst_suma = mysql_num_rows($rst_suma); 
?>
			<table width="990" border="0" align="center" bgcolor="#CCCCCC">
			  <tr bgcolor="#6699FF" class="ui-widget-header">
				<td align="left">INMUEBLE: <?php echo $row_rst_suma['CODIGO_INMUEBLE']; ?></td>
				<td width="70" align="right"><?php echo number_format($row_rst_suma['DEBITO'],2, ",", "."); ?></td>
				<td width="70" align="right"><?php echo number_format($row_rst_suma['CREDITO'],2, ",", "."); ?></td>
				<td width="70" align="right"><?php echo number_format(( $row_rst_suma['DEBITO']-$row_rst_suma['CREDITO']),2, ",", "."); ?></td>
			  </tr>
			
			</table>
            
            <?php		
			mysql_select_db($database_conexion, $conexion);
			$query_rst_observacion = "SELECT * FROM inmuebles_mov WHERE ID_INMUEBLES_MASTER=".$row_rpt3['ID_INMUEBLES'];
			$rst_observacion = mysql_query($query_rst_observacion, $conexion) or die(mysql_error());
			$row_rst_observacion = mysql_fetch_assoc($rst_observacion);
			$totalRows_rst_observacion = mysql_num_rows($rst_observacion);
			//echo $query_rst_observacion;
?>
			<form id="form2" name="form2" method="get" action="edit.php">
			<table width="990" border="0" align="center" bgcolor="#CCCCCC">
			  <tr bgcolor="#6699FF"  class="ui-widget-header">
				<td height="28" align="left" valign="top">
				
				  <label for="observaciones"></label>
				  OBSERVACION:
				  <textarea name="observaciones" id="observaciones" cols="150" rows="2" ><?php echo $row_rst_observacion['DESCRIPCION']; ?></textarea>
				  <input type="hidden" name="inmueble" id="inmueble"  value="<?php echo $row_rst_suma['ID_INMUEBLES']; ?>"/>
				  <input name="nombre" type="hidden" id="nombre" value="<?php echo $_GET['nombre'] ?>" />
				  <input name="proyecto" type="hidden" id="proyecto" value="<?php echo $pagos ?>" />
				  <input name="grupo" type="hidden" id="grupo" value="<?php echo $documentos ?>" />
			<input name="inmuebles" type="hidden" id="inmuebles" value="<?php echo $proveedores ?>" />
				  <input name="VENCIDOS" type="hidden" id="VENCIDOS" value="<?php echo $numero ?>" />
				  <input name="FROM" type="hidden" id="FROM" value="<?php echo $_GET['FROM'] ?>" />
				  <input name="TO" type="hidden" id="TO" value="<?php echo $_GET['TO'] ?>" /></td>
				<td width="70" align="center"><input type="submit" name="Aceptar" id="Aceptar" value="Aceptar"  class="ui-state-hover" /></td>
			  </tr>
			
			</table>
			</form>
                <?php } while ($row_rpt3 = mysql_fetch_assoc($rpt3)); ?>
			
			<?php } while ($row_rst_clientes = mysql_fetch_assoc($rst_clientes));  ?>
          <?php } else { ?>
			  
			 <!-- //////////////////////nuevo-->
			    <?php do { ?>
<table width="990" border="0" align="center" bgcolor="#CCCCCC">
  <tr align="center" bgcolor="#6699FF"  class="ui-widget-header">
    <td>NOMBRE</td>
    <td>PROFESION</td>
    <td>EDO CIVIL</td>
    <td>R LABORAL</td>
    <td>CEDULA</td>
    <td>RUC</td>
  </tr>
  <tr class="Campos">
    <td><?php echo htmlentities($row_rst_clientes['NOMBRE']); ?></td>
    <td><?php echo htmlentities($row_rst_clientes['PROFESION']); ?></td>
    <td><?php echo htmlentities($row_rst_clientes['EDO_CIVIL']); ?></td>
    <td><?php echo htmlentities($row_rst_clientes['LABORAL']); ?></td>
    <td><?php echo $row_rst_clientes['CODIGO']; ?></td>
    <td><?php echo $row_rst_clientes['ID_TRIBUTARIA_CEDULA']; ?></td>
  </tr>
</table>
<table width="990" border="0" align="center" bgcolor="#CCCCCC">
  <tr align="center" bgcolor="#6699FF"  class="ui-widget-header">
    <td>CONTACTO</td>
    <td>TELEFONO HAB</td>
    <td>TELEFONO OFI</td>
    <td>TELEFONO MOVIL</td>
    <td>TELEFONO MOVIL</td>
    <td>EMAIL</td>
  </tr>
  <tr class="Campos">
    <td><?php echo htmlentities($row_rst_clientes['CONTACTO']); ?></td>
    <td><?php echo $row_rst_clientes['TELEFONO_FIJO_1']; ?></td>
    <td><?php echo $row_rst_clientes['TELEFONO_FIJO_2']; ?></td>
    <td><?php echo $row_rst_clientes['TELEFONO_MOVIL_1']; ?></td>
    <td><?php echo $row_rst_clientes['TELEFONO_MOVIL_2']; ?></td>
    <td><?php echo $row_rst_clientes['EMAIL_1']; ?></td>
  </tr>
</table>


<?php

$sql3="SELECT DISTINCT vista_edo_cuenta_clientes.ID_INMUEBLES FROM inmuebles_grupo 
INNER JOIN inmuebles_master ON (inmuebles_grupo.ID_INMUEBLES_GRUPO = inmuebles_master.ID_INMUEBLES_GRUPO) 
INNER JOIN vista_edo_cuenta_clientes ON (inmuebles_master.ID_INMUEBLES_MASTER = vista_edo_cuenta_clientes.ID_INMUEBLES) 
WHERE vista_edo_cuenta_clientes.ID_PRO_CLI=".$row_rst_clientes['ID_PRO_CLI_MASTER'].$proveedores.$fecha." ORDER BY vista_edo_cuenta_clientes.ID_INMUEBLES";

	//echo $sql3;
mysql_select_db($database_conexion, $conexion);
$query_rpt3 = $sql3;
$rpt3 = mysql_query($query_rpt3, $conexion) or die(mysql_error());
$row_rpt3 = mysql_fetch_assoc($rpt3);
$totalRows_rpt3 = mysql_num_rows($rpt3);

 do {

			     
                 mysql_select_db($database_conexion, $conexion);
			$query_rst_suma = "SELECT CODIGO_INMUEBLE, ID_INMUEBLES, SUM(DEBITO) as DEBITO,   SUM(CREDITO) AS CREDITO FROM vista_edo_cuenta_clientes where vista_edo_cuenta_clientes.ID_PRO_CLI=".$row_rst_clientes['ID_PRO_CLI_MASTER']." AND vista_edo_cuenta_clientes.ID_INMUEBLES=".$row_rpt3['ID_INMUEBLES'];
			//echo $query_rst_suma;
			$rst_suma = mysql_query($query_rst_suma, $conexion) or die(mysql_error());
			$row_rst_suma = mysql_fetch_assoc($rst_suma);
			$totalRows_rst_suma = mysql_num_rows($rst_suma); 
?>
			<table width="990" border="0" align="center" bgcolor="#CCCCCC">
            <tr align="center" bgcolor="#6699FF" class="ui-widget-header">
				<td width="780">INMUEBLE</td>
				<td width="70">DEBITO</td>
				<td width="70">CREDITO</td>
				<td width="70">SALDO</td>
			  </tr>
			  <tr bgcolor="#6699FF" class="ui-widget-header">
				<td align="left">INMUEBLE: <?php echo $row_rst_suma['CODIGO_INMUEBLE']; ?></td>
				<td align="right"><?php echo number_format($row_rst_suma['DEBITO'],2, ",", "."); ?></td>
				<td align="right"><?php echo number_format($row_rst_suma['CREDITO'],2, ",", "."); ?></td>
				<td align="right"><?php echo number_format(( $row_rst_suma['DEBITO']-$row_rst_suma['CREDITO']),2, ",", "."); ?></td>
			  </tr>
			
			</table>
            
            <?php		
			mysql_select_db($database_conexion, $conexion);
			$query_rst_observacion = "SELECT * FROM inmuebles_mov WHERE ID_INMUEBLES_MASTER=".$row_rpt3['ID_INMUEBLES'];
			$rst_observacion = mysql_query($query_rst_observacion, $conexion) or die(mysql_error());
			$row_rst_observacion = mysql_fetch_assoc($rst_observacion);
			$totalRows_rst_observacion = mysql_num_rows($rst_observacion);
			//echo $query_rst_observacion;
?>
			<form id="form2" name="form2" method="get" action="edit.php">
			<table width="990" border="0" align="center" bgcolor="#CCCCCC">
			  <tr bgcolor="#6699FF"  class="ui-widget-header">
				<td height="28" align="left" valign="top">
				
				  <label for="observaciones"></label>
				  OBSERVACION:
				  <textarea name="observaciones" id="observaciones" cols="150" rows="2" ><?php echo $row_rst_observacion['DESCRIPCION']; ?></textarea>
				  <input type="hidden" name="inmueble" id="inmueble"  value="<?php echo $row_rst_suma['ID_INMUEBLES']; ?>"/>
				  <input name="nombre" type="hidden" id="nombre" value="<?php echo $_GET['nombre'] ?>" />
				  <input name="proyecto" type="hidden" id="proyecto" value="<?php echo $pagos ?>" />
				  <input name="grupo" type="hidden" id="grupo" value="<?php echo $documentos ?>" />
			<input name="inmuebles" type="hidden" id="inmuebles" value="<?php echo $proveedores ?>" />
				  <input name="VENCIDOS" type="hidden" id="VENCIDOS" value="<?php echo $numero ?>" />
				  <input name="FROM" type="hidden" id="FROM" value="<?php echo $_GET['FROM'] ?>" />
				  <input name="TO" type="hidden" id="TO" value="<?php echo $_GET['TO'] ?>" /></td>
				<td width="70" align="center"><input type="submit" name="Aceptar" id="Aceptar" value="Aceptar"  class="ui-state-hover" /></td>
			  </tr>
			
			</table>
			</form>
                <?php } while ($row_rpt3 = mysql_fetch_assoc($rpt3)); ?>
			
			<?php } while ($row_rst_clientes = mysql_fetch_assoc($rst_clientes));  ?>
		 <?php } ?>
</body>
</html>
<?php
mysql_free_result($rst_clientes);

mysql_free_result($rst_observacion);

@mysql_free_result($rst_inmueble);
?>

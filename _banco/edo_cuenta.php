<?php require_once('../../Connections/conexion.php'); ?>
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
$query_CONSULTA = "SELECT 
NOMBRE_TIPO_MOV,
 NOMBRE_PRO_CLI,
  NUMERO_PAGO, 
  NOMBRE_PROYECTO,
   NOMBRE_BANCO, 
   NUMERO_CUENTA,
   ID_MOV_BANCO_CAJA, 
   DESCRIPCION, 
   MES, 
   ANO, 
   DIA,
    DEBITO, 
	CREDITO 
	FROM vista_banco_movimientos  WHERE AFECTA_BANCO=1 AND ANULADO=0 AND ID_CUENTA_BANCARIA=".$_GET['ID_CUENTA_BANCARIA']." AND MES=".$_GET['MES']." AND ANO=".$_GET['ANO']." ";
	//"SELECT * FROM vista_mov_1 WHERE AFECTA_BANCO=1 AND ANULADO=0 AND ID_CUENTA_BANCARIA=".$_GET['ID_CUENTA_BANCARIA']." AND MES=".$_GET['MES']." AND ANO=".$_GET['ANO']." order by dia";
$CONSULTA = mysql_query($query_CONSULTA, $conexion) or die(mysql_error());
//echo $query_CONSULTA."<br>";
$row_CONSULTA = mysql_fetch_assoc($CONSULTA);
$totalRows_CONSULTA = mysql_num_rows($CONSULTA);

$MES=$_GET['MES'];
$ANO=$_GET['ANO'];
/*if($_GET['MES']==1){
	$MES=13;
	}
*/
mysql_select_db($database_conexion, $conexion);
$query_CONSULTA_SALDO = //"SELECT SUM(SALDO) AS SALDO FROM vista_banco_saldos WHERE ID_CUENTA_BANCARIA=".$_GET['ID_CUENTA_BANCARIA']." AND FECHA<'".$ANO."-".$MES."'";
//echo $query_CONSULTA_SALDO;

"SELECT
PROYECTOS.NOMBRE AS NOMBRE_PROYECTO,
 `banco_master`.`NOMBRE` AS NOMBRE_BANCO
    , `banco_cuentas`.`NUMERO_CUENTA`,
  SUM(  IF((`tesoreria_tipo_mov`.`TIPO_IO` = _latin1'O'),`mov_banco_caja`.`MONTO`,0)) AS `TOTAL_DEBITO`,
  SUM(IF((`tesoreria_tipo_mov`.`TIPO_IO` = _latin1'I'),`mov_banco_caja`.`MONTO`,0)) AS `TOTAL_CREDITO`,
  SUM(IF((`tesoreria_tipo_mov`.`TIPO_IO` = _latin1'I'),`mov_banco_caja`.`MONTO`,0))-SUM(  IF((`tesoreria_tipo_mov`.`TIPO_IO` = _latin1'O'),`mov_banco_caja`.`MONTO`,0)) AS SALDO

FROM
    `grupocal_calpe`.`tesoreria_tipo_mov`
    INNER JOIN `grupocal_calpe`.`mov_banco_caja` 
        ON (`tesoreria_tipo_mov`.`ID_TESORERIA_TIPO_MOV` = `mov_banco_caja`.`TIPO_PAGO`)
    INNER JOIN `grupocal_calpe`.`banco_cuentas` 
        ON (`mov_banco_caja`.`ID_CUENTA_BANCARIA` = `banco_cuentas`.`ID_CUENTA_BANCARIA`)
    INNER JOIN `grupocal_calpe`.`banco_master` 
        ON (`banco_master`.`ID_BANCO_MASTER` = `banco_cuentas`.`ID_BANCO_MASTER`)
            INNER JOIN `grupocal_calpe`.empresas_master 
        ON (empresas_master.CODIGO_EMPRESAS_MASTER = `banco_cuentas`.CODIGO_EMPRESA)
            INNER JOIN `grupocal_calpe`.proyectos
        ON (empresas_master.CODIGO_EMPRESAS_MASTER = PROYECTOS.COD_EMP)
        WHERE `tesoreria_tipo_mov`.AFECTA_BANCO=1 AND `mov_banco_caja`.`ID_CUENTA_BANCARIA`=".$_GET['ID_CUENTA_BANCARIA']." AND  `mov_banco_caja`.FECHA <'".$ANO."-".$MES."' 
        GROUP BY `banco_cuentas`.`NUMERO_CUENTA`
		ORDER BY PROYECTOS.CODIGO";
$CONSULTA_SALDO = mysql_query($query_CONSULTA_SALDO, $conexion) or die(mysql_error());
$row_CONSULTA_SALDO = mysql_fetch_assoc($CONSULTA_SALDO);
$totalRows_CONSULTA_SALDO = mysql_num_rows($CONSULTA_SALDO);

/*Definiciones*/
$formulario="Banco01-Listado";
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1" />
<title>Untitled Document</title>
<?php include("../include/_js.php"); ?>
<?php include("../include/_css.php"); ?>

</head>

<body style="font-family:Verdana, Geneva, sans-serif; font-size:12px">
<?php $opcion_menu=2; ?>
<?php include('../include/header.php'); ?>

      <table width="1100" align="center" class="ui-widget-header" >
    <tr>
          <td width="100%" align="center" class="textos_form"><div class="titulo_formulario"> Estado de Cuenta Bancaria
				

	
				<?php if ($totalRows_CONSULTA > 0) { // Show if recordset not empty ?>
						<BR><?php echo $row_CONSULTA['NOMBRE_PROYECTO']; ?>-<?php echo $row_CONSULTA['NOMBRE_BANCO']; ?>-<?php echo $row_CONSULTA['NUMERO_CUENTA']; ?>-(<?php echo $_GET['MES']."/".$_GET['ANO']; ?>)
					<?php } // Show if recordset not empty ?>
					<?php if ($totalRows_CONSULTA == 0) { // Show if recordset empty ?>
					<br />Ningun registro coincide con esta consulta.
					<?php } // Show if recordset empty ?>
			</div>
    </tr>
  </table>
<?php //include("_menu.php"); ?>
<form name="enviar" method="POST" id="enviar">
	<?php if ($totalRows_CONSULTA > 0) { // Show if recordset not empty ?>
		<table width="1100" align="center" cellpadding="2" cellspacing="2" >
			<tr>
				<td width="50" align="center" bgcolor="#F3F3F3" class="textos_form" >Dia
				<td width="50" align="center" bgcolor="#F3F3F3" class="textos_form" >ID
				<td width="50" align="center" bgcolor="#F3F3F3" class="textos_form" >Tipo 
				<td width="100" align="center" bgcolor="#F3F3F3" class="textos_form" >Numero
				<td colspan="2" align="center" bgcolor="#F3F3F3" class="textos_form" >Descripcion
                <td align="center" bgcolor="#F3F3F3" class="textos_form" >Cliente o Proveedor
				<td width="150" align="center" bgcolor="#F3F3F3" class="textos_form" >Debito					
				<td width="150" align="center" bgcolor="#F3F3F3" class="textos_form" >Credito					
				<td width="150" align="center" bgcolor="#F3F3F3" class="textos_form" >Saldo		
			</tr>
			<tr>
				<td colspan="9" align="right" bgcolor="#999999" class="textos_form_derecha" >Saldo Anterior			
				<td align="right" bgcolor="#999999" class="textos_form_derecha" ><?php echo number_format($row_CONSULTA_SALDO['SALDO'],2); ?>				
			</tr>
			<?php 
		   $SALDO=$row_CONSULTA_SALDO['SALDO'];
		   $DEBITO=0;
		   $CREDITO=0;
		   do { 
		   $SALDO=$SALDO+$row_CONSULTA['CREDITO']-$row_CONSULTA['DEBITO'];
		   $DEBITO=$DEBITO+$row_CONSULTA['DEBITO'];
		   $CREDITO=$CREDITO+$row_CONSULTA['CREDITO'];
		   ?>
			<tr bgcolor="<?php if($row_CONSULTA['CREDITO']>0){?>#ffffff<?php }else{?>#F3F3F3<?php }?>">
				<td align="center"  class="textos_form" ><?php echo $row_CONSULTA['DIA']; ?></td>
				<td align="center" ><?php echo $row_CONSULTA['ID_MOV_BANCO_CAJA']; ?>
				<td align="center" ><?php echo $row_CONSULTA['NOMBRE_TIPO_MOV']; ?>
				<td align="center" ><?php echo $row_CONSULTA['NUMERO_PAGO']; ?>
				<td colspan="2" align="left"  ><?php if($row_CONSULTA['CREDITO']>0){echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";} ?>
					<?php echo htmlentities($row_CONSULTA['DESCRIPCION']); ?>
                <td align="center" ><?php echo $row_CONSULTA['NOMBRE_PRO_CLI']; ?>
				<td align="right" ><?php echo number_format($row_CONSULTA['DEBITO'],2); ?>
				<td align="right"><?php echo number_format($row_CONSULTA['CREDITO'],2); ?>
				<td align="right" class="textos_form_derecha" style="color:<?php if ($SALDO>0){ ?>#000000<?php }else{?>#FF0000<?php }?>" ><?php echo number_format($SALDO,2); ?>			
			</tr>
			<?php } while ($row_CONSULTA = mysql_fetch_assoc($CONSULTA)); ?>
			<tr>
				<td colspan="7" align="right" bgcolor="#999999" class="textos_form_derecha" >Saldo Final<td align="right" bgcolor="#999999" class="textos_form_derecha" >	<?php echo number_format($DEBITO,2); ?>		
				<td align="right" bgcolor="#999999" class="textos_form_derecha" >	<?php echo number_format($CREDITO,2); ?>			
				<td align="right" bgcolor="#999999" class="textos_form_derecha" style="color:<?php if ($CREDITO-$DEBITO+$row_CONSULTA_SALDO['SALDO']>0){ ?>#000000<?php }else{?>#FF0000<?php }?>" >	<?php echo number_format($CREDITO-$DEBITO+$row_CONSULTA_SALDO['SALDO'],2); ?>			
			</tr>
			<tr>
				<td colspan="9" align="left" ><div class="validity-summary-container" style="color:#F00">
					<ul>
					</ul>
				</div>
		</table>
		<?php } // Show if recordset not empty ?>
</form>


<?php include("../include/_foot.php"); ?>
</body>
</html>
<?php
mysql_free_result($CONSULTA);

?>

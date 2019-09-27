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
$query_TABLA = "SELECT CODIGO_PROYECTO, NOMBRE_PROYECTO, ID_GRUPO, NOMBRE_GRUPO, ANO, MES, NOMBRE_MES, SUM(monto_egresos) AS MONTO_EGRESOS, SUM(monto_ingresos) AS MONTO_INGRESOS, MIN(MONTO_INGRESOS) AS MIN_INGRESOS,MAX(MONTO_INGRESOS) AS MAX_INGRESOS, MIN(MONTO_EGRESOS) AS MIN_EGRESOS, MAX(MONTO_EGRESOS) AS MAX_EGRESOS FROM vista_egresos_ingresos_inmuebles_grupo WHERE ANO = ".$_GET['ANOS']." AND ID_GRUPO=".$_GET['GRUPO']." GROUP BY nombre_grupo,ano,mes ";
$TABLA = mysql_query($query_TABLA, $conexion) or die(mysql_error());
$row_TABLA = mysql_fetch_assoc($TABLA);
$totalRows_TABLA = mysql_num_rows($TABLA);

/*Definiciones*/
$formulario="Grafica00-Editar";
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
<title>Untitled Document</title>
<?php include("../include/_js.php"); ?>
<?php include("../include/_css.php"); ?>

</head>

<body style="font-family:Verdana, Geneva, sans-serif; font-size:12px">
<?php $opcion_menu=2; ?>
<?php include("../include/menu.php"); ?>

      <table width="1100" align="center" class="ui-widget-header" >
    <tr>
          <td width="100%" align="center" class="textos_form"><div class="titulo_formulario">Relacion Ingreso-Egresos<br />
          		<?php echo $row_TABLA['NOMBRE_GRUPO']; ?>- <?php echo $row_TABLA['ANO']; ?></div>
    </tr>
  </table>
<?php //include("_menu.php"); ?>
<?php if ($totalRows_TABLA > 0) { // Show if recordset not empty ?>
	<form name="enviar" method="POST" id="enviar">
		<table width="1100" align="center" >
			<tr>
				<td colspan="3" align="center" bgcolor="#F3F3F3" class="textos_form" >
					<?php 
$EGRESO='';
$INGRESOS='';
$MINIMO=0;
$MAXIMO=0;
$mes='';


for($a=1; $a<=12;$a++)
{
	mysql_select_db($database_conexion, $conexion);
	$query_GRAFICO = "SELECT CODIGO_PROYECTO, NOMBRE_PROYECTO, ID_GRUPO, NOMBRE_GRUPO, ANO, MES, NOMBRE_MES, SUM(monto_egresos) AS MONTO_EGRESOS, SUM(monto_ingresos) AS MONTO_INGRESOS, MIN(MONTO_INGRESOS) AS MIN_INGRESOS,MAX(MONTO_INGRESOS) AS MAX_INGRESOS, MIN(MONTO_EGRESOS) AS MIN_EGRESOS, MAX(MONTO_EGRESOS) AS MAX_EGRESOS FROM vista_egresos_ingresos_inmuebles_grupo WHERE ANO = ".$_GET['ANOS']." AND ID_GRUPO=".$_GET['GRUPO']." AND MES=".$a." GROUP BY nombre_grupo,ano,mes ";
	//echo $query_GRAFICO;
	$GRAFICO = mysql_query($query_GRAFICO, $conexion) or die(mysql_error());
	$row_GRAFICO = mysql_fetch_assoc($GRAFICO);
	$totalRows_GRAFICO = mysql_num_rows($GRAFICO);
	

	$mes=substr($row_GRAFICO['NOMBRE_MES'],0,3);
	//echo $row_GRAFICO['MONTO_EGRESOS'].",".$row_GRAFICO['MONTO_INGRESOS']."<br>";
	if($EGRESO==''){
		$EGRESO='t:'.($row_GRAFICO['MONTO_EGRESOS']/10000); 
		$INGRESOS='|'.($row_GRAFICO['MONTO_INGRESOS']/10000);
		$mes='|'.substr($row_GRAFICO['NOMBRE_MES'],0,3);
		//echo "si"."<br>";
	
	}
	else
	{
		$EGRESO=$EGRESO.','.($row_GRAFICO['MONTO_EGRESOS']/10000); 
		$INGRESOS=$INGRESOS.','.($row_GRAFICO['MONTO_INGRESOS']/10000);
		$mes=$mes.substr($row_GRAFICO['NOMBRE_MES'],0,3);
		//echo "no"."<br>";
	}
	//echo $EGRESO."<br>";
	$MINIMO=max($row_GRAFICO['MIN_EGRESOS']/10000,$row_GRAFICO['MIN_INGRESOS']/10000,$MINIMO);
$MAXIMO=min($row_GRAFICO['MAX_EGRESOS']/10000,$row_GRAFICO['MAX_INGRESOS']/10000,$MAXIMO);
	
	
}


 ?>
					<img src="http://chart.apis.google.com/chart?chxl=0:|Ene|Feb|Mar|Abr|May|Jun|Jul|Ago|Sep|Oct|Nov|Dic&chx=x&chxs=0,676767,11.5,0,lt,676767&chxt=x,y&chs=600x400&cht=lc&chco=FF0000,0000FF&chds=0,100,0,100&chd=<?php echo $EGRESO; ?><?php echo $INGRESOS; ?>&chdl=Egresos|Ingreso&chg=25,25&chls=0.75,-1,-1|0.75,-1,-1&chma=10,10,10,10&chm=b,EFEFEF66,0,1,0,1|s,FF0000,0,-1,5|s,0000FF,1,-1,5" alt="" width="600" height="400" />
					
					<br /><br />
					<br />
					
					
			</tr>
			<tr class="textos_form">
				<td width="398" align="center" bgcolor="#F3F3F3" class="textos_form" >Mes<td align="center" bgcolor="#F3F3F3" ><label for="MONTO_ESTIMADO"></label>		
					Ingreso
				<td align="center" bgcolor="#F3F3F3" >Egreso		
			</tr>
			
			<?php do { ?><tr>
				<td width="398" bgcolor="#FFFFFF" class="textos_form" ><?php echo $row_TABLA['NOMBRE_MES']; ?>
				<td align="right" bgcolor="#FFFFFF" ><label for="textfield3"></label>
					<?php echo number_format($row_TABLA['MONTO_INGRESOS'],2); ?>
				<td align="right" bgcolor="#FFFFFF" ><?php echo number_format($row_TABLA['MONTO_EGRESOS'],2); ?>
				</tr>	<?php } while ($row_TABLA = mysql_fetch_assoc($TABLA)); ?>
			
			<tr>
				<td width="398" bgcolor="#F3F3F3" class="textos_form" >
				<td align="left" bgcolor="#F3F3F3" ><label for="textfield3"></label>		
				<td align="left" bgcolor="#F3F3F3" >		
			</tr>
			<tr>
				<td colspan="3" align="left" >
					<div class="validity-summary-container" style="color:#F00">
						
						<ul></ul>
			</div></tr>
			
			<td colspan="3" align="center" bgcolor="#999999" class="textos_form" ></tr>
		</table>
	</form>
	<?php } // Show if recordset not empty ?>
	<?php if ($totalRows_TABLA == 0) { // Show if recordset empty ?>
		<center><span class="textos_form">Ningun registro asociado a esta busqueda</span></center>
	<?php } // Show if recordset empty ?>
	<?php include("../include/_foot.php"); ?>
</body>
</html>
<?php
mysql_free_result($TABLA);


?>

<?php require_once('../Connections/conexion.php'); ?>
<?php
if(isset($_GET['proyecto']) && $_GET['proyecto']!=''){$pagos=$_GET['proyecto'] ;} else {$pagos='';}

if(isset($_GET['grupo']) && $_GET['grupo']!=''){$documentos=$_GET['grupo'];} else {$documentos='';}
if(isset($_GET['inmuebles']) && $_GET['inmuebles']!=''){$proveedores=$_GET['inmuebles'];} else {$proveedores='';}
if(isset($_GET['VENCIDOS']) && $_GET['VENCIDOS']!=''){$numero=' AND vista_documentos_ventas.STATUS_DOCUMENTO='.$_GET['VENCIDOS'];} else {$numero='';}
if(isset($_GET['FROM']) && $_GET['FROM']!='' && isset($_GET['TO']) && $_GET['TO']!='')
{$fi=DMAtoAMD($_GET['FROM']); $ff=DMAtoAMD($_GET['TO']);
	$fecha=' AND vista_documentos_ventas.FECHA_VENCIMIENTO_DATE BETWEEN "'.$fi.'" AND "'.$ff.'"';} else {$fecha='';}

$colname_rst_observaciones = "-1";
if (isset($_GET['inmueble'])) {
  $colname_rst_observaciones = $_GET['inmueble'];
}
mysql_select_db($database_conexion, $conexion);
$query_rst_observaciones = "UPDATE inmuebles_mov SET DESCRIPCION='".$_GET['observaciones']."' WHERE ID_INMUEBLES_MASTER =".$_GET['inmueble'];
$rst_observaciones = mysql_query($query_rst_observaciones, $conexion) or die(mysql_error());
//echo $query_rst_observaciones;
?>
<script type="text/javascript">

alert("Proceso Completado con Exito.");
window.location = "list.php?titulo_formulario=Cobranzas&nombre=<?php echo $_GET['nombre'] ?>&proyecto=<?php echo $_GET['proyecto'] ?>&grupo=<?php echo $_GET['grupo'] ?>&inmueble=<?php echo $_GET['inmuebles'] ?>&VENCIDOS=<?php echo $_GET['VENCIDOS'] ?>&FROM=<?php echo $_GET['FROM'] ?>&TO=<?php echo $_GET['TO'] ?>&Aceptar";

</script>

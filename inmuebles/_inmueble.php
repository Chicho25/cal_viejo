<?php include('../Connections/conexion.php'); ?>
<?php
$colname_inmuebles = "-1";
if (isset($_POST['ID_INMUEBLES_GRUPO'])) {
$colname_inmuebles = $_POST['ID_INMUEBLES_GRUPO'];
}
 mysql_select_db($database_conexion, $conexion);
$query_inmuebles = "SELECT DISTINCT ID_INMUEBLE, NOMBRE_INMUEBLE FROM vista_inmuebles WHERE COD_PROYECTO <> ' '".$_POST['ID_INMUEBLES_GRUPO'].";";
$inmuebles = mysql_query($query_inmuebles, $conexion) or die(mysql_error());
$row_inmuebles = mysql_fetch_assoc($inmuebles);
$totalRows_inmuebles = mysql_num_rows($inmuebles);

?>
<option value=" ">Selecione el Inmueble</option>
<?php do { ?><option value=" AND ID_INMUEBLE=<?php echo $row_inmuebles['ID_INMUEBLE']; ?>">
<?php echo $row_inmuebles['NOMBRE_INMUEBLE'] ?></option>
<?php } while ($row_inmuebles = mysql_fetch_assoc($inmuebles)); ?>

<?php
mysql_free_result($inmuebles);
?>

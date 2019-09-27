<?php include('../Connections/conexion.php'); ?>
<?php
$colname_grupos = "-1";
if (isset($_POST['COD_PROYECTOS_MASTER'])) {
  $colname_grupos = $_POST['COD_PROYECTOS_MASTER'];
}
mysql_select_db($database_conexion, $conexion);
$query_grupos = "SELECT DISTINCT ID_INMUEBLES_GRUPO, NOMBRE FROM inmuebles_grupo WHERE  COD_PROYECTOS_MASTER <>' '".$_POST['COD_PROYECTOS_MASTER'].";";
$grupos = mysql_query($query_grupos, $conexion) or die(mysql_error());
$row_grupos = mysql_fetch_assoc($grupos);
$totalRows_grupos = mysql_num_rows($grupos);

?>
<option value=" ">TODOS</option>
<?php do { ?><option value=" AND ID_GRUPO=<?php echo $row_grupos['ID_INMUEBLES_GRUPO']; ?>">
<?php echo $row_grupos['NOMBRE'] ?></option>
<?php } while ($row_grupos = mysql_fetch_assoc($grupos)); ?>

<?php
mysql_free_result($grupos);
?>

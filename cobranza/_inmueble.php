<?php include('../Connections/conexion.php'); ?>
<?php
$colname_inmuebles = "-1";
if (isset($_POST['ID_INMUEBLES_GRUPO'])) {
$colname_inmuebles = $_POST['ID_INMUEBLES_GRUPO'];
}
 mysql_select_db($database_conexion, $conexion);
$query_inmuebles = "SELECT DISTINCT 
  inmuebles_master.ID_INMUEBLES_MASTER,
  inmuebles_master.NOMBRE,
  inmuebles_grupo.ID_INMUEBLES_GRUPO
FROM
  inmuebles_grupo
  INNER JOIN inmuebles_master ON (inmuebles_grupo.ID_INMUEBLES_GRUPO = inmuebles_master.ID_INMUEBLES_GRUPO)
WHERE
  inmuebles_grupo.COD_PROYECTOS_MASTER <> ''".$_POST['ID_INMUEBLES_GRUPO'];
//echo $query_inmuebles;
$inmuebles = mysql_query($query_inmuebles, $conexion) or die(mysql_error());
$row_inmuebles = mysql_fetch_assoc($inmuebles);
$totalRows_inmuebles = mysql_num_rows($inmuebles);

?>
<option value=" ">Selecione el Inmueble</option>
<?php do { ?><option value=" AND ID_INMUEBLES_MASTER=<?php echo $row_inmuebles['ID_INMUEBLES_MASTER']; ?>">
<?php echo $row_inmuebles['NOMBRE'] ?></option>
<?php } while ($row_inmuebles = mysql_fetch_assoc($inmuebles)); ?>

<?php
mysql_free_result($inmuebles);
?>

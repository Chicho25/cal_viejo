<?php include('../Connections/conexion.php'); ?>
<?php
$colname_grupos = "-1";
if (isset($_POST['COD_PROYECTOS_MASTER'])) {
  $colname_grupos = $_POST['COD_PROYECTOS_MASTER'];
}
mysql_select_db($database_conexion, $conexion);
$query_grupos = "SELECT DISTINCT 
  inmuebles_grupo.NOMBRE,
  inmuebles_grupo.ID_INMUEBLES_GRUPO
FROM
   inmuebles_grupo
WHERE
  inmuebles_grupo.COD_PROYECTOS_MASTER <>' '".$_POST['COD_PROYECTOS_MASTER'].";";
echo $query_grupos;
$grupos = mysql_query($query_grupos, $conexion) or die(mysql_error());
$row_grupos = mysql_fetch_assoc($grupos);
$totalRows_grupos = mysql_num_rows($grupos);

?>
<option value=" ">Seleccione el Grupo</option>
<?php do { ?><option value=" AND inmuebles_master.ID_INMUEBLES_GRUPO=<?php echo $row_grupos['ID_INMUEBLES_GRUPO']; ?>">
<?php echo $row_grupos['NOMBRE'] ?></option>
<?php } while ($row_grupos = mysql_fetch_assoc($grupos)); ?>

<?php
mysql_free_result($grupos);
?>

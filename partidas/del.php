<?php include('../include/header.php'); ?>
<?php 
if ((isset($_GET['ID_CUENTA'])) && ($_GET['ID_CUENTA'] != "")) {
  $deleteSQL = "DELETE FROM contabilidad_cuentas WHERE ID_CUENTA=".$_GET['ID_CUENTA'];

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($deleteSQL, $conexion) or die(mysql_error());
 $ids=$_GET['ID_CUENTA'];
aud($_SESSION['i'], $ids,'Elimino registro con el id',$_GET['menu']);
  ?>
   <script type="text/javascript">
alert("Los cambios se realizaron con exito...");

window.location = "index.php?titulo_formulario=<?php echo $_GET['titulo_formulario'] ?>"
</script>
<?php
}
?>
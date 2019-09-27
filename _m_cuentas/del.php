<?php include('../include/header.php'); ?>
<?php
if ((isset($_GET['ID_CUENTA_BANCARIA'])) && ($_GET['ID_CUENTA_BANCARIA'] != "")) {
  $deleteSQL = sprintf("DELETE FROM banco_cuentas WHERE ID_CUENTA_BANCARIA=%s",
                       GetSQLValueString($_GET['ID_CUENTA_BANCARIA'], "int"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($deleteSQL, $conexion) or die(mysql_error());
   $ids=$_GET['ID_CUENTA_BANCARIA'];
aud($_SESSION['i'], $ids,'Elimino registro con el id',$_GET['id_menu'] );
  ?>
   <script type="text/javascript">
alert("Los cambios se realizaron con exito...");

window.location = "index.php?titulo_formulario=<?php echo $_GET['titulo_formulario'] ?>&id_menu=<?php echo $_GET['id_menu'] ?>"
</script>
<?php
}
?>

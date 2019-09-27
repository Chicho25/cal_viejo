<?php include("../include/header.php"); 
if ((isset($_GET['ID_CHEQUERA'])) && ($_GET['ID_CHEQUERA'] != "")) {
  $deleteSQL = sprintf("DELETE FROM banco_chequeras WHERE ID_CHEQUERA=%s",
                       GetSQLValueString($_GET['ID_CHEQUERA'], "int"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($deleteSQL, $conexion) or die(mysql_error());
  	$ids=$_GET['ID_CHEQUERA'];
   aud($_SESSION['i'],$ids,'Eliminacion de chequera con el id ',30);
}
?>
 <script type="text/javascript">
alert("Proceso Completado con Exito.");
 window.location="index.php";

</script>
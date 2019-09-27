<?php require_once('../Connections/conexion.php'); ?>
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

if ((isset($_GET['ID_FORMULARIO'])) && ($_GET['ID_FORMULARIO'] != "")) {
  $deleteSQL = sprintf("DELETE FROM usuarios_menu WHERE ID_FORMULARIO=%s",
                       GetSQLValueString($_GET['ID_MENU'], "int"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($deleteSQL, $conexion) or die(mysql_error());
}

if ((isset($_GET['ID_FORMULARIO'])) && ($_GET['ID_FORMULARIO'] != "")) {
  $deleteSQL = sprintf("DELETE FROM usuarios_formularios WHERE ID_FORMULARIO=%s",
                       GetSQLValueString($_GET['ID_FORMULARIO'], "int"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($deleteSQL, $conexion) or die(mysql_error());

$ids=$_GET['ID_FORMULARIO'];
aud($_SESSION['i'], $ids,'Elimino el registro con el id',$_GET['id_menu']);
  ?>
<script type="text/javascript">
alert("Los cambios se realizaron con exito...");

window.location = "index.php?titulo_formulario=<?php echo $_GET['titulo_formulario'] ?>&id_menu=<?php echo $_GET['id_menu']; ?>"
</script>
<?php
}
?>

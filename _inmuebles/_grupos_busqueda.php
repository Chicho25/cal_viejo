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

$colname_grupos = "-1";
if (isset($_POST['COD_PROYECTOS_MASTER'])) {
  $colname_grupos = $_POST['COD_PROYECTOS_MASTER'];
}
mysql_select_db($database_conexion, $conexion);
$query_grupos = sprintf("SELECT ID_INMUEBLES_GRUPO, NOMBRE FROM inmuebles_grupo WHERE COD_PROYECTOS_MASTER = %s", GetSQLValueString($colname_grupos, "text"));
$grupos = mysql_query($query_grupos, $conexion) or die(mysql_error());
$row_grupos = mysql_fetch_assoc($grupos);
$totalRows_grupos = mysql_num_rows($grupos);

?>
<option value="">Seleccione...................</option>
<?php do { ?><option value="<?php echo $row_grupos['ID_INMUEBLES_GRUPO']; ?>">
<?php echo $row_grupos['NOMBRE'] ?></option>
<?php } while ($row_grupos = mysql_fetch_assoc($grupos)); ?>

<?php
mysql_free_result($grupos);
?>

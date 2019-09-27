
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

$colname_rst_part = "-1";
if (isset($_POST['PROYECTO'])) {
  $colname_rst_part = $_POST['PROYECTO'];
}
//echo $_POST['PROYECTO'];
mysql_select_db($database_conexion, $conexion);
$query_rst_part = sprintf("SELECT DISTINCT ID_PARTIDA, DESCRIPCION_COMPLETA FROM pagos_partidas ". $_POST['PROYECTO']." ORDER BY DESCRIPCION_COMPLETA", GetSQLValueString($colname_rst_part, "text"));
$rst_part = mysql_query($query_rst_part, $conexion) or die(mysql_error());
$row_rst_part = mysql_fetch_assoc($rst_part);
$totalRows_rst_part = mysql_num_rows($rst_part);
if ($totalRows_rst_part > 0){ ?>
<option value=" ">TODOS</option>
<?php
do {  
?>

    <option value=" AND ID_PARTIDA=<?php echo $row_rst_part['ID_PARTIDA'];?>"><?php echo htmlentities($row_rst_part['DESCRIPCION_COMPLETA']);?></option>
    <?php
} while ($row_rst_part = mysql_fetch_assoc($rst_part));
  $rows = mysql_num_rows($rst_part);
  if($rows > 0) {
      mysql_data_seek($rst_part, 0);
	  $row_rst_part = mysql_fetch_assoc($rst_part);
  }
} else {?>
<option value=" ">TODOS</option>
	<option value=" " disabled="disabled">Seleccione un proyecto</option>
    <?php
}
?>
<?php
mysql_free_result($rst_part);
?>

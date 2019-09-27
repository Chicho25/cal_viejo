<?php include('../Connections/conexion.php'); ?>
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

$colname_grafica = "-1";
if (isset($_POST['elegido'])) {
  $colname_grafica = $_POST['elegido'];

mysql_select_db($database_conexion, $conexion);
$query_grafica = sprintf("SELECT DESCRIPCION, MONTO_PAGADO, format(MONTO_PAGADO * 100/ MONTO_ESTIMADO,2) as PORC FROM partidas WHERE ID_GRUPO = %s", GetSQLValueString($colname_grafica, "int"));
$grafica = mysql_query($query_grafica, $conexion) or die(mysql_error());
//$row_grafica = mysql_fetch_assoc($grafica);
$totalRows_grafica = mysql_num_rows($grafica);
if ($totalRows_grafica > 0) {

while ($valor= mysql_fetch_assoc($grafica)){$datos[]= $valor;}
?>
<!--<style type="text/css">  
  
table {  
    font: 11px Verdana, Arial, Helvetica, sans-serif;  
    color: #777;  
    padding:7px;  
}  
  </style>  -->
<?php  
function random_color(){
    mt_srand((double)microtime()*1000000);
    $c = '';
    while(strlen($c)<6){
        $c .= sprintf("%02X", mt_rand(0, 255));
    }
    return $c;
}
$maximo = 0;  
foreach ( $datos as $ElemArray ) { $maximo += $ElemArray['MONTO_PAGADO']; } 

?>  
  
<table  width="990" cellspacing="0" cellpadding="2">  
<?php foreach( $datos as $ElemArray ) {  
?>  
<tr>  
    <td width="29%"><strong><?php echo htmlentities($ElemArray['DESCRIPCION']) ?></strong></td>  
    <td width="21%">Ejecutado un <?php echo $ElemArray['PORC']; ?> % </td>  
  <td width="50%">  
    <table width="<?php echo $ElemArray['PORC'] / 2; ?>%" bgcolor="<?php echo random_color() ?>">  
        <tr><td></td></tr>  
    </table></td>  
    </tr> 
    <?php } ?>
    </table> 
    
 <?php } else {echo 'No se puede generar la grafica ya que la partida seleccionada es de ultimo nivel'; }}?>

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

$colname_rst_cta_banco = "-1";

  $colname_rst_cta_banco = $CODIGO_PROYECTO;

mysql_select_db($database_conexion, $conexion);
$query_rst_cta_banco = sprintf("SELECT * FROM vista_banco_cuentas WHERE CODIGO_PROYECTO = %s order by PREDETERMINADA", GetSQLValueString($colname_rst_cta_banco, "text"));
$rst_cta_banco = mysql_query($query_rst_cta_banco, $conexion) or die(mysql_error());
$row_rst_cta_banco = mysql_fetch_assoc($rst_cta_banco);
$totalRows_rst_cta_banco = mysql_num_rows($rst_cta_banco);
?>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />


<tr class="ctabanca"><td>Cuenta Bancaria: </td>
       
       <td><span id="spryselect_banco">
         <select name="id_cuenta_bancaria" id="id_cuenta_bancaria">
           <option value="" <?php if (!(strcmp("", $row_rst_cta_banco['ID_CUENTA']))) {echo "selected=\"selected\"";} ?>>Seleccione..</option>
           <?php
do {  
?>
           <option value="<?php echo $row_rst_cta_banco['ID_CUENTA']?>"<?php if (!(strcmp($row_rst_cta_banco['ID_CUENTA'], $row_rst_cta_banco['ID_CUENTA']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rst_cta_banco['NOMBRE_BANCO']?> - <?php echo $row_rst_cta_banco['NUMERO_CUENTA']?></option>
           <?php
} while ($row_rst_cta_banco = mysql_fetch_assoc($rst_cta_banco));
  $rows = mysql_num_rows($rst_cta_banco);
  if($rows > 0) {
      mysql_data_seek($rst_cta_banco, 0);
	  $row_rst_cta_banco = mysql_fetch_assoc($rst_cta_banco);
  }
?>
         </select>
       <span class="selectInvalidMsg">Please select a valid item.</span><span class="selectRequiredMsg">Please select an item.</span></span></td>
  </tr>
<?php
mysql_free_result($rst_cta_banco);


?>

<script type="text/javascript">
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect_banco", {invalidValue:"-1", validateOn:["blur", "change"]});
</script>

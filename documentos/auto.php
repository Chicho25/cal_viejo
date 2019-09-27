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

mysql_select_db($database_conexion, $conexion);
$query_partidas = "SELECT ID, DESCRIPCION_COMPLETA FROM partidas WHERE TIPO = 2";
$partidas = mysql_query($query_partidas, $conexion) or die(mysql_error());
$row_partidas = mysql_fetch_assoc($partidas);
$totalRows_partidas = mysql_num_rows($partidas);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="../js/jquery-1.4.2.min.js" language="javascript"></script>
<script src="../js/jquery-ui-1.8.5.custom.min.js" language="javascript"></script>
<script src="../js/jquery.ui.datepicker-es.js" language="javascript"></script>
<script src="../js/jquery.infieldlabel.min.js" language="javascript"></script>
<script type='text/javascript' src='../js/jquery.autocomplete.js'></script>
<script type='text/javascript' src='../js/thickbox-compressed.js'></script> 


<link rel="stylesheet" type="text/css" href="../js/jquery.autocomplete.css" /> 

<link href="../js/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
<title>Untitled Document</title>
<script type="text/javascript"> 
$().ready(function() {
	var partidas = [
	<?php do { ?>
	<?php echo "{ partida: '".$row_partidas['DESCRIPCION_COMPLETA']."', id: '".$row_partidas['ID']."' },"; ?>
	<?php } while ($row_partidas = mysql_fetch_assoc($partidas)); ?>
			 ];
 
	function findValueCallback(event, data, formatted) {

		$("<li>").html( !data ? "No match!" : "Selected: " + formatted).appendTo("#result");
	}
	
	function formatItem(row) {
		return row[0] + " (<strong>id: " + row[1] + "</strong>)";
	}
	/*function formatResult(row) {
		return row[0].replace(/(<.+?>)/gi, '');
	}
	*/
	$("#month").autocomplete(partidas, {
		minChars: 0,
		max: 100,
		autoFill: false,
		selectFirst: false,
		mustMatch: true,
		//matchContains: true,
		matchContains: "word",
		scrollHeight: 220,
		formatItem: function(row, i, max) {
			return row.partida + "\" [" + row.id + "]";
		},
		formatMatch: function(row, i, max) {
			return  row.id, row.partida ;
		},
		formatResult: function(row) {
			return row.partida;
		},

	});
	$("#month").result(function(event, item) {
		//alert(item.id);
		$("#id_partida").val(item.id);
		$("#xxx").focus(); 
		
	});
});
 
</script> 
	
</head> 
 
<body> 

<div id="content">
	<form autocomplete="off"> 
		<p>
			<label>partida:</label> 
			<input type="text" id="month" size="150" />
		</p>
		<ol id="result2">
			<input type="text" name="xxx" id="xxx" />
		</ol>
	</form> 

	<h3>variable:
		<label for="id_partida"></label>
		<input type="text" name="id_partida" id="id_partida" />
	</h3> 
	<ol id="result">
		<label for="xxx"></label>
	</ol> 
 
</div>
<p>&nbsp;</p>

</body> 
</html>
<?php
mysql_free_result($partidas);
?>

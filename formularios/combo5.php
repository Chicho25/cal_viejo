<?php
$rpta="";
if ($_POST["elegido"]=="op5_1") {
	$rpta= '
	<option value="op6_1">Option6661</option>
	<option value="op6_2">Option6662</option>
	<option value="op6_3">Option66663</option>
	';	
}
if ($_POST["elegido"]=="op6_2") {
	$rpta= '
	<option value="op6_1">Option66631</option>
	<option value="op6_2">Option632</option>
	<option value="op6_3">Option633</option>
	';	
}
if ($_POST["elegido"]=="op4_3") {
	$rpta= '
	<option value="op6_1">Option66655551</option>
	<option value="op6_2">Option666555552</option>
	<option value="op6_3">Option6665555553</option>
	';	
}
echo $rpta;	
?>
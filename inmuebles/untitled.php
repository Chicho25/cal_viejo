<!DOCTYPE html> 
<html lang="en"> 
<head> 
	<meta charset="utf-8"> 
	<title>jQuery UI Datepicker - Default functionality</title> 
	<link rel="stylesheet" href="http://jqueryui.com/themes/base/jquery.ui.all.css"> 
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script> 
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script> 
	<!--<script src="http://jqueryui.com/ui/jquery.ui.widget.js"></script> -->
	<script src="../js/jquery.ui.datepicker.js"></script> 
	<link rel="stylesheet" href="../demos.css"> 
	<script> 
	$(function() {
		$( "#datepicker" ).datepicker();
	});
	</script> 
</head> 
<body> 
 
<div class="demo"> 
 
<p>Date: <input type="text" id="datepicker"></p> 
 
</div><!-- End demo --> 
 
 
 
<div class="demo-description"> 
<p>The datepicker is tied to a standard form input field.  Focus on the input (click, or use the tab key) to open an interactive calendar in a small overlay.  Choose a date, click elsewhere on the page (blur the input), or hit the Esc key to close. If a date is chosen, feedback is shown as the input's value.</p> 
</div><!-- End demo-description --> 
 
</body> 
</html> 